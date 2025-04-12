<?php

if ( ! function_exists( 'wd_get_transform_control_attrs' ) ) {
	function wd_get_transform_control_attrs( $attr, $attrs_prefix = '' ) {
		$attr->add_attr(
			array(
				'rotate3d'          => array(
					'type' => 'boolean',
				),
				'perspective'       => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'rotateX'           => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'rotateY'           => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'rotateZ'           => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'translateX'        => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'translateY'        => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'proportionalScale' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'scaleX'            => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'scaleY'            => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'skewX'             => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'skewY'             => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'originY'           => array(
					'type' => 'string',
				),
				'originX'           => array(
					'type' => 'string',
				),
			),
			$attrs_prefix
		);

		return $attr->get_attr();
	}
}
