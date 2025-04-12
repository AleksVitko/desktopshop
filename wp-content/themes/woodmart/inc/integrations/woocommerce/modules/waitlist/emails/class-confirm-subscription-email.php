<?php
/**
 * Send promotional email.
 *
 * @package XTS
 */

use XTS\Modules\Waitlist\DB_Storage;
use XTS\Modules\Unit_Of_Measure\Main as Unit_Of_Measure;

if ( ! class_exists( 'XTS_Email_Waitlist_Confirm_Subscription' ) ) :

	/**
	 * Send a letter that the product has been successfully added to Waitlist.
	 */
	class XTS_Email_Waitlist_Confirm_Subscription extends Waitlist_Email {
		/**
		 * DB_Storage instance.
		 *
		 * @var DB_Storage
		 */
		protected $db_storage;

		/**
		 * Confirm url html/plain.
		 *
		 * @var string
		 */
		public $confirm_url = '';

		/**
		 * Create an instance of the class.
		 */
		public function __construct() {
			$this->id          = 'woodmart_waitlist_confirm_subscription_email';
			$this->title       = esc_html__( 'Waitlist: confirm your subscription', 'woodmart' );
			$this->description = esc_html__( 'Configure the email that notifies customers when a product they are interested in is back in stock, ensuring they are among the first to know and can make a purchase promptly.', 'woodmart' );

			$this->customer_email = true;
			$this->heading        = esc_html__( 'Get notified when product back in stock', 'woodmart' );
			$this->subject        = esc_html__( 'Confirm waitlist subscription', 'woodmart' );

			$this->template_html  = 'emails/waitlist-confirm-subscription-email.php';
			$this->template_plain = 'emails/plain/waitlist-confirm-subscription-email.php';

			add_action( 'woodmart_waitlist_send_confirm_subscription_email_notification', array( $this, 'trigger' ), 10, 3 );

			parent::__construct();
		}

		/**
		 * Init form fields for email on admin panel.
		 */
		public function init_form_fields() {
			parent::init_form_fields();

			$this->form_fields = array_merge(
				array_slice( $this->form_fields, 0, 1 ),
				array(
					'send_to' => array(
						'title'   => esc_html__( 'Send to', 'woodmart' ),
						'type'    => 'select',
						'default' => 'all',
						'class'   => 'wc-enhanced-select',
						'options' => array(
							'all'   => esc_html__( 'All users', 'woodmart' ),
							'guest' => esc_html__( 'Only non-logged users', 'woodmart' ),
						),
					),
				),
				array_slice( $this->form_fields, 1, null )
			);
		}

		/**
		 * Trigger Function that will send this email to the customer.
		 *
		 * @param string     $user_email User email.
		 * @param WC_Product $product WC_Product instanse.
		 *
		 * @return void
		 */
		public function trigger( $user_email, $product, $email_language = '' ) {
			$this->object         = $product;
			$this->recipient      = $user_email;
			$this->email_language = $email_language;

			if ( ! $this->is_enabled() || ! $this->get_recipient() || ! $this->object ) {
				return;
			}

			$this->confirm_url = $this->get_confirm_subscription_link();

			parent::set_email_args();

			$this->send(
				$this->get_recipient(),
				$this->get_subject(),
				$this->get_content(),
				$this->get_headers(),
				$this->get_attachments()
			);
		}

		/**
		 * Get confirm subscription link.
		 * Create confirm token if not exists.
		 *
		 * @return string Confirm subscription url.
		 */
		public function get_confirm_subscription_link() {
			if ( woodmart_is_email_preview_request() ) {
				return '';
			}

			$waitlist      = $this->db_storage->get_subscription( $this->object, $this->recipient );
			$confirm_token = ! empty( $waitlist ) && property_exists( $waitlist, 'confirm_token' ) ? $waitlist->confirm_token : false;

			if ( ! $confirm_token ) {
				$confirm_token = wp_generate_password( 24, false );

				$this->db_storage->update_waitlist_data(
					$this->object,
					$this->recipient,
					array(
						'confirm_token' => $confirm_token,
					)
				);
			}

			return apply_filters(
				'woodmart_waitlist_confirm_url',
				add_query_arg(
					array(
						'action' => 'woodmart_confirm_subscription',
						'token'  => $confirm_token,
					),
					$this->object->get_permalink()
				)
			);
		}
	}

endif;

return new XTS_Email_Waitlist_Confirm_Subscription();
