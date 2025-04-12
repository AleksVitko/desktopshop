<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_shop_archive_block_order_by_attrs' ) ) {
	function wd_get_shop_archive_block_order_by_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'style'      => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'mobileIcon' => array(
					'type' => 'boolean',
				),
			)
		);

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
