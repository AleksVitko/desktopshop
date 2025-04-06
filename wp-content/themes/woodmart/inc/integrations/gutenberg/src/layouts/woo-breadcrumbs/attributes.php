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

		$attr->add_attr( wd_get_typography_control_attrs(), 'tp' );

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
