<?php
/**
 * Abandoned cart class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Abandoned_Cart;

use XTS\Singleton;
use WC_Coupon;
use WC_Product;

/**
 * Abandoned cart class.
 */
class Emails extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		add_action( 'init', array( $this, 'unsubscribe_user' ) );

		add_filter( 'woocommerce_email_classes', array( $this, 'register_email' ) );
		add_action( 'woocommerce_init', array( $this, 'load_wc_mailer' ) );

		add_action( 'woodmart_abandoned_cart_cron', array( $this, 'send_abandoned_cart_email' ), 30 );
		add_action( 'woodmart_abandoned_cart_cron', array( $this, 'clear_coupons' ), 40 );

		add_filter( 'woocommerce_prepare_email_for_preview', array( $this, 'prepare_email_for_preview' ) );
	}

	/**
	 * Unsubscribe after the user has followed the link from email.
	 */
	public function unsubscribe_user() {
		if ( ! isset( $_GET['token'] ) || ! isset( $_GET['email'] ) ) { //phpcs:ignore
			return;
		}

		$redirect           = apply_filters( 'woodmart_abandoned_cart_after_unsubscribe_redirect', remove_query_arg( array( 'token', 'email' ) ) );
		$token              = woodmart_clean( $_GET['token'] ); //phpcs:ignore.
		$user_email         = isset( $_GET['email'] ) ? sanitize_email( wp_unslash( $_GET['email'] ) ) : '';
		$unsubscribed_users = get_option( 'woodmart_abandoned_cart_unsubscribed_users', array() );

		if ( ! empty( $user_email ) && ! in_array( $user_email, $unsubscribed_users, true ) && $this->validate_unsubscribe_token( $user_email, $token ) ) {
			$unsubscribed_users[] = $user_email;

			update_option( 'woodmart_abandoned_cart_unsubscribed_users', $unsubscribed_users, false );
		}

		wc_add_notice( esc_html__( 'You have unsubscribed from this product mailing lists', 'woodmart' ), 'success' );
		wp_safe_redirect( $redirect );
		exit();
	}

	/**
	 * Validate the unsubscribe token for an email.
	 *
	 * @param string $email The email to validate.
	 * @param string $token The token to validate.
	 *
	 * @return bool True if the token is valid, false otherwise.
	 */
	public function validate_unsubscribe_token( $email, $token ) {
		$expected_token = hash_hmac( 'sha256', $email, 'woodmart_abandoned_cart_unsubscribe' );

		return hash_equals( $expected_token, $token );
	}

	/**
	 * List of registered emails.
	 *
	 * @param array $emails List of registered emails.
	 *
	 * @return array
	 */
	public function register_email( $emails ) {
		$emails['XTS_Email_Abandoned_Cart'] = include WOODMART_THEMEROOT . '/inc/integrations/woocommerce/modules/abandoned-cart/emails/class-abandoned-cart-email.php';

		return $emails;
	}

	/**
	 * Load woocommerce mailer.
	 */
	public function load_wc_mailer() {
		add_action( 'woodmart_send_abandoned_cart', array( 'WC_Emails', 'send_transactional_email' ), 10, 4 );
	}

	/**
	 * Send abandoned cart email.
	 *
	 * @codeCoverageIgnore
	 */
	public function send_abandoned_cart_email() {
		$carts = get_posts(
			array(
				'post_type'      => Abandoned_Cart::get_instance()->post_type_name,
				'posts_per_page' => apply_filters( 'woodmart_send_abandoned_cart_email_limited', 20 ),
				'orderby'        => 'date',
				'order'          => 'ASC',
				'meta_query'     => array( //phpcs:ignore
					array(
						'key'     => '_cart_status',
						'value'   => 'abandoned',
						'compare' => 'LIKE',
					),
					array(
						'key'     => '_email_sent',
						'compare' => 'NOT EXISTS',
					),
				),
			)
		);

		if ( ! $carts ) {
			return;
		}

		$meta_keys = array(
			'_user_id',
			'_user_email',
			'_user_first_name',
			'_user_last_name',
			'_user_currency',
			'_cart_status',
			'_language',
			'_cart',
			'_order_totals',
			'_subtotal',
		);

		foreach ( $carts as $id => $cart ) {
			$cart_data = array(
				'ID'            => $cart->ID,
				'title'         => $cart->post_title,
				'post_modified' => $cart->post_modified,
			);

			foreach ( $meta_keys as $meta_key ) {
				$cart_data[ $meta_key ] = maybe_unserialize( get_post_meta( $cart->ID, $meta_key, true ) );
			}

			do_action( 'woodmart_send_abandoned_cart', (object) $cart_data );

			update_post_meta( $cart->ID, '_email_sent', gmdate( 'Y-m-d H:i:s', time() ) );
		}
	}

	/**
	 * Clear coupons after use.
	 */
	public function clear_coupons() {
		$delete_after_use = woodmart_get_opt( 'abandoned_cart_delete_used_coupons', true );
		$delete_expired   = woodmart_get_opt( 'abandoned_cart_delete_expired_coupons', true );

		if ( ! $delete_after_use && ! $delete_expired ) {
			return;
		}

		$coupons = get_posts(
			array(
				'post_type'       => 'shop_coupon',
				'posts_per_pages' => -1,
				'meta_key'        => 'wd_abandoned_cart_coupon', //phpcs:ignore
				'meta_value'      => 'yes', //phpcs:ignore
			)
		);

		foreach ( $coupons as $coupon ) {
			$coupon_code = wc_get_coupon_code_by_id( $coupon->ID );
			$wc_coupon   = new WC_Coupon( $coupon_code );

			if ( $delete_after_use ) {
				$usage_count = $wc_coupon->get_usage_count();

				if ( 1 === $usage_count ) {
					wp_delete_post( $coupon->ID );
				}
			}

			if ( $delete_expired ) {
				$date_expires = $wc_coupon->get_date_expires();

				if ( strtotime( $date_expires ) < strtotime( date( 'Y-m-d' ) ) ) { //phpcs:ignore
					wp_delete_post( $coupon->ID );
				}
			}
		}
	}

	/**
	 * Prepare email for preview.
	 *
	 * @param object $preview_email Email object.
	 */
	public function prepare_email_for_preview( $preview_email ) {
		if ( 'XTS_Email_Abandoned_Cart' === get_class( $preview_email ) ) {
			$object = $this->get_dummy_cart_data();

			$preview_email->set_object( $object );
			$preview_email->recipient = 'user_preview@example.com';
			$preview_email->user_name = esc_html__( 'User Preview', 'woodmart' );
		}

		return $preview_email;
	}

	/**
	 * Get a dummy cart data.
	 *
	 * @return array
	 */
	private function get_dummy_cart_data() {
		$dummy_product = new WC_Product();
		$dummy_product->set_name( 'Dummy Product' );
		$dummy_product->set_price( 25 );

		$dummy_cart = new class( $dummy_product ) {
			private $dummy_product;

			public function __construct( $dummy_product ) {
				$this->dummy_product = $dummy_product;
			}

			public function get_subtotal() {
				return 25;
			}

			public function get_cart_contents() {
				return array(
					array(
						'product_id'    => 1,
						'data'          => $this->dummy_product,
						'line_subtotal' => 25,
						'quantity'      => 1,
					),
				);
			}
		};

		$cart_data = array(
			'ID'               => 0,
			'title'            => 'Cart',
			'post_modified'    => gmdate( 'Y-m-d H:i:s', time() ),
			'_user_id'         => 0,
			'_user_email'      => 'user_preview@example.com',
			'_user_first_name' => 'user',
			'_user_last_name'  => 'preview',
			'_user_currency'   => 'USD',
			'_cart_status'     => 'abandoned',
			'_language'        => 'en',
			'_cart'            => $dummy_cart,
		);

		return (object) $cart_data;
	}
}

Emails::get_instance();
