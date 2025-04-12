<?php

if ( ! function_exists( 'wd_get_box_shadow_control_attrs' ) ) {
	function wd_get_border_control_attrs( $attr, $attrs_prefix = '' ) {
		$attr->add_attr(
			array(
				'type'         => array(
					'type' => 'string',
				),
				'width'        => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'widthTop'     => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'widthRight'   => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'widthBottom'  => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'widthLeft'    => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'widthLock'    => array(
					'type'       => 'boolean',
					'responsive' => true,
				),
				'widthUnits'   => array(
					'type'       => 'string',
					'default'    => 'px',
					'responsive' => true,
				),
				'radius'       => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'radiusTop'    => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'radiusRight'  => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'radiusBottom' => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'radiusLeft'   => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'radiusLock'   => array(
					'type'       => 'boolean',
					'default'    => true,
					'responsive' => true,
				),
				'radiusUnits'  => array(
					'type'       => 'string',
					'default'    => 'px',
					'responsive' => true,
				),
			),
			$attrs_prefix
		);

		$attr->add_attr( wd_get_color_control_attrs( 'color' ), $attrs_prefix );
		$attr->add_attr( wd_get_color_control_attrs( 'hoverColor' ), $attrs_prefix );
		$attr->add_attr( wd_get_color_control_attrs( 'activeColor' ), $attrs_prefix );
	}
}
