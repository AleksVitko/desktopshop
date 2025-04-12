<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_shop_archive_block_view_attrs' ) ) {
	function wd_get_shop_archive_block_view_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'products_columns_variations' => array(
					'type'    => 'string',
					'default' => '2,3,4',
				),
			)
		);

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
