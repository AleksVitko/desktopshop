<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_video_attrs' ) ) {
	function wd_get_block_video_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'videoHeight'       => array(
					'type'       => 'string',
					'default'    => 400,
					'responsive' => true,
					'units'      => 'px',
				),
				'videoHeightTablet' => array(
					'type' => 'string',
				),
				'videoHeightMobile' => array(
					'type' => 'string',
				),
				'videoSize'         => array(
					'type'    => 'string',
					'default' => 'custom',
				),
				'videoActionButton' => array(
					'type'    => 'string',
					'default' => 'without',
				),
				'videoAspectRatio'  => array(
					'type'    => 'string',
					'default' => '16/9',
				),
			)
		);

		return $attr->get_attr();
	}
}
