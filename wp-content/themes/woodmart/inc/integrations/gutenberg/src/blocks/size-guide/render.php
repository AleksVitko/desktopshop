<?php
if ( ! function_exists( 'wd_gutenberg_size_guide' ) ) {
	function wd_gutenberg_size_guide( $block_attributes ) {
		if ( empty( $block_attributes['size_guide_id'] ) && empty( $block_attributes['inheritProduct'] ) ) {
			return '';
		}

		if ( ! empty( $block_attributes['inheritProduct'] ) ) {
			$block_attributes['size_guide_id'] = 'inherit';
		}

		return woodmart_size_guide_shortcode(
			array(
				'id'          => $block_attributes['size_guide_id'],
				'title'       => $block_attributes['title'],
				'description' => $block_attributes['description'],
				'el_class'    => wd_get_gutenberg_element_classes( $block_attributes ),
				'el_id'       => wd_get_gutenberg_element_id( $block_attributes ),
			)
		);
	}
}
