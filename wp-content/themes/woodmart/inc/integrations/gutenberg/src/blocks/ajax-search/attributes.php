<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_ajax_search_attrs' ) ) {
	function wd_get_block_ajax_search_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'number'                => array(
					'type'    => 'string',
					'default' => '12',
				),
				'search_post_type'      => array(
					'type'    => 'string',
					'default' => 'product',
				),
				'price'                 => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'thumbnail'             => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'category'              => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'cat_selector_style'    => array(
					'type'    => 'string',
					'default' => 'bordered',
				),
				'form_style'            => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'woodmart_button_set'   => array(
					'type' => 'string',
				),
				'formShape'             => array(
					'type' => 'string',
				),
				'woodmart_color_scheme' => array(
					'type'    => 'string',
					'default' => '',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'formColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formPlaceholderColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formBrdColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formBrdColorFocus' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formBg' ) );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
