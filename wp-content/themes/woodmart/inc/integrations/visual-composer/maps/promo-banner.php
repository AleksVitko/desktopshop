<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}
/**
* ------------------------------------------------------------------------------------------------
* Promo Banner element map
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_get_vc_map_promo_banner' ) ) {
	function woodmart_get_vc_map_promo_banner() {
		return array(
			'name'        => esc_html__( 'Promo Banner', 'woodmart' ),
			'base'        => 'promo_banner',
			'class'       => '',
			'category'    => function_exists( 'woodmart_get_tab_title_category_for_wpb' ) ?
				woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ) : esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Promo image with text and hover effect', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/promo-banner.svg',
			'params'      => woodmart_get_banner_params(),
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_banners_carousel' ) ) {
	function woodmart_get_vc_map_banners_carousel() {
		return array(
			'name'                    => esc_html__( 'Banners carousel', 'woodmart' ),
			'base'                    => 'banners_carousel',
			'as_parent'               => array( 'only' => 'promo_banner' ),
			'content_element'         => true,
			'show_settings_on_create' => true,
			'category'                => function_exists( 'woodmart_get_tab_title_category_for_wpb' ) ?
				woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ) : esc_html__( 'Theme elements', 'woodmart' ),
			'description'             => esc_html__( 'Show your banners as a carousel', 'woodmart' ),
			'icon'                    => WOODMART_ASSETS . '/images/vc-icon/banners-carousel.svg',
			'params'                  => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Carousel', 'woodmart' ),
					'param_name' => 'slider_divider',
				),

				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ? woodmart_get_vc_responsive_spacing_map() : '',
				/**
				 * Extra
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'group'      => esc_html__( 'Advanced', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'group'      => esc_html__( 'Advanced', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
			),
			'js_view'                 => 'VcColumnView',
		);
	}
}

if ( ! function_exists( 'woodmart_get_banner_params' ) ) {
	function woodmart_get_banner_params() {
		$secondary_font = woodmart_get_opt( 'secondary-font' );
		$text_font      = woodmart_get_opt( 'text-font' );
		$primary_font   = woodmart_get_opt( 'primary-font' );

		$secondary_font_title = isset( $secondary_font[0]['font-family'] ) ? esc_html__( 'Secondary font', 'woodmart' ) . ' (' . $secondary_font[0]['font-family'] . ')' : esc_html__( 'Secondary font', 'woodmart' );
		$text_font_title      = isset( $text_font[0]['font-family'] ) ? esc_html__( 'Text font', 'woodmart' ) . ' (' . $text_font[0]['font-family'] . ')' : esc_html__( 'Text', 'woodmart' );
		$primary_font_title   = isset( $primary_font[0]['font-family'] ) ? esc_html__( 'Title font', 'woodmart' ) . ' (' . $primary_font[0]['font-family'] . ')' : esc_html__( 'Title font', 'woodmart' );

		return apply_filters(
			'woodmart_get_banner_params',
			array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				/**
				* Image
				*/
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Background', 'woodmart' ),
					'param_name' => 'image_divider',
				),
				array(
					'type'       => 'woodmart_button_set',
					'heading'    => esc_html__( 'Source', 'woodmart' ),
					'param_name' => 'source_type',
					'value'      => array(
						esc_html__( 'Image', 'woodmart' ) => 'image',
						esc_html__( 'Video', 'woodmart' ) => 'video',
					),
					'default'    => 'image',
				),
				array(
					'type'            => 'wd_upload',
					'heading'         => esc_html__( 'Video', 'woodmart' ),
					'param_name'      => 'video',
					'attachment_type' => 'video',
					'value'           => '',
					'hint'            => esc_html__( 'Select video from media library.', 'woodmart' ),
					'dependency'      => array(
						'element' => 'source_type',
						'value'   => array( 'video' ),
					),
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Fallback image', 'woodmart' ),
					'param_name'       => 'video_poster',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'source_type',
						'value'   => array( 'video' ),
					),
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Fallback image size', 'woodmart' ),
					'param_name'       => 'video_poster_size',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'source_type',
						'value'   => array( 'video' ),
					),
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'param_name'       => 'image',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'source_type',
						'value'   => array( 'image' ),
					),
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'param_name'       => 'img_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'source_type',
						'value'   => array( 'image' ),
					),
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Fixed height', 'woodmart' ),
					'param_name'       => 'custom_height',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
				),
				array(
					'type'             => 'wd_slider',
					'heading'          => esc_html__( 'Banner Height', 'woodmart' ),
					'param_name'       => 'new_height',
					'selectors'  => array(
						'{{WRAPPER}}' => array(
							'--wd-img-height: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'    => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
						'tablet'  => array(
							'value' => '',
							'unit'  => 'px',
						),
						'mobile'  => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'      => array(
						'px' => array(
							'min'  => 0,
							'max'  => 2000,
							'step' => 1,
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'hint'             => esc_html__( 'Default: 0', 'woodmart' ),
					'dependency'       => array(
						'element' => 'custom_height',
						'value'   => array( 'yes' ),
					),
					'transfer'         => 'height',
				),
				array(
					'type'             => 'woodmart_slider',
					'heading'          => esc_html__( 'Image Height', 'woodmart' ),
					'param_name'       => 'height',
					'min'              => '0',
					'max'              => '2000',
					'step'             => '1',
					'default'          => '0',
					'units'            => 'px',
					'value'            => array(
						'600' => '600',
						'500' => '500',
						'400' => '400',
						'350' => '350',
						'300' => '300',
						'250' => '250',
						'200' => '200',
						'150' => '150',
						'100' => '100',
						'0'   => '0',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column xts-hidden',
					'hint'             => esc_html__( 'Default: 0', 'woodmart' ),
					'dependency'       => array(
						'element' => 'custom_height',
						'value'   => array( 'yes' ),
					),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Image Position', 'woodmart' ),
					'param_name'       => 'image_bg_position',
					'value'            => array(
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Top', 'woodmart' )    => 'top',
						esc_html__( 'Bottom', 'woodmart' ) => 'bottom',
						esc_html__( 'Left', 'woodmart' )   => 'left',
						esc_html__( 'Right', 'woodmart' )  => 'right',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'custom_height',
						'value'   => array( 'yes' ),
					),
					'wd_dependency'    => array(
						'element' => 'source_type',
						'value'   => array( 'image' ),
					),
				),
				array(
					'heading'       => esc_html__( 'Rounding', 'woodmart' ),
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
					'type'       => 'vc_link',
					'heading'    => esc_html__( 'Banner link', 'woodmart' ),
					'param_name' => 'link',
					'hint'       => esc_html__( 'Enter URL if you want this banner to have a link.', 'woodmart' ),
				),
				/**
				* Style
				*/
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'style_divider',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Banner style', 'woodmart' ),
					'param_name'       => 'style',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Color mask', 'woodmart' ) => 'mask',
						esc_html__( 'Mask with shadow', 'woodmart' ) => 'shadow',
						esc_html__( 'Bordered', 'woodmart' ) => 'border',
						esc_html__( 'Bordered background', 'woodmart' ) => 'background',
						esc_html__( 'Content background', 'woodmart' ) => 'content-background',
					),
					'images_value'     => array(
						'default'            => WOODMART_ASSETS_IMAGES . '/settings/banner-style/default.png',
						'mask'               => WOODMART_ASSETS_IMAGES . '/settings/banner-style/mask.png',
						'shadow'             => WOODMART_ASSETS_IMAGES . '/settings/banner-style/shadow.png',
						'border'             => WOODMART_ASSETS_IMAGES . '/settings/banner-style/border.png',
						'background'         => WOODMART_ASSETS_IMAGES . '/settings/banner-style/background.png',
						'content-background' => WOODMART_ASSETS_IMAGES . '/settings/banner-style/content-background.png',
					),
					'wood_tooltip'     => true,
					'hint'             => esc_html__( 'You can use some of our predefined styles for your banner content.', 'woodmart' ),
					'edit_field_class' => 'vc_col-xs-12 vc_column banner-style',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Hover effect', 'woodmart' ),
					'param_name'       => 'hover',
					'value'            => array(
						esc_html__( 'Zoom image', 'woodmart' ) => 'zoom',
						esc_html__( 'Parallax', 'woodmart' ) => 'parallax',
						esc_html__( 'Background', 'woodmart' ) => 'background',
						esc_html__( 'Bordered', 'woodmart' ) => 'border',
						esc_html__( 'Zoom reverse', 'woodmart' ) => 'zoom-reverse',
						esc_html__( 'Disable', 'woodmart' ) => 'none',
					),
					'hint'             => esc_html__( 'Set beautiful hover effects for your banner.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Color Scheme', 'woodmart' ),
					'param_name'       => 'woodmart_color_scheme',
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Dark', 'woodmart' )  => 'dark',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Content background color', 'woodmart' ),
					'param_name'       => 'custom_content_bg_color',
					'css_args'         => array(
						'background-color' => array(
							' .wrapper-content-banner',
						),
					),
					'dependency'       => array(
						'element' => 'style',
						'value'   => array( 'content-background' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				* Extra
				*/
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
				/**
				* Title
				*/
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Title', 'woodmart' ),
					'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name' => 'title_divider',
				),
				array(
					'type'       => 'textarea',
					'heading'    => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title',
					'holder'     => 'div',
					'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Font', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'title_font',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						$text_font_title      => 'text',
						$primary_font_title   => 'primary',
						$secondary_font_title => 'alt',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Title tag', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'title_tag',
					'value'            => array(
						'h1'   => 'h1',
						'h2'   => 'h2',
						'h3'   => 'h3',
						'h4'   => 'h4',
						'h5'   => 'h5',
						'h6'   => 'h6',
						'p'    => 'p',
						'div'  => 'div',
						'span' => 'span',
					),
					'std'              => 'h4',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Predefined title size', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'title_size',
					'value'            => array(
						esc_html__( 'Default (22px)', 'woodmart' ) => 'default',
						esc_html__( 'Small (16px)', 'woodmart' ) => 'small',
						esc_html__( 'Large (26px)', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large (36px)', 'woodmart' ) => 'extra-large',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Font weight', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'font_weight',
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
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_responsive_size',
					'heading'          => esc_html__( 'Custom font size', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'custom_title_size',
					'css_args'         => array(
						'font-size' => array(
							' .banner-title',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_responsive_size',
					'heading'          => esc_html__( 'Custom line height', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'custom_title_line_height',
					'css_args'         => array(
						'line-height' => array(
							' .banner-title',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'woodmart_empty_space',
					'param_name' => 'woodmart_empty_space',
					'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
				),
				array(
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'custom_title_color',
					'css_args'         => array(
						'color' => array(
							' .banner-title',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				* Subtitle
				*/
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Subtitle', 'woodmart' ),
					'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name' => 'subtitle_divider',
				),
				array(
					'type'       => 'textarea',
					'heading'    => esc_html__( 'Sub title', 'woodmart' ),
					'param_name' => 'subtitle',
					'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Font', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'subtitle_font',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						$text_font_title      => 'text',
						$primary_font_title   => 'primary',
						$secondary_font_title => 'alt',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Font weight', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'subtitle_font_weight',
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
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_responsive_size',
					'heading'          => esc_html__( 'Size', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'custom_subtitle_size',
					'css_args'         => array(
						'font-size' => array(
							' .banner-subtitle',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_responsive_size',
					'heading'          => esc_html__( 'Line height', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'custom_subtitle_line_height',
					'css_args'         => array(
						'line-height' => array(
							' .banner-subtitle',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'woodmart_empty_space',
					'param_name' => 'woodmart_empty_space',
					'group'      => esc_html__( 'Title and Subtitle', 'woodmart' ),
				),
				array(
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Predefined subtitle color scheme', 'woodmart' ),
					'param_name'       => 'subtitle_color',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Primary', 'woodmart' ) => 'primary',
						esc_html__( 'Alternative', 'woodmart' ) => 'alt',
					),
					'style'            => array(
						'default' => '#f3f3f3',
						'primary' => woodmart_get_color_value( 'primary-color', '#7eb934' ),
						'alt'     => woodmart_get_color_value( 'secondary-color', '#fbbc34' ),
					),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Custom color', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'custom_subtitle_color',
					'css_args'         => array(
						'color' => array(
							' .banner-subtitle',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Subtitle style', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'subtitle_style',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Background', 'woodmart' ) => 'background',
					),
					'images_value'     => array(
						'default'    => WOODMART_ASSETS_IMAGES . '/settings/subtitle-style/default.png',
						'background' => WOODMART_ASSETS_IMAGES . '/settings/subtitle-style/background.png',
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Background color', 'woodmart' ),
					'group'            => esc_html__( 'Title and Subtitle', 'woodmart' ),
					'param_name'       => 'custom_subtitle_bg_color',
					'css_args'         => array(
						'background-color' => array(
							' .banner-subtitle',
						),
					),
					'dependency'       => array(
						'element' => 'subtitle_style',
						'value'   => array( 'background' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				* Content
				*/
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Content', 'woodmart' ),
					'group'      => esc_html__( 'Content', 'woodmart' ),
					'param_name' => 'content_divider',
				),
				array(
					'type'       => 'textarea_html',
					'holder'     => 'div',
					'heading'    => esc_html__( 'Banner content', 'woodmart' ),
					'group'      => esc_html__( 'Content', 'woodmart' ),
					'param_name' => 'content',
					'hint'       => esc_html__( 'Add here few words to your banner image.', 'woodmart' ),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Text size', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'content_text_size',
					'value'            => array(
						esc_html__( 'Default (14px)', 'woodmart' ) => 'default',
						esc_html__( 'Medium (16px)', 'woodmart' ) => 'medium',
						esc_html__( 'Large (18px)', 'woodmart' ) => 'large',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'custom_text_color',
					'css_args'         => array(
						'color' => array(
							' .banner-inner',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_responsive_size',
					'heading'          => esc_html__( 'Size', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'custom_text_size',
					'css_args'         => array(
						'font-size' => array(
							' .banner-inner',
						),
					),
					'dependency'       => array(
						'element' => 'content_text_size',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_responsive_size',
					'heading'          => esc_html__( 'Line height', 'woodmart' ),
					'group'            => esc_html__( 'Content', 'woodmart' ),
					'param_name'       => 'custom_text_line_height',
					'css_args'         => array(
						'line-height' => array(
							' .banner-inner',
						),
					),
					'dependency'       => array(
						'element' => 'content_text_size',
						'value'   => array( 'custom' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Countdown.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Date', 'woodmart' ),
					'group'      => esc_html__( 'Countdown', 'woodmart' ),
					'param_name' => 'countdown_date_divider',
				),
				array(
					'type'             => 'woodmart_datepicker',
					'heading'          => esc_html__( 'Date', 'woodmart' ),
					'group'            => esc_html__( 'Countdown', 'woodmart' ),
					'param_name'       => 'date',
					'hint'             => esc_html__( 'Final date in the format Y/m/d. For example 2020/12/12 13:00', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Hide countdown on finish', 'woodmart' ),
					'group'            => esc_html__( 'Countdown', 'woodmart' ),
					'param_name'       => 'hide_countdown_on_finish',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Style', 'woodmart' ),
					'group'      => esc_html__( 'Countdown', 'woodmart' ),
					'param_name' => 'countdown_style_divider',
				),
				array(
					'type'       => 'woodmart_dropdown',
					'heading'    => esc_html__( 'Style', 'woodmart' ),
					'group'      => esc_html__( 'Countdown', 'woodmart' ),
					'param_name' => 'countdown_style',
					'value'      => array(
						esc_html__( 'Default', 'woodmart' ) => 'simple',
						esc_html__( 'Shadow', 'woodmart' ) => 'standard',
						esc_html__( 'Transparent', 'woodmart' ) => 'transparent',
						esc_html__( 'Primary color', 'woodmart' ) => 'active',
					),
					'style'      => array(
						'active' => woodmart_get_color_value( 'primary-color', '#7eb934' ),
					),
				),
				array(
					'type'       => 'woodmart_button_set',
					'heading'    => esc_html__( 'Color Scheme', 'woodmart' ),
					'group'      => esc_html__( 'Countdown', 'woodmart' ),
					'param_name' => 'countdown_color_scheme',
					'value'      => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Dark', 'woodmart' ) => 'dark',
					),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Size', 'woodmart' ),
					'group'      => esc_html__( 'Countdown', 'woodmart' ),
					'param_name' => 'countdown_size',
					'value'      => array(
						esc_html__( 'Medium (24px)', 'woodmart' ) => 'medium',
						esc_html__( 'Small (20px)', 'woodmart' ) => 'small',
						esc_html__( 'Large (28px)', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large (42px)', 'woodmart' ) => 'xlarge',
					),
				),
				/**
				* Button
				*/
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Button', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'button_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Button text', 'woodmart' ),
					'param_name'       => 'btn_text',
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Button position', 'woodmart' ),
					'param_name'       => 'btn_position',
					'value'            => array(
						esc_html__( 'Show on hover', 'woodmart' ) => 'hover',
						esc_html__( 'Static', 'woodmart' ) => 'static',
					),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'dependency'       => array(
						'element'            => 'style',
						'value_not_equal_to' => array( 'content-background' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Button style', 'woodmart' ),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'param_name'       => 'btn_style',
					'value'            => array(
						esc_html__( 'Flat', 'woodmart' ) => 'default',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						esc_html__( 'Link button', 'woodmart' ) => 'link',
						esc_html__( '3D', 'woodmart' ) => '3d',
					),
					'images_value'     => array(
						'default'  => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/default.png',
						'bordered' => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/bordered.png',
						'link'     => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/link.png',
						'3d'       => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/3d.png',
					),
					'title'            => false,
					'std'              => 'default',
					'edit_field_class' => 'vc_col-xs-12 vc_column button-style',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Button shape', 'woodmart' ),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'param_name'       => 'btn_shape',
					'value'            => array(
						esc_html__( 'Rectangle', 'woodmart' ) => 'rectangle',
						esc_html__( 'Circle', 'woodmart' ) => 'round',
						esc_html__( 'Round', 'woodmart' )  => 'semi-round',
					),
					'images_value'     => array(
						'rectangle'  => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/rectangle.jpeg',
						'round'      => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/circle.jpeg',
						'semi-round' => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/round.jpeg',
					),
					'dependency'       => array(
						'element'            => 'btn_style',
						'value_not_equal_to' => array( 'round', 'link' ),
					),
					'title'            => false,
					'std'              => 'rectangle',
					'edit_field_class' => 'vc_col-xs-12 vc_column button-shape',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Button size', 'woodmart' ),
					'param_name'       => 'btn_size',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Extra Small', 'woodmart' ) => 'extra-small',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
					),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_dropdown',
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'heading'          => esc_html__( 'Predefined button color', 'woodmart' ),
					'param_name'       => 'btn_color',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Primary color', 'woodmart' ) => 'primary',
						esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
						esc_html__( 'White', 'woodmart' ) => 'white',
						esc_html__( 'Black', 'woodmart' ) => 'black',
					),
					'style'            => array(
						'default' => '#f3f3f3',
						'primary' => woodmart_get_color_value( 'primary-color', '#7eb934' ),
						'alt'     => woodmart_get_color_value( 'secondary-color', '#fbbc34' ),
						'black'   => '#212121',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'          => esc_html__( 'Idle background color', 'woodmart' ),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'btn_bg_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-button-wrapper a' => array(
							'background-color: {{VALUE}};',
							'border-color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Idle text color scheme', 'woodmart' ),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'param_name'       => 'btn_color_scheme',
					'value'            => array(
						esc_html__( 'Light', 'woodmart' )  => 'light',
						esc_html__( 'Dark', 'woodmart' )   => 'dark',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'    => esc_html__( 'Custom text color', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'type'       => 'wd_colorpicker',
					'param_name' => 'btn_custom_color_scheme',
					'selectors'  => array(
						'{{WRAPPER}} .wd-button-wrapper a' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency' => array(
						'element' => 'btn_color_scheme',
						'value'   => 'custom',
					),
				),

				array(
					'heading'          => esc_html__( 'Background color on hover', 'woodmart' ),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'btn_bg_color_hover',
					'selectors'        => array(
						'{{WRAPPER}} .wd-button-wrapper a:hover' => array(
							'background-color: {{VALUE}};',
							'border-color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Text color scheme on hover', 'woodmart' ),
					'param_name'       => 'btn_color_scheme_hover',
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Light', 'woodmart' )  => 'light',
						esc_html__( 'Dark', 'woodmart' )   => 'dark',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'    => esc_html__( 'Custom text color on hover', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'type'       => 'wd_colorpicker',
					'param_name' => 'btn_custom_color_scheme_hover',
					'selectors'  => array(
						'{{WRAPPER}} .wd-button-wrapper a:hover' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency' => array(
						'element' => 'btn_color_scheme_hover',
						'value'   => 'custom',
					),
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Hide button on tablet', 'woodmart' ),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'param_name'       => 'hide_btn_tablet',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Hide button on mobile', 'woodmart' ),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'param_name'       => 'hide_btn_mobile',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Button icon
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'btn_icon_divider',
				),
				array(
					'type'       => 'woodmart_button_set',
					'heading'    => esc_html__( 'Type', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'btn_icon_type',
					'value'      => array(
						esc_html__( 'Icon', 'woodmart' )  => 'icon',
						esc_html__( 'Image', 'woodmart' ) => 'image',
					),
					'default'    => 'icon',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'param_name'       => 'btn_image',
					'value'            => '',
					'dependency'       => array(
						'element' => 'btn_icon_type',
						'value'   => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'param_name'       => 'btn_img_size',
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'btn_icon_type',
						'value'   => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Icon library', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'value'      => array(
						esc_html__( 'Font Awesome', 'woodmart' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'woodmart' ) => 'openiconic',
						esc_html__( 'Typicons', 'woodmart' ) => 'typicons',
						esc_html__( 'Entypo', 'woodmart' ) => 'entypo',
						esc_html__( 'Linecons', 'woodmart' ) => 'linecons',
						esc_html__( 'Mono Social', 'woodmart' ) => 'monosocial',
						esc_html__( 'Material', 'woodmart' ) => 'material',
					),
					'param_name' => 'icon_library',
					'hint'       => esc_html__( 'Select icon library.', 'woodmart' ),
					'dependency' => array(
						'element' => 'btn_icon_type',
						'value'   => 'icon',
					),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'icon_fontawesome',
					'value'      => '',
					'settings'   => array(
						'emptyIcon'    => true,
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'fontawesome' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'icon_openiconic',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'openiconic',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'openiconic' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'icon_typicons',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'typicons',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'typicons' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'icon_entypo',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'entypo',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'entypo' ),
					),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'icon_linecons',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'linecons',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'linecons' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'icon_monosocial',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'monosocial',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'monosocial' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'icon_material',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'material',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'material' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Button icon position', 'woodmart' ),
					'group'            => esc_html__( 'Button', 'woodmart' ),
					'param_name'       => 'btn_icon_position',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )  => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
					'std'              => 'right',
					'edit_field_class' => 'vc_col-xs-12 vc_column button-style',
				),
				/**
				* Layouts
				*/
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Layouts', 'woodmart' ),
					'group'      => esc_html__( 'Layouts', 'woodmart' ),
					'param_name' => 'positioning_divider',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Content horizontal alignment', 'woodmart' ),
					'group'            => esc_html__( 'Layouts', 'woodmart' ),
					'param_name'       => 'horizontal_alignment',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )   => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' )  => 'right',
					),
					'images_value'     => array(
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/left.png',
						'center' => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/center.png',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/right.png',
					),
					'std'              => 'left',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column content-position',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Content vertical alignment', 'woodmart' ),
					'param_name'       => 'vertical_alignment',
					'group'            => esc_html__( 'Layouts', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Top', 'woodmart' )    => 'top',
						esc_html__( 'Middle', 'woodmart' ) => 'middle',
						esc_html__( 'Bottom', 'woodmart' ) => 'bottom',
					),
					'images_value'     => array(
						'top'    => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/top.png',
						'middle' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/middle.png',
						'bottom' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/bottom.png',
					),
					'std'              => 'top',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column content-position',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Text alignment', 'woodmart' ),
					'group'            => esc_html__( 'Layouts', 'woodmart' ),
					'param_name'       => 'text_alignment',
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
					'std'              => 'left',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Content width', 'woodmart' ),
					'group'            => esc_html__( 'Layouts', 'woodmart' ),
					'param_name'       => 'content_width',
					'value'            => array(
						'100%'                             => '100',
						'90%'                              => '90',
						'80%'                              => '80',
						'70%'                              => '70',
						'60%'                              => '60',
						'50%'                              => '50',
						'40%'                              => '40',
						'30%'                              => '30',
						'20%'                              => '20',
						'10%'                              => '10',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Custom content width', 'woodmart' ),
					'group'            => esc_html__( 'Layouts', 'woodmart' ),
					'param_name'       => 'custom_content_width',
					'tabs'             => true,
					'value'            => array(
						esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
						esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
						esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
					),
					'default'          => 'desktop',
					'edit_field_class' => 'wd-res-control vc_col-sm-12 vc_column wd-custom-width',
					'dependency'       => array(
						'element' => 'content_width',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'             => 'woodmart_slider',
					'group'            => esc_html__( 'Layouts', 'woodmart' ),
					'param_name'       => 'content_desktop_width',
					'min'              => '0',
					'max'              => '1000',
					'step'             => '1',
					'default'          => '600',
					'units'            => 'px',
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
					'css_args'         => array(
						'--wd-max-width' => array(
							'',
						),
					),
					'css_params'       => array(
						'device' => 'desktop',
					),
					'wd_dependency'    => array(
						'element' => 'custom_content_width',
						'value'   => array( 'desktop' ),
					),
					'dependency'       => array(
						'element' => 'content_width',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'             => 'woodmart_slider',
					'group'            => esc_html__( 'Layouts', 'woodmart' ),
					'param_name'       => 'content_tablet_width',
					'min'              => '0',
					'max'              => '1000',
					'step'             => '1',
					'default'          => '0',
					'units'            => 'px',
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
					'css_args'         => array(
						'--wd-max-width' => array(
							'',
						),
					),
					'css_params'       => array(
						'device' => 'tablet',
					),
					'wd_dependency'    => array(
						'element' => 'custom_content_width',
						'value'   => array( 'tablet' ),
					),
					'dependency'       => array(
						'element' => 'content_width',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'             => 'woodmart_slider',
					'group'            => esc_html__( 'Layouts', 'woodmart' ),
					'param_name'       => 'content_mobile_width',
					'min'              => '0',
					'max'              => '1000',
					'step'             => '1',
					'default'          => '0',
					'units'            => 'px',
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
					'css_args'         => array(
						'--wd-max-width' => array(
							'',
						),
					),
					'css_params'       => array(
						'device' => 'mobile',
					),
					'wd_dependency'    => array(
						'element' => 'custom_content_width',
						'value'   => array( 'mobile' ),
					),
					'dependency'       => array(
						'element' => 'content_width',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'             => 'wd_slider',
					'param_name'       => 'content_height',
					'heading'          => esc_html__( 'Content height', 'woodmart' ),
					'group'            => esc_html__( 'Layouts', 'woodmart' ),
					'devices'          => array(
						'desktop' => array(
							'unit'  => '%',
							'value' => '',
						),
						'tablet'  => array(
							'unit'  => '%',
							'value' => '',
						),
						'mobile'  => array(
							'unit'  => '%',
							'value' => '',
						),
					),
					'range'            => array(
						'%'  => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
						'px' => array(
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						),
					),
					'selectors'        => array(
						'{{WRAPPER}} .promo-banner:not(.banner-content-background) .content-banner, {{WRAPPER}} .promo-banner.banner-content-background .wrapper-content-banner' => array(
							'min-height: {{VALUE}}{{UNIT}};',
						),
					),
					'dependency'       => array(
						'element' => 'style',
						'value'   => array( 'content-background' ),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Increase spaces', 'woodmart' ),
					'group'            => esc_html__( 'Layouts', 'woodmart' ),
					'param_name'       => 'increase_spaces',
					'hint'             => esc_html__( 'Suggest to use this option if you have large banners. Padding will be set in percentage to your screen width.', 'woodmart' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ? woodmart_get_vc_responsive_spacing_map() : '',
				/**
				* Deprecated
				*/
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title desktop text size ( > 1024px )', 'woodmart' ),
					'param_name' => 'title_desktop_text_size',
					'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
					'group'      => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'title_size',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title tablet text size ( < 1024px )', 'woodmart' ),
					'param_name' => 'title_tablet_text_size',
					'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
					'group'      => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'title_size',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title mobile text size ( < 767px )', 'woodmart' ),
					'param_name' => 'title_mobile_text_size',
					'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
					'group'      => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'title_size',
						'value'   => array( 'custom' ),
					),
				),
				// Subtitle custom size
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Subtitle desktop text size ( > 1024px )', 'woodmart' ),
					'param_name' => 'subtitle_desktop_text_size',
					'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
					'group'      => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'title_size',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Subtitle tablet text size ( < 1024px )', 'woodmart' ),
					'param_name' => 'subtitle_tablet_text_size',
					'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
					'group'      => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'title_size',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Subtitle mobile text size ( < 767px )', 'woodmart' ),
					'param_name' => 'subtitle_mobile_text_size',
					'hint'       => esc_html__( 'Only number without px.', 'woodmart' ),
					'group'      => esc_html__( 'Custom size', 'woodmart' ),
					'dependency' => array(
						'element' => 'title_size',
						'value'   => array( 'custom' ),
					),
				),
				/**
				 * Advanced.
				 */
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Highlight text style', 'woodmart' ),
					'hint'             => esc_html__( 'The text must be wrapped with the <u></u> tag to highlight it.', 'woodmart' ),
					'group'            => esc_html__( 'Advanced', 'woodmart' ),
					'param_name'       => 'title_decoration_style',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' )  => 'default',
						esc_html__( 'Primary color', 'woodmart' )  => 'colored',
						esc_html__( 'Primary color + secondary font', 'woodmart' ) => 'colored-alt',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
					),
					'std'              => 'colored',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				function_exists( 'woodmart_get_vc_responsive_visible_map' ) ? woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ) : '',
				function_exists( 'woodmart_get_vc_responsive_visible_map' ) ? woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ) : '',
				function_exists( 'woodmart_get_vc_responsive_visible_map' ) ? woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ) : '',
				function_exists( 'woodmart_get_vc_responsive_visible_map' ) ? woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ) : '',
			)
		);
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_banners_carousel extends WPBakeryShortCodesContainer {}
}
