<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_instagram_attrs' ) ) {
	function wd_get_block_instagram_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'data_source'          => array(
					'type'    => 'string',
					'default' => 'images',
				),
				'username'             => array(
					'type' => 'string',
				),
				'images'               => array(
					'type'    => 'array',
					'default' => array(),
				),
				'images_size'          => array(
					'type'    => 'string',
					'default' => 'medium',
				),
				'imgSizeCustomWidth'   => array(
					'type' => 'string',
				),
				'imgSizeCustomHeight'  => array(
					'type' => 'string',
				),
				'images_link'          => array(
					'type' => 'string',
				),
				'images_likes'         => array(
					'type'    => 'string',
					'default' => '1000-10000',
				),
				'images_comments'      => array(
					'type'    => 'string',
					'default' => '0-1000',
				),
				'custom_rounding_size' => array(
					'type'  => 'string',
					'units' => 'px',
				),
				'number'               => array(
					'type'    => 'number',
					'default' => 9,
				),
				'target'               => array(
					'type'    => 'string',
					'default' => '_self',
				),
				'link'                 => array(
					'type' => 'string',
				),
				'design'               => array(
					'type'    => 'string',
					'default' => 'grid',
				),
				'per_row'              => array(
					'type'       => 'number',
					'default'    => 3,
					'responsive' => true,
				),
				'spacing'              => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'spacing_custom'       => array(
					'type'       => 'string',
					'default'    => '20',
					'responsive' => true,
				),
				'show_meta'            => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'meta_position'        => array(
					'type'    => 'string',
					'default' => 'bottom',
				),
				'show_content'         => array(
					'type'    => 'boolean',
					'default' => false,
				),
			)
		);

		$attr->add_attr( wd_get_advanced_tab_attrs() );
		$attr->add_attr( wd_get_carousel_settings_attrs() );

		return $attr->get_attr();
	}
}
