<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_cart_block_free_gifts_attrs' ) ) {
	function wd_get_cart_block_free_gifts_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'showTitle' => array(
					'type'    => 'boolean',
					'default' => true,
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'titleColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'titleTp' );
		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
