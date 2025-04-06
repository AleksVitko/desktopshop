<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_product_filters_price_attrs' ) ) {
	function wd_get_block_product_filters_price_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'title'                => array(
					'type' => 'string',
				),

				'submit_form_on'       => array(
					'type'    => 'string',
					'default' => 'click',
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
