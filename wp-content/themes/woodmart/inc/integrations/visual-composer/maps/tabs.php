<?php
/**
 * Maps for tabs element.
 *
 * @package Elements.
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_vc_map_tabs' ) ) {
	/**
	 * Displays the shortcode settings fields in the admin.
	 */
	function woodmart_get_vc_map_tabs() {
		$typography = woodmart_get_typography_map(
			array(
				'title'    => esc_html__( 'Title typography', 'woodmart' ),
				'group'    => esc_html__( 'General', 'woodmart' ),
				'key'      => 'heading_title',
				'selector' => '{{WRAPPER}}.wd-tabs .tabs-name',
			)
		);

		$secondary_font = woodmart_get_opt( 'secondary-font' );
		$primary_font   = woodmart_get_opt( 'primary-font' );
		$text_font      = woodmart_get_opt( 'text-font' );

		$secondary_font_title = isset( $secondary_font[0]['font-family'] ) ? esc_html__( 'Secondary font', 'woodmart' ) . ' (' . $secondary_font[0]['font-family'] . ')' : esc_html__( 'Secondary font', 'woodmart' );
		$text_font_title      = isset( $text_font[0]['font-family'] ) ? esc_html__( 'Text font', 'woodmart' ) . ' (' . $text_font[0]['font-family'] . ')' : esc_html__( 'Text', 'woodmart' );
		$primary_font_title   = isset( $primary_font[0]['font-family'] ) ? esc_html__( 'Title font', 'woodmart' ) . ' (' . $primary_font[0]['font-family'] . ')' : esc_html__( 'Title font', 'woodmart' );

		return array(
			'base'            => 'woodmart_tabs',
			'name'            => esc_html__( 'Tabs', 'woodmart' ),
			'description'     => esc_html__( 'Tabbed content', 'woodmart' ),
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/tabs.svg',
			'as_parent'       => array( 'only' => 'woodmart_tab' ),
			'content_element' => true,
			'js_view'         => 'VcColumnView',
			'default_content' => '[woodmart_tab title="Tab #1"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.[/woodmart_tab][woodmart_tab title="Tab #2"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. 2[/woodmart_tab]',
			'params'          => array(
				array(
					'param_name' => 'woodmart_css_id',
					'type'       => 'woodmart_css_id',
					'group'      => esc_html__( 'General', 'woodmart' ),
				),
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Heading', 'woodmart' ),
					'group'      => esc_html__( 'General', 'woodmart' ),
					'param_name' => 'title_divider',
				),
				array(
					'heading'          => esc_html__( 'Design', 'woodmart' ),
					'group'            => esc_html__( 'General', 'woodmart' ),
					'type'             => 'woodmart_image_select',
					'param_name'       => 'design',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Bordered', 'woodmart' ) => 'simple',
						esc_html__( 'Space between', 'woodmart' ) => 'alt',
						esc_html__( 'Aside', 'woodmart' ) => 'aside',
					),
					'images_value'     => array(
						'default' => WOODMART_ASSETS_IMAGES . '/settings/ajax-tabs/default.png',
						'simple'  => WOODMART_ASSETS_IMAGES . '/settings/ajax-tabs/simple.png',
						'alt'     => WOODMART_ASSETS_IMAGES . '/settings/ajax-tabs/alternative.png',
						'aside'   => WOODMART_ASSETS_IMAGES . '/settings/ajax-tabs/aside.png',
					),
					'std'              => 'default',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-xs-12 vc_column tab-design',
				),
				array(
					'heading'          => esc_html__( 'Title color', 'woodmart' ),
					'group'            => esc_html__( 'General', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'tabs_title_color',
					'selectors'        => array(
						'{{WRAPPER}} .tabs-name' => array(
							'color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				$typography['font_family'],
				$typography['font_size'],
				$typography['font_weight'],
				$typography['text_transform'],
				$typography['font_style'],
				$typography['line_height'],
				array(
					'heading'          => esc_html__( 'Description color', 'woodmart' ),
					'group'            => esc_html__( 'General', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'tabs_description_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-tabs-desc' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'default', 'aside' ),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Border color', 'woodmart' ),
					'group'            => esc_html__( 'General', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'tabs_border_color',
					'selectors'        => array(
						'{{WRAPPER}}.wd-tabs.tabs-design-simple .tabs-name' => array(
							'border-color: {{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'simple' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'wd_slider',
					'param_name'       => 'tabs_side_width',
					'heading'          => esc_html__( 'Side heading width', 'woodmart' ),
					'group'            => esc_html__( 'General', 'woodmart' ),
					'devices'          => array(
						'desktop' => array(
							'unit' => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 100,
							'max'  => 500,
							'step' => 1,
						),
						'%'  => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					),
					'selectors'        => array(
						'{{WRAPPER}} .wd-tabs.tabs-design-aside' => array(
							'--wd-side-width: {{VALUE}}{{UNIT}};',
						),
					),
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'aside' ),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Heading background', 'woodmart' ),
					'group'            => esc_html__( 'General', 'woodmart' ),
					'type'             => 'woodmart_switch',
					'param_name'       => 'enable_heading_bg',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				array(
					'heading'          => esc_html__( 'Custom background color', 'woodmart' ),
					'group'            => esc_html__( 'General', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'heading_bg',
					'selectors'        => array(
						'{{WRAPPER}}.wd-tabs.wd-header-with-bg .wd-tabs-header' => array(
							'background-color:{{VALUE}};',
						),
					),
					'dependency'       => array(
						'element' => 'enable_heading_bg',
						'value'   => array( 'yes' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				array(
					'group'       => esc_html__( 'General', 'woodmart' ),
					'type'       => 'woodmart_empty_space',
					'param_name' => 'woodmart_empty_space',
				),
				array(
					'param_name'       => 'tabs_title_alignment',
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Alignment', 'woodmart' ),
					'group'            => esc_html__( 'General', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
					'images_value'     => array(
						'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
					'std'              => 'center',
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'default' ),
					),
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				/**
				 * Title
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Heading content', 'woodmart' ),
					'group'      => esc_html__( 'General', 'woodmart' ),
					'param_name' => 'title_divider',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title', 'woodmart' ),
					'group'      => esc_html__( 'General', 'woodmart' ),
					'param_name' => 'title',
				),
				array(
					'type'       => 'textarea',
					'heading'    => esc_html__( 'Description', 'woodmart' ),
					'group'      => esc_html__( 'General', 'woodmart' ),
					'param_name' => 'description',
					'dependency' => array(
						'element' => 'design',
						'value'   => array( 'default', 'aside' ),
					),
				),
				/**
				 * Image
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Icon settings', 'woodmart' ),
					'group'      => esc_html__( 'General', 'woodmart' ),
					'param_name' => 'image_divider',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Icon image', 'woodmart' ),
					'group'            => esc_html__( 'General', 'woodmart' ),
					'param_name'       => 'image',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Images size', 'woodmart' ),
					'group'            => esc_html__( 'General', 'woodmart' ),
					'param_name'       => 'img_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Tabs Layout.
				 */
				array(
					'param_name' => 'tabs_layout_divider',
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'Layout', 'woodmart' ),
					'group'      => esc_html__( 'Tab title', 'woodmart' ),
					'holder'     => 'div',
				),
				array(
					'param_name'       => 'tabs_style',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Style', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Underline', 'woodmart' ) => 'underline',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'icon_position',
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Icon position', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Top', 'woodmart' ) => 'top',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
					'images_value'     => array(
						'top'   => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/top.png',
						'left'  => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/left.png',
						'right' => WOODMART_ASSETS_IMAGES . '/settings/infobox/position/right.png',
					),
					'std'              => 'left',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				array(
					'type'             => 'wd_slider',
					'param_name'       => 'tabs_title_space_between_vertical',
					'heading'          => esc_html__( 'Vertical spacing', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'devices'          => array(
						'desktop' => array(
							'unit' => 'px',
						),
						'tablet'  => array(
							'unit' => 'px',
						),
						'mobile'  => array(
							'unit' => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 0,
							'max'  => 150,
							'step' => 1,
						),
					),
					'selectors'        => array(
						'body.wpb-js-composer {{WRAPPER}}.wd-tabs' => array(
							'--wd-row-gap: {{VALUE}}{{UNIT}};',
						),
					),
					'dependency'       => array(
						'element'            => 'design',
						'value_not_equal_to' => array( 'aside' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'wd_slider',
					'param_name'       => 'tabs_title_space_between_horizontal',
					'heading'          => esc_html__( 'Horizontal spacing', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'devices'          => array(
						'desktop' => array(
							'unit' => 'px',
						),
						'tablet'  => array(
							'unit' => 'px',
						),
						'mobile'  => array(
							'unit' => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 0,
							'max'  => 150,
							'step' => 1,
						),
					),
					'selectors'        => array(
						'{{WRAPPER}} .wd-nav-tabs' => array(
							'--nav-gap: {{VALUE}}{{UNIT}};',
						),
					),
					'dependency'       => array(
						'element'            => 'design',
						'value_not_equal_to' => array( 'aside' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Tabs Typography.
				 */
				array(
					'param_name' => 'tabs_layout_divider',
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'Typography', 'woodmart' ),
					'group'      => esc_html__( 'Tab title', 'woodmart' ),
					'holder'     => 'div',
				),
				array(
					'param_name'       => 'tabs_title_font_family',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Font family', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'value'            => array(
						$primary_font_title   => 'primary',
						$text_font_title      => 'text',
						$secondary_font_title => 'alt',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_title_font_weight',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Font weight', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'value'            => array(
						'' => '',
						esc_html__( 'Ultra-Light 100', 'woodmart' ) => 100,
						esc_html__( 'Light 200', 'woodmart' ) => 200,
						esc_html__( 'Book 300', 'woodmart' ) => 300,
						esc_html__( 'Normal 400', 'woodmart' ) => 400,
						esc_html__( 'Medium 500', 'woodmart' ) => 500,
						esc_html__( 'Semi-Bold 600', 'woodmart' ) => 600,
						esc_html__( 'Bold 700', 'woodmart' ) => 700,
						esc_html__( 'Extra-Bold 800', 'woodmart' ) => 800,
						esc_html__( 'Ultra-Bold 900', 'woodmart' ) => 900,
					),
					'std'              => 600,
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_title_font_size',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Predefined size', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Small (16px)', 'woodmart' ) => 's',
						esc_html__( 'Extra Small (14px)', 'woodmart' ) => 'xs',
						esc_html__( 'Medium (18px)', 'woodmart' ) => 'm',
						esc_html__( 'Large (22px)', 'woodmart' ) => 'l',
						esc_html__( 'Extra Large (26px)', 'woodmart' ) => 'xl',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_title_custom_font_size',
					'type'             => 'woodmart_responsive_size',
					'heading'          => esc_html__( 'Custom font size', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'css_args'         => array(
						'font-size' => array(
							' .wd-fontsize-custom',
						),
					),
					'dependency'       => array(
						'element' => 'tabs_title_font_size',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_title_line_height',
					'type'             => 'woodmart_responsive_size',
					'heading'          => esc_html__( 'Custom line height', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'css_args'         => array(
						'line-height' => array(
							' .wd-fontsize-custom',
						),
					),
					'dependency'       => array(
						'element' => 'tabs_title_font_size',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_title_color_scheme',
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Color scheme', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'style'            => array(
						'dark' => '#2d2a2a',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_title_text_color',
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Text color', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'css_args'         => array(
						'color' => array(
							' .wd-nav > li > a',
						),
					),
					'dependency'       => array(
						'element' => 'tabs_title_color_scheme',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_text_hover_color',
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Text hover color', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'css_args'         => array(
						'color' => array(
							' .wd-nav > li:hover > a',
						),
					),
					'dependency'       => array(
						'element' => 'tabs_title_color_scheme',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_text_active_color',
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Text active color', 'woodmart' ),
					'group'            => esc_html__( 'Tab title', 'woodmart' ),
					'css_args'         => array(
						'color' => array(
							'.wd-tabs:not(.wd-inited) .wd-nav-tabs li:first-child a',
							' .wd-nav-tabs > li.wd-active > a',
						),
					),
					'dependency'       => array(
						'element' => 'tabs_title_color_scheme',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Content Settings.
				 */
				array(
					'param_name' => 'content_typography_divider',
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'Typography', 'woodmart' ),
					'group'      => esc_html__( 'Content', 'woodmart' ),
					'holder'     => 'div',
				),
				array(
					'param_name'       => 'content_font_family',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Font family', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						$primary_font_title   => 'primary',
						$text_font_title      => 'text',
						$secondary_font_title => 'alt',
					),
					'std'              => '',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'content_font_size',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Predefined size', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( 'Small (16px)', 'woodmart' ) => 's',
						esc_html__( 'Extra Small (14px)', 'woodmart' ) => 'xs',
						esc_html__( 'Medium (18px)', 'woodmart' ) => 'm',
						esc_html__( 'Large (22px)', 'woodmart' ) => 'l',
						esc_html__( 'Extra Large (26px)', 'woodmart' ) => 'xl',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'content_custom_font_size',
					'type'             => 'woodmart_responsive_size',
					'heading'          => esc_html__( 'Custom font size', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'css_args'         => array(
						'font-size' => array(
							' .wd-fontsize-custom',
						),
					),
					'dependency'       => array(
						'element' => 'content_font_size',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'content_line_height',
					'type'             => 'woodmart_responsive_size',
					'heading'          => esc_html__( 'Custom line height', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'css_args'         => array(
						'line-height' => array(
							' .wd-fontsize-custom',
						),
					),
					'dependency'       => array(
						'element' => 'content_font_size',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'content_font_weight',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Font weight', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( 'Ultra-Light 100', 'woodmart' ) => 100,
						esc_html__( 'Light 200', 'woodmart' ) => 200,
						esc_html__( 'Book 300', 'woodmart' ) => 300,
						esc_html__( 'Normal 400', 'woodmart' ) => 400,
						esc_html__( 'Medium 500', 'woodmart' ) => 500,
						esc_html__( 'Semi-Bold 600', 'woodmart' ) => 600,
						esc_html__( 'Bold 700', 'woodmart' ) => 700,
						esc_html__( 'Extra-Bold 800', 'woodmart' ) => 800,
						esc_html__( 'Ultra-Bold 900', 'woodmart' ) => 900,
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'content_text_color_scheme',
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Color scheme', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'style'            => array(
						'dark' => '#2d2a2a',
					),
					'std'              => 'inherit',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name' => 'content_text_color_custom',
					'type'       => 'woodmart_colorpicker',
					'heading'    => esc_html__( 'Custom Color', 'woodmart' ),
					'group'      => esc_html__( 'Content', 'woodmart' ),
					'css_args'   => array(
						'color' => array(
							' .wd-tab-content',
						),
					),
					'dependency' => array(
						'element' => 'content_text_color_scheme',
						'value'   => array( 'custom' ),
					),

				),

				/**
				 * Design Options.
				 */
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				woodmart_get_vc_responsive_spacing_map(),

				woodmart_get_responsive_dependency_width_map( 'responsive_tabs' ),
				woodmart_get_responsive_dependency_width_map( 'width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'width_mobile' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_mobile' ),

				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Theme Animation', 'woodmart' ),
					'hint'             => esc_html__( 'Use custom theme animations if you want to run them in the slider element.', 'woodmart' ),
					'param_name'       => 'wd_animation',
					'group'            => esc_html__( 'Advanced', 'woodmart' ),
					'admin_label'      => true,
					'value'            => array(
						esc_html__( 'None', 'woodmart' )       => '',
						esc_html__( 'Slide from top', 'woodmart' ) => 'slide-from-top',
						esc_html__( 'Slide from bottom', 'woodmart' ) => 'slide-from-bottom',
						esc_html__( 'Slide from left', 'woodmart' ) => 'slide-from-left',
						esc_html__( 'Slide from right', 'woodmart' ) => 'slide-from-right',
						esc_html__( 'Slide short from left', 'woodmart' ) => 'slide-short-from-left',
						esc_html__( 'Slide short from right', 'woodmart' ) => 'slide-short-from-right',
						esc_html__( 'Flip X bottom', 'woodmart' ) => 'bottom-flip-x',
						esc_html__( 'Flip X top', 'woodmart' ) => 'top-flip-x',
						esc_html__( 'Flip Y left', 'woodmart' ) => 'left-flip-y',
						esc_html__( 'Flip Y right', 'woodmart' ) => 'right-flip-y',
						esc_html__( 'Zoom in', 'woodmart' )    => 'zoom-in',
					),
					'std'              => '',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Theme Animation Delay (ms)', 'woodmart' ),
					'param_name'       => 'wd_animation_delay',
					'group'            => esc_html__( 'Advanced', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'dependency'       => array(
						'element'            => 'wd_animation',
						'value_not_equal_to' => array( '' ),
					),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Theme Animation duration', 'woodmart' ),
					'param_name'       => 'wd_animation_duration',
					'group'            => esc_html__( 'Advanced', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'value'            => array(
						esc_html__( 'Slow', 'woodmart' )   => 'slow',
						esc_html__( 'Normal', 'woodmart' ) => 'normal',
						esc_html__( 'Fast', 'woodmart' )   => 'fast',
					),
					'dependency'       => array(
						'element'            => 'wd_animation',
						'value_not_equal_to' => array( '' ),
					),
					'std'              => 'normal',
				),

				woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ),
			),
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_tab' ) ) {
	function woodmart_get_vc_map_tab() {
		return array(
			'base'            => 'woodmart_tab',
			'name'            => esc_html__( 'Tab', 'woodmart' ),
			'description'     => esc_html__( 'Add tab in tabs area', 'woodmart' ),
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/tab.svg',
			'as_child'        => array( 'only' => 'woodmart_tabs' ),
			'content_element' => true,
			'params'          => array(
				/**
				 * Title.
				 */
				array(
					'param_name' => 'title',
					'type'       => 'textarea',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Title', 'woodmart' ),
				),
				/**
				 * Content.
				 */
				array(
					'param_name' => 'tabs_content_divider',
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'Content', 'woodmart' ),
				),
				array(
					'param_name'       => 'content_type',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Content type', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Text', 'woodmart' ) => 'text',
						esc_html__( 'HTML Block', 'woodmart' ) => 'html_block',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name' => 'content',
					'type'       => 'textarea_html',
					'heading'    => esc_html__( 'Content', 'woodmart' ),
					'dependency' => array(
						'element' => 'content_type',
						'value'   => array( 'text' ),
					),
				),
				array(
					'param_name' => 'html_block_id',
					'type'       => 'woodmart_dropdown',
					'heading'    => esc_html__( 'Select block', 'woodmart' ),
					'callback'   => 'woodmart_get_html_blocks_array_with_empty',
					'dependency' => array(
						'element' => 'content_type',
						'value'   => array( 'html_block' ),
					),
				),

				/**
				 * Icon.
				 */
				array(
					'param_name' => 'icon_divider',
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'Icon settings', 'woodmart' ),
					'holder'     => 'div',
				),
				array(
					'param_name'       => 'tabs_title_icon_type',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'List type', 'woodmart' ),
					'value'            => array(
						esc_html__( 'With icon', 'woodmart' ) => 'icon',
						esc_html__( 'With image', 'woodmart' ) => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_image',
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'value'            => '',
					'dependency'       => array(
						'element' => 'tabs_title_icon_type',
						'value'   => array( 'image' ),
					),
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_image_size',
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'dependency'       => array(
						'element' => 'tabs_title_icon_type',
						'value'   => array( 'image' ),
					),
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name'       => 'tabs_icon_libraries',
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Icon library', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Font Awesome', 'woodmart' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'woodmart' )  => 'openiconic',
						esc_html__( 'Typicons', 'woodmart' )     => 'typicons',
						esc_html__( 'Entypo', 'woodmart' )       => 'entypo',
						esc_html__( 'Linecons', 'woodmart' )     => 'linecons',
						esc_html__( 'Mono Social', 'woodmart' )  => 'monosocial',
						esc_html__( 'Material', 'woodmart' )     => 'material',
					),
					'dependency'       => array(
						'element' => 'tabs_title_icon_type',
						'value'   => 'icon',
					),
					'hint'             => esc_html__( 'Select icon library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'param_name' => 'icon_fontawesome',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'fontawesome',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'param_name' => 'icon_openiconic',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'openiconic',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'openiconic',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'param_name' => 'icon_typicons',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'typicons',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'typicons',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'param_name' => 'icon_entypo',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'entypo',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'entypo',
					),
				),
				array(
					'param_name' => 'icon_linecons',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'linecons',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'linecons',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'param_name' => 'icon_monosocial',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'monosocial',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'monosocial',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'param_name' => 'icon_material',
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'material',
						'iconsPerPage' => 50,
					),
					'dependency' => array(
						'element' => 'tabs_icon_libraries',
						'value'   => 'material',
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
			),
		);
	}
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	/**
	 * Create woodmart tabs wrapper.
	 */
	class WPBakeryShortCode_woodmart_tabs extends WPBakeryShortCodesContainer {}
}
