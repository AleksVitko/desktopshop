<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_brands_attrs' ) ) {
	function wd_get_single_product_block_brands_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'title'      => array(
					'type' => 'boolean',
				),
				'layout'     => array(
					'type' => 'string',
				),
				'align'      => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'style'      => array(
					'type' => 'string',
				),
				'imageWidth' => array(
					'type'       => 'number',
					'responsive' => true,
				),
			)
		);

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
