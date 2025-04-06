<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_color_control_attrs' ) ) {
	function wd_get_color_control_attrs( $attrs_prefix = '' ) {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'variable' => array(
					'type'    => 'string',
					'default' => '',
				),
				'code'     => array(
					'type' => 'string',
				),
			),
			$attrs_prefix
		);

		return $attr->get_attr();
	}
}
