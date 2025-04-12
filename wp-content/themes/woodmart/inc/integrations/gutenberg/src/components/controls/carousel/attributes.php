<?php

if ( ! function_exists( 'wd_get_carousel_settings_attrs' ) ) {
	function wd_get_carousel_settings_attrs( $attr ) {
		$attr->add_attr(
			array(
				'slides_per_view'            => array(
					'type'       => 'string',
					'responsive' => true,
					'default'    => '3',
				),
				'scroll_per_page'            => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'center_mode'                => array(
					'type' => 'boolean',
				),
				'wrap'                       => array(
					'type' => 'boolean',
				),
				'autoheight'                 => array(
					'type' => 'boolean',
				),
				'autoplay'                   => array(
					'type' => 'boolean',
				),
				'speed'                      => array(
					'type'    => 'number',
					'default' => 5000,
				),
				'disable_overflow_carousel'  => array(
					'type' => 'boolean',
				),
				'scroll_carousel_init'       => array(
					'type' => 'boolean',
				),
				'hide_prev_next_buttons'     => array(
					'type'       => 'boolean',
					'responsive' => true,
				),
				'carousel_arrows_position'   => array(
					'type' => 'string',
				),
				'carouselArrowsOffsetH'      => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'carouselArrowsOffsetV'      => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'hide_pagination_control'    => array(
					'type'       => 'boolean',
					'responsive' => true,
					'default'    => false,
				),
				'dynamic_pagination_control' => array(
					'type' => 'boolean',
				),
				'hide_scrollbar'             => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'hide_scrollbarTablet'       => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'hide_scrollbarMobile'       => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'carousel_sync'              => array(
					'type' => 'string',
				),
				'sync_parent_id'             => array(
					'type' => 'string',
				),
				'sync_child_id'              => array(
					'type' => 'string',
				),
			)
		);
	}
}
