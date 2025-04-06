<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_reviews_attrs' ) ) {
	function wd_get_single_product_block_reviews_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'layout'               => array(
					'type'    => 'string',
					'default' => 'one-column',
				),
				'reviewsGap'           => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'reviewsColumns'       => array(
					'type'    => 'number',
					'default' => 1,
				),
				'reviewsColumnsTablet' => array(
					'type'    => 'number',
					'default' => 1,
				),
				'reviewsColumnsMobile' => array(
					'type'    => 'number',
					'default' => 1,
				),
			)
		);

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
