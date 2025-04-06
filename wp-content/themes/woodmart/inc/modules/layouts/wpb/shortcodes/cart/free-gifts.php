<?php
/**
 * Manual free gifts table shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;
use XTS\Modules\Free_Gifts\Frontend as Free_Gifts_Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_cart_free_gifts' ) ) {
	/**
	 * Manual free gifts table shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_cart_free_gifts( $settings ) {
		if ( ! woodmart_get_opt( 'free_gifts_enabled', 0 ) || ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			return '';
		}

		$default_settings = array(
			'css' => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes  = ' wd-wpb';
		$wrapper_classes .= apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		$free_gifts_frontend = Free_Gifts_Frontend::get_instance();

		ob_start();

		$free_gifts_frontend->render_free_gifts_table( $wrapper_classes );

		$gifts_table = ob_get_clean();

		ob_start();

		Main::setup_preview();

		if ( ! $gifts_table ) {
			$wrapper_classes .= ' wd-hide';
		}

		woodmart_enqueue_js_script( 'free-gifts-table' );

		echo '<div class="wd-fg' . esc_attr( $wrapper_classes ) . '">' . $gifts_table . '</div>';

		Main::restore_preview();

		return ob_get_clean();
	}
}
