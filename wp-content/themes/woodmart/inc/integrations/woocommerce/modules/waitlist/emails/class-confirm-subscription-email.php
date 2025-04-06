<?php
/**
 * Send promotional email.
 *
 * @package XTS
 */

namespace XTS\Modules\Waitlist\Emails;

use XTS\Modules\Waitlist\DB_Storage;
use WP_User;
use WC_Product;

if ( ! class_exists( 'XTS\Modules\Waitlist\Emails\Confirm_Subscription_Email' ) ) :

	/**
	 * Send a letter that the product has been successfully added to Waitlist.
	 */
	class Confirm_Subscription_Email extends Waitlist_Email {
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
			$this->id          = 'woodmart_waitlist_confirm_subscription_email';
			$this->title       = esc_html__( 'Waitlist - Confirm your subscription', 'woodmart' );
			$this->description = esc_html__( 'Configure the email that notifies customers when a product they are interested in is back in stock, ensuring they are among the first to know and can make a purchase promptly.', 'woodmart' );

			$this->customer_email = true;
			$this->heading        = esc_html__( 'Get notified when {product_title} back in stock', 'woodmart' );
			$this->subject        = esc_html__( 'Confirm waitlist subscription', 'woodmart' );

			$this->template_html  = 'emails/waitlist-confirm-subscription-email.php';
			$this->template_plain = 'emails/plain/waitlist-confirm-subscription-email.php';

			add_action( 'woodmart_waitlist_send_confirm_subscription_email_notification', array( $this, 'trigger' ), 10, 2 );

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
		public function trigger( $user_email, $product ) {
			$this->object    = $product;
			$this->recipient = $user_email;

			if ( ! $this->is_enabled() || ! $this->get_recipient() || ! $this->object ) {
				return;
			}

			$confirm_url = $this->get_confirm_subscription_link();

			$this->placeholders = array_merge(
				$this->placeholders,
				array(
					'{confirm_button}' => ( 'html' === $this->get_email_type() ) ? '<div style="margin:0 0 16px;"><a class="xts-add-to-cart" href="' . esc_url( $confirm_url ) . '">' . apply_filters( 'woodmart_waitlist_label_confirm_button', __( 'Confirm now', 'woodmart' ) ) . '</a></div>' : $confirm_url,
				)
			);

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

		/**
		 * Returns text with placeholders that can be used in this email
		 *
		 * @param string $email_type Email type.
		 *
		 * @return string Placeholders
		 *
		 * @since 3.0.0
		 */
		public function get_placeholder_text( $email_type ) {
			$this->placeholders_text = array_merge(
				parent::get_placeholder_text( $email_type ),
				array(
					'confirm_button',
				)
			);

			return $this->placeholders_text;
		}

		/**
		 * Returns default email content.
		 *
		 * @param string $email_type Email type.
		 *
		 * @return string Default content.
		 */
		public function get_default_content( $email_type ) {
			if ( 'plain' === $email_type ) {
				$content  = __( "Hi {user_name}\n", 'woodmart' );
				$content .= __( "Thank you for requesting to join the waitlist for this item:\n", 'woodmart' );
				$content .= "{product_title} {product_price} {product_link}\n";
				$content .= __( "Please click the button below to confirm your email address. Once confirmed, we will notify you when the item is back in stock:{confirm_button}\n", 'woodmart' );
				$content .= __( "Note: The confirmation period is 2 days.\n", 'woodmart' );
				$content .= __( "If you did not request to join this waitlist, please ignore this message.\n", 'woodmart' );
				$content .= __( "Cheers\n", 'woodmart' );
				$content .= "{site_title}\n";

				return trim( $content );
			} else {
				ob_start();
				?>
				<p><?php esc_html_e( 'Hi {user_name}', 'woodmart' ); ?></p>
				<p><?php esc_html_e( 'Thank you for requesting to join the waitlist for this item:', 'woodmart' ); ?></p>
				<table class="td xts-prod-table" cellspacing="0" cellpadding="6" border="1">
					<thead>
						<tr>
							<th class="td" scope="col"></th>
							<th class="td xts-align-start" scope="col"><?php esc_html_e( 'Product', 'woodmart' ); ?></th>
							<th class="td xts-align-end" scope="col"><?php esc_html_e( 'Price', 'woodmart' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="td xts-tbody-td xts-img-col xts-align-start">
								<a href="{product_link}">
									{product_image}
								</a>
							</td>
							<td class="td xts-tbody-td xts-align-start">
								{product_title_with_link}
							</td>
							<td class="td xts-tbody-td xts-align-end">
								{product_price}
							</td>
						</tr>
					</tbody>
				</table>
				<p><?php esc_html_e( 'Please click the button below to confirm your email address. Once confirmed, we will notify you when the item is back in stock:', 'woodmart' ); ?></p>
				{confirm_button}
				<p><?php esc_html_e( 'Note: The confirmation period is 2 days.', 'woodmart' ); ?></p>
				<p><?php esc_html_e( 'If you did not request to join this waitlist, please ignore this message.', 'woodmart' ); ?></p>
				<p><?php esc_html_e( 'Cheers', 'woodmart' ); ?></p>
				<p>{site_title}</p>
				<?php
				$content = ob_get_clean();
				$content = trim( preg_replace( '/^\t{4}/m', '', $content ) );

				return $content;
			}
		}
	}

endif;

return new Confirm_Subscription_Email();
