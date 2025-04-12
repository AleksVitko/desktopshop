<?php
/**
 * Send abandoned cart email.
 *
 * @package XTS
 */

if ( ! class_exists( 'XTS_Email_Abandoned_Cart' ) ) :

	/**
	 * Send abandoned cart email.
	 */
	class XTS_Email_Abandoned_Cart extends WC_Email {
		/**
		 * True when the email notification is sent to customers.
		 *
		 * @var bool
		 */
		protected $customer_email = true;

		/**
		 * WC_Product instance.
		 *
		 * @var WC_Product;
		 */
		public $object;

		/**
		 * WC_Coupon instance.
		 *
		 * @var WC_Coupon|false
		 */
		public $coupon;

		/**
		 * User name.
		 *
		 * @var string $user_name
		 */
		public $user_name;

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id          = 'woodmart_abandoned_cart_email';
			$this->title       = esc_html__( 'Abandoned cart: incomplete purchase notification', 'woodmart' );
			$this->description = esc_html__( 'This email reminds customers about their incomplete purchases, encouraging them to complete their orders.', 'woodmart' );

			$this->heading = wp_kses_post( __( 'Don\'t Forget to Complete Your Purchase!', 'woodmart' ) );
			$this->subject = wp_kses_post( __( 'Don\'t Forget to Complete Your Purchase!', 'woodmart' ) );

			$this->template_html  = 'emails/abandoned-cart.php';
			$this->template_plain = 'emails/plain/abandoned-cart.php';

			// Triggers for this email.
			add_action( 'woodmart_send_abandoned_cart_notification', array( $this, 'trigger' ) );

			add_filter( 'woodmart_emails_list', array( $this, 'register_woodmart_email' ) );

			// Call parent constructor.
			parent::__construct();
		}

		public function register_woodmart_email( $email_class ) {
			$email_class[] = get_class( $this );

			return $email_class;
		}

		/**
		 * Method triggered to send email.
		 *
		 * @param array $cart_data Abandoned art data.
		 *
		 * @return void
		 */
		public function trigger( $cart_data ) {
			$this->object    = $cart_data;
			$this->recipient = $this->object->_user_email;

			if ( ! empty( $this->object->_language ) ) {
				do_action( 'wpml_switch_language', $this->object->_language );
			}

			$user = get_user_by( 'email', $this->recipient );

			if ( $user instanceof WP_User ) {
				$user_name = $user->display_name;
			} elseif ( ! empty( $this->object->_user_first_name ) || ! empty( $this->object->_user_last_name ) ) {
				$user_name = $this->object->_user_first_name . ' ' . $this->object->_user_last_name;
			} else {
				$user_name = esc_html__( 'Customer', 'woodmart' );
			}

			$this->user_name = $user_name;
			$this->coupon    = $this->create_and_get_coupon();

			if ( ! $this->is_enabled() || ! $this->get_recipient() || ! $this->object ) {
				return;
			}

			$this->send(
				$this->get_recipient(),
				$this->get_subject(),
				$this->get_content(),
				$this->get_headers(),
				$this->get_attachments()
			);

			do_action( 'wpml_switch_language', apply_filters( 'wpml_default_language', null ) );
		}

		/**
		 * Get content html.
		 *
		 * @return string
		 */
		public function get_content_html() {
			ob_start();

			wc_get_template(
				$this->template_html,
				array(
					'email'               => $this,
					'email_heading'       => $this->get_heading(),
					'unsubscribe_link'    => $this->get_unsubscribe_link(),
					'recover_button_link' => $this->get_recover_button_link(),
					'coupon'              => $this->coupon,
					'sent_to_admin'       => false,
					'plain_text'          => false,
				)
			);

			return ob_get_clean();
		}

		/**
		 * Get content plain.
		 *
		 * @return string
		 */
		public function get_content_plain() {
			ob_start();

			wc_get_template(
				$this->template_plain,
				array(
					'email'               => $this,
					'email_heading'       => $this->get_heading(),
					'unsubscribe_link'    => $this->get_unsubscribe_link(),
					'recover_button_link' => $this->get_recover_button_link(),
					'coupon'              => $this->coupon,
					'sent_to_admin'       => false,
					'plain_text'          => true,
				)
			);

			return ob_get_clean();
		}

		/**
		 * Get confirm subscription link.
		 * Create confirm token if not exists.
		 *
		 * @return string Confirm subscription url.
		 */
		public function get_recover_button_link() {
			$args = array( 'wd_rec_cart' => $this->object->ID );

			if ( $this->coupon ) {
				$args['coupon_code'] = $this->coupon->get_code();
			}

			return add_query_arg( $args, wc_get_cart_url() );
		}

		/**
		 * Get unsubscribe link.
		 * Create unsubscribe token if not exists.
		 *
		 * @return string Unsubscribe url.
		 */
		public function get_unsubscribe_link() {
			$unsubscribe_token = hash_hmac( 'sha256', $this->object->_user_email, 'woodmart_abandoned_cart_unsubscribe' );

			return add_query_arg(
				array(
					'token' => $unsubscribe_token,
					'email' => $this->object->_user_email,
				),
				wc_get_page_permalink( 'shop' )
			);
		}

		/**
		 * Init fields that will store admin preferences.
		 *
		 * @return void
		 */
		public function init_form_fields() {
			parent::init_form_fields();

			unset( $this->form_fields['additional_content'] );
		}

		/**
		 * Create a new coupon to send with email and return WC_Coupon instance.
		 *
		 * @return WC_Coupon|false
		 */
		public function create_and_get_coupon() {
			$coupon_enabled = woodmart_get_opt( 'abandoned_cart_coupon_enabled' );
			$discount_type  = woodmart_get_opt( 'abandoned_cart_coupon_discount_type', 'percent' );
			$coupon_amount  = woodmart_get_opt( 'abandoned_cart_coupon_amount', 10 );

			if ( ! $coupon_enabled || ! $discount_type || ! $coupon_amount ) {
				return false;
			}

			$expiry_date = '';

			if ( woodmart_get_opt( 'abandoned_cart_delete_expired_coupons', true ) ) {
				$expiry_date = time() + intval( woodmart_get_opt( 'abandoned_cart_coupon_timeframe', 1 ) ) * intval( woodmart_get_opt( 'abandoned_cart_coupon_timeframe_period', DAY_IN_SECONDS ) );
				$expiry_date = gmdate( 'Y-m-d h:i:s', $expiry_date );
			}

			if ( woodmart_is_email_preview_request() ) {
				$dummy_coupon = new class( $coupon_amount, $discount_type, $expiry_date ) {
					private $coupon_amount;
					private $discount_type;
					private $expiry_date;

					public function __construct( $coupon_amount, $discount_type, $expiry_date ) {
						$this->coupon_amount = $coupon_amount;
						$this->discount_type = $discount_type;
						$this->expiry_date   = $expiry_date;
					}

					public function get_amount() {
						return $this->coupon_amount;
					}

					public function get_discount_type() {
						return $this->discount_type;
					}

					public function get_date_expires() {
						return woodmart_get_opt( 'abandoned_cart_delete_expired_coupons', true ) ? new WC_DateTime( $this->expiry_date ) : '';
					}

					public function get_code() {
						return 'DUMMY_COUPON';
					}
				};

				return $dummy_coupon;
			}

			$coupon_prefix = woodmart_get_opt( 'abandoned_cart_coupon_prefix', 'WD' );
			$coupon_code   = substr( strtoupper( uniqid( $coupon_prefix . '_', true ) ), 0, apply_filters( 'woodmart_abandoned_cart_coupon_code_length', 10 ) );
			$coupon        = new WC_Coupon( $coupon_code );

			if ( $coupon->get_amount() ) {
				$new_coupon_id = $coupon->get_id();
			} else {
				$new_coupon_id = wp_insert_post(
					array(
						'post_title'   => $coupon_code,
						'post_content' => '',
						'post_status'  => 'publish',
						'post_author'  => 1,
						'post_type'    => 'shop_coupon',
					)
				);
			}

			$args = apply_filters(
				'woodmart_coupon_args',
				array(
					'discount_type'            => $discount_type,
					'coupon_amount'            => $coupon_amount,
					'individual_use'           => 'yes',
					'product_ids'              => '',
					'exclude_product_ids'      => '',
					'usage_limit'              => '1',
					'expiry_date'              => $expiry_date,
					'apply_before_tax'         => 'yes',
					'free_shipping'            => 'no',
					'wd_abandoned_cart_coupon' => 'yes',
				),
				$new_coupon_id,
				$this->object->ID // Abandoned cart id.
			);

			if ( $args ) {
				foreach ( $args as $key => $arg ) {
					update_post_meta( $new_coupon_id, $key, $arg );
				}
			}

			return new WC_Coupon( $coupon_code );
		}
	}

endif;

return new XTS_Email_Abandoned_Cart();
