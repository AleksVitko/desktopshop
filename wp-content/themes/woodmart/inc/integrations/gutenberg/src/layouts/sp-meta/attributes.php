<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_meta_attrs' ) ) {
	function wd_get_single_product_block_meta_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'showSku'        => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showCategories' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showTags'       => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showBrand'      => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'layout'         => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'textAlign'      => array(
					'type'       => 'string',
					'responsive' => true,
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'labelColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'labelTp' );

		$attr->add_attr( wd_get_color_control_attrs( 'valueColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'valueTp' );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
