<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_shop_archive_block_archive_products_attrs' ) ) {
	function wd_get_shop_archive_block_archive_products_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'layout'                    => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'productHover'              => array(
					'type' => 'string',
				),
				'columns'                   => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'spacing'                   => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'shopPagination'            => array(
					'type' => 'string',
				),
				'imgSize'                   => array(
					'type'    => 'string',
					'default' => 'woocommerce_thumbnail',
				),
				'imgSizeCustomHeight'       => array(
					'type' => 'string',
				),
				'imgSizeCustomWidth'        => array(
					'type' => 'string',
				),
				'productsColorScheme'       => array(
					'type' => 'string',
				),
				'productsBorderedGrid'      => array(
					'type' => 'string',
				),
				'productsBorderedGridStyle' => array(
					'type' => 'string',
				),
				'productsWithBackground'    => array(
					'type' => 'string',
				),
				'productsShadow'            => array(
					'type' => 'string',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'productsBackground' ) );
		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
