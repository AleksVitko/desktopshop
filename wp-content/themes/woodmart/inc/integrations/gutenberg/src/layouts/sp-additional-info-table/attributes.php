<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_additional_info_table_attrs' ) ) {
	function wd_get_single_product_block_additional_info_table_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'title'               => array(
					'type' => 'boolean',
				),
				'source'              => array(
					'type'    => 'string',
					'default' => 'all',
				),
				'include'             => array(
					'type' => 'string',
				),
				'exclude'             => array(
					'type' => 'string',
				),
				'layout'              => array(
					'type'    => 'string',
					'default' => 'list',
				),
				'style'               => array(
					'type'    => 'string',
					'default' => 'bordered',
				),
				'columns'             => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'columnGap'           => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'horizontalGap'       => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'attrImage'           => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'imageWidth'          => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'attrName'            => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'attrNameColumnWidth' => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'attrNameColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'attrNameTp' );

		$attr->add_attr( wd_get_color_control_attrs( 'attrTermColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'attrTermTp' );

		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
