<?php
if ( ! function_exists( 'wd_gutenberg_product_categories' ) ) {
	function wd_gutenberg_product_categories( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		wd_replace_boolean_to_yes_no( array( 'images', 'product_count', 'mobile_accordion', 'hide_empty', 'shop_categories_ancestors', 'shop_categories_ancestors', 'hide_pagination_control', 'hide_prev_next_buttons', 'scroll_per_page', 'center_mode', 'wrap', 'autoplay', 'hide_scrollbar', 'autoheight', 'disable_overflow_carousel', 'dynamic_pagination_control', 'scroll_carousel_init' ), $block_attributes );

		$block_attributes['categories_design']      = ! empty( $block_attributes['categories_design'] ) ? $block_attributes['categories_design'] : woodmart_get_opt( 'categories_design' );

		$block_attributes['el_class'] = wd_get_gutenberg_element_classes( $block_attributes );
		$block_attributes['el_id']    = wd_get_gutenberg_element_id( $block_attributes );

		$block_attributes['columns_tablet'] = ! empty( $block_attributes['columnsTablet'] ) ? $block_attributes['columnsTablet'] : 'auto';
		$block_attributes['columns_mobile'] = ! empty( $block_attributes['columnsMobile'] ) ? $block_attributes['columnsMobile'] : 'auto';

		$block_attributes['slides_per_view_tablet'] = ! empty( $block_attributes['slides_per_viewTablet'] ) ? $block_attributes['slides_per_viewTablet'] : 'auto';
		$block_attributes['slides_per_view_mobile'] = ! empty( $block_attributes['slides_per_viewMobile'] ) ? $block_attributes['slides_per_viewMobile'] : 'auto';

		$block_attributes['hide_prev_next_buttons_tablet'] = ! empty( $block_attributes['hide_prev_next_buttonsTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_prev_next_buttons_mobile'] = ! empty( $block_attributes['hide_prev_next_buttonsMobile'] ) ? 'yes' : 'no';

		$block_attributes['hide_pagination_control_tablet'] = ! empty( $block_attributes['hide_pagination_controlTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_pagination_control_mobile'] = ! empty( $block_attributes['hide_pagination_controlMobile'] ) ? 'yes' : 'no';

		$block_attributes['hide_scrollbar_tablet'] = ! empty( $block_attributes['hide_scrollbarTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_scrollbar_mobile'] = ! empty( $block_attributes['hide_scrollbarMobile'] ) ? 'yes' : 'no';

		$block_attributes['spacing_tablet'] = isset( $block_attributes['spacingTablet'] ) ? $block_attributes['spacingTablet'] : '';
		$block_attributes['spacing_mobile'] = isset( $block_attributes['spacingMobile'] ) ? $block_attributes['spacingMobile'] : '';

		if ( isset( $block_attributes['type'] ) && 'navigation' === $block_attributes['type'] && ( ! empty( $block_attributes['navAlignment'] ) || ! empty( $block_attributes['navAlignmentTablet'] ) || ! empty( $block_attributes['navAlignmentMobile'] ) ) ) {
			$block_attributes['el_class'] .= ' wd-align';
		}

		if ( ! empty( $block_attributes['masonry_grid'] ) ) {
			$block_attributes['style'] = 'masonry';
		}

		if ( ! empty( $block_attributes['img_size'] ) && 'custom' === $block_attributes['img_size'] && ( ! empty( $block_attributes['imgSizeCustomHeight'] ) || ! empty( $block_attributes['imgSizeCustomWidth'] ) ) ) {
			woodmart_set_loop_prop(
				'product_categories_image_size_custom',
				array(
					'width'  => $block_attributes['imgSizeCustomWidth'],
					'height' => $block_attributes['imgSizeCustomHeight'],
				)
			);
		}

		return woodmart_shortcode_categories( $block_attributes, '' );
	}
}
