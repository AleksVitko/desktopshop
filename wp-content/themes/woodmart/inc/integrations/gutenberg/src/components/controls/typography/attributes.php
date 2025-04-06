<?php

if ( ! function_exists( 'wd_get_typography_control_attrs' ) ) {
	function wd_get_typography_control_attrs() {
		return array(
			'fontFamily'                  => array(
				'type' => 'string',
			),
			'fontSize'                    => array(
				'type'       => 'string',
				'responsive' => true,
				'units'      => 'px',
			),
			'lineHeight'                  => array(
				'type'       => 'string',
				'responsive' => true,
				'units'      => 'px',
			),
			'letterSpacing'               => array(
				'type'       => 'string',
				'responsive' => true,
				'units'      => 'px',
			),
			'wordSpacing'                 => array(
				'type'       => 'string',
				'responsive' => true,
				'units'      => 'px',
			),
			'textTransform'               => array(
				'type' => 'string',
			),
			'textDecoration'              => array(
				'type' => 'string',
			),
			'textDecorationColorVariable' => array(
				'type'    => 'string',
				'default' => '',
			),
			'textDecorationColorCode'     => array(
				'type'    => 'string',
				'default' => '',
			),
			'textDecorationStyle'         => array(
				'type' => 'string',
			),
			'textDecorationThickness'     => array(
				'type'  => 'string',
				'units' => 'px',
			),
			'textUnderlineOffset'         => array(
				'type'  => 'string',
				'units' => 'px',
			),
			'fontVariant'                 => array(
				'type' => 'string',
			),
			'fontWeight'                  => array(
				'type' => 'string',
			),
			'fontStyle'                   => array(
				'type' => 'string',
			),
			'fontSubset'                  => array(
				'type' => 'string',
			),
			'google'                      => array(
				'type'    => 'boolean',
				'default' => false,
			),
		);
	}
}
