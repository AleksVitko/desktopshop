<?php
if ( ! function_exists( 'wd_gutenberg_brands' ) ) {
	function wd_gutenberg_brands( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		wd_replace_boolean_to_yes_no( array( 'hide_empty', 'filter_in_current_category', 'disable_link', 'with_bg_color', 'hide_pagination_control', 'hide_prev_next_buttons', 'scroll_per_page', 'center_mode', 'wrap', 'autoplay', 'hide_scrollbar', 'autoheight', 'disable_overflow_carousel', 'dynamic_pagination_control', 'scroll_carousel_init' ), $block_attributes );

		$block_attributes['el_class'] = wd_get_gutenberg_element_classes( $block_attributes );
		$block_attributes['el_id']    = wd_get_gutenberg_element_id( $block_attributes );

		$block_attributes['columns_tablet'] = ! empty( $block_attributes['columnsTablet'] ) ? $block_attributes['columnsTablet'] : 'auto';
		$block_attributes['columns_mobile'] = ! empty( $block_attributes['columnsMobile'] ) ? $block_attributes['columnsMobile'] : 'auto';

		$block_attributes['per_row']        = ! empty( $block_attributes['slides_per_view'] ) ? $block_attributes['slides_per_view'] : '3';
		$block_attributes['per_row_tablet'] = ! empty( $block_attributes['slides_per_viewTablet'] ) ? $block_attributes['slides_per_viewTablet'] : 'auto';
		$block_attributes['per_row_mobile'] = ! empty( $block_attributes['slides_per_viewMobile'] ) ? $block_attributes['slides_per_viewMobile'] : 'auto';

		$block_attributes['hide_prev_next_buttons_tablet'] = ! empty( $block_attributes['hide_prev_next_buttonsTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_prev_next_buttons_mobile'] = ! empty( $block_attributes['hide_prev_next_buttonsMobile'] ) ? 'yes' : 'no';

		$block_attributes['hide_pagination_control_tablet'] = ! empty( $block_attributes['hide_pagination_controlTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_pagination_control_mobile'] = ! empty( $block_attributes['hide_pagination_controlMobile'] ) ? 'yes' : 'no';

		$block_attributes['hide_scrollbar_tablet'] = ! empty( $block_attributes['hide_scrollbarTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_scrollbar_mobile'] = ! empty( $block_attributes['hide_scrollbarMobile'] ) ? 'yes' : 'no';

		$block_attributes['spacing_tablet'] = isset( $block_attributes['spacingTablet'] ) ? $block_attributes['spacingTablet'] : '';
		$block_attributes['spacing_mobile'] = isset( $block_attributes['spacingMobile'] ) ? $block_attributes['spacingMobile'] : '';

		if ( ! empty( $block_attributes['align'] ) || ! empty( $block_attributes['alignTablet'] ) || ! empty( $block_attributes['alignMobile'] ) ) {
			$block_attributes['el_class'] .= ' wd-align';
		}

		return woodmart_shortcode_brands( $block_attributes, '' );
	}
}
