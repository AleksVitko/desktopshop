<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_meta_value_attrs' ) ) {
	function wd_get_single_product_block_meta_value_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'metaKey' => array(
					'type' => 'string',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'color' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'tp' );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
