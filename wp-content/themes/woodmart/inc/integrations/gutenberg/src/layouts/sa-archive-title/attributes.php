<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_shop_archive_block_title_attrs' ) ) {
	function wd_get_shop_archive_block_title_attrs() {
		$attr = new Block_Attributes();

		wd_get_advanced_tab_attrs( $attr );

		$attr->add_attr(
			array(
				'textAlign' => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'htmlTag'   => array(
					'type'    => 'string',
					'default' => 'span',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'color' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'tp' );

		return $attr->get_attr();
	}
}
