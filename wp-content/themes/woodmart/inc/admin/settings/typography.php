<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
use XTS\Admin\Modules\Options;

Options::add_field(
	array(
		'id'           => 'text-font',
		'type'         => 'typography',
		'section'      => 'typography_section',
		'name'         => esc_html__( 'Text font', 'woodmart' ),
		'description'  => esc_html__( 'Set general font for site content. This font will also be applied to other typography options if they are not set.', 'woodmart' ),
		'selector_var' => array(
			'font-family' => '--wd-text-font',
			'font-size'   => '--wd-text-font-size',
			'font-weight' => '--wd-text-font-weight',
			'font-style'  => '--wd-text-font-style',
			'color'       => '--wd-text-color',
		),
		'default'      => array(
			array(
				'color'       => '#767676',
				'font-size'   => '14',
				'font-weight' => '400',
			),
		),
		'line-height'  => false,
		'tags'         => 'typography',
		'priority'     => 10,
	)
);

Options::add_field(
	array(
		'id'             => 'primary-font',
		'type'           => 'typography',
		'section'        => 'typography_section',
		'name'           => esc_html__( 'Title font', 'woodmart' ),
		'description'    => esc_html__( 'Set typography for titles (h1, h2, h3, h4, h5, h6).', 'woodmart' ),
		'selector_var'   => array(
			'font-family'    => '--wd-title-font',
			'font-weight'    => '--wd-title-font-weight',
			'text-transform' => '--wd-title-transform',
			'color'          => '--wd-title-color',
			'font-style'     => '--wd-title-font-style',
		),
		'default'        => array(
			array(
				'font-weight' => '600',
				'color'       => '#242424',
			),
		),
		'line-height'    => false,
		'text-transform' => true,
		'font-size'      => false,
		'tags'           => 'typography',
		'priority'       => 20,
	)
);

Options::add_field(
	array(
		'id'             => 'post-titles-font',
		'type'           => 'typography',
		'section'        => 'typography_section',
		'name'           => esc_html__( 'Entities names font', 'woodmart' ),
		'description'    => esc_html__( 'Set titles for posts, products, categories and projects.', 'woodmart' ),
		'selector_var'   => array(
			'font-family'    => '--wd-entities-title-font',
			'font-weight'    => '--wd-entities-title-font-weight',
			'color'          => '--wd-entities-title-color',
			'color-hover'    => '--wd-entities-title-color-hover',
			'text-transform' => '--wd-entities-title-transform',
			'font-style'     => '--wd-entities-title-font-style',
		),
		'default'        => array(
			array(
				'font-weight' => '500',
				'color'       => '#333333',
				'hover'       => array(
					'color' => 'rgb(51 51 51 / 65%)',
				),
			),
		),
		'color-hover'    => true,
		'line-height'    => false,
		'text-transform' => true,
		'font-size'      => false,
		'tags'           => 'typography',
		'priority'       => 30,
	)
);

Options::add_field(
	array(
		'id'           => 'secondary-font',
		'type'         => 'typography',
		'section'      => 'typography_section',
		'name'         => esc_html__( 'Secondary font', 'woodmart' ),
		'description'  => esc_html__( 'Typography for page builder elements options where "Secondary font" was chosen or used custom CSS class "font-alt".', 'woodmart' ),
		'selector_var' => array(
			'font-family' => '--wd-alternative-font',
			'font-style'  => '--wd-alternative-font-style',
		),
		'default'      => array(
			array(
				'font-weight' => '400',
			),
		),
		'line-height'  => false,
		'font-size'    => false,
		'color'        => false,
		'tags'         => 'typography',
		'priority'     => 40,
	)
);

Options::add_field(
	array(
		'id'             => 'widget-titles-font',
		'type'           => 'typography',
		'section'        => 'typography_section',
		'name'           => esc_html__( 'Widget titles font', 'woodmart' ),
		'description'    => esc_html__( 'Typography options for widget titles.', 'woodmart' ),
		'selector_var'   => array(
			'font-family'    => '--wd-widget-title-font',
			'font-weight'    => '--wd-widget-title-font-weight',
			'font-size'      => '--wd-widget-title-font-size',
			'text-transform' => '--wd-widget-title-transform',
			'color'          => '--wd-widget-title-color',
			'font-style'     => '--wd-widget-title-font-style',
		),
		'default'        => array(
			array(
				'font-weight'    => '600',
				'font-size'      => '16',
				'color'          => '#333',
				'text-transform' => 'uppercase',
			),
		),
		'text-transform' => true,
		'line-height'    => false,
		'tags'           => 'typography',
		'priority'       => 50,
	)
);

Options::add_field(
	array(
		'id'             => 'navigation-font',
		'type'           => 'typography',
		'section'        => 'typography_section',
		'name'           => esc_html__( 'Header font', 'woodmart' ),
		'description'    => esc_html__( 'Typography options for site header elements.', 'woodmart' ),
		'selector_var'   => array(
			'font-family'    => '--wd-header-el-font',
			'font-weight'    => '--wd-header-el-font-weight',
			'font-size'      => '--wd-header-el-font-size',
			'text-transform' => '--wd-header-el-transform',
			'font-style'     => '--wd-header-el-font-style',
		),
		'default'        => array(
			array(
				'font-weight'    => '700',
				'font-size'      => '13',
				'text-transform' => 'uppercase',
			),
		),
		'text-transform' => true,
		'line-height'    => false,
		'color'          => false,
		'tags'           => 'typography',
		'priority'       => 60,
	)
);

Options::add_field(
	array(
		'id'       => 'typography_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'content'  => wp_kses(
			__( 'Note that if you use Google fonts, only select font weights will be loaded on your website. So if you set font-weight 400 for body and 600 for headings, you will not be able to set 100, 300, or 700 font-weight for some of the Elementor/WPBakery elements. If you want to load additional font weights but don\'t want to set them globally, go to Advanced Typography, add a new rule with your font-family and font-weight without assigning it to any of the elements. Then, you will have this font-weight loaded globally so you can set it for any of the WPBakery/Elementor elements.', 'woodmart' ),
			array(
				'a'      => array(
					'href'   => true,
					'target' => true,
				),
				'br'     => array(),
				'strong' => array(),
				'u'      => array(),
			)
		),
		'section'  => 'typography_section',
		'priority' => 70,
	)
);

/**
 * Advanced typography.
 */
Options::add_field(
	array(
		'id'             => 'advanced_typography',
		'type'           => 'typography',
		'name'           => 'Advanced typography',
		'section'        => 'advanced_typography_section',
		'selectors'      => '',
		'callback'       => 'woodmart_get_theme_settings_selectors_array',
		'color-hover'    => true,
		'text-transform' => true,
		'priority'       => 10,
		'class'          => 'xts-hide-field-title',
	)
);

Options::add_field(
	array(
		'id'       => 'advanced_typography_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'content'  => wp_kses(
			__( 'Here you can change the typography settings for individual site elements regardless of basic settings. For example, change the font size for the price, set the color for mobile menu links, increase post titles font size, change breadcrumbs color, etc. Using “Custom selector” option allows you to write your own CSS selector and apply any font rules to it.', 'woodmart' ),
			array(
				'a'      => array(
					'href'   => true,
					'target' => true,
				),
				'br'     => array(),
				'strong' => array(),
				'u'      => array(),
			)
		),
		'section'  => 'advanced_typography_section',
		'priority' => 20,
	)
);

/**
 * Custom Fonts.
 */
Options::add_field(
	array(
		'id'       => 'multi_custom_fonts_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'content'  => wp_kses(
			__(
				'In this section you can upload your custom fonts files. To ensure the best compatibility in all browsers you would better upload your fonts in all available formats. 
<br><strong>IMPORTANT NOTE</strong>: After uploading all files and entering the font name, you will have to save Theme Settings and <strong>RELOAD</strong> this page. Then, you will be able to go to Theme Settings -> Typography and select the custom font from the list. Find more information in our documentation <a href="https://xtemos.com/docs/woodmart/faq-guides/upload-custom-fonts/" target="_blank">here</a>.',
				'woodmart'
			),
			array(
				'a'      => array(
					'href'   => true,
					'target' => true,
				),
				'br'     => array(),
				'strong' => array(),
			)
		),
		'section'  => 'custom_fonts_section',
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'multi_custom_fonts',
		'type'     => 'custom_fonts',
		'name'     => 'Custom fonts',
		'section'  => 'custom_fonts_section',
		'fonts'    => apply_filters( 'woodmart_custom_fonts_type', array( 'woff', 'woff2' ) ),
		'priority' => 20,
		'class'    => 'xts-hide-field-title',
	)
);

/**
 * Icon Fonts.
 */
Options::add_field(
	array(
		'id'       => 'icon_font',
		'type'     => 'icons_font',
		'name'     => esc_html__( 'Icon fonts', 'woodmart' ),
		'section'  => 'icons_fonts_section',
		'options'  => array(
			'font'   => array(
				'1' => array(
					'name'  => esc_html__( 'Icon font 1', 'woodmart' ),
					'value' => '1',
				),
				'2' => array(
					'name'  => esc_html__( 'Icon font 2', 'woodmart' ),
					'value' => '2',
				),
				'3' => array(
					'name'  => esc_html__( 'Icon font 3', 'woodmart' ),
					'value' => '3',
				),
			),
			'weight' => array(
				'300' => array(
					'name'  => esc_html__( 'Light', 'woodmart' ),
					'value' => '300',
				),
				'400' => array(
					'name'  => esc_html__( 'Regular', 'woodmart' ),
					'value' => '400',
				),
				'700' => array(
					'name'  => esc_html__( 'Bold', 'woodmart' ),
					'value' => '700',
				),
			),
		),
		'default'  => array(
			'font'   => '1',
			'weight' => '400',
		),
		'class'    => 'xts-hide-field-title',
		'priority' => 10,
	)
);

/**
 * Typekit fonts.
 */
Options::add_field(
	array(
		'id'       => 'typekit_notice',
		'type'     => 'notice',
		'style'    => 'info',
		'name'     => '',
		'content'  => wp_kses(
			__( 'To use your Adobe font, you need to create an account on the <a href="https://fonts.adobe.com/" target="_blank"><u>service</u></a> and obtain your key ID here. Then, you need to enter all custom fonts you will use separated with coma. After this, save Theme Settings and reload this page to be able to select your fonts in the list under the Theme Settings -> Typography section.', 'woodmart' ),
			array(
				'a'      => array(
					'href'   => true,
					'target' => true,
				),
				'br'     => array(),
				'strong' => array(),
				'u'      => array(),
			)
		),
		'section'  => 'typekit_section',
		'priority' => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'typekit_id',
		'name'        => esc_html__( 'Adobe project IDs', 'woodmart' ),
		'description' => sprintf(
			'%s <a target="_blank" href="https://fonts.adobe.com/my_fonts#web_projects-section">%s</a> %s',
			esc_html__( 'Enter your', 'woodmart' ),
			esc_html__( 'Adobe project IDs', 'woodmart' ),
			esc_html__( 'separate with coma: tpm3one, qny2aiv. ', 'woodmart' )
		),
		'type'        => 'text_input',
		'section'     => 'typekit_section',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'typekit_fonts',
		'name'        => esc_html__( 'Adobe font face', 'woodmart' ),
		'description' => esc_html__( 'Example: futura-pt, lato', 'woodmart' ),
		'type'        => 'text_input',
		'section'     => 'typekit_section',
		'priority'    => 30,
	)
);
