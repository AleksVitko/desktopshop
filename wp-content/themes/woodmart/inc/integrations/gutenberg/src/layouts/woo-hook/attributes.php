<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_woo_block_hook_attrs' ) ) {
	function wd_get_woo_block_hook_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'hook' => array(
					'type' => 'string',
				),
				'cleanActions' => array(
					'type'    => 'boolean',
					'default' => true,
				),
			)
		);

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
