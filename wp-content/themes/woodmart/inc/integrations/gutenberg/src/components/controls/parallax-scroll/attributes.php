<?php

if ( ! function_exists( 'wd_get_paralax_srcroll_control_attrs' ) ) {
	function wd_get_paralax_srcroll_control_attrs() {
		return array(
			'parallaxScroll'     => array(
				'type' => 'boolean',
			),
			'parallaxScrollX'    => array(
				'type'    => 'number',
				'default' => 0,
			),
			'parallaxScrollY'    => array(
				'type'    => 'number',
				'default' => -80,
			),
			'parallaxScrollZ'    => array(
				'type'    => 'number',
				'default' => 0,
			),
			'parallaxSmoothness' => array(
				'type'    => 'number',
				'default' => 30,
			),
		);
	}
}
