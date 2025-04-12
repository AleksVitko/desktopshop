<?php
/**
 * Database storage.
 *
 * @package woodmart
 */

namespace XTS\Modules\Waitlist;

use XTS\Singleton;
use WC_Product;

/**
 * Database storage class.
 */
class DB_Storage extends Singleton {
	/**
	 * Waitlists table name.
	 *
	 * @const string
	 */
	const WAITLISTS_TABLE = 'woodmart_waitlists';

	/**
	 * Constructor.
	 */
	public function init() {
		self::define_tables();

		if ( ! get_option( 'wd_waitlist_installed' ) ) {
			add_action( 'admin_init', array( __CLASS__, 'install' ), 100 );
		}

		add_action( 'admin_init', array( $this, 'add_email_language_column' ), 110 );
	}

	/**
	 * Create an entry in the waiting list table.
	 *
	 * @param string     $email User email.
	 * @param WC_Product $product Product instance.
	 *
	 * @return int ID recording.
	 */
	public function create_subscription( $email, $product, $email_language = '' ) {
		global $wpdb;

		$data = array_merge(
			$this->get_product_ids_by_type( $product ),
			array(
				'user_id'           => get_current_user_id(),
				'user_email'        => $email,
				'email_language'    => $email_language,
				'unsubscribe_token' => wp_generate_password( 24, false ),
				'created_date_gmt'  => current_time( 'mysql', 1 ),
			)
		);

		$wpdb->insert( $wpdb->wd_waitlists, $data ); // phpcs:ignore.

		return $wpdb->insert_id;
	}

	/**
	 * Get subscribe data by confirmed token.
	 *
	 * @param string $token Confirm token.
	 */
	public function get_subscription_by_token( $token ) {
		global $wpdb;

		$db_row = $wpdb->get_row( // phpcs:ignore.
			$wpdb->prepare( "SELECT user_email, product_id, variation_id FROM $wpdb->wd_waitlists WHERE confirm_token = %s", $token )
		);

		return $db_row;
	}

	/**
	 * Get waiting lists.
	 *
	 * @param WC_Product $product Product instance.
	 * @param string     $email User email.
	 * @param string|int $user_id User id.
	 * @param bool       $confirmed Refund only those records that have confirmed email.
	 * @param bool|int   $page What is the pagination page.
	 *
	 * @return stdClass[]|null Retrieve waiting lists.
	 */
	public function get_waitlists( $product = '', $email = '', $user_id = '', $confirmed = true, $page = false ) {
		global $wpdb;

		$where = array();

		if ( ! empty( $product ) && $product instanceof WC_Product ) {
			$where_product_key = $this->is_variation_product( $product ) ? 'variation_id' : 'product_id';
			$where[]           = $where_product_key . ' = ' . $product->get_id();
		}

		if ( is_email( $email ) ) {
			$where[] = $wpdb->prepare( 'user_email = %s', $email );
		}

		if ( ! empty( $user_id ) ) {
			$where[] = $wpdb->prepare( 'user_id = %d', $user_id );
		}

		if ( $confirmed ) {
			$where[] = $wpdb->prepare( 'confirmed = %d', 1 );
		}

		$query = "SELECT * FROM $wpdb->wd_waitlists";

		if ( ! empty( $where ) ) {
			$query .= ' WHERE ' . implode( ' AND ', $where );
		}

		if ( $page ) {
			$items_per_page = abs( apply_filters( 'woodmart_waitlist_per_page', 12 ) );
			$offset         = ( $page - 1 ) * $items_per_page;
			$query         .= $wpdb->prepare(
				' LIMIT %d OFFSET %d',
				$items_per_page,
				$offset
			);
		}

		return $wpdb->get_results( $query ); // phpcs:ignore.
	}

	/**
	 * Get waiting lists by product.
	 *
	 * @param WC_Product $product Product instance.
	 *
	 * @return stdClass[]|null Retrieve waiting lists.
	 */
	public function get_subscriptions_by_product( $product ) {
		return $this->get_waitlists( $product );
	}

	/**
	 * Get waiting lists by user id.
	 *
	 * @param string|int $user_id User id.
	 * @param int        $page What is the pagination page.
	 *
	 * @return stdClass[]|null Retrieve waiting lists.
	 */
	public function get_subscriptions_user_id( $user_id, $page ) {
		return $this->get_waitlists( '', '', $user_id, false, $page );
	}

	/**
	 * Get single waiting list by wc product id and user email.
	 *
	 * @param WC_Product $product Product instance.
	 * @param string     $email User email.
	 *
	 * @return stdClass[]|null Retrieve waiting lists.
	 */
	public function get_subscription( $product, $email ) {
		$waitlists = $this->get_waitlists( $product, $email, '', false );

		return isset( $waitlists[0] ) ? $waitlists[0] : $waitlists;
	}

	/**
	 * Get waitlists count.
	 */
	public function get_subscription_count_for_current_user() {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(list_id) FROM $wpdb->wd_waitlists WHERE user_id = %d", get_current_user_id() ) ); // phpcs:ignore.
	}

	/**
	 * Check whether this email saved for this product.
	 *
	 * @param WC_Product $product Product instance.
	 * @param string     $email User email.
	 *
	 * @return bool Isn't the empty waiting list?
	 */
	public function check_subscription_exists_by_email( $product, $email ) {
		global $wpdb;

		$where             = array();
		$where_product_key = $this->is_variation_product( $product ) ? 'variation_id' : 'product_id';
		$where[]           = $where_product_key . ' = ' . $product->get_id();
		$where[]           = $wpdb->prepare( 'user_email = %s', $email );

		$query  = "SELECT list_id FROM $wpdb->wd_waitlists";
		$query .= ' WHERE ' . implode( ' AND ', $where );

		return ! empty( $wpdb->get_results( $query ) ); // phpcs:ignore
	}

	/**
	 * Check whether this user_id saved for this product.
	 *
	 * @param WC_Product $product Product instance.
	 * @param string|int $user_id User id.
	 *
	 * @return bool Isn't the empty waiting list?
	 */
	public function check_subscription_exists_by_user_id( $product, $user_id ) {
		global $wpdb;

		$where      = array();
		$product_id = $product->get_id();

		if ( defined( 'WCML_VERSION' ) && defined( 'ICL_SITEPRESS_VERSION' ) ) {
			$product_id = apply_filters( 'wpml_object_id', $product_id, 'product', true, wpml_get_default_language() );
		}

		if ( $this->is_variation_product( $product ) ) {
			$where[] = $wpdb->prepare( 'variation_id = %d', $product_id );
		} else {
			$where[] = $wpdb->prepare( 'product_id = %d', $product_id );
		}

		$where[] = $wpdb->prepare( 'user_id = %d', $user_id );

		$query  = "SELECT list_id FROM $wpdb->wd_waitlists";
		$query .= ' WHERE ' . implode( ' AND ', $where );

		return ! empty( $wpdb->get_results( $query ) ); // phpcs:ignore
	}

	/**
	 * Confirm subscribe data by confirmed token.
	 *
	 * @param string $token Confirm token.
	 */
	public function confirm_subscription( $token ) {
		global $wpdb;

		$db_row = $wpdb->update( // phpcs:ignore.
			$wpdb->wd_waitlists,
			array( 'confirmed' => 1 ),
			array( 'confirm_token' => $token )
		);

		return $db_row ? $db_row : false;
	}

	/**
	 * Update waitlist data.
	 *
	 * @param WC_Product $product Product instance.
	 * @param string     $email User email.
	 * @param array      $data Data that should be updated.
	 *
	 * @return int ID recording.
	 */
	public function update_waitlist_data( $product, $email, $data ) {
		global $wpdb;

		$where = array(
			'user_email' => $email,
		);

		$where_product_key           = $this->is_variation_product( $product ) ? 'variation_id' : 'product_id';
		$where[ $where_product_key ] = $product->get_id();

		$db_row = $wpdb->update( // phpcs:ignore.
			$wpdb->wd_waitlists,
			$data,
			$where
		);

		return $db_row ? $db_row : false;
	}

	/**
	 * Delete waitlist data by unsubscribe token.
	 *
	 * @param string $token Unsubscribe token.
	 */
	public function unsubscribe_by_token( $token ) {
		global $wpdb;

		return $wpdb->delete( $wpdb->wd_waitlists, array( 'unsubscribe_token' => $token ) ); // phpcs:ignore.
	}

	/**
	 * Delete waitlist data.
	 *
	 * @param WC_Product $product Product instance.
	 *
	 * @return int ID deleted recording.
	 */
	public function unsubscribe_current_user( $product ) {
		global $wpdb;

		$data            = $this->get_product_ids_by_type( $product );
		$data['user_id'] = get_current_user_id();

		return $wpdb->delete( $wpdb->wd_waitlists, $data ); // phpcs:ignore.
	}

	/**
	 * Delete waitlist data.
	 *
	 * @param WC_Product $product Product instance.
	 *
	 * @return int ID deleted recording.
	 */
	public function unsubscribe_by_product( $product ) {
		global $wpdb;

		return $wpdb->delete( $wpdb->wd_waitlists, $this->get_product_ids_by_type( $product ) ); // phpcs:ignore.
	}

	/**
	 * Delete waitlist data by product id.
	 *
	 * @param int|string $product_id Product id.
	 *
	 * @return void
	 */
	public function unsubscribe_by_product_id( $product_id ) {
		$product = wc_get_product( $product_id );

		if ( ! $product instanceof WC_Product ) {
			return;
		}

		$this->unsubscribe_by_product( $product );
	}

	/**
	 * Delete waitlist data.
	 *
	 * @param WC_Product $product Product instance.
	 * @param string     $user_email User email.
	 *
	 * @return int ID deleted recording.
	 */
	public function unsubscribe_by_user_email( $product, $user_email ) {
		global $wpdb;

		$data               = $this->get_product_ids_by_type( $product );
		$data['user_email'] = $user_email;

		return $wpdb->delete( $wpdb->wd_waitlists, $data ); // phpcs:ignore.
	}

	/**
	 * Delete all the records from the waiting list that did not confirm the electronic mail address for a specified period of time (2 day).
	 */
	public function remove_not_confirmed_emails() {
		global $wpdb;

		$wpdb->query( // phpcs:ignore.
			"DELETE FROM $wpdb->wd_waitlists
			WHERE created_date_gmt < (NOW() - INTERVAL 2 DAY)
			AND confirmed != 1"
		);
	}

	/**
	 * Define plugin tables aliases.
	 *
	 * @return void
	 */
	public static function define_tables() {
		global $wpdb;

		$wpdb->wd_waitlists = $wpdb->prefix . self::WAITLISTS_TABLE;
		$wpdb->tables[]     = self::WAITLISTS_TABLE;
	}

	/**
	 * Create table.
	 */
	public static function install() {
		global $wpdb;

		if ( ! isset( $_GET['settings-updated'] ) ) {
			return;
		}

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		}

		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . self::WAITLISTS_TABLE;
		$sql             = "CREATE TABLE $table_name (
					list_id bigint(20) NOT NULL AUTO_INCREMENT,
					user_id bigint(20),
					user_email VARCHAR(100) NOT NULL,
					product_id bigint(20) NOT NULL,
					variation_id bigint(20),
					email_language VARCHAR(20),
					confirmed tinyint(1) NOT NULL DEFAULT 0,
					confirm_token VARCHAR(100),
					unsubscribe_token VARCHAR(100),
					created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					created_date_gmt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
					PRIMARY KEY (list_id),
					UNIQUE (confirm_token),
					UNIQUE (unsubscribe_token)
					) $charset_collate;";

		dbDelta( $sql );

		update_option( 'wd_waitlist_installed', true, false );
		update_option( 'woodmart_waitlist_added_email_language_column', true, false );
	}

	public function add_email_language_column() {
		global $wpdb;

		if ( get_option( 'woodmart_waitlist_added_email_language_column' ) ) {
			return;
		}

		$table_name = $wpdb->prefix . self::WAITLISTS_TABLE;

		$wpdb->query( "ALTER TABLE {$table_name} ADD COLUMN email_language VARCHAR(20) AFTER variation_id" );

		update_option( 'woodmart_waitlist_added_email_language_column', true, false );
	}

	/**
	 * Get an array with products ID with their types.
	 *
	 * @param WC_Product $product Product instance.
	 *
	 * @return array
	 */
	public function get_product_ids_by_type( $product ) {
		$product_id = $product->get_id();

		if ( $this->is_variation_product( $product ) ) {
			$variation_id = $product_id;
			$product_id   = $product->get_parent_id();
		} else {
			$variation_id = null;
		}

		return array(
			'product_id'   => $product_id,
			'variation_id' => $variation_id,
		);
	}

	/**
	 * Сheck whether this product can be considered variation.
	 *
	 * @param WC_Product $product Product Object.
	 *
	 * @return bool
	 */
	public function is_variation_product( $product ) {
		return in_array( $product->get_type(), array( 'variation', 'subscription_variation' ), true );
	}
}

DB_Storage::get_instance();
