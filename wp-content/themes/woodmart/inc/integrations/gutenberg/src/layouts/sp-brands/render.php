<?php

use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
	use XTS\Modules\Layouts\Global_Data as Builder_Data;
	use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_brands' ) ) {
	function wd_gutenberg_single_product_brands( $block_attributes, $content ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		if ( ( ! isset( $block_attributes['layout'] ) || 'justify' !== $block_attributes['layout'] ) && ( ! empty( $block_attributes['align'] ) || ! empty( $block_attributes['alignTablet'] ) || ! empty( $block_attributes['alignMobile'] ) ) ) {
			$classes .= ' wd-align';
		}

		if ( ! empty( $block_attributes['title'] ) && ! empty( $block_attributes['layout'] ) ) {
			$classes .= ' wd-layout-' . $block_attributes['layout'];
		}

		if ( ! empty( $block_attributes['style'] ) ) {
			$classes .= ' wd-style-' . $block_attributes['style'];
		}

		if ( ! wp_is_serving_rest_request() ) {
			$classes .= ' wd-single-brands';
		}

		ob_start();

		Main::setup_preview();

		woodmart_product_brand(
			array(
				'classes'    => $classes,
				'element_id' => wd_get_gutenberg_element_id( $block_attributes ),
				'content'    => do_shortcode( $content ),
			)
		);

		Main::restore_preview();

		return ob_get_clean();
	}
}
