<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_sidebar_attrs' ) ) {
	function wd_get_block_sidebar_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'sidebar_id' => array(
					'type'    => 'string',
					'default' => 'sidebar-1',
				),
			)
		);

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
