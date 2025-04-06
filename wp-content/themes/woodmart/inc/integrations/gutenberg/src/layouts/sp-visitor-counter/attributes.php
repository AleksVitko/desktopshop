<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_visitor_counter_attrs' ) ) {
	function wd_get_single_product_block_visitor_counter_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'style'    => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'iconType' => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'iconSize' => array(
					'type'       => 'number',
					'responsive' => true,
				),
			)
		);

		$attr->add_attr( wd_get_typography_control_attrs(), 'textTp' );
		$attr->add_attr( wd_get_color_control_attrs( 'textColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'iconColor' ) );

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
