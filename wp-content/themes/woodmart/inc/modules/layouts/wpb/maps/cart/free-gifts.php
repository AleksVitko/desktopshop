<?php
/**
 * Manual free gifts table map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_free_gifts' ) ) {
	function woodmart_get_vc_map_free_gifts() {
		$typography = woodmart_get_typography_map(
			array(
				'key'        => 'title_typography',
				'group'      => esc_html__( 'Style', 'woodmart' ),
				'selector'   => '{{WRAPPER}} .wd-el-title',
				'dependency' => array(
					'element' => 'show_title',
					'value'   => 'yes',
				),
			)
		);

		return array(
			'base'        => 'woodmart_cart_free_gifts',
			'name'        => esc_html__( 'Free gifts', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Cart elements', 'woodmart' ), 'cart' ),
			'description' => esc_html__( 'Manual free gifts table', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/ct-icons/ct-free-gifts.svg',
			'params'      => array(
				array(
					'group'       => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Title', 'woodmart' ),
					'param_name' => 'title_divider',
				),

				$typography['font_family'],
				$typography['font_size'],
				$typography['font_weight'],
				$typography['text_transform'],
				$typography['font_style'],
				$typography['line_height'],

				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'title_color',
					'selectors'        => array(
						'{{WRAPPER}} .wd-el-title' => array(
							'color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),

				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
				),
				woodmart_get_vc_responsive_spacing_map(),

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
