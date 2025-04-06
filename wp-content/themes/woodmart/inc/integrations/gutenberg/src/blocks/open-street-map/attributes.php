<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_open_street_map_attrs' ) ) {
	function wd_get_block_open_street_map_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'height' => array(
					'type'       => 'string',
					'default'    => '400',
					'responsive' => true,
					'unit'       => 'px',
				),
			)
		);

		return $attr->get_attr();
	}
}
