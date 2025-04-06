<?php
if ( ! function_exists( 'wd_gutenberg_menu' ) ) {
	function wd_gutenberg_menu( $block_attributes ) {
		$block_attributes['el_class'] = wd_get_gutenberg_element_classes( $block_attributes );
		$block_attributes['el_id']    = wd_get_gutenberg_element_id( $block_attributes );
		$block_attributes['is_wpb']   = false;

		if ( ! empty( $block_attributes['color_scheme'] ) ) {
			$block_attributes['el_class'] .= ' color-scheme-' . $block_attributes['color_scheme'];
		}

		if ( ! empty( $block_attributes['align'] ) || ! empty( $block_attributes['alignTablet'] ) || ! empty( $block_attributes['alignMobile'] ) ) {
			$block_attributes['el_class'] .= ' wd-align';
		}

		return woodmart_shortcode_mega_menu( $block_attributes, '' );
	}
}
