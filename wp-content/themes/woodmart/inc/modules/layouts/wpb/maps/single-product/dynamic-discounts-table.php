<?php
/**
 * Product price table map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_single_product_dynamic_discounts_table' ) ) {
	/**
	 * Content map.
	 */
	function woodmart_get_vc_map_single_product_dynamic_discounts_table() {
		$quantity_typography = woodmart_get_typography_map(
			array(
				'key'           => 'quantity_typography',
				'title'         => esc_html__( 'Typography', 'woodmart' ),
				'group'         => esc_html__( 'Style', 'woodmart' ),
				'selector'      => '{{WRAPPER}} .wd-dd-quantity span',
				'wd_dependency' => array(
					'element' => 'dd_typography_tabs',
					'value'   => array( 'quantity' ),
				),
			)
		);

		$price_typography = woodmart_get_typography_map(
			array(
				'key'           => 'price_typography',
				'title'         => esc_html__( 'Typography', 'woodmart' ),
				'group'         => esc_html__( 'Style', 'woodmart' ),
				'selector'      => '{{WRAPPER}} .wd-dd-price .amount',
				'wd_dependency' => array(
					'element' => 'dd_typography_tabs',
					'value'   => array( 'price' ),
				),
			)
		);

		$discount_typography = woodmart_get_typography_map(
			array(
				'key'           => 'discount_typography',
				'title'         => esc_html__( 'Typography', 'woodmart' ),
				'group'         => esc_html__( 'Style', 'woodmart' ),
				'selector'      => '{{WRAPPER}} .wd-dd-discount span',
				'wd_dependency' => array(
					'element' => 'dd_typography_tabs',
					'value'   => array( 'discount' ),
				),
			)
		);

		return array(
			'base'        => 'woodmart_single_product_dynamic_discounts_table',
			'name'        => esc_html__( 'Product dynamic discounts table', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
			'description' => esc_html__( 'Shows the current discount relative to the product quantity', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-dynamic-discounts.svg',
			'params'      => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
					'group'      => esc_html__( 'Style', 'woodmart' ),
				),

				array(
					'title'      => esc_html__( 'Table', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'dd_typography_title',
					'group'      => esc_html__( 'Style', 'woodmart' ),
				),

				array(
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'woodmart_button_set',
					'param_name'       => 'dd_typography_tabs',
					'tabs'             => true,
					'value'            => array(
						esc_html__( 'Quantity', 'woodmart' ) => 'quantity',
						esc_html__( 'Price', 'woodmart' ) => 'price',
						esc_html__( 'Discount', 'woodmart' ) => 'discount',
					),
					'default'          => 'quantity',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),

				// Quantity typography.
				$quantity_typography['font_family'],
				$quantity_typography['font_size'],
				$quantity_typography['font_weight'],
				$quantity_typography['text_transform'],
				$quantity_typography['font_style'],
				$quantity_typography['line_height'],

				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'quantity_color',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wd-dd-quantity span' => array(
							'color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'dd_typography_tabs',
						'value'   => array( 'quantity' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				// Price typography.
				$price_typography['font_family'],
				$price_typography['font_size'],
				$price_typography['font_weight'],
				$price_typography['text_transform'],
				$price_typography['font_style'],
				$price_typography['line_height'],

				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'price_color',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wd-dd-price .amount' => array(
							'color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'dd_typography_tabs',
						'value'   => array( 'price' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				// Discount typography.
				$discount_typography['font_family'],
				$discount_typography['font_size'],
				$discount_typography['font_weight'],
				$discount_typography['text_transform'],
				$discount_typography['font_style'],
				$discount_typography['line_height'],

				array(
					'heading'          => esc_html__( 'Color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'discount_color',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}} .wd-dd-discount span' => array(
							'color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'dd_typography_tabs',
						'value'   => array( 'discount' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				// Design options.
				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
				),
				woodmart_get_vc_responsive_spacing_map(),
			),
		);
	}
}
