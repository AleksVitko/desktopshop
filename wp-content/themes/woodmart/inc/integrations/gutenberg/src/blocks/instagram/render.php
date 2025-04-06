<?php
if ( ! function_exists( 'wd_gutenberg_instagram' ) ) {
	function wd_gutenberg_instagram( $block_attributes, $content ) {
		$block_attributes['el_class'] = wd_get_gutenberg_element_classes( $block_attributes );
		$block_attributes['el_id']    = wd_get_gutenberg_element_id( $block_attributes );
		$block_attributes['is_wpb']   = false;

		if ( 'images' === $block_attributes['data_source'] && ! empty( $block_attributes['images'] ) ) {
			$block_attributes['images'] = implode( ',', array_column( $block_attributes['images'], 'id' ) );
		}

		$block_attributes['hide_prev_next_buttons_tablet'] = ! empty( $block_attributes['hide_prev_next_buttonsTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_prev_next_buttons_mobile'] = ! empty( $block_attributes['hide_prev_next_buttonsMobile'] ) ? 'yes' : 'no';

		$block_attributes['hide_pagination_control_tablet'] = ! empty( $block_attributes['hide_pagination_controlTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_pagination_control_mobile'] = ! empty( $block_attributes['hide_pagination_controlMobile'] ) ? 'yes' : 'no';

		$block_attributes['hide_scrollbar_tablet'] = ! empty( $block_attributes['hide_scrollbarTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_scrollbar_mobile'] = ! empty( $block_attributes['hide_scrollbarMobile'] ) ? 'yes' : 'no';

		$block_attributes['spacing_custom_tablet'] = isset( $block_attributes['spacing_customTablet'] ) ? $block_attributes['spacing_customTablet'] : '';
		$block_attributes['spacing_custom_mobile'] = isset( $block_attributes['spacing_customMobile'] ) ? $block_attributes['spacing_customMobile'] : '';

		if ( 'slider' === $block_attributes['design'] ) {
			$block_attributes['per_row']        = ! empty( $block_attributes['slides_per_view'] ) ? $block_attributes['slides_per_view'] : 3;
			$block_attributes['per_row_tablet'] = ! empty( $block_attributes['slides_per_viewTablet'] ) ? $block_attributes['slides_per_viewTablet'] : 'auto';
			$block_attributes['per_row_mobile'] = ! empty( $block_attributes['slides_per_viewMobile'] ) ? $block_attributes['slides_per_viewMobile'] : 'auto';
		} else {
			$block_attributes['per_row_tablet'] = ! empty( $block_attributes['per_rowTablet'] ) ? $block_attributes['per_rowTablet'] : 'auto';
			$block_attributes['per_row_mobile'] = ! empty( $block_attributes['per_rowMobile'] ) ? $block_attributes['per_rowMobile'] : 'auto';
		}

		$block_attributes['hide_mask'] = isset( $block_attributes['show_meta'] ) ? ! $block_attributes['show_meta'] : 0;

		wd_replace_boolean_to_yes_no( array( 'hide_pagination_control', 'hide_prev_next_buttons', 'scroll_per_page', 'center_mode', 'wrap', 'autoplay', 'hide_scrollbar', 'autoheight', 'disable_overflow_carousel', 'dynamic_pagination_control', 'scroll_carousel_init' ), $block_attributes );

		if ( ! empty( $block_attributes['images_size'] ) && 'custom' === $block_attributes['images_size'] && ( ! empty( $block_attributes['imgSizeCustomHeight'] ) || ! empty( $block_attributes['imgSizeCustomWidth'] ) ) ) {
			$block_attributes['images_size'] = $block_attributes['imgSizeCustomWidth'] . 'x' . $block_attributes['imgSizeCustomHeight'];
		}

		if ( empty( $block_attributes['show_content'] ) ) {
			$content = '';
		}

		return woodmart_shortcode_instagram( $block_attributes, $content );
	}
}
