<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_add_to_cart_attrs' ) ) {
	function wd_get_single_product_block_add_to_cart_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'align'                     => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'buttonDesign'              => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'design'                    => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'swatchLayout'              => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'clearButtonPosition'       => array(
					'type'    => 'string',
					'default' => 'side',
				),
				'clearButtonPositionTablet' => array(
					'type'    => 'string',
					'default' => 'side',
				),
				'labelPosition'             => array(
					'type'    => 'string',
					'default' => 'side',
				),
				'labelPositionTablet'       => array(
					'type'    => 'string',
					'default' => 'side',
				),
				'stockStatus'               => array(
					'type'    => 'boolean',
					'default' => true,
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
