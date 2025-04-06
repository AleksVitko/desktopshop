<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_shop_archive_block_archive_description_attrs' ) ) {
	function wd_get_shop_archive_block_archive_description_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'textAlign' => array(
					'type'       => 'string',
					'responsive' => true,
				),
			)
		);

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
