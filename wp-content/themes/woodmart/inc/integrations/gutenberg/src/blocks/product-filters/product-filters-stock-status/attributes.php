<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_product_filters_stock_status_attrs' ) ) {
	function wd_get_block_product_filters_stock_status_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'title'                => array(
					'type' => 'string',
				),
				'onsale'               => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'instock'              => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'onbackorder'          => array(
					'type'    => 'boolean',
					'default' => true,
				),

				'show_selected_values' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'show_dropdown_on'     => array(
					'type'    => 'string',
					'default' => 'click',
				),
			)
		);

		return $attr->get_attr();
	}
}
