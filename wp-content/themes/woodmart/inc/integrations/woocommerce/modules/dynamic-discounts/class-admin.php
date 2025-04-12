<?php
/**
 * Add Dynamic discounts settings on wp admin page.
 *
 * @package woodmart
 */

namespace XTS\Modules\Dynamic_Discounts;

use WP_Error;
use XTS\Singleton;
use XTS\Admin\Modules\Options\Metaboxes;
use XTS\Admin\Modules\Dashboard\Status_Button;

/**
 * Add Dynamic discounts settings on wp admin page.
 */
class Admin extends Singleton {
	/**
	 * Manager instance.
	 *
	 * @var Manager instanse.
	 */
	public $manager;

	/**
	 * Init.
	 */
	public function init() {
		$this->manager = Manager::get_instance();

		add_action( 'new_to_publish', array( $this, 'clear_transients_on_publish' ) );
		add_action( 'save_post', array( $this, 'clear_transients' ), 10, 2 );
		add_action( 'edit_post', array( $this, 'clear_transients' ), 10, 2 );
		add_action( 'deleted_post', array( $this, 'clear_transients' ), 10, 2 );

		add_action( 'init', array( $this, 'add_metaboxes' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		new Status_Button( 'wd_woo_discounts', 2 );

		// Status switcher column in Dynamic Pricing & Discounts post type page.
		add_action( 'manage_wd_woo_discounts_posts_columns', array( $this, 'admin_columns_titles' ) );
		add_action( 'manage_wd_woo_discounts_posts_custom_column', array( $this, 'admin_columns_content' ), 10, 2 );
	}

	/**
	 * Add metaboxes for free gifts.
	 */
	public function add_metaboxes() {
		$metabox = Metaboxes::add_metabox(
			array(
				'id'         => 'xts_woo_discounts_meta_boxes',
				'title'      => esc_html__( 'Settings', 'woodmart' ),
				'post_types' => array( 'wd_woo_discounts' ),
			)
		);

		$metabox->add_section(
			array(
				'id'       => 'general',
				'name'     => esc_html__( 'General', 'woodmart' ),
				'icon'     => 'xts-i-footer',
				'priority' => 10,
			)
		);

		$metabox->add_field(
			array(
				'id'       => '_woodmart_rule_type',
				'type'     => 'select',
				'section'  => 'general',
				'name'     => esc_html__( 'Rule type', 'woodmart' ),
				'options'  => array(
					'bulk' => array(
						'name'  => esc_html__( 'Bulk pricing', 'woodmart' ),
						'value' => 'bulk',
					),
				),
				'class'    => 'xts-col-6 xts-hidden',
				'priority' => 10,
			)
		);

		$metabox->add_field(
			array(
				'id'       => 'discount_rules',
				'group'    => esc_html__( 'Rules', 'woodmart' ),
				'type'     => 'discount_rules',
				'section'  => 'general',
				'priority' => 20,
			)
		);

		$metabox->add_field(
			array(
				'id'       => 'discount_condition',
				'group'    => esc_html__( 'Condition', 'woodmart' ),
				'type'     => 'conditions',
				'section'  => 'general',
				'priority' => 30,
			)
		);

		$metabox->add_field(
			array(
				'id'          => 'woodmart_discount_priority',
				'name'        => esc_html__( 'Priority', 'woodmart' ),
				'description' => esc_html__( 'Set priority for current discount rules. This will be useful if several rules apply to one product.', 'woodmart' ),
				'group'       => esc_html__( 'Settings', 'woodmart' ),
				'type'        => 'text_input',
				'attributes'  => array(
					'type' => 'number',
					'min'  => '1',
				),
				'default'     => 1,
				'section'     => 'general',
				'class'       => 'xts-col-6',
				'priority'    => 40,
			)
		);

		$metabox->add_field(
			array(
				'id'          => 'discount_quantities',
				'type'        => 'select',
				'section'     => 'general',
				'name'        => esc_html__( 'Quantities', 'woodmart' ),
				'description' => esc_html__( 'Choose "Individual variation" to have variations of a variable product count as an individual product.', 'woodmart' ),
				'group'       => esc_html__( 'Settings', 'woodmart' ),
				'options'     => array(
					'individual_variation' => array(
						'name'  => esc_html__( 'Individual variation', 'woodmart' ),
						'value' => 'individual_variation',
					),
					'individual_product'   => array(
						'name'  => esc_html__( 'Individual product', 'woodmart' ),
						'value' => 'individual_product',
					),
				),
				'class'       => 'xts-col-6',
				'priority'    => 50,
			)
		);

		$this->manager->set_meta_boxes_fields_keys(
			array(
				'_woodmart_rule_type',
				'discount_rules',
				'discount_condition',
				'woodmart_discount_priority',
				'discount_quantities',
			)
		);
	}
	
	/**
	 * Clear transients on create post.
	 *
	 * @param WP_Post $post Post object.
	 *
	 * @return void
	 */
	public function clear_transients_on_publish( $post ) {
		$this->clear_transients( 0, $post );
	}

	/**
	 * Clear transients.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post Post object.
	 *
	 * @return void
	 */
	public function clear_transients( $post_id, $post ) {
		if ( ! $post || 'wd_woo_discounts' !== $post->post_type ) {
			return;
		}

		delete_transient( $this->manager->wd_transient_discounts_rule . '_' . $post->ID );
		delete_transient( $this->manager->wd_transient_discounts_ids );
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( 'wd_woo_discounts' !== get_post_type() ) {
			return;
		}

		wp_enqueue_style( 'wd-cont-table-control', WOODMART_ASSETS . '/css/parts/cont-table-control.min.css', array(), WOODMART_VERSION );
	}

	/**
	 * Columns header.
	 *
	 * @param array $posts_columns Columns.
	 *
	 * @return array
	 */
	public function admin_columns_titles( $posts_columns ) {
		$offset = 3;

		return array_slice( $posts_columns, 0, $offset, true ) + array(
			'wd_discount_priority' => esc_html__( 'Priority', 'woodmart' ),
		) + array_slice( $posts_columns, $offset, null, true );
	}

	/**
	 * Columns content.
	 *
	 * @param string $column_name Column name.
	 * @param int    $post_id     Post id.
	 */
	public function admin_columns_content( $column_name, $post_id ) {
		if ( 'wd_discount_priority' === $column_name ) {
			echo esc_html( get_post_meta( $post_id, 'woodmart_discount_priority', true ) );
		}
	}
}

Admin::get_instance();
