<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_woo_block_notices_attrs' ) ) {
	function wd_get_woo_block_notices_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
