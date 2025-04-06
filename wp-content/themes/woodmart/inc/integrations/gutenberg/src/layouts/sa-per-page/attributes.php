<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_shop_archive_block_per_page_attrs' ) ) {
	function wd_get_shop_archive_block_per_page_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'per_page_options' => array(
					'type'    => 'string',
					'default' => '9,12,18,24',
				),
			)
		);

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
