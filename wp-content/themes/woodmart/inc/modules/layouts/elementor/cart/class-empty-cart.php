<?php
/**
 * Cart totals map.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Widget_Base;
use WC_Shortcode_Cart;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Empty_Cart_Template extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_empty_cart';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Empty cart', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-ct-empty-cart';
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
		return Main::is_layout_type( 'empty_cart' );
	}

	/**
	 * Register the widget controls.
	 */
	protected function register_controls() {

	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		wc_get_template( 'cart/cart-empty.php' );
	}
}

Plugin::instance()->widgets_manager->register( new Empty_Cart_Template() );
