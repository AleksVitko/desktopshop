<?php
/**
 * JS libraries.
 *
 * @version 1.0
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

return array(
	'autocomplete'           => array(
		array(
			'title'      => esc_html__( 'Autocomplete', 'woodmart' ),
			'name'       => 'autocomplete',
			'file'       => '/js/libs/autocomplete',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'cookie'                 => array(
		array(
			'title'      => esc_html__( 'Cookie', 'woodmart' ),
			'name'       => 'cookie',
			'file'       => '/js/libs/cookie',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'countdown-bundle'       => array(
		array(
			'title'      => esc_html__( 'Countdown', 'woodmart' ),
			'name'       => 'countdown-bundle',
			'file'       => '/js/libs/countdown-bundle',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'device'                 => array(
		array(
			'title'      => esc_html__( 'Device', 'woodmart' ),
			'name'       => 'device',
			'file'       => '/js/libs/device',
			'in_footer'  => false,
			'dependency' => array( 'jquery' ),
			'default'    => 'not_use',
		),
	),
	'isotope-bundle'         => array(
		array(
			'title'      => esc_html__( 'Isotope', 'woodmart' ),
			'name'       => 'isotope-bundle',
			'file'       => '/js/libs/isotope-bundle',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'justified'              => array(
		array(
			'title'      => esc_html__( 'Justified gallery', 'woodmart' ),
			'name'       => 'justified',
			'file'       => '/js/libs/justifiedGallery',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'magnific'               => array(
		array(
			'title'      => esc_html__( 'Magnific popup', 'woodmart' ),
			'name'       => 'magnific',
			'file'       => '/js/libs/magnific-popup',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'panr-parallax-bundle'   => array(
		array(
			'title'      => esc_html__( 'Panr parallax', 'woodmart' ),
			'name'       => 'panr-parallax-bundle',
			'file'       => '/js/libs/panr-parallax-bundle',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'parallax'               => array(
		array(
			'title'      => esc_html__( 'Parallax', 'woodmart' ),
			'name'       => 'parallax',
			'file'       => '/js/libs/parallax',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'parallax-scroll-bundle' => array(
		array(
			'title'      => esc_html__( 'Parallax scroll', 'woodmart' ),
			'name'       => 'parallax-scroll-bundle',
			'file'       => '/js/libs/parallax-scroll-bundle',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'photoswipe-bundle'      => array(
		array(
			'title'      => esc_html__( 'Photoswipe', 'woodmart' ),
			'name'       => 'photoswipe-bundle',
			'file'       => '/js/libs/photoswipe-bundle',
			'in_footer'  => true,
			'dependency' => array(),
		),
	),
	'pjax'                   => array(
		array(
			'title'      => esc_html__( 'PJAX', 'woodmart' ),
			'name'       => 'pjax',
			'file'       => '/js/libs/pjax',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'sticky-kit'             => array(
		array(
			'title'      => esc_html__( 'Sticky kit', 'woodmart' ),
			'name'       => 'sticky-kit',
			'file'       => '/js/libs/sticky-kit',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'swiper'                 => array(
		array(
			'title'      => esc_html__( 'Swiper', 'woodmart' ),
			'name'       => 'wd_swiper',
			'file'       => '/js/libs/swiper',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'threesixty'             => array(
		array(
			'title'      => esc_html__( 'Threesixty', 'woodmart' ),
			'name'       => 'threesixty',
			'file'       => '/js/libs/threesixty',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'tooltips'               => array(
		array(
			'title'      => esc_html__( 'Tooltips', 'woodmart' ),
			'name'       => 'tooltips',
			'file'       => '/js/libs/tooltips',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'vivus'                  => array(
		array(
			'title'      => esc_html__( 'Vivus', 'woodmart' ),
			'name'       => 'vivus',
			'file'       => '/js/libs/vivus',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'waypoints'              => array(
		array(
			'title'      => esc_html__( 'Waypoint', 'woodmart' ),
			'name'       => 'waypoints',
			'file'       => '/js/libs/waypoints',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'leaflet'                => array(
		array(
			'title'      => esc_html__( 'Leaflet', 'woodmart' ),
			'name'       => 'leaflet',
			'file'       => '/js/libs/leaflet',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
	'vimeo_player'           => array(
		array(
			'title'      => esc_html__( 'Vimeo player', 'woodmart' ),
			'name'       => 'vimeo_player',
			'file'       => '/js/libs/vimeo-player',
			'in_footer'  => true,
			'dependency' => array(),
			'default'    => 'required',
		),
	),
);
