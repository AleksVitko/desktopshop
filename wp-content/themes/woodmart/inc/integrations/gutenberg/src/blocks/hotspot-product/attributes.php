<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_hotspot_product_attrs' ) ) {
	function wd_get_block_hotspot_product_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'productId' => array(
					'type'    => 'string',
					'default' => '',
				),
			)
		);

		return $attr->get_attr();
	}
}
