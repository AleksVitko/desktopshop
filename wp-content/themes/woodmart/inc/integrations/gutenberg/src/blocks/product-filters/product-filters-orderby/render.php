<?php
if ( ! function_exists( 'wd_gutenberg_product_filters_orderby' ) ) {
	function wd_gutenberg_product_filters_orderby( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$block_attributes['el_class'] = wd_get_gutenberg_element_classes( $block_attributes );
		$block_attributes['el_id']    = wd_get_gutenberg_element_id( $block_attributes );

		wd_replace_boolean_to_yes_no( array( 'show_selected_values' ), $block_attributes );

		return woodmart_orderby_filter_template( $block_attributes );
	}
}