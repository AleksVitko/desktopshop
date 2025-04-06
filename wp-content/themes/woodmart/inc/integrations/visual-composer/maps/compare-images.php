<?php
/**
 * Compare images map.
 *
 * @package WoodMart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_vc_map_compare_images' ) ) {
	/**
	 * Compare images element map.
	 */
	function woodmart_get_vc_map_compare_images() {
		return array(
			'name'        => esc_html__( 'Compare images', 'woodmart' ),
			'base'        => 'woodmart_compare_images',
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/compare-images.svg',
			'description' => esc_html__( 'Compare two images using the slider', 'woodmart' ),
			'params'      => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),

				array(
					'type'        => 'wd_notice',
					'param_name'  => 'notice',
					'notice_type' => 'info',
					'value'       => esc_html__(
						'Note: For the best appearance, both images should have identical dimensions and aspect ratios.',
						'woodmart'
					),
				),

				/**
				 * Image Option Section.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Image before', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'param_name'       => 'first_image',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'param_name'       => 'first_image_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'full\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Image after', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'param_name'       => 'second_image',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'param_name'       => 'second_image_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'full\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				/**
				 * Style Tab.
				 */
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Image alignment', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'alignment',
					'std'              => '',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )   => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' )  => 'right',
					),
					'images_value'     => array(
						'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
					'wood_tooltip'     => true,
					'allowed_unselect' => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),

				array(
					'heading'       => esc_html__( 'Rounding', 'woodmart' ),
					'group'         => esc_html__( 'Style', 'woodmart' ),
					'type'          => 'wd_select',
					'param_name'    => 'rounding_size',
					'style'         => 'select',
					'selectors'     => array(
						'{{WRAPPER}}' => array(
							'--wd-brd-radius: {{VALUE}}px;',
						),
					),
					'devices'       => array(
						'desktop' => array(
							'value' => '',
						),
					),
					'value'         => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( '0', 'woodmart' )      => '0',
						esc_html__( '5', 'woodmart' )      => '5',
						esc_html__( '8', 'woodmart' )      => '8',
						esc_html__( '12', 'woodmart' )     => '12',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'generate_zero' => true,
				),

				array(
					'heading'       => esc_html__( 'Custom rounding', 'woodmart' ),
					'group'         => esc_html__( 'Style', 'woodmart' ),
					'type'          => 'wd_slider',
					'param_name'    => 'custom_rounding_size',
					'selectors'     => array(
						'{{WRAPPER}}' => array(
							'--wd-brd-radius: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'       => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'         => array(
						'px' => array(
							'min'  => 0,
							'max'  => 300,
							'step' => 1,
						),
						'%'  => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					),
					'dependency'    => array(
						'element' => 'rounding_size',
						'value'   => function_exists( 'woodmart_compress' ) ? woodmart_compress(
							wp_json_encode(
								array(
									'devices' => array(
										'desktop' => array(
											'value' => 'custom',
										),
									),
								)
							)
						) : '',
					),
					'generate_zero' => true,
				),

				array(
					'param_name'       => 'handle_color_scheme',
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Color scheme', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
						esc_html__( 'Dark', 'woodmart' )   => 'dark',
						esc_html__( 'Light', 'woodmart' )  => 'light',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'style'            => array(
						'dark' => '#2d2a2a',
					),
					'std'              => 'inherit',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Custom handle color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'custom_handle_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-compare-img-handle' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'handle_color_scheme',
						'value'   => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Custom handle background', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'custom_handle_background',
					'selectors'        => array(
						'{{WRAPPER}} .wd-compare-img-handle' => array(
							'background-color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'handle_color_scheme',
						'value'   => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				/**
				 * Design Option Tab.
				 */
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				woodmart_get_vc_responsive_spacing_map(),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Box Shadow', 'woodmart' ),
					'param_name'       => 'woodmart_box_shadow',
					'group'            => esc_html__( 'Design Options', 'js_composer' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'wd_box_shadow',
					'param_name'       => 'wd_box_shadow',
					'group'            => esc_html__( 'Design Options', 'js_composer' ),
					'selectors'        => array(
						'{{WRAPPER}}' => array(
							'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'dependency'       => array(
						'element' => 'woodmart_box_shadow',
						'value'   => array( 'yes' ),
					),
					'default'          => array(
						'horizontal' => '0',
						'vertical'   => '0',
						'blur'       => '9',
						'spread'     => '0',
						'color'      => 'rgba(0, 0, 0, .15)',
					),
				),

				/**
				 * Advanced Tab.
				 */
				woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ),

				// Width option (with dependency Columns option, responsive).
				woodmart_get_responsive_dependency_width_map( 'responsive_tabs' ),
				woodmart_get_responsive_dependency_width_map( 'width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'width_mobile' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_mobile' ),
			),
		);
	}
}
