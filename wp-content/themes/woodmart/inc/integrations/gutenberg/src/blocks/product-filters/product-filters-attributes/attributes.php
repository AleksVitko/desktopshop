<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_product_filters_attributes_attrs' ) ) {
	function wd_get_block_product_filters_attributes_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'title'                => array(
					'type' => 'string',
				),
				'attribute'            => array(
					'type'    => 'string',
					'default' => '1',
				),
				'categories'           => array(
					'type' => 'string',
				),
				'query_type'           => array(
					'type'    => 'string',
					'default' => 'and',
				),
				'size'                 => array(
					'type'    => 'string',
					'default' => 'normal',
				),
				'shape'                => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'swatch_style'         => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'display'              => array(
					'type'    => 'string',
					'default' => 'list',
				),
				'labels'               => array(
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
