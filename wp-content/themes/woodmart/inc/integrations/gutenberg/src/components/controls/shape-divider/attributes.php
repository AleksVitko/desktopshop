<?php

if ( ! function_exists( 'wd_get_shape_divider_control_attrs' ) ) {
	function wd_get_shape_divider_control_attrs() {
		return array_merge(
			array(
				'icon'         => array(
					'type' => 'string',
				),
				'width'        => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'height'       => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'flip'         => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'bringToFront' => array(
					'type'    => 'boolean',
					'default' => false,
				),
			),
			wd_get_color_control_attrs( 'color' )
		);
	}
}
