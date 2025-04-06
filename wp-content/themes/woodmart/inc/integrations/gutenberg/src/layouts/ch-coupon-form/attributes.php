<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_checkout_block_coupon_form_attrs' ) ) {
	function wd_get_checkout_block_coupon_form_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'align'     => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'formWidth' => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
			)
		);

		$attr->add_attr( wd_get_typography_control_attrs(), 'toggleTp' );

		$attr->add_attr( wd_get_color_control_attrs( 'formBgColor' ) );
		$attr->add_attr( wd_get_border_control_attrs( 'formBorder' ) );
		$attr->add_attr( wd_get_padding_control_attrs( 'formPadding' ) );

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
