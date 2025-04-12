<?php

if ( ! function_exists( 'wd_get_margin_control_attrs' ) ) {
	function wd_get_margin_control_attrs( $attr, $attrs_prefix = '' ) {
		$attr->add_attr(
			array(
				'top'    => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'right'  => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'bottom' => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'left'   => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'lock'   => array(
					'type'       => 'boolean',
					'default'    => false,
					'responsive' => true,
				),
				'units'  => array(
					'type'       => 'string',
					'default'    => 'px',
					'responsive' => true,
				),
			),
			$attrs_prefix
		);
	}
}
