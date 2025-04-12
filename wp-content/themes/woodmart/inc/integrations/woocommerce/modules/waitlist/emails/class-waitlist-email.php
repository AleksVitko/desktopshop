<?php
/**
 * Parenting class for letters from the waiting list.
 *
 * @package XTS
 */


use XTS\Modules\Waitlist\DB_Storage;
use XTS\Modules\Unit_Of_Measure\Main as Unit_Of_Measure;
use Automattic\WooCommerce\Utilities\FeaturesUtil;

/**
 * Parenting class for letters from the waiting list.
 */
class Waitlist_Email extends WC_Email {
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
	 * Product image html.
	 *
	 * @var string
	 */
	public $product_image = '';

	/**
	 * Product price html/plain.
	 *
	 * @var string
	 */
	public $product_price = '';

	/**
	 * User name.
	 *
	 * @var string
	 */
	public $user_name = '';

	/**
	 * Email language.
	 *
	 * @var string
	 */
	public $email_language = '';

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct();

		$this->db_storage = DB_Storage::get_instance();

		if ( class_exists( 'XTS\Modules\Unit_Of_Measure\Main', false ) ) {
			$this->unit_of_measure = Unit_Of_Measure::get_instance();
		}

		add_filter( 'woodmart_emails_list', array( $this, 'register_woodmart_email' ) );
	}

	public function set_email_args() {
		$user = get_user_by( 'email', $this->recipient );

		if ( ! empty( $this->email_language ) && defined( 'WCML_VERSION' ) && defined( 'ICL_SITEPRESS_VERSION' ) ) {
			$product_id = $this->object->get_id();
			$product_id = apply_filters( 'wpml_object_id', $product_id, 'product', false, $this->email_language );

			$this->object = wc_get_product( $product_id );
		}

		$this->user_name     = $user instanceof WP_User ? $user->display_name : esc_html__( 'Customer', 'woodmart' );
		$this->product_image = $this->get_product_image_html();
		$this->product_price = $this->get_product_price();
	}

	public function register_woodmart_email( $email_class ) {
		$email_class[] = get_class( $this );

		return $email_class;
	}

	/**
	 * Init form fields for email on admin panel.
	 */
	public function init_form_fields() {
		parent::init_form_fields();

		unset( $this->form_fields['additional_content'] );
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
				'unsubscribe_link' => $this->get_unsubscribe_link(),
				'sent_to_admin'    => false,
				'plain_text'       => true,
			)
		);

		return ob_get_clean();
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

	public function get_product_price() {
		$product_price   = wc_price( $this->object->get_price() );
		$unit_of_measure = false;

		if ( class_exists( 'XTS\Modules\Unit_Of_Measure\Main', false ) ) {
			$unit_of_measure = Unit_Of_Measure::get_instance();
		}

		if ( $unit_of_measure instanceof Unit_Of_Measure ) {
			$unit_of_measure = $this->unit_of_measure->get_unit_of_measure_db( $this->object );

			if ( $unit_of_measure ) {
				$product_price = str_replace( $this->object->get_price_suffix(), '', $product_price );

				if ( 'html' === $this->get_email_type() ) {
					$product_price .= '<span class="xts-unit-slash">/</span><span>' . $unit_of_measure . '</span>' . $this->object->get_price_suffix();
				} else {
					$product_price .= $unit_of_measure . $this->object->get_price_suffix();
				}
			}
		}

		return $product_price;
	}
}
