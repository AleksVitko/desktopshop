<?php
/**
 * Manual free gifts table.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use XTS\Modules\Free_Gifts\Frontend as Free_Gifts_Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Free_Gifts extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_cart_free_gifts';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Free gifts', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-ct-free-gifts';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-cart-elements' );
	}

	/**
	 * Show in panel.
	 *
	 * @return bool Whether to show the widget in the panel or not.
	 */
	public function show_in_panel() {
		return Main::is_layout_type( 'cart' );
	}

	/**
	 * Register the widget controls.
	 */
	protected function register_controls() {
		/**
		 * Style tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'Title', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'css_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-cart-free-gifts',
				'prefix_class' => '',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-el-title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-el-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		if ( ! woodmart_get_opt( 'free_gifts_enabled', 0 ) || ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			return;
		}

		$free_gifts_frontend = Free_Gifts_Frontend::get_instance();

		ob_start();

		$free_gifts_frontend->render_free_gifts_table();

		$gifts_table  = ob_get_clean();
		$is_edit_mode = woodmart_elementor_is_edit_mode() || woodmart_elementor_is_preview_page() || woodmart_elementor_is_preview_mode();

		woodmart_enqueue_js_script( 'free-gifts-table' );

		if ( $gifts_table || ! $is_edit_mode ) {
			echo '<div class="wd-fg">' . $gifts_table . '</div>';
		}
	}
}

Plugin::instance()->widgets_manager->register( new Free_Gifts() );
