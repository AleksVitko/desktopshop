<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_price_attrs' ) ) {
	function wd_get_single_product_block_price_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'align' => array(
					'type'       => 'string',
					'responsive' => true,
				),
			)
		);

		$attr->add_attr( wd_get_typography_control_attrs(), 'mainPriceTp' );
		$attr->add_attr( wd_get_typography_control_attrs(), 'oldPriceTp' );
		$attr->add_attr( wd_get_typography_control_attrs(), 'suffixTp' );

		$attr->add_attr( wd_get_color_control_attrs( 'mainPriceTextColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'oldPriceTextColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'suffixTextColor' ) );

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
