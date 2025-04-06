<?php
if ( ! function_exists( 'wd_gutenberg_product_filters_attributes' ) ) {
	function wd_gutenberg_product_filters_attributes( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$block_attributes['el_class'] = wd_get_gutenberg_element_classes( $block_attributes );
		$block_attributes['el_id']    = wd_get_gutenberg_element_id( $block_attributes );

		if ( ! empty( $block_attributes['attribute'] ) ) {
			$product_attr = wc_get_attribute( $block_attributes['attribute'] );

			if ( $product_attr ) {
				$block_attributes['attribute'] = wc_attribute_taxonomy_slug( $product_attr->slug );
			}
		}

		wd_replace_boolean_to_yes_no( array( 'show_selected_values' ), $block_attributes );

		return woodmart_filters_attribute_shortcode( $block_attributes, '' );
	}
}
