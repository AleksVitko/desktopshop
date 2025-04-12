<?php
/**
 * Send promotional email.
 *
 * @package XTS
 */

use XTS\Modules\Waitlist\DB_Storage;

if ( ! class_exists( 'XTS_Email_Waitlist_Subscribe' ) ) :

	/**
	 * Send a letter that the product has been successfully added to Waitlist.
	 */
	class XTS_Email_Waitlist_Subscribe extends Waitlist_Email {
		/**
		 * Email content html.
		 *
		 * @var string
		 */
		protected $content_html = '';

		/**
		 * Email content html.
		 *
		 * @var string
		 */
		protected $content_text = '';

		/**
		 * DB_Storage instance.
		 *
		 * @var DB_Storage
		 */
		protected $db_storage;

		/**
		 * Create an instance of the class.
		 */
		public function __construct() {
			$this->id          = 'woodmart_waitlist_subscribe_email';
			$this->title       = esc_html__( 'Waitlist: subscription confirmed', 'woodmart' );
			$this->description = esc_html__( 'Configure the email that confirms a customer\'s subscription to the waitlist, assuring them that they will receive updates when the requested item is back in stock.', 'woodmart' );

			$this->customer_email = true;
			$this->heading        = esc_html__( 'You will be notified when product is back in stock', 'woodmart' );
			$this->subject        = esc_html__( 'Waitlist subscription confirmed', 'woodmart' );

			$this->template_html  = 'emails/waitlist-subscribe-email.php';
			$this->template_plain = 'emails/plain/waitlist-subscribe-email.php';

			add_action( 'woodmart_waitlist_send_subscribe_email_notification', array( $this, 'trigger' ), 10, 2 );

			parent::__construct();
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

			parent::set_email_args();

			$this->send(
				$this->get_recipient(),
				$this->get_subject(),
				$this->get_content(),
				$this->get_headers(),
				$this->get_attachments()
			);
		}
	}

endif;

return new XTS_Email_Waitlist_Subscribe();
