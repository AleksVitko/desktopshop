<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_title_attrs' ) ) {
	function wd_get_single_product_block_title_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'textAlign' => array(
					'type'       => 'string',
					'responsive' => true,
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'color' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'tp' );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
