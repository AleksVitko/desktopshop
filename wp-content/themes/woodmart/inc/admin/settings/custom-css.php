<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Admin\Modules\Options;

/**
 * Custom CSS section.
 */
Options::add_field(
	array(
		'id'       => 'custom_css',
		'name'     => esc_html__( 'Global custom CSS', 'woodmart' ),
		'type'     => 'editor',
		'language' => 'css',
		'section'  => 'custom_css',
		't_tab'    => array(
			'id'    => 'custom_css_tabs',
			'icon'  => 'xts-i-global',
			'tab'   => esc_html__( 'Global', 'woodmart' ),
			'style' => 'default',
		),
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'css_desktop',
		'name'     => esc_html__( 'Custom CSS for desktop', 'woodmart' ),
		'type'     => 'editor',
		'language' => 'css',
		'section'  => 'custom_css',
		't_tab'    => array(
			'id'  => 'custom_css_tabs',
			'icon'  => 'xts-i-desktop',
			'tab' => esc_html__( 'Desktop', 'woodmart' ),
		),
		'priority' => 20,

	)
);

Options::add_field(
	array(
		'id'       => 'css_tablet',
		'name'     => esc_html__( 'Custom CSS for tablet', 'woodmart' ),
		'type'     => 'editor',
		'language' => 'css',
		'section'  => 'custom_css',
		't_tab'    => array(
			'id'  => 'custom_css_tabs',
			'icon'  => 'xts-i-tablet',
			'tab' => esc_html__( 'Tablet', 'woodmart' ),
		),
		'priority' => 30,

	)
);

Options::add_field(
	array(
		'id'       => 'css_wide_mobile',
		'name'     => esc_html__( 'Custom CSS for mobile landscape', 'woodmart' ),
		'type'     => 'editor',
		'language' => 'css',
		'section'  => 'custom_css',
		't_tab'    => array(
			'id'  => 'custom_css_tabs',
			'icon'  => 'xts-i-phone xts-i-landscape',
			'tab' => esc_html__( 'Mobile Landscape', 'woodmart' ),
		),
		'priority' => 40,

	)
);

Options::add_field(
	array(
		'id'       => 'css_mobile',
		'name'     => esc_html__( 'Custom CSS for mobile', 'woodmart' ),
		'type'     => 'editor',
		'language' => 'css',
		'section'  => 'custom_css',
		't_tab'    => array(
			'id'  => 'custom_css_tabs',
			'icon'  => 'xts-i-phone',
			'tab' => esc_html__( 'Mobile', 'woodmart' ),
		),
		'priority' => 50,

	)
);

Options::add_field(
	array(
		'id'       => 'css_backend',
		'name'     => esc_html__( 'Custom CSS for admin dashboard', 'woodmart' ),
		'type'     => 'editor',
		'language' => 'css',
		'section'  => 'custom_css',
		't_tab'    => array(
			'id'  => 'custom_css_tabs',
			'icon'  => 'xts-i-wordpress',
			'tab' => esc_html__( 'Dashboard', 'woodmart' ),
		),
		'priority' => 60,
	)
);
