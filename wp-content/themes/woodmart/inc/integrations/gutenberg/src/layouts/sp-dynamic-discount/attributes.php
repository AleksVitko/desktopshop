<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_dynamic_discount_attrs' ) ) {
	function wd_get_single_product_block_dynamic_discount_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr( wd_get_color_control_attrs( 'quantityColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'quantityTp' );

		$attr->add_attr( wd_get_color_control_attrs( 'priceColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'priceTp' );

		$attr->add_attr( wd_get_color_control_attrs( 'discountColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'discountTp' );

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
