<?php
/**
 * Parenting class for letters from the waiting list.
 *
 * @package XTS
 */

namespace XTS\Modules\Waitlist\Emails;

use XTS\Modules\Waitlist\DB_Storage;
use XTS\Modules\Unit_Of_Measure\Main as Unit_Of_Measure;
use WC_Email;
use WC_Product;
use WP_User;

/**
 * Parenting class for letters from the waiting list.
 */
class Waitlist_Email extends WC_Email {
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
	 * List of registered placeholder keys for show in content options descritions..
	 *
	 * @var array
	 */
	protected $placeholders_text = array();

	/**
	 * DB_Storage instance.
	 *
	 * @var DB_Storage
	 */
	protected $db_storage;

	/**
	 * Unit_Of_Measure instance.
	 *
	 * @var Unit_Of_Measure|false
	 */
	protected $unit_of_measure = false;

	/**
	 * WC_Product instance.
	 *
	 * @var WC_Product;
	 */
	public $object;

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->db_storage = DB_Storage::get_instance();

		if ( class_exists( 'XTS\Modules\Unit_Of_Measure\Main', false ) ) {
			$this->unit_of_measure = Unit_Of_Measure::get_instance();
		}

		$this->content_html = $this->get_option( 'content_html' );
		$this->content_text = $this->get_option( 'content_text' );

		add_filter( 'woodmart_emails_list', array( $this, 'register_woodmart_email' ) );

		if ( defined( 'WCML_VERSION' ) ) {
			add_filter( 'woodmart_custom_html_content_' . $this->id, array( $this, 'meybe_translate_content_html' ), 10, 2 );
			add_filter( 'woodmart_custom_text_content_' . $this->id, array( $this, 'meybe_translate_content_text' ), 10, 2 );
		}
	}

	public function register_woodmart_email( $email_class ) {
		$email_class[] = get_class( $this );

		return $email_class;
	}

	/**
	 * Translates the HTML content of a product email if necessary.
	 *
	 * @param string     $content The original HTML content.
	 * @param WC_Product $product The WooCommerce product object.
	 *
	 * @return string The translated HTML content.
	 */
	public function meybe_translate_content_html( $content, $product ) {
		$translated_value = $this->translate_content( 'content_html', $product );

		if ( ! empty( $translated_value ) ) {
			return $this->format_string( $translated_value );
		}

		return $content;
	}

	/**
	 * Translates the text content of a product email if necessary.
	 *
	 * @param string     $content The original text content.
	 * @param WC_Product $product The WooCommerce product object.
	 *
	 * @return string The translated text content.
	 */
	public function meybe_translate_content_text( $content, $product ) {
		$translated_value = $this->translate_content( 'content_text', $product );

		if ( ! empty( $translated_value ) ) {
			return $this->format_string( $translated_value );
		}

		return $content;
	}

	/**
	 * Translates the content of a product email based on the specified key.
	 *
	 * @param string     $key The key identifying the type of content (e.g., 'content_html' or 'content_text').
	 * @param WC_Product $product The WooCommerce product object.
	 *
	 * @return string The translated content.
	 */
	public function translate_content( $key, $product ) {
		$language_info       = wpml_get_language_information( '', $product->get_id() );
		$translated_language = '';

		if ( $language_info ) {
			$translated_language = $language_info['language_code'];
		}

		$option_name    = 'woocommerce_' . $this->id . '_settings';
		$domain         = 'admin_texts_woocommerce_' . $this->id . '_settings';
		$options        = get_option( $option_name );
		$original_value = isset( $options[ $key ] ) ? $options[ $key ] : '';

		$translated_value = apply_filters( 'wpml_translate_single_string', $original_value, $domain, '[' . $option_name . ']' . $key, $translated_language ); // phpcs:ignore.

		return $translated_value;
	}

	/**
	 * Init form fields for email on admin panel.
	 */
	public function init_form_fields() {
		parent::init_form_fields();

		unset( $this->form_fields['additional_content'] );

		$this->form_fields['content_html'] = array(
			'title'       => esc_html__( 'Email HTML content', 'woodmart' ),
			'type'        => 'textarea',
			'description' => sprintf(
				// translators: %1$s Following placeholders.
				esc_html__( 'This field lets you modify the main content of the HTML email. You can use the following placeholders: %1$s.', 'woodmart' ),
				$this->get_placeholder_text_string( $this->get_placeholder_text( 'html' ) )
			),
			'placeholder' => '',
			'css'         => 'min-height: 250px;',
			'default'     => $this->get_default_content( 'html' ),
		);

		$this->form_fields['content_text'] = array(
			'title'       => esc_html__( 'Email text content', 'woodmart' ),
			'type'        => 'textarea',
			'description' => sprintf(
				// translators: %1$s Following placeholders.
				esc_html__( 'This field lets you modify the main content of the text email. You can use the following placeholders: %1$s.', 'woodmart' ),
				$this->get_placeholder_text_string( $this->get_placeholder_text( 'plain' ) )
			),
			'placeholder' => '',
			'css'         => 'min-height: 250px;',
			'default'     => $this->get_default_content( 'plain' ),
		);
	}

	/**
	 * Get email content.
	 *
	 * @return string
	 */
	public function get_content() {
		$user          = get_user_by( 'email', $this->recipient );
		$product_price = wc_price( $this->object->get_price() );

		if ( $this->unit_of_measure instanceof Unit_Of_Measure ) {
			$unit_of_measure = $this->unit_of_measure->get_unit_of_measure_db( $this->object );

			if ( $unit_of_measure ) {
				$product_price  = str_replace( $this->object->get_price_suffix(), '', $product_price );
				$product_price .= '<span class="xts-unit-slash">/</span><span>' . $unit_of_measure . '</span>' . $this->object->get_price_suffix();		
			}
		}

		$this->placeholders = array_merge(
			$this->placeholders,
			array(
				'{product_title}'   => $this->object->get_name(),
				'{product_link}'    => esc_url( $this->object->get_permalink() ),
				'{product_sku}'     => $this->object->get_sku(),
				'{product_price}'   => $product_price,
				'{add_to_cart_url}' => esc_url( add_query_arg( 'add-to-cart', $this->object->get_id(), $this->object->get_permalink() ) ),
				'{user_name}'       => $user instanceof WP_User ? $user->display_name : esc_html__( 'Customer', 'woodmart' ),
				'{user_email}'      => $this->recipient,
			)
		);

		return parent::get_content();
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
				'email'            => $this,
				'email_heading'    => $this->get_heading(),
				'email_content'    => $this->get_custom_content_html(),
				'unsubscribe_link' => $this->get_unsubscribe_link(),
				'sent_to_admin'    => false,
				'plain_text'       => false,
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
				'email'            => $this,
				'email_heading'    => $this->get_heading(),
				'email_content'    => $this->get_custom_content_plain(),
				'unsubscribe_link' => $this->get_unsubscribe_link(),
				'sent_to_admin'    => false,
				'plain_text'       => true,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Retrieve custom email html content
	 *
	 *  @return string Сustom content, with replaced values.
	 */
	public function get_custom_content_html() {
		$user = get_user_by( 'email', $this->recipient );

		$this->placeholders = array_merge(
			$this->placeholders,
			array(
				'{product_image}'           => $this->get_product_image_html(),
				'{product_title_with_link}' => '<a href="' . esc_url( $this->object->get_permalink() ) . '">' . esc_html( $this->object->get_name() ) . '</a>',
			)
		);

		return apply_filters( 'woodmart_custom_html_content_' . $this->id, $this->format_string( stripcslashes( $this->content_html ) ), $this->object );
	}

	/**
	 * Retrieve custom email text content
	 *
	 *  @return string Custom content, with replaced values.
	 */
	public function get_custom_content_plain() {
		return apply_filters( 'woodmart_custom_text_content_' . $this->id, $this->format_string( stripcslashes( $this->content_text ) ), $this->object );
	}

	/**
	 * Get unsubscribe link.
	 * Create unsubscribe token if not exists.
	 *
	 * @return string Unsubscribe url.
	 */
	public function get_unsubscribe_link() {
		$waitlist = $this->db_storage->get_subscription( $this->object, $this->recipient );

		if ( empty( $waitlist ) ) {
			return '';
		}

		$unsubscribe_token = $waitlist->unsubscribe_token;

		return apply_filters(
			'woodmart_waitlist_unsubscribe_url',
			add_query_arg(
				array(
					'action' => 'woodmart_waitlist_unsubscribe',
					'token'  => $unsubscribe_token,
				),
				$this->object->get_permalink()
			)
		);
	}

	/**
	 * Returns the product image.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return string Product image html.
	 */
	public function get_product_image_html() {
		if ( ! $this->object instanceof WC_Product ) {
			return '';
		}

		$image_src   = $this->object->get_image_id() ? wp_get_attachment_image_src( $this->object->get_image_id(), 'thumbnail' )[0] : wc_placeholder_img_src();
		$image_size  = apply_filters( 'woodmart_waitlist_email_thumbnail_size', array( 32, 32 ) );
		$image_style = array(
			'vertical-align' => 'middle',
			'font-size'      => '12px',
		);

		if ( is_rtl() ) {
			$image_style['margin-left'] = '10px';
		} else {
			$image_style['margin-right'] = '10px';
		}

		$image_style = implode('; ', array_map(
			function ($v, $k) {
				return sprintf( "%s=%s", $k, $v );
			},
			$image_style,
			array_keys( $image_style )
		)) . ';';

		ob_start();
		?>
			<div style="margin-bottom: 5px">
				<img src="<?php echo $image_src; // phpcs:ignore. ?>" alt="<?php esc_attr_e( 'Product image', 'woodmart' ); ?>" height="<?php echo esc_attr( $image_size[1] ); ?>" width="<?php echo esc_attr( $image_size[0] ); ?>" style="<?php echo esc_attr( $image_style ); ?> " />
			</div>
		<?php
		$image_html = ob_get_clean();

		return $image_html;
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
		$this->placeholders_text = array(
			// Default placeholders.
			'site_title',
			'site_address',
			'site_url',

			// Custom placeholders.
			'product_title',
			'product_link',
			'product_sku',
			'product_price',
			'add_to_cart_url',
			'user_name',
			'user_email',
		);

		if ( 'html' === $email_type ) {
			$this->placeholders_text = array_merge(
				$this->placeholders_text,
				array(
					'product_image',
					'product_title_with_link',
				)
			);
		}

		return $this->placeholders_text;
	}

	/**
	 * Convert list of registered placeholder keys to string for show in content options descritions.
	 *
	 * @param array $placeholders List of registered placeholder keys.
	 */
	public function get_placeholder_text_string( $placeholders ) {
		$placeholders = array_map(
			function ( $placeholder ) {
				return sprintf(
					'<code>{%s}</code>',
					$placeholder
				);
			},
			$placeholders
		);

		return implode( ' ', $placeholders );
	}

	/**
	 * Returns default email content.
	 *
	 * @param string $email_type Email type.
	 */
	public function get_default_content( $email_type ) {}
}
