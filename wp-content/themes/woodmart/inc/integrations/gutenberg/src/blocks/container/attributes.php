<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_container_attrs' ) ) {
	function wd_get_block_container_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'direction' => array(
					'type'       => 'string',
					'default'    => 'row',
					'responsive' => true,
				),
				'wrap'      => array(
					'type'       => 'string',
					'responsive' => true,
				),
			)
		);

		return $attr->get_attr();
	}
}
