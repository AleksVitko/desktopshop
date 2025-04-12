<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_portfolio_attrs' ) ) {
	function wd_get_block_portfolio_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'layout'               => array(
					'type'    => 'string',
					'default' => 'grid',
				),
				'posts_per_page'       => array(
					'type' => 'string',
				),
				'columns'              => array(
					'type'       => 'number',
					'default'    => 3,
					'responsive' => true,
				),
				'spacing'              => array(
					'type'       => 'string',
					'default'    => '20',
					'responsive' => true,
				),
				'filters'              => array(
					'type' => 'boolean',
				),
				'filters_type'         => array(
					'type'    => 'string',
					'default' => 'masonry',
				),
				'categories'           => array(
					'type' => 'string',
				),
				'orderby'              => array(
					'type' => 'string',
				),
				'order'                => array(
					'type' => 'string',
				),
				'pagination'           => array(
					'type'    => 'string',
					'default' => 'disable',
				),
				'style'                => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'custom_rounding_size' => array(
					'type'  => 'string',
					'units' => 'px',
				),
				'image_size'           => array(
					'type'    => 'string',
					'default' => 'large',
				),
				'imgSizeCustomWidth'   => array(
					'type' => 'string',
				),
				'imgSizeCustomHeight'  => array(
					'type' => 'string',
				),
			)
		);

		wd_get_advanced_tab_attrs( $attr );
		wd_get_carousel_settings_attrs( $attr );

		return $attr->get_attr();
	}
}
