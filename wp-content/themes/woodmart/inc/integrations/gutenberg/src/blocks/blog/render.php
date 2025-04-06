<?php
if ( ! function_exists( 'wd_gutenberg_blog' ) ) {
	function wd_gutenberg_blog( $block_attributes ) {
		wd_replace_boolean_to_yes_no( array( 'hide_pagination_control', 'hide_prev_next_buttons', 'scroll_per_page', 'center_mode', 'wrap', 'autoplay', 'hide_scrollbar', 'autoheight', 'disable_overflow_carousel', 'dynamic_pagination_control', 'scroll_carousel_init' ), $block_attributes );

		$block_attributes['wrapper_classes'] = wd_get_gutenberg_element_classes( $block_attributes );
		$block_attributes['el_id']           = wd_get_gutenberg_element_id( $block_attributes );

		$block_attributes['taxonomies'] = '';

		if ( ! empty( $block_attributes['categoriesIds'] ) ) {
			$block_attributes['taxonomies'] .= $block_attributes['categoriesIds'];
		}
		if ( ! empty( $block_attributes['tagsIds'] ) ) {
			$block_attributes['taxonomies'] .= $block_attributes['taxonomies'] ? ',' : '';
			$block_attributes['taxonomies'] .= $block_attributes['tagsIds'];
		}

		$block_attributes['blog_columns_tablet'] = ! empty( $block_attributes['blog_columnsTablet'] ) ? $block_attributes['blog_columnsTablet'] : 'auto';
		$block_attributes['blog_columns_mobile'] = ! empty( $block_attributes['blog_columnsMobile'] ) ? $block_attributes['blog_columnsMobile'] : 'auto';

		$block_attributes['slides_per_view_tablet'] = ! empty( $block_attributes['slides_per_viewTablet'] ) ? $block_attributes['slides_per_viewTablet'] : 'auto';
		$block_attributes['slides_per_view_mobile'] = ! empty( $block_attributes['slides_per_viewMobile'] ) ? $block_attributes['slides_per_viewMobile'] : 'auto';

		$block_attributes['hide_prev_next_buttons_tablet'] = ! empty( $block_attributes['hide_prev_next_buttonsTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_prev_next_buttons_mobile'] = ! empty( $block_attributes['hide_prev_next_buttonsMobile'] ) ? 'yes' : 'no';

		$block_attributes['hide_pagination_control_tablet'] = ! empty( $block_attributes['hide_pagination_controlTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_pagination_control_mobile'] = ! empty( $block_attributes['hide_pagination_controlMobile'] ) ? 'yes' : 'no';

		$block_attributes['hide_scrollbar_tablet'] = ! empty( $block_attributes['hide_scrollbarTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_scrollbar_mobile'] = ! empty( $block_attributes['hide_scrollbarMobile'] ) ? 'yes' : 'no';

		$block_attributes['blog_spacing_tablet'] = isset( $block_attributes['blog_spacingTablet'] ) ? $block_attributes['blog_spacingTablet'] : '';
		$block_attributes['blog_spacing_mobile'] = isset( $block_attributes['blog_spacingMobile'] ) ? $block_attributes['blog_spacingMobile'] : '';

		if ( ! empty( $block_attributes['layout'] ) ) {
			if ( 'carousel' === $block_attributes['layout'] ) {
				$block_attributes['blog_design'] = 'carousel';
			} else {
				$block_attributes['blog_design'] = 'grid' === $block_attributes['layout'] ? $block_attributes['blog_grid_design'] : $block_attributes['blog_list_design'];
			}
		}

		if ( ! empty( $block_attributes['img_size'] ) && 'custom' === $block_attributes['img_size'] && ( ! empty( $block_attributes['imgSizeCustomHeight'] ) || ! empty( $block_attributes['imgSizeCustomWidth'] ) ) ) {
			$block_attributes['img_size_custom'] = array(
				'width'  => $block_attributes['imgSizeCustomWidth'],
				'height' => $block_attributes['imgSizeCustomHeight'],
			);
		}

		return woodmart_shortcode_blog( $block_attributes );
	}
}
