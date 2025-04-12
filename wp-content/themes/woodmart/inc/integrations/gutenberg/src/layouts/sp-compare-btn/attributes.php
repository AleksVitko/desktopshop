<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_compare_btn_attrs' ) ) {
	function wd_get_single_product_block_compare_btn_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'style'     => array(
					'type'    => 'string',
					'default' => 'text',
				),
				'iconSize'  => array(
					'type'       => 'number',
					'responsive' => true,
				),
			)
		);

		$attr->add_attr( wd_get_typography_control_attrs(), 'textTp' );

		$attr->add_attr( wd_get_color_control_attrs( 'textColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'iconColor' ) );

		$attr->add_attr( wd_get_color_control_attrs( 'textColorHover' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'iconColorHover' ) );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
