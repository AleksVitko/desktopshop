<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_gallery_attrs' ) ) {
	function wd_get_single_product_block_gallery_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'thumbnailsPosition'                  => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'slidesPerView'                       => array(
					'type'       => 'string',
					'default'    => '',
					'responsive' => true,
				),
				'gridColumns'                         => array(
					'type'       => 'string',
					'default'    => '',
					'responsive' => true,
				),
				'gridColumnsGap'                      => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'carouselOnTablet'                    => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'carouselOnMobile'                    => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'mainGalleryCenterMode'               => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'paginationMainGallery'               => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'thumbnailsLeftVerticalColumns'       => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'thumbnailsLeftVerticalColumnsTablet' => array(
					'type'    => 'string',
					'default' => '',
				),
				'thumbnailsLeftVerticalColumnsMobile' => array(
					'type'    => 'string',
					'default' => '',
				),
				'thumbnailsWrapInMobileDevices'       => array(
					'type'    => 'string',
					'default' => 'inherit',
				),
				'thumbnailsLeftGalleryWidth'          => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'thumbnailsLeftGalleryHeight'         => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'thumbnailsBottomColumns'             => array(
					'type'    => 'string',
					'default' => '',
				),
				'thumbnailsBottomColumnsTablet'       => array(
					'type'    => 'string',
					'default' => '',
				),
				'thumbnailsBottomColumnsMobile'       => array(
					'type'    => 'string',
					'default' => '',
				),
			)
		);

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
