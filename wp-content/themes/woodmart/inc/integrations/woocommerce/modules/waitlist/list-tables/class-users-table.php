<?php
/**
 * This file describes class for render view waiting lists in WordPress admin panel.
 *
 * @package Woodmart.
 */

namespace XTS\Modules\Waitlist\List_Table;

use WP_List_Table;
use XTS\Modules\Waitlist\DB_Storage;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Create a new table class that will extend the WP_List_Table.
 */
class Users_Table extends WP_List_Table {
	/**
	 * DB_Storage instance.
	 *
	 * @var DB_Storage
	 */
	protected $db_storage;

	/**
	 * Define what data to show on each column of the table.
	 *
	 * @param array  $item        Data.
	 * @param string $column_name - Current column name.
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		return array_key_exists( $column_name, $item ) ? esc_html( $item[ $column_name ] ) : '';
	}

	/**
	 * Prints column for waitlist user.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="users_emails[]" value="%1$s" />',
			$item['user_email']
		);
	}

	/**
	 * Print column for user thumbnail.
	 *
	 * @param array $item Item for the current record.
	 * @return string Column content
	 */
	public function column_thumb( $item ) {
		$avatar   = get_avatar( $item['user_id'], 40 );
		$edit_url = get_edit_user_link( $item['user_id'] );

		return sprintf( '<a href="%s">%s</a>', $edit_url, $avatar );
	}

	/**
	 * Print column for username
	 *
	 * @param array $item Item for the current record.
	 * @return string Column content
	 * @since 2.0.5
	 */
	public function column_name( $item ) {
		if ( ! $item['user_id'] ) {
			return esc_html__( 'guest', 'woodmart' );
		}

		$user          = get_user_by( 'id', $item['user_id'] );
		$user_edit_url = get_edit_user_link( $item['user_id'] );
		$user_name     = $user->user_login;

		$actions     = array(
			'ID'      => sprintf( 'ID: %s', esc_html( $item['user_id'] ) ),
			'edit'    => sprintf( '<a href="%s" title="%s">%s</a>', $user_edit_url, esc_html__( 'Edit this customer', 'woodmart' ), esc_html__( 'Edit', 'woodmart' ) ),
		);
		$row_actions = $this->row_actions( $actions );

		return sprintf( '<strong><a class="row-title" href="%s">%s</a></strong>%s', $user_edit_url, $user_name, $row_actions );
	}

	/**
	 * Prints column for waitlist user email.
	 *
	 * @param array $item Item to use to print record.
	 *
	 * @return string
	 */
	public function column_email( $item ) {
		$view_waitlist_url   = '';
		$delete_waitlist_url = add_query_arg(
			array(
				'action'     => 'woodmart_delete_waitlist',
				'token'      => $item['unsubscribe_token'],
				'product_id' => $_GET['product_id'],
			),
			admin_url( 'edit.php?post_type=product' )
		);

		if ( '0' !== $item['user_id'] ) {
			$view_waitlist_url = esc_url(
				add_query_arg(
					array(
						'page'     => 'xts-waitlist-page',
						'_user_id' => $item['user_id'],
					),
					admin_url( 'edit.php?post_type=product' )
				)
			);
		}

		$actions = array(
			'delete' => sprintf( '<a href="%s">%s</a>', esc_url( $delete_waitlist_url ), esc_html__( 'Delete', 'woodmart' ) ),
		);

		if ( ! empty( $view_waitlist_url ) ) {
			$actions['view'] = sprintf( '<a href="%s">%s</a>', esc_url( $view_waitlist_url ), esc_html__( 'View', 'woodmart' ) );
		}

		?>
		<?php if ( ! empty( $view_waitlist_url ) ) : ?>
			<a href='<?php echo esc_url( $view_waitlist_url ); ?>'>
		<?php endif; ?>

		<?php echo esc_html( $item['user_email'] ); ?>
		
		<?php if ( ! empty( $view_waitlist_url ) ) : ?>
			</a>
		<?php endif; ?>

		<?php echo $this->row_actions( $actions ); // phpcs:ignore. ?>
		<?php
	}

	/**
	 * Prints column for waitlist user.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_is_registered( $item ) {
		$class = $item['is_registered'] ? 'dashicons-saved' : 'dashicons-minus';
		return '<span class="dashicons ' . $class . '"></span>';
	}

	/**
	 * Prints column for waitlist user.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_date_created( $item ) {
		$date_created = strtotime( $item['created_date'] );
		$time_diff    = time() - $date_created;

		if ( $time_diff < DAY_IN_SECONDS ) {
			// translators: 1. Date diff since wishlist creation (EG: 1 hour, 2 seconds, etc...).
			$row = sprintf( esc_html__( '%s ago', 'woodmart' ), human_time_diff( $date_created ) );
		} else {
			$row = date_i18n( wc_date_format(), $date_created );
		}

		return $row;
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table.
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb'            => '<input type="checkbox" />',
			'thumb'         => '<span class="wc-image tips" data-tip="' . esc_attr__( 'Image', 'woodmart' ) . '">' . esc_html__( 'Image', 'woodmart' ) . '</span>',
			'name'          => esc_html__( 'Name', 'woodmart' ),
			'email'         => esc_html__( 'Email', 'woodmart' ),
			'is_registered' => esc_html__( 'Is registered', 'woodmart' ),
			'date_created'  => esc_html__( 'Date created', 'woodmart' ),
		);
	}

	/**
	 * Define which columns are hidden.
	 *
	 * @return array
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 * Define the sortable columns.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return array(
			'date_created' => array( 'created_date', false ),
		);
	}

	/**
	 * Sets bulk actions for table.
	 *
	 * @return array Array of available actions.
	 */
	public function get_bulk_actions() {
		return array(
			'delete' => esc_html__( 'Delete', 'woodmart' ),
		);
	}

	/**
	 * Delete waitlist on bulk action.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public function process_bulk_action() {
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-' . $this->_args['plural'] ) ) { // phpcs:ignore.
			return;
		}

		// Detect when a bulk action is being triggered...
		$users_emails = isset( $_REQUEST['users_emails'] ) ? array_map( 'sanitize_email', (array) $_REQUEST['users_emails'] ) : false;
		$product_id   = isset( $_REQUEST['product_id'] ) ? intval( $_REQUEST['product_id'] ) : false;
		$variation_id = isset( $_REQUEST['variation_id'] ) ? intval( $_REQUEST['variation_id'] ) : false;

		if ( 'delete' === $this->current_action() && ! empty( $users_emails ) && ! empty( $product_id ) ) {
			foreach ( $users_emails as $users_email ) {
				try {
					$product_id = $variation_id ? $variation_id : $product_id;
					$product    = wc_get_product( $product_id );

					$this->db_storage->unsubscribe_by_user_email( $product, $users_email );
				} catch ( Exception $e ) {
					continue;
				}
			}

			wp_safe_redirect(
				add_query_arg(
					array(
						'page'         => 'xts-waitlist-page',
						'tab'          => 'users',
						'product_id'   => $_REQUEST['product_id'],
						'variation_id' => $_REQUEST['variation_id'],
					),
					admin_url( 'edit.php?post_type=product' )
				)
			);
			die();
		}
	}

	/**
	 * Prepare the items for the table to process.
	 *
	 * @return void
	 */
	public function prepare_items() {
		$this->db_storage = DB_Storage::get_instance();
		$columns          = $this->get_columns();
		$hidden           = $this->get_hidden_columns();
		$sortable         = $this->get_sortable_columns();
		$user_id          = get_current_user_id();

		$items = $this->table_data();
		$data  = array();

		foreach ( $items as $item ) {
			if ( ! get_user_by( 'id', $item['user_id'] ) ) {
				$item['is_registered'] = false;
			} else {
				$item['is_registered'] = true;
			}

			$data[] = $item;
		}

		usort( $data, array( $this, 'sort_data' ) );

		$per_page     = ! empty( get_user_meta( $user_id, 'waitlist_per_page', true ) ) ? get_user_meta( $user_id, 'waitlist_per_page', true ) : 20;
		$current_page = $this->get_pagenum();
		$total_items  = count( $data );

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
			)
		);

		$data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );

		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = $data;

		$this->process_bulk_action();
	}

	/**
	 * Get the table data.
	 *
	 * @return array
	 */
	private function table_data() {
		global $wpdb;

		$where_query  = array();
		$product_id   = isset( $_REQUEST['product_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['product_id'] ) ) : false; // phpcs:ignore.
		$variation_id = isset( $_REQUEST['variation_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['variation_id'] ) ) : false; // phpcs:ignore.

		if ( empty( $product_id ) && empty( $variation_id ) ) {
			return array();
		}

		if ( $product_id ) {
			$where_query[] = $wpdb->prepare( "$wpdb->wd_waitlists.`product_id` = %d", intval( $product_id ) );
		}

		if ( $variation_id ) {
			$where_query[] = $wpdb->prepare( "$wpdb->wd_waitlists.`variation_id` = %d", intval( $variation_id ) );
		}

		$where_query_text = ! empty( $where_query ) ? ' WHERE ' . implode( ' AND ', $where_query ) : '';

		if ( ! wp_cache_get( 'wd_waitlist_users_table_data' ) ) {
			wp_cache_set(
				'wd_waitlist_users_table_data',
				$wpdb->get_results( //phpcs:ignore;
					"SELECT
						$wpdb->wd_waitlists.`user_id`,
						$wpdb->wd_waitlists.`user_email`,
						$wpdb->wd_waitlists.`unsubscribe_token`,
						$wpdb->wd_waitlists.`created_date_gmt` as `created_date`
					FROM $wpdb->wd_waitlists"
					. $where_query_text .
					';',
					ARRAY_A
				)
			);
		}

		return wp_cache_get( 'wd_waitlist_users_table_data' );
	}

	/**
	 * Allows you to sort the data by the variables set in the $_GET.
	 *
	 * @param array $a First array.
	 * @param array $b Next array.
	 * @return int
	 */
	private function sort_data( $a, $b ) {
		// Set defaults.
		$order_by = 'created_date';
		$order    = 'desc';

		// If orderby is set, use this as the sort column.
		if ( ! empty( $_GET['orderby'] ) ) { // phpcs:ignore.
			$order_by = $_GET['orderby']; // phpcs:ignore.
		}

		// If order is set use this as the order.
		if ( ! empty( $_GET['order'] ) ) { // phpcs:ignore.
			$order = $_GET['order']; // phpcs:ignore.
		}

		$result = strcmp( $a[ $order_by ], $b[ $order_by ] );

		if ( is_numeric( $a[ $order_by ] ) && is_numeric( $a[ $order_by ] ) ) {
			$result = $a[ $order_by ] - $b[ $order_by ];
		}

		if ( 'asc' === $order ) {
			return $result;
		}

		return -$result;
	}
}
