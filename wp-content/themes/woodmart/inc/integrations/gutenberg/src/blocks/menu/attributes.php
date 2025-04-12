<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_menu_attrs' ) ) {
	function wd_get_block_menu_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'nav_menu'           => array(
					'type' => 'string',
				),
				'design'             => array(
					'type'    => 'string',
					'default' => 'horizontal',
				),
				'dropdown_design'    => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'vertical_items_gap' => array(
					'type'    => 'string',
					'default' => 's',
				),
				'style'              => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'items_gap'          => array(
					'type'    => 'string',
					'default' => 's',
				),
				'align'              => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'icon_alignment'     => array(
					'type' => 'string',
				),
				'color_scheme'       => array(
					'type' => 'string',
				),
				'iconWidth'          => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'iconHeight'         => array(
					'type'       => 'string',
					'responsive' => true,
				),
			)
		);

		$attr->add_attr( wd_get_typography_control_attrs(), 'itemTp' );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
