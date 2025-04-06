<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_brands_attrs' ) ) {
	function wd_get_block_brands_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'number'                     => array(
					'type' => 'string',
				),
				'orderby'                    => array(
					'type' => 'string',
				),
				'order'                      => array(
					'type'    => 'string',
					'default' => 'ASC',
				),
				'ids'                        => array(
					'type' => 'string',
				),
				'hide_empty'                 => array(
					'type' => 'boolean',
				),
				'filter_in_current_category' => array(
					'type' => 'boolean',
				),
				'hover'                      => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'brand_style'                => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'style'                      => array(
					'type'    => 'string',
					'default' => 'carousel',
				),
				'spacing'                    => array(
					'type'       => 'string',
					'default'    => '',
					'responsive' => true,
				),
				'columns'                    => array(
					'type'       => 'number',
					'default'    => 3,
					'responsive' => true,
				),
				'disable_link'               => array(
					'type' => 'boolean',
				),
				'imagesWidth'                => array(
					'type'       => 'string',
					'default'    => '',
					'responsive' => true,
					'units'      => 'px',
				),
				'imagesHeight'               => array(
					'type'       => 'string',
					'default'    => '',
					'responsive' => true,
					'units'      => 'px',
				),
				'with_bg_color'              => array(
					'type' => 'boolean',
				),
				'align'                      => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'padding'                    => array(
					'type'       => 'string',
					'default'    => '',
					'responsive' => true,
					'units'      => 'px',
				),
			)
		);

		$attr->add_attr( wd_get_advanced_tab_attrs() );
		$attr->add_attr( wd_get_carousel_settings_attrs() );
		$attr->add_attr( wd_get_color_control_attrs( 'brandBgColor' ) );

		return $attr->get_attr();
	}
}
