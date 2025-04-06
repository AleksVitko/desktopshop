<?php
/**
 * Add Free gifts settings on wp admin page.
 *
 * @package woodmart
 */

namespace XTS\Modules\Free_Gifts;

use WP_Error;
use XTS\Singleton;
use XTS\Admin\Modules\Options\Metaboxes;
use XTS\Admin\Modules\Dashboard\Status_Button;
use WC_Product;

/**
 * Add Free gifts settings on wp admin page.
 */
class Admin extends Singleton {
	/**
	 * Metabox class instanse.
	 *
	 * @var Metabox instanse.
	 */
	public $metabox;

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
		add_action( 'woodmart_change_post_status', array( $this, 'clear_transients_on_ajax' ) );
		add_action( 'woocommerce_product_set_stock_status', array( $this, 'clear_transients_on_change_product_state' ), 10, 3 );
		add_action( 'woocommerce_variation_set_stock_status', array( $this, 'clear_transients_on_change_product_state' ), 10, 3 );

		add_action( 'init', array( $this, 'add_metaboxes' ) );

		// Select2 values for free gift options.
		add_action( 'wp_ajax_xts_woo_free_gift_select', array( $this, 'free_gift_select' ) );

		new Status_Button( 'wd_woo_free_gifts', 2 );

		add_action( 'manage_wd_woo_free_gifts_posts_columns', array( $this, 'admin_columns_titles' ) );
		add_action( 'manage_wd_woo_free_gifts_posts_custom_column', array( $this, 'admin_columns_content' ), 10, 2 );
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
		if ( ! $post || 'wd_woo_free_gifts' !== $post->post_type ) {
			return;
		}

		delete_transient( $this->manager->wd_transient_free_gifts_all_rules );
		delete_transient( $this->manager->wd_transient_free_gifts_ids );
		delete_transient( $this->manager->wd_transient_free_gifts_rule . '_' . $post->ID );
	}

	/**
	 * Clear transients on ajax action.
	 *
	 * @return void
	 */
	public function clear_transients_on_ajax() {
		if ( ! wp_doing_ajax() || empty( $_POST['action'] ) || empty( $_POST['id'] ) || 'wd_change_post_status' !== $_POST['action'] ) {
			return;
		}

		$post = get_post( $_POST['id'] );

		if ( ! $post || 'wd_woo_free_gifts' !== $post->post_type ) {
			return;
		}

		delete_transient( $this->manager->wd_transient_free_gifts_all_rules );
		delete_transient( $this->manager->wd_transient_free_gifts_ids );
		delete_transient( $this->manager->wd_transient_free_gifts_rule . '_' . $post->ID );
	}

	/**
	 * Clear transients on change product state status.
	 *
	 * @param integer $product_id Product ID.
	 * @param string  $stock_status Stock status product.
	 * @param object  $product Data product.
	 *
	 * @return void
	 */
	public function clear_transients_on_change_product_state( $product_id, $stock_status, $product ) {
		if ( 'variable' === $product->get_type() ) {
			return;
		}

		$ids = $this->manager->get_all_rule_posts_ids();

		foreach ( $ids as $id ) {
			delete_transient( $this->manager->wd_transient_free_gifts_rule . '_' . $id );
		}

		delete_transient( $this->manager->wd_transient_free_gifts_ids );
		delete_transient( $this->manager->wd_transient_free_gifts_all_rules );
	}

	/**
	 * Add metaboxes for free gifts.
	 *
	 * @return void
	 */
	public function add_metaboxes() {
		$metabox = Metaboxes::add_metabox(
			array(
				'id'         => 'wd_woo_free_gifts_metaboxes',
				'title'      => esc_html__( 'Settings', 'woodmart' ),
				'post_types' => array( 'wd_woo_free_gifts' ),
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
				'id'          => 'free_gifts_rule_type',
				'type'        => 'select',
				'section'     => 'general',
				'name'        => esc_html__( 'Rule type', 'woodmart' ),
				'description' => esc_html__( 'Choose the method for applying gift rules: either automatically add the gift to the cart or display it in a table for manual addition by the customer.', 'woodmart' ),
				'options'     => array(
					'manual'    => array(
						'name'  => esc_html__( 'Manual Gifts', 'woodmart' ),
						'value' => 'manual',
					),
					'automatic' => array(
						'name'  => esc_html__( 'Automatic Gifts', 'woodmart' ),
						'value' => 'automatic',
					),
				),
				'class'       => 'xts-col-6',
				'priority'    => 10,
			)
		);

		$metabox->add_field(
			array(
				'id'           => 'free_gifts',
				'type'         => 'select',
				'section'      => 'general',
				'name'         => esc_html__( 'Free gifts', 'woodmart' ),
				'description'  => esc_html__( 'Select the products that customers can choose from as free gifts with their purchase, allowing them to pick their preferred option.', 'woodmart' ),
				'select2'      => true,
				'multiple'     => true,
				'autocomplete' => array(
					'type'   => 'post',
					'value'  => array( 'product', 'product_variation' ),
					'search' => 'xts_woo_free_gift_select', // Ajax action.
					'render' => 'woodmart_get_post_by_ids_autocomplete',
				),
				'class'        => 'xts-col-6',
				'priority'     => 20,
			)
		);

		$metabox->add_field(
			array(
				'id'       => 'free_gifts_condition',
				'group'    => esc_html__( 'Products in cart condition', 'woodmart' ),
				'type'     => 'conditions',
				'section'  => 'general',
				'priority' => 30,
			)
		);

		$metabox->add_field(
			array(
				'id'          => 'free_gifts_cart_total_min',
				'name'        => esc_html__( 'Cart total min', 'woodmart' ),
				'description' => esc_html__( 'Set the minimum cart total required for customers to qualify for a free gift, ensuring that the gift is only offered on purchases above a specified amount.', 'woodmart' ),
				'group'       => esc_html__( 'Cart price condition', 'woodmart' ),
				'type'        => 'text_input',
				'attributes'  => array(
					'type' => 'number',
					'min'  => '0',
					'step' => '1',
				),
				'default'     => 0,
				'section'     => 'general',
				'priority'    => 40,
				'class'       => 'xts-col-6',
			)
		);

		$metabox->add_field(
			array(
				'id'          => 'free_gifts_cart_total_max',
				'name'        => esc_html__( 'Cart total max', 'woodmart' ),
				'description' => esc_html__( 'Define the maximum cart total for which a free gift is available, ensuring the offer is valid only within a specified purchase range.', 'woodmart' ),
				'group'       => esc_html__( 'Cart price condition', 'woodmart' ),
				'type'        => 'text_input',
				'attributes'  => array(
					'type' => 'number',
					'min'  => '0',
					'step' => '1',
				),
				'section'     => 'general',
				'priority'    => 50,
				'class'       => 'xts-col-6',
			)
		);

		Manager::get_instance()->set_meta_boxes_fields_keys(
			array(
				'free_gifts_rule_type',
				'free_gifts',
				'free_gifts_condition',
				'free_gifts_cart_total_min',
				'free_gifts_cart_total_max',
			)
		);
	}

	/**
	 * Get data from db for render select2 options for free gifts options in admin page.
	 *
	 * @return void
	 */
	public function free_gift_select() {
		check_ajax_referer( 'xts_woo_free_gift_select_nonce', 'security' );

		$search    = isset( $_POST['params']['term'] ) ? $_POST['params']['term'] : false; // phpcs:ignore
		$post_type = isset( $_POST['value'] ) ? explode( ',', $_POST['value'] ) : array( 'product', 'product_variation' ); // phpcs:ignore
		$products  = array();

		$posts = get_posts(
			array(
				's'                => $search,
				'post_type'        => $post_type,
				'post_status'      => 'publish',
				'posts_per_page'   => apply_filters( 'woodmart_get_numberposts_by_query_autocomplete', 20 ),
				'suppress_filters' => false,
			)
		);

		if ( count( $posts ) > 0 ) {
			foreach ( $posts as $post ) {
				$wc_product = wc_get_product( $post->ID );

				if ( $wc_product->has_child() ) {
					continue;
				}

				$products[] = array(
					'id'   => $post->ID,
					'text' => $post->post_title . ' (ID: ' . $post->ID . ')',
				);
			}
		}

		wp_send_json( $products );
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
			'gifts' => esc_html__( 'Gifts', 'woodmart' ),
		) + array_slice( $posts_columns, $offset, null, true );
	}

	/**
	 * Columns content.
	 *
	 * @param string $column_name Column name.
	 * @param int    $post_id     Post id.
	 *
	 * @return void
	 */
	public function admin_columns_content( $column_name, $post_id ) {
		if ( 'gifts' === $column_name ) {
			$gift_ids    = get_post_meta( $post_id, 'free_gifts', true );
			$gift_titles = array();

			if ( empty( $gift_ids ) ) {
				return;
			}

			foreach ( $gift_ids as $gift_id ) {
				$gift_product = wc_get_product( $gift_id );

				if ( ! $gift_product instanceof WC_Product ) {
					continue;
				}

				$gift_titles[] = '<a href="' . get_permalink( $gift_id ) . '">' . $gift_product->get_title() . '</a>';
			}

			echo wp_kses( implode( ' | ', $gift_titles ), true );
		}
	}
}

Admin::get_instance();
