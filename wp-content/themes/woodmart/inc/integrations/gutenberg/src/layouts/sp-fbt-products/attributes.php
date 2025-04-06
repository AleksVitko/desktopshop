<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_fbt_products_attrs' ) ) {
	function wd_get_single_product_block_fbt_products_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'showTitle'                     => array(
					'type' => 'boolean',
				),
				'formWidth'                     => array(
					'type'  => 'string',
					'units' => 'px',
				),
				'slides_per_view'               => array(
					'type'       => 'string',
					'default'    => '3',
					'responsive' => true,
				),
				'hide_pagination_control'       => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hide_pagination_controlTablet' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'hide_pagination_controlMobile' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'hide_prev_next_buttons'        => array(
					'type'       => 'boolean',
					'responsive' => true,
				),
				'hide_scrollbar'                => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'hide_scrollbarTablet'          => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'hide_scrollbarMobile'          => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'formColorScheme'               => array(
					'type' => 'string',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'formBgColor' ) );
		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
