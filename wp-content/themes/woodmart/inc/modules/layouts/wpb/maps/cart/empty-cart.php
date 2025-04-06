<?php
/**
 * Content map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_empty_cart_template' ) ) {
	/**
	 * Content map.
	 */
	function woodmart_get_vc_map_empty_cart_template() {
		return array(
			'base'        => 'woodmart_empty_cart',
			'name'        => esc_html__( 'Empty cart', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Cart elements', 'woodmart' ), 'empty_cart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/ct-icons/ct-empty-cart.svg',
			'params'      => array(
				array(
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),

				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
				),
				woodmart_get_vc_responsive_spacing_map(),
			),
		);
	}
}
