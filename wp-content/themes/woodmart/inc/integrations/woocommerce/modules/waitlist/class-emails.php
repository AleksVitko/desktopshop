<?php
/**
 * Emails class file.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Waitlist;

use XTS\Singleton;
use WC_Product;
use WC_Emails;
use stdClass;

/**
 * Emails class.
 */
class Emails extends Singleton {
	/**
	 * DB_Storage instance.
	 *
	 * @var DB_Storage
	 */
	protected $db_storage;

	/**
	 * Constructor.
	 */
	public function init() {
		$this->db_storage = DB_Storage::get_instance();

		add_action( 'init', array( $this, 'confirm_subscription' ) );
		add_action( 'init', array( $this, 'unsubscribe_user' ) );
		add_action( 'woocommerce_init', array( $this, 'load_wc_mailer' ) );
		add_filter( 'woocommerce_email_classes', array( $this, 'register_email' ) );

		add_action( 'woocommerce_product_set_stock_status', array( $this, 'send_instock_email_emails' ), 10, 3 );
		add_action( 'woocommerce_variation_set_stock_status', array( $this, 'send_instock_email_emails' ), 10, 3 );
	}

	/**
	 * Confirm subscription after the user has followed the link from email.
	 */
	public function confirm_subscription() {
		if ( ! isset( $_GET['action'] ) || 'woodmart_confirm_subscription' !== $_GET['action'] ||  ! isset( $_GET['token'] ) ) { //phpcs:ignore
			return;
		}

		$redirect = apply_filters( 'woodmart_waitlist_after_confirm_subscription_redirect', remove_query_arg( array( 'action', 'token' ) ) );
		$token    = woodmart_clean( $_GET['token'] ); //phpcs:ignore

		if ( $this->db_storage->confirm_subscription( $token ) ) {
			$data       = $this->db_storage->get_subscription_by_token( $token );
			$product_id = ! empty( $data->variation_id ) ? $data->variation_id : $data->product_id;
			$product    = wc_get_product( $product_id );

			do_action( 'woodmart_waitlist_send_subscribe_email', $data->user_email, $product );

			wc_add_notice( esc_html__( 'Your waitlist subscription has been successfully confirmed.', 'woodmart' ), 'success' );
		}

		wp_safe_redirect( $redirect );
		exit();
	}

	/**
	 * Unsubscribe after the user has followed the link from email.
	 */
	public function unsubscribe_user() {
		if ( ! isset( $_GET['action'] ) || 'woodmart_waitlist_unsubscribe' !== $_GET['action'] ||  ! isset( $_GET['token'] ) ) { //phpcs:ignore
			return;
		}

		$redirect = apply_filters( 'woodmart_waitlist_after_unsubscribe_redirect', remove_query_arg( array( 'action', 'token' ) ) );
		$token    = woodmart_clean( $_GET['token'] ); //phpcs:ignore.

		$this->db_storage->unsubscribe_by_token( $token );

		wc_add_notice( esc_html__( 'You have unsubscribed from this product mailing lists', 'woodmart' ), 'success' );
		wp_safe_redirect( $redirect );
		exit();
	}

	/**
	 * Load woocommerce mailer.
	 */
	public function load_wc_mailer() {
		add_action( 'woodmart_waitlist_send_in_stock', array( 'WC_Emails', 'send_transactional_email' ), 10, 4 );
		add_action( 'woodmart_waitlist_send_subscribe_email', array( 'WC_Emails', 'send_transactional_email' ), 10, 4 );
		add_action( 'woodmart_waitlist_send_confirm_subscription_email', array( 'WC_Emails', 'send_transactional_email' ), 10, 4 );
	}

	/**
	 * List of registered emails.
	 *
	 * @param array $emails List of registered emails.
	 *
	 * @return array
	 */
	public function register_email( $emails ) {
		include_once XTS_WAITLIST_DIR . 'emails/class-waitlist-email.php'; // Include parent waitlists class.

		$emails['woodmart_waitlist_in_stock']                   = include XTS_WAITLIST_DIR . 'emails/class-instock-email.php';
		$emails['woodmart_waitlist_subscribe_email']            = include XTS_WAITLIST_DIR . 'emails/class-subscribe-email.php';
		$emails['woodmart_waitlist_confirm_subscription_email'] = include XTS_WAITLIST_DIR . 'emails/class-confirm-subscription-email.php';

		return $emails;
	}

	/**
	 * Send a letter of return product to the store.
	 *
	 * @codeCoverageIgnore
	 *
	 * @param integer $product_id Product ID.
	 * @param string  $stock_status Stock status product.
	 * @param object  $product Data product.
	 *
	 * @return void
	 */
	public function send_instock_email_emails( $product_id, $stock_status, $product ) {
		if ( 'instock' !== $stock_status || 'variable' === $product->get_type() ) {
			return;
		}

		$waitlists       = $this->db_storage->get_subscriptions_by_product( $product );
		$waitlists       = apply_filters( 'woodmart_waitlists_instock_list', $waitlists, $product_id );
		$waitlists_chunk = array_chunk( $waitlists, apply_filters( 'woodmart_waitlist_scheduled_email_chunk', 50 ) );
		$schedule_time   = time();

		foreach ( $waitlists_chunk as $waitlist_chunk ) {
			wp_schedule_single_event(
				$schedule_time,
				'woodmart_waitlist_send_in_stock',
				array( $waitlist_chunk )
			);

			$schedule_time += apply_filters( 'woodmart_waitlist_schedule_time', intval( woodmart_get_opt( 'waitlist_wait_interval', HOUR_IN_SECONDS ) ) );
		}
	}
}

Emails::get_instance();
