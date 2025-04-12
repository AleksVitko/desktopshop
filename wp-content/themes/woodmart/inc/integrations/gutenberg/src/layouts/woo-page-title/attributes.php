<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_woo_block_page_title_attrs' ) ) {
	function wd_get_woo_block_page_title_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'stretch' => array(
					'type' => 'boolean',
				),
			)
		);

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
