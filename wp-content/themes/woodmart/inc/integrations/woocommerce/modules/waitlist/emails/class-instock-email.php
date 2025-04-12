<?php
/**
 * Send promotional email.
 *
 * @package XTS
 */

use XTS\Modules\Waitlist\DB_Storage;

if ( ! class_exists( 'XTS_Email_Waitlist_Back_In_Stock' ) ) :

	/**
	 * Send back in stock status product for waitlist subscribers.
	 */
	class XTS_Email_Waitlist_Back_In_Stock extends Waitlist_Email {
		/**
		 * Create an instance of the class.
		 */
		public function __construct() {
			$this->id          = 'woodmart_waitlist_in_stock';
			$this->title       = esc_html__( 'Waitlist: product back in stock', 'woodmart' );
			$this->description = esc_html__( 'Set up the email notification that informs customers when a product they have been waiting for is back in stock.', 'woodmart' );

			$this->customer_email = true;
			$this->heading        = esc_html__( 'Good news! The product you\'ve been waiting for is now back in stock.', 'woodmart' );
			$this->subject        = esc_html__( 'A product you are waiting for is back in stock', 'woodmart' );

			$this->template_html  = 'emails/waitlist-in-stock.php';
			$this->template_plain = 'emails/plain/waitlist-in-stock.php';

			add_action( 'woodmart_waitlist_send_in_stock_notification', array( $this, 'trigger' ) );

			parent::__construct();
		}

		/**
		 * Trigger Function that will send this email to the customer.
		 *
		 * @param stdClass[] $waitlists List of subscribers data.
		 *
		 * @return void
		 */
		public function trigger( $waitlists ) {
			foreach ( $waitlists as $waitlist ) {
				$product_id      = $waitlist->variation_id ? $waitlist->variation_id : $waitlist->product_id;
				$this->object    = wc_get_product( $product_id );
				$this->recipient = $waitlist->user_email;

				if ( ! empty( $waitlist->email_language ) ) {
					$this->email_language = $waitlist->email_language;
					do_action( 'wpml_switch_language', $this->email_language );
				}

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

				$this->db_storage->unsubscribe_by_token( $waitlist->unsubscribe_token );

				do_action( 'wpml_switch_language', apply_filters( 'wpml_default_language', null ) );
			}
		}
	}
endif;

return new XTS_Email_Waitlist_Back_In_Stock();
