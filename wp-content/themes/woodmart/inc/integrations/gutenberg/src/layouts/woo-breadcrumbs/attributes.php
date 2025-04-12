<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_woo_block_breadcrumbs_attrs' ) ) {
	function wd_get_woo_block_breadcrumbs_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'textAlign' => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'nowrapMd'  => array(
					'type' => 'boolean',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'textColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'textHoverColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'textActiveColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'delimiterColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'tp' );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
