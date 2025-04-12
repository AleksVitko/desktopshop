<?php
/**
 * Contact form 7 map.
 *
 * @package Elements
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_contact_forms' ) ) {
	/**
	 * Get contact forms.
	 *
	 * @access public
	 *
	 * @return array Contact forms.
	 */
	function woodmart_get_contact_forms() {
		$contact_forms = array();
		$forms         = get_posts(
			array(
				'post_type'   => 'wpcf7_contact_form',
				'numberposts' => -1,
			)
		);

		if ( $forms ) {
			foreach ( $forms as $form ) {
				$contact_forms[ $form->post_title ] = $form->ID;
			}
		}

		return $contact_forms;
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_contact_form_7' ) ) {
	/**
	 * Displays the shortcode settings fields in the admin.
	 */
	function woodmart_get_vc_map_contact_form_7() {
		$contact_forms = woodmart_get_contact_forms();

		return array(
			'base'        => 'woodmart_contact_form_7',
			'name'        => esc_html__( 'Contact form 7', 'woodmart' ),
			'description' => esc_html__( 'Place Contact Form 7', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/contact-form7.svg',
			'params'      => array(
				array(
					'param_name' => 'woodmart_css_id',
					'type'       => 'woodmart_css_id',
				),

				/**
				 * General.
				 */
				array(
					'heading'          => esc_html__( 'Select contact form', 'woodmart' ),
					'type'             => 'dropdown',
					'param_name'       => 'form_id',
					'value'            => $contact_forms,
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),

				/**
				 * Style.
				 */
				array(
					'param_name' => 'form_divider',
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'Form', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'holder'     => 'div',
				),

				array(
					'heading'          => esc_html__( 'Text color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_color',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wpcf7-form' => array(
							'--wd-form-color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Placeholder color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_placeholder_color',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wpcf7-form' => array(
							'--wd-form-placeholder-color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Border color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_brd_color',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wpcf7-form' => array(
							'--wd-form-brd-color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Border color focus', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_brd_color_focus',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wpcf7-form' => array(
							'--wd-form-brd-color-focus: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Background color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'form_bg',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wpcf7-form' => array(
							'--wd-form-bg: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'param_name' => 'button_divider',
					'type'       => 'woodmart_title_divider',
					'title'      => esc_html__( 'Button', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'holder'     => 'div',
				),

				array(
					'type'             => 'woodmart_button_set',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'button_color_tabs',
					'value'            => array(
						esc_html__( 'Idle', 'woodmart' )  => 'idle',
						esc_html__( 'Hover', 'woodmart' ) => 'hover',
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'button_text_color',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wpcf7-submit' => array(
							'--btn-accented-color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'button_color_tabs',
						'value'   => array( 'idle' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'button_text_color_hover',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wpcf7-submit' => array(
							'--btn-accented-color-hover: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'button_color_tabs',
						'value'   => array( 'hover' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Background color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'button_bg_color',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wpcf7-submit' => array(
							'--btn-accented-bgcolor: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'button_color_tabs',
						'value'   => array( 'idle' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Background color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'button_bg_color_hover',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wpcf7-submit' => array(
							'--btn-accented-bgcolor-hover: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'button_color_tabs',
						'value'   => array( 'hover' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
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
				function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ? woodmart_get_vc_responsive_spacing_map() : '',

				/**
				 * Advanced.
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
