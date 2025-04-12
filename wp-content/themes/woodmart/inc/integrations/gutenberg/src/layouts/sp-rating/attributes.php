<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_rating_attrs' ) ) {
	function wd_get_single_product_block_rating_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'textAlign' => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'size'      => array(
					'type'       => 'string',
					'responsive' => true,
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'linkColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'linkColorHover' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'linkTp' );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
