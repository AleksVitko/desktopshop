<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_products_attrs' ) ) {
	function wd_get_block_products_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'show_title'                   => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'title'                        => array(
					'type'    => 'string',
					'default' => 'Tab title',
				),
				'icon'                         => array(
					'type'    => 'object',
					'default' => array(
						'url'   => '',
						'id'    => '',
						'sizes' => array(),
					),
				),
				'iconAlt'                      => array(
					'type' => 'string',
				),
				'iconTitle'                    => array(
					'type' => 'string',
				),
				'iconSize'                     => array(
					'type'    => 'string',
					'default' => 'full',
				),
				'post_type'                    => array(
					'type'    => 'string',
					'default' => 'product',
				),
				'include'                      => array(
					'type' => 'string',
				),
				'categoriesIds'                => array(
					'type' => 'string',
				),
				'tagsIds'                      => array(
					'type' => 'string',
				),
				'productBrandIds'              => array(
					'type' => 'string',
				),
				'productAttrs'                 => array(
					'type' => 'string',
				),
				'orderby'                      => array(
					'type' => 'string',
				),
				'order'                        => array(
					'type' => 'string',
				),
				'offset'                       => array(
					'type' => 'string',
				),
				'query_type'                   => array(
					'type' => 'string',
				),
				'meta_key'                     => array(
					'type' => 'string',
				),
				'hide_out_of_stock'            => array(
					'type' => 'boolean',
				),
				'ajax_recently_viewed'         => array(
					'type' => 'boolean',
				),
				'exclude'                      => array(
					'type' => 'string',
				),
				// Style.
				'layout'                       => array(
					'type'    => 'string',
					'default' => 'grid',
				),
				'columns'                      => array(
					'type'    => 'number',
					'default' => 4,
				),
				'columnsTablet'                => array(
					'type' => 'number',
				),
				'columnsMobile'                => array(
					'type' => 'number',
				),
				'products_masonry'             => array(
					'type' => 'string',
				),
				'products_different_sizes'     => array(
					'type'    => 'string',
					'default' => 'disable',
				),
				'spacing'                      => array(
					'type'       => 'string',
					'default'    => '20',
					'responsive' => true,
				),
				'items_per_page'               => array(
					'type'    => 'string',
					'default' => '12',
				),
				'pagination'                   => array(
					'type' => 'string',
				),
				'product_hover'                => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'img_size'                     => array(
					'type'    => 'string',
					'default' => 'woocommerce_thumbnail',
				),
				'imgSizeCustomWidth'           => array(
					'type' => 'string',
				),
				'imgSizeCustomHeight'          => array(
					'type' => 'string',
				),
				'custom_rounding_size'         => array(
					'type'  => 'string',
					'units' => 'px',
				),
				'sale_countdown'               => array(
					'type' => 'boolean',
				),
				'stretch_product'              => array(
					'type'       => 'boolean',
					'default'    => false,
					'responsive' => true,
				),
				'stock_progress_bar'           => array(
					'type' => 'boolean',
				),
				'products_color_scheme'        => array(
					'type' => 'string',
				),
				'products_divider'             => array(
					'type' => 'boolean',
				),
				'products_bordered_grid'       => array(
					'type' => 'boolean',
				),
				'products_bordered_grid_style' => array(
					'type'    => 'string',
					'default' => 'outside',
				),
				'products_with_background'     => array(
					'type' => 'boolean',
				),
				'products_shadow'              => array(
					'type' => 'boolean',
				),
				'product_quantity'             => array(
					'type' => 'string',
				),
				'grid_gallery'                 => array(
					'type' => 'string',
				),
				'grid_gallery_control'         => array(
					'type' => 'string',
				),
				'grid_gallery_enable_arrows'   => array(
					'type' => 'string',
				),
				'pagination_arrows_position'   => array(
					'type' => 'string',
				),
				'paginationArrowsOffsetH'      => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'paginationArrowsOffsetV'      => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'grid_items_different_sizes'   => array(
					'type' => 'string',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'productsBackground' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'productsBorderColor' ) );
		wd_get_carousel_settings_attrs( $attr );
		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
