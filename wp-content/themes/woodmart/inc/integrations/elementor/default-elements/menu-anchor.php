<?php
/**
 * Elementor column custom controls
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_menu_anchor_before_render' ) ) {
	/**
	 * Column before render.
	 *
	 * @since 1.0.0
	 *
	 * @param object $widget Element.
	 */
	function woodmart_menu_anchor_before_render( $widget ) {
		if ( 'menu-anchor' === $widget->get_name() ) {
			woodmart_enqueue_js_script( 'menu-anchor' );
		}
	}

	add_action( 'elementor/frontend/before_render', 'woodmart_menu_anchor_before_render', 10 );
}
