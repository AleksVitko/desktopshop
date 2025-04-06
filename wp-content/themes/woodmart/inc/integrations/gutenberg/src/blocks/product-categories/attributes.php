<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_product_categories_attrs' ) ) {
	function wd_get_block_product_categories_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'data_source'                    => array(
					'type'    => 'string',
					'default' => 'custom_query',
				),
				'type'                           => array(
					'type'    => 'string',
					'default' => 'grid',
				),
				'images'                         => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'product_count'                  => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'mobile_accordion'               => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'shop_categories_ancestors'      => array(
					'type' => 'boolean',
				),
				'show_categories_neighbors'      => array(
					'type' => 'boolean',
				),
				'number'                         => array(
					'type' => 'string',
				),
				'orderby'                        => array(
					'type' => 'string',
				),
				'order'                          => array(
					'type' => 'string',
				),
				'ids'                            => array(
					'type' => 'string',
				),
				'hide_empty'                     => array(
					'type'    => 'boolean',
					'default' => true,
				),

				'categories_design'              => array(
					'type'    => 'string',
					'default' => '',
				),
				'image_container_width'          => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'color_scheme'                   => array(
					'type' => 'string',
				),
				'navAlignment'                   => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'title_idle_color'               => array(
					'type' => 'string',
				),
				'title_hover_color'              => array(
					'type' => 'string',
				),
				'custom_rounding_size'           => array(
					'type'  => 'string',
					'units' => 'px',
				),

				'style'                          => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'grid_different_sizes'           => array(
					'type' => 'string',
				),
				'masonry_grid'                   => array(
					'type' => 'boolean',
				),
				'columns'                        => array(
					'type'       => 'number',
					'default'    => 4,
					'responsive' => true,
				),
				'spacing'                        => array(
					'type'       => 'string',
					'default'    => '20',
					'responsive' => true,
				),
				'img_size'                       => array(
					'type'    => 'string',
					'default' => 'woocommerce_thumbnail',
				),
				'imgSizeCustomWidth'             => array(
					'type' => 'string',
				),
				'imgSizeCustomHeight'            => array(
					'type' => 'string',
				),
				'categories_bordered_grid'       => array(
					'type' => 'boolean',
				),
				'categories_bordered_grid_style' => array(
					'type'    => 'string',
					'default' => 'outside',
				),
				'categories_with_background'     => array(
					'type' => 'boolean',
				),
				'subcategories'                  => array(
					'type' => 'string',
				),
				'grid_product_count'             => array(
					'type' => 'string',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'titleIdleColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'titleHoverColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'categoriesBorderColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'categoriesBackground' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'title' );
		$attr->add_attr( wd_get_advanced_tab_attrs() );
		$attr->add_attr( wd_get_carousel_settings_attrs() );

		return $attr->get_attr();
	}
}
