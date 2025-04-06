<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_checkout_block_payment_methods_attrs' ) ) {
	function wd_get_checkout_block_payment_methods_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'btnAlign' => array(
					'type'       => 'string',
					'responsive' => true,
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'titleColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'titleTp' );

		$attr->add_attr( wd_get_color_control_attrs( 'descriptionColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'descriptionBgColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'descriptionTp' );
		$attr->add_attr( wd_get_box_shadow_control_attrs( 'descriptionBoxShadow' ) );
		$attr->add_attr( wd_get_padding_control_attrs( 'descriptionPadding' ) );

		$attr->add_attr( wd_get_color_control_attrs( 'termsConditionsColor' ) );
		$attr->add_attr( wd_get_box_shadow_control_attrs( 'termsConditionsBoxShadow' ) );
		$attr->add_attr( wd_get_padding_control_attrs( 'termsConditionsPadding' ) );

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
