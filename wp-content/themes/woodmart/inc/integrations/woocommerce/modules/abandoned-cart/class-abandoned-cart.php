<?php
/**
 * Abandoned cart class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Abandoned_Cart;

use XTS\Singleton;
use WOOMC\Currency;
use WC_Cart;
use WC_Order;

/**
 * Abandoned cart class.
 */
class Abandoned_Cart extends Singleton {
	/**
	 * Post type name.
	 *
	 * @var string
	 */
	public $post_type_name = 'wd_abandoned_cart';

	/**
	 * Cut Off time. Default 2 days.
	 *
	 * @var int
	 */
	public $cutoff = 172800;

	/**
	 * Delete abandoned time. Default 30 days.
	 *
	 * @var int
	 */
	public $delete_abandoned_time = 2592000;

	/**
	 * Init.
	 */
	public function init() {
		$this->cutoff                = intval( woodmart_get_opt( 'abandoned_cart_timeframe', 2 ) ) * intval( woodmart_get_opt( 'abandoned_cart_timeframe_period', DAY_IN_SECONDS ) );
		$this->delete_abandoned_time = intval( woodmart_get_opt( 'abandoned_cart_delete_timeframe', 30 ) ) * intval( woodmart_get_opt( 'abandoned_cart_delete_timeframe_period', DAY_IN_SECONDS ) );

		// Enqueue scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'woodmart_localized_string_array', array( $this, 'add_localized_settings' ) );

		add_action( 'woocommerce_cart_updated', array( $this, 'cart_updated' ) );

		add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'update_order_origin' ) );
		add_action( 'woocommerce_admin_order_data_after_order_details', array( $this, 'display_recovered_cart_info' ) );

		add_action( 'wp_ajax_woodmart_recover_guest_cart', array( $this, 'recover_guest_cart' ) );
		add_action( 'wp_ajax_nopriv_woodmart_recover_guest_cart', array( $this, 'recover_guest_cart' ) );

		add_action( 'wp_footer', array( $this, 'maybe_add_privacy_checkbox' ), 10 );

		add_action( 'wp_loaded', array( $this, 'recovery_cart' ), 10 );

		add_action( 'woocommerce_order_status_changed', array( $this, 'order_processed' ), 10 );

		add_filter( 'cron_schedules', array( $this, 'add_cron_schedules' ) );

		add_action( 'woodmart_abandoned_cart_cron', array( $this, 'remove_carts_abandoned_is_expired' ) );
		add_action( 'woodmart_abandoned_cart_cron', array( $this, 'update_carts' ), 20 );

		if ( ! wp_next_scheduled( 'woodmart_abandoned_cart_cron' ) ) {
			wp_schedule_event( time(), apply_filters( 'woodmart_schedule_abandoned_cart_cron', 'fifteen_minutes' ), 'woodmart_abandoned_cart_cron' );
		}
	}

	/**
	 * Add custom cron schedules.
	 *
	 * @param array $schedules List of cron schedules.
	 */
	public function add_cron_schedules( $schedules ) {
		$schedules['fifteen_minutes'] = array(
			'interval' => 15 * MINUTE_IN_SECONDS,
			'display'  => esc_html__( 'Every 15 Minutes', 'woodmart' ),
		);

		return $schedules;
	}

	/**
	 * Update order meta.
	 * Adding '_wd_is_recovered_cart' meta from cookie.
	 *
	 * @param int $order_id Order id.
	 *
	 * @codeCoverageIgnore
	 */
	public function update_order_origin( $order_id ) {
		if ( isset( $_COOKIE['woodmart_recovered_cart'] ) ) {
			$recovered_cart = sanitize_text_field( $_COOKIE['woodmart_recovered_cart'] );

			update_post_meta( $order_id, '_wd_is_recovered_cart', $recovered_cart );
		}
	}

	/**
	 * Add label on admin panel.
	 *
	 * @param WC_Order $order Order id.
	 *
	 * @codeCoverageIgnore
	 */
	public function display_recovered_cart_info( $order ) {
		if ( ! get_post_meta( $order->get_id(), '_wd_is_recovered_cart', true ) ) {
			return;
		}

		?>
			<p class="form-field form-field-wide">
				<strong><?php esc_html_e( 'Recovered Cart', 'woodmart' ); ?></strong> 
			</p>
		<?php
	}

	/**
	 * Check if add the privacy checkbox.
	 *
	 * @codeCoverageIgnore
	 */
	public function maybe_add_privacy_checkbox() {
		if ( is_checkout() && woodmart_get_opt( 'recover_guest_cart_enable_privacy_checkbox' ) && ! is_user_logged_in() ) {
			$privacy_text = woodmart_get_opt( 'recover_guest_cart_privacy_checkbox_text' );
			?>
				<div class="wd-data-consent wd-hide">
					<input type="checkbox" id="wd-data-consent">
					<label for="wd-data-consent">
						<?php echo wp_kses_post( $privacy_text ); ?>
					</label>
				</div>
			<?php
		}
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {
		if ( ! woodmart_get_opt( 'recover_guest_cart_enabled' ) ) {
			return;
		}

		if ( is_checkout() && ! is_user_logged_in() ) {
			woodmart_enqueue_js_script( 'abandoned-cart' );
		}
	}

	/**
	 * Add live duration in localized settings.
	 *
	 * @param array $localized Settings.
	 *
	 * @return array
	 */
	public function add_localized_settings( $localized ) {
		if ( woodmart_get_opt( 'recover_guest_cart_enabled' ) && ! is_user_logged_in() && is_checkout() ) {
			$localized['abandoned_cart_security']      = wp_create_nonce( 'wd_recover_guest_cart' );
			$localized['abandoned_cart_currency']      = get_woocommerce_currency();
			$localized['abandoned_cart_language']      = $this->get_user_language();
			$localized['abandoned_cart_needs_privacy'] = woodmart_get_opt( 'recover_guest_cart_enable_privacy_checkbox' ) ? 'yes' : 'no';
		}

		return $localized;
	}

	/**
	 * Called when a cart is updated.
	 *
	 * @return void
	 */
	public function update_carts() {
		$current_time  = time();
		$start_to_date = (int) ( $current_time - $this->cutoff );
		$carts         = get_posts(
			array(
				'post_type'      => $this->post_type_name,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_value'     => 'open', //phpcs:ignore
				'meta_key'       => '_cart_status', //phpcs:ignore
				'date_query'     => array(
					array(
						'column' => 'post_modified_gmt',
						'before' => gmdate( 'Y-m-d H:i:s', $start_to_date ),
					),
				),
			)
		);

		if ( ! empty( $carts ) ) {
			foreach ( $carts as $cart ) {
				$current_status = get_post_meta( $cart->ID, '_cart_status', true );
				$post_modified  = strtotime( $cart->post_modified_gmt );
				$delta          = $current_time - $post_modified;

				// Change the status from open to abandoned if cuttoff time is over.
				if ( $delta > $this->cutoff && 'open' === $current_status ) {
					update_post_meta( $cart->ID, '_cart_status', 'abandoned' );

					wp_update_post(
						array(
							'ID'                => $cart->ID,
							'post_modified'     => current_time( 'mysql' ),
							'post_modified_gmt' => gmdate( 'Y-m-d H:i:s', $current_time ),
						)
					);
				}
			}
		}
	}

	/**
	 * Called by cron to clear abandoned carts.
	 *
	 * @return void
	 */
	public function remove_carts_abandoned_is_expired() {
		if ( ! $this->delete_abandoned_time ) {
			return;
		}

		$start_to_date = (int) ( time() - $this->delete_abandoned_time );
		$carts         = get_posts(
			array(
				'post_type'      => $this->post_type_name,
				'posts_per_page' => -1,
				'meta_key'       => '_cart_status', //phpcs:ignore
				'meta_value'     => 'abandoned', //phpcs:ignore
				'date_query'     => array(
					array(
						'column' => 'post_modified_gmt',
						'before' => gmdate( 'Y-m-d H:i:s', $start_to_date ),
					),
				),
			)
		);

		if ( ! empty( $carts ) ) {
			foreach ( $carts as $cart ) {
				wp_delete_post( $cart->ID, true );
			}
		}
	}

	/**
	 * Update the entry on db.
	 *
	 * When the user update the cart update the entry on db of the current cart.
	 */
	public function cart_updated() {
		if ( isset( $_GET['wd_rec_cart'] ) && isset( $_COOKIE['woodmart_recovered_cart'] ) ) {
			setcookie( 'woodmart_recovered_cart', '', time() - 1, '/' );

			return;
		}

		if ( isset( $_GET['wd_rec_cart'] ) || is_admin() || apply_filters( 'woodmart_skip_register_cart', false ) ) { //phpcs:ignore
			return;
		}

		if ( is_user_logged_in() ) {
			$user_id      = get_current_user_id();
			$user_details = get_userdata( $user_id );
			$email        = $user_details->user_email;

			if ( $this->check_is_unsubscribed_user( $email ) ) {
				return;
			}

			$previous_cart = $this->get_previous_cart( $user_id );
			$get_cart      = WC()->cart->get_cart();
			$title         = $user_details->display_name;
			$first_name    = get_user_meta( $user_id, 'billing_first_name', true );
			$last_name     = get_user_meta( $user_id, 'billing_last_name', true );
			$metas         = apply_filters(
				'woodmart_abandoned_cart_updated_meta',
				array(
					'user_id'         => $user_id,
					'user_email'      => $email,
					'user_first_name' => $first_name ? $first_name : $user_details->first_name,
					'user_last_name'  => $last_name ? $last_name : $user_details->last_name,
					'user_currency'   => $this->get_user_currency(),
					'cart_status'     => 'open',
				)
			);

			if ( ! $previous_cart && ! empty( $get_cart ) ) {
				$post_id = $this->add_abandoned_cart( $title, $metas );
			} elseif ( $previous_cart ) {
				$post_id = $previous_cart->ID;

				if ( ! empty( $get_cart ) && WC()->cart->get_displayed_subtotal() > 0 ) {
					$this->update_abandoned_cart(
						$post_id,
						array(
							'post_modified'     => $previous_cart->post_modified,
							'post_modified_gmt' => $previous_cart->post_modified_gmt,
						),
						array( 'cart_status' => 'open' )
					);
				} else {
					wp_delete_post( $post_id, true );
				}
			}
		} elseif ( isset( $_COOKIE['woodmart_guest_cart'] ) ) {
			$post_id = sanitize_text_field( wp_unslash( $_COOKIE['woodmart_guest_cart'] ) );
			$post    = get_post( $post_id );

			if ( ! empty( $post ) ) {
				$this->update_abandoned_cart(
					$post_id,
					array(
						'post_modified'     => $post->post_modified,
						'post_modified_gmt' => $post->post_modified_gmt,
					),
					array( 'cart_status' => 'open' )
				);
			}
		}
	}

	public function check_is_unsubscribed_user( $email ) {
		$unsubscribed_users = get_option( 'woodmart_abandoned_cart_unsubscribed_users', array() );

		return ! empty( $unsubscribed_users ) && in_array( $email, $unsubscribed_users, true );
	}

	/**
	 * Register a guest cart when he add your email address in checkout page.
	 *
	 * @codeCoverageIgnore Don`t coverage because this method use setcookie function.
	 *
	 * @return void
	 */
	public function recover_guest_cart() {
		check_ajax_referer( 'wd_recover_guest_cart', 'security' );

		if ( is_user_logged_in() || empty( $_POST['email'] ) || ! is_email( $_POST['email'] ) || ( isset( $_COOKIE['woodmart_guest_cart'] ) && isset( $_COOKIE['woodmart_recovered_cart'] ) && $_COOKIE['woodmart_guest_cart'] === $_COOKIE['woodmart_recovered_cart'] ) ) { //phpcs:ignore
			return;
		}

		$email = sanitize_email( wp_unslash( $_POST['email'] ) );

		if ( $this->check_is_unsubscribed_user( $email ) ) {
			return;
		}

		$post_id  = 0;
		$add_new  = true;
		$cart     = $this->guest_email_exists( $email );
		$currency = isset( $_POST['currency'] ) ? sanitize_text_field( wp_unslash( $_POST['currency'] ) ) : $this->get_user_currency();

		if ( ! empty( $cart ) ) {
			$post_id = $cart->ID;

			$this->update_abandoned_cart(
				$cart->ID,
				array(
					'post_modified'     => $cart->post_modified,
					'post_modified_gmt' => $cart->post_modified_gmt,
				),
				array(
					'cart_status' => 'open',
				)
			);

			setcookie( 'woodmart_guest_cart', $post_id, time() + $this->delete_abandoned_time * 60, '/' );

			if ( isset( $_COOKIE['woodmart_recovered_cart'] ) && $post_id !== $_COOKIE['woodmart_recovered_cart'] ) {
				setcookie( 'woodmart_recovered_cart', '', time() - 1, '/' );
			}

			$add_new = false;
		} elseif ( isset( $_COOKIE['woodmart_guest_cart'] ) && ! empty( $_COOKIE['woodmart_guest_cart'] ) ) {
			$cart = get_post( sanitize_text_field( wp_unslash( $_COOKIE['woodmart_guest_cart'] ) ) );

			if ( ! empty( $cart ) ) {
				$this->update_abandoned_cart(
					$cart->ID,
					array(
						'post_modified'     => $cart->post_modified,
						'post_modified_gmt' => $cart->post_modified_gmt,
					),
					array(
						'cart_status'   => 'open',
						'user_email'    => $email,
						'user_currency' => $currency,
					)
				);

				setcookie( 'woodmart_guest_cart', $cart->ID, time() + $this->delete_abandoned_time * 60, '/' );

				if ( isset( $_COOKIE['woodmart_recovered_cart'] ) && $cart->ID !== $_COOKIE['woodmart_recovered_cart'] ) {
					setcookie( 'woodmart_recovered_cart', '', time() - 1, '/' );
				}

				$add_new = false;
			}
		}

		if ( $add_new ) {
			$meta_cart = array(
				'user_id'         => '0',
				'user_email'      => $email,
				'user_first_name' => isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '',
				'user_last_name'  => isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '',
				'language'        => isset( $_POST['language'] ) ? sanitize_text_field( wp_unslash( $_POST['language'] ) ) : '',
				'cart_status'     => 'open',
				'user_currency'   => $currency,
			);

			if ( ! empty( $meta_cart['user_first_name'] ) || ! empty( $meta_cart['user_last_name'] ) ) {
				$title = $meta_cart['user_first_name'] . ' ' . $meta_cart['user_last_name'];
			} else {
				$title = $meta_cart['user_email'];
			}

			$post_id = $this->add_abandoned_cart( $title, $meta_cart );

			if ( $post_id ) {
				// Add a cookie to the user.
				setcookie( 'woodmart_guest_cart', $post_id, time() + $this->delete_abandoned_time * 60, '/' );
			}
		}

		wp_send_json(
			array(
				'cart_id' => $post_id,
			)
		);
	}

	/**
	 * Check if the email of the current user exists
	 *
	 * @param string $email Email.
	 *
	 * @return mixed
	 */
	public function guest_email_exists( $email ) {
		$args = array(
			'post_type'   => $this->post_type_name,
			'post_status' => 'publish',
			'meta_query'  => array( //phpcs:ignore
				'relation' => 'AND',
				array(
					'key'   => '_user_email',
					'value' => $email,
				),
				array(
					'key'   => '_user_id',
					'value' => 0,
				),
			),
		);

		$p = get_posts( $args );

		if ( empty( $p ) ) {
			return false;
		}

		return $p[0];
	}

	/**
	 * Add a new abandoned cart
	 *
	 * @param string $title Title.
	 *
	 * @param array  $metas Metas.
	 */
	public function add_abandoned_cart( $title, $metas ) {
		$post = array(
			'post_content' => '',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_type'    => 'wd_abandoned_cart',
		);

		$cart_id = wp_insert_post( $post );

		if ( $cart_id && ! empty( $metas ) ) {
			update_post_meta( $cart_id, '_language', $this->get_user_language() );

			foreach ( $metas as $meta_key => $meta_value ) {
				update_post_meta( $cart_id, '_' . $meta_key, $meta_value );
			}

			update_post_meta( $cart_id, '_cart', maybe_serialize( WC()->cart ) );

			$order    = new WC_Order();
			$checkout = WC()->checkout();

			$checkout->set_data_from_cart( $order );

			$order_totals = $order->get_order_item_totals();
			$subtotal     = $order->get_subtotal();

			update_post_meta( $cart_id, '_order_totals', maybe_serialize( $order_totals ) );
			update_post_meta( $cart_id, '_subtotal', maybe_serialize( $subtotal ) );
		}

		return $cart_id;
	}

	/**
	 * Update abandoned cart
	 *
	 * @param int   $cart_id Cart id.
	 * @param array $post_data Post data for update.
	 * @param array $metas Meta.
	 *
	 * @return int|false|WP_Error
	 */
	public function update_abandoned_cart( $cart_id, $post_data, $metas ) {
		$cart = WC()->cart;

		if ( 0 === $cart->get_cart_contents_count() ) {
			wp_delete_post( $cart_id );

			return false;
		}

		$post_updated = array_merge(
			array(
				'ID'        => $cart_id,
				'post_type' => $this->post_type_name,
			),
			$post_data
		);

		$updated = wp_update_post( $post_updated );

		if ( $updated ) {
			foreach ( $metas as $meta_key => $meta_value ) {
				update_post_meta( $cart_id, '_' . $meta_key, $meta_value );
			}

			update_post_meta( $cart_id, '_cart', maybe_serialize( $cart ) );

			$order    = new WC_Order();
			$checkout = WC()->checkout();

			$checkout->set_data_from_cart( $order );

			$order_totals = $order->get_order_item_totals();
			$subtotal     = $order->get_subtotal();

			update_post_meta( $cart_id, '_order_totals', maybe_serialize( $order_totals ) );
			update_post_meta( $cart_id, '_subtotal', maybe_serialize( $subtotal ) );
		}

		return $updated;
	}

	/**
	 * Recovery cart from cart email link.
	 *
	 * @codeCoverageIgnore Don`t coverage because this method use setcookie function.
	 *
	 * @return void
	 */
	public function recovery_cart() {
		if ( ! isset( $_GET['wd_rec_cart'] ) ) {
			return;
		}

		$cart_id     = intval( wp_unslash( $_GET['wd_rec_cart'] ) );
		$coupon_code = isset( $_GET['coupon_code'] ) ? sanitize_text_field( wp_unslash( $_GET['coupon_code'] ) ) : '';
		$cart        = get_post( $cart_id );

		if ( empty( $cart ) ) {
			wc_add_notice( esc_html__( 'The cart you\'re trying to recover has expired.', 'woodmart' ), 'error' );
			wp_safe_redirect( wc_get_cart_url() );
			exit;
		}

		// Add abandoned cart into the session.
		$stored_cart = maybe_unserialize( get_post_meta( $cart_id, '_cart', true ) );

		// We check the content of meta-data.
		if ( ! $stored_cart instanceof WC_Cart ) {
			wc_add_notice( esc_html__( 'The cart you\'re trying to recover is empty.', 'woodmart' ), 'error' );
			wp_safe_redirect( wc_get_cart_url() );
			exit;
		}

		$cart_data = $stored_cart->get_cart();

		if ( ! empty( $cart_data ) ) {
			// Clear current cart and set new cart data.
			WC()->cart->empty_cart();

			foreach ( $cart_data as $cart_item_key => $cart_item ) {
				WC()->cart->add_to_cart(
					$cart_item['product_id'],
					$cart_item['quantity'],
					isset( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : '',
					isset( $cart_item['variation'] ) ? $cart_item['variation'] : '',
					isset( $cart_item['cart_item_data'] ) ? $cart_item['cart_item_data'] : array()
				);
			}

			if ( ! empty( $coupon_code ) && ! WC()->cart->has_discount( $coupon_code ) ) {
				WC()->cart->add_discount( $coupon_code );
			}

			// Set session and cookies.
			WC()->session->set( 'cart', $cart_data );
			WC()->cart->get_cart_from_session();
			WC()->cart->set_session();

			setcookie('woodmart_recovered_cart', $cart_id, time() + 24 * 3600, '/'); //phpcs:ignore

			wc_add_notice( esc_html__( 'Your cart has been recovered successfully.', 'woodmart' ), 'success' );
			wp_safe_redirect( wc_get_cart_url() );

			wp_delete_post( $cart_id, true );
			exit;
		}

		wc_add_notice( esc_html__( 'The cart you\'re trying to recover is empty.', 'woodmart' ), 'error' );
		wp_safe_redirect( wc_get_cart_url() );
		exit;
	}

	/**
	 * Delete cart after order process.
	 *
	 * @codeCoverageIgnore Don`t coverage because this method use setcookie function.
	 *
	 * @param int $order_id Order id.
	 */
	public function order_processed( $order_id ) {
		$order = wc_get_order( $order_id );
		$email = method_exists( $order, 'get_billing_email' ) ? $order->get_billing_email() : false;

		if ( $email ) {
			$carts = get_posts(
				array(
					'post_type'      => $this->post_type_name,
					'posts_per_page' => -1,
					'meta_query'     => array( // phpcs:ignore.
						array(
							'key'     => '_user_email',
							'value'   => $email,
							'compare' => 'LIKE',
						),
					),
				)
			);

			if ( $carts ) {
				foreach ( $carts as $cart ) {
					wp_delete_post( $cart->ID, true );
				}
			}
		}

		setcookie( 'woodmart_recovered_cart', '', time() - 1 );

		if ( isset( $_COOKIE['woodmart_guest_cart'] ) ) {
			setcookie( 'woodmart_guest_cart', '', time() - 1 );
		}
	}

	/**
	 * Get user previous cart.
	 *
	 * @param int $user_id User id.
	 */
	public function get_previous_cart( $user_id ) {
		$args = array(
			'post_type'   => $this->post_type_name,
			'post_status' => 'publish',
			'meta_query'  => array( //phpcs:ignore
				'relation' => 'AND',
				array(
					'key'     => '_user_id',
					'value'   => $user_id,
					'compare' => '=',
				),
				array(
					'key'     => '_cart_status',
					'value'   => 'recovered',
					'compare' => 'NOT LIKE',
				),
			),
		);

		$carts = get_posts( $args );

		if ( empty( $carts ) ) {
			return false;
		} else {
			return $carts[0];
		}
	}

	/**
	 * Return the language of the current user
	 *
	 * @return string
	 */
	public function get_user_currency() {
		$currency = get_woocommerce_currency();

		if ( class_exists( 'WOOCS' ) ) {
			global $WOOCS; //phpcs:ignore

			$currency = $WOOCS->current_currency; //phpcs:ignore
		} elseif ( defined( 'WOOCOMMERCE_MULTICURRENCY_VERSION' ) && class_exists( 'WOOMC\App' ) ) {
			$currency_detector = new Currency\Detector();

			$currency_detector->setup_hooks();
		}

		return $currency;
	}

	/**
	 * Return the language of the current user
	 *
	 * @return string
	 */
	public function get_user_language() {
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			return apply_filters( 'wpml_current_language', null ); //phpcs:ignore.
		} else {
			return substr( get_bloginfo( 'language' ), 0, 2 );
		}
	}
}

Abandoned_Cart::get_instance();
