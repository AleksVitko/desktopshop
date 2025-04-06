<?php

if ( ! function_exists( 'wd_get_animation_control_attrs' ) ) {
	function wd_get_animation_control_attrs() {
		return array(
			'animation'         => array(
				'type' => 'string',
			),
			'animationDelay'    => array(
				'type'    => 'string',
				'default' => '100',
			),
			'animationDuration' => array(
				'type'    => 'string',
				'default' => '',
			),
		);
	}
}
