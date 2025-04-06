<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_contact_form_attrs' ) ) {
	function wd_get_block_contact_form_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'form_id'   => array(
					'type'    => 'string',
					'default' => '',
				),
				'style'     => array(
					'type'    => 'string',
					'default' => '',
				),
				'formShape' => array(
					'type' => 'string',
				),
				'color_scheme' => array(
					'type' => 'string',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'formColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formPlaceholderColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formBrdColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formBrdColorFocus' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formBg' ) );

		$attr->add_attr( wd_get_color_control_attrs( 'buttonTextColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'buttonBgColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'buttonTextColorHover' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'buttonBgColorHover' ) );

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
