<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_countdown_attrs' ) ) {
	function wd_get_single_product_block_countdown_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'showTitle'             => array(
					'type' => 'boolean',
				),
				'textAlign'             => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'woodmart_color_scheme' => array(
					'type' => 'string',
				),
				'size'                  => array(
					'type'    => 'string',
					'default' => 'standard',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'bgTimerColor' ) );
		wd_get_box_shadow_control_attrs( $attr, 'timerBoxShadow' );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
