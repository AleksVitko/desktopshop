<?php

if ( ! function_exists( 'wd_get_color_control_attrs' ) ) {
	function wd_get_color_control_attrs( $attrs_prefix = '' ) {
		return array(
			$attrs_prefix . 'Variable' => array(
				'type'    => 'string',
				'default' => '',
			),
			$attrs_prefix . 'Code'     => array(
				'type' => 'string',
			),
		);
	}
}
