<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_background_control_attrs' ) ) {
	function wd_get_background_control_attrs( $attrs_prefix = '' ) {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'type'              => array(
					'type'    => 'string',
					'default' => 'classic',
				),
				'image'             => array(
					'type'       => 'object',
					'responsive' => true,
				),
				'imageSize'         => array(
					'type'       => 'string',
					'default'    => 'full',
					'responsive' => true,
				),
				'gradient'          => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'gradientPosition'  => array(
					'type'       => 'string',
					'default'    => 'center center',
					'responsive' => true,
				),
				'externalVideo'     => array(
					'type' => 'string',
				),
				'video'             => array(
					'type' => 'object',
				),
				'videoSource'       => array(
					'type'    => 'string',
					'default' => 'external',
				),
				'videoFallback'     => array(
					'type' => 'object',
				),
				'position'          => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'customPositionX'   => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'customPositionY'   => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'attachment'        => array(
					'type' => 'string',
				),
				'repeat'            => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'displaySize'       => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'customDisplaySize' => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
			),
			$attrs_prefix
		);

		$attr->add_attr( wd_get_color_control_attrs( 'color' ), $attrs_prefix );

		return $attr->get_attr();
	}
}
