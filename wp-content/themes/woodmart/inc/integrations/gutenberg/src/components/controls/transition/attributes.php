<?php

if ( ! function_exists( 'wd_get_transition_control_attrs' ) ) {
	function wd_get_transition_control_attrs() {
		return array(
			'transitionBorder'             => array(
				'type'    => 'string',
				'default' => '',
			),
			'transitionBackground'         => array(
				'type'    => 'string',
				'default' => '',
			),
			'transitionTransform'          => array(
				'type'    => 'string',
				'default' => '',
			),
			'transitionOpacity'            => array(
				'type'    => 'string',
				'default' => '',
			),
		);
	}
}
