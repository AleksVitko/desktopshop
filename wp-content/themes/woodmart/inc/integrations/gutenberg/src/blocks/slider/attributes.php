<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_slider_attrs' ) ) {
	function wd_get_block_slider_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'height'               => array(
					'type'       => 'string',
					'default'    => '500',
					'responsive' => true,
					'unit'       => 'px',
				),
				'effect'               => array(
					'type'    => 'string',
					'default' => 'slide',
				),
				'arrowsBorderType'     => array(
					'type' => 'string',
				),
				'arrows'               => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'arrowsTablet'         => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'arrowsMobile'         => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'arrowsStyle'          => array(
					'type'    => 'string',
					'default' => '1',
				),
				'pagination'           => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'paginationTablet'     => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'paginationMobile'     => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'paginationStyle'      => array(
					'type'    => 'string',
					'default' => '1',
				),
				'paginationBorderType' => array(
					'type' => 'string',
				),
			)
		);

		return $attr->get_attr();
	}
}
