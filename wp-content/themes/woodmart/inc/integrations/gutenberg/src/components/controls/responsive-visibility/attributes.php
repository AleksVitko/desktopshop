<?php

if ( ! function_exists( 'wd_get_responsive_visible_control_attrs' ) ) {
	function wd_get_responsive_visible_control_attrs() {
		return array(
			'hideOnDesktop' => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'hideOnTablet'  => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'hideOnMobile'  => array(
				'type'    => 'boolean',
				'default' => false,
			),
		);
	}
}
