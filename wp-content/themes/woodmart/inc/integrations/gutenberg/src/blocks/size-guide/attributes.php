<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_size_guide_attrs' ) ) {
	function wd_get_block_size_guide_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'size_guide_id' => array(
					'type' => 'string',
				),
				'title'         => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'description'   => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'inheritProduct' => array(
					'type'    => 'boolean',
					'default' => false,
				),
			)
		);

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
