<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_linked_variations_attrs' ) ) {
	function wd_get_single_product_block_linked_variations_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'align'               => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'layout'              => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'labelPosition'       => array(
					'type'    => 'string',
					'default' => 'side',
				),
				'labelPositionTablet' => array(
					'type'    => 'string',
					'default' => 'side',
				),
			)
		);

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
