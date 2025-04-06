<?php
if ( ! function_exists( 'wd_gutenberg_social_buttons' ) ) {
	function wd_gutenberg_social_buttons( $block_attributes, $content ) {
		$block_attributes['el_class'] = wd_get_gutenberg_element_classes( $block_attributes );
		$block_attributes['el_id']    = wd_get_gutenberg_element_id( $block_attributes );
		$block_attributes['align']    = '';

		if ( ! empty( $block_attributes['alignment'] ) || ! empty( $block_attributes['alignmentTablet'] ) || ! empty( $block_attributes['alignmentMobile'] ) ) {
			$block_attributes['el_class'] .= ' wd-align';
		}

		return woodmart_shortcode_social( $block_attributes, $content );
	}
}
