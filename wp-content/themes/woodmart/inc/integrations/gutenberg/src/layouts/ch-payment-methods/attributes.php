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
		wd_get_box_shadow_control_attrs( $attr, 'descriptionBoxShadow' );
		wd_get_padding_control_attrs( $attr, 'descriptionPadding' );

		$attr->add_attr( wd_get_color_control_attrs( 'termsConditionsColor' ) );
		wd_get_box_shadow_control_attrs( $attr, 'termsConditionsBoxShadow' );
		wd_get_padding_control_attrs( $attr, 'termsConditionsPadding' );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
