<?php

use XTS\Gutenberg\Google_Fonts;
use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_typography_css' ) ) {
	function wd_get_block_typography_css( $selector, $attributes, $attr_prefix ) {
		$block_css = new Block_CSS( $attributes );

		if ( ! empty( $attributes[ $attr_prefix . 'FontFamily' ] ) && ! empty( $attributes[ $attr_prefix . 'Google' ] ) ) {
			Google_Fonts::get_instance()->add_google_font(
				array(
					'font-family' => $attributes[ $attr_prefix . 'FontFamily' ],
					'font-weight' => ! empty( $attributes[ $attr_prefix . 'FontWeight' ] ) ? $attributes[ $attr_prefix . 'FontWeight' ] : '',
					'font-style'  => ! empty( $attributes[ $attr_prefix . 'FontStyle' ] ) ? $attributes[ $attr_prefix . 'FontStyle' ] : '',
					'font-subset' => ! empty( $attributes[ $attr_prefix . 'FontSubset' ] ) ? $attributes[ $attr_prefix . 'FontSubset' ] : '',
				)
			);
		}

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'FontFamily',
					'template'  => 'font-family: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'FontWeight',
					'template'  => 'font-weight: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'FontStyle',
					'template'  => 'font-style: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'FontSize',
					'template'  => 'font-size: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'FontSize' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'LineHeight',
					'template'  => 'line-height: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'LineHeight' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'LetterSpacing',
					'template'  => 'letter-spacing: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'LetterSpacing' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'WordSpacing',
					'template'  => 'word-spacing: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'WordSpacing' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'TextTransform',
					'template'  => 'text-transform: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'TextDecoration',
					'template'  => 'text-decoration: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'TextDecorationStyle',
					'template'  => 'text-decoration-style: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'TextDecorationColorCode',
					'template'  => 'text-decoration-color: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'TextDecorationColorVariable',
					'template'  => 'text-decoration-color: var({{value}});',
				),
				array(
					'attr_name' => $attr_prefix . 'TextDecorationThickness',
					'template'  => 'text-decoration-thickness: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'TextDecorationThickness' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'TextUnderlineOffset',
					'template'  => 'text-underline-offset: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'TextUnderlineOffset' ) . ';',
				),
			)
		);

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'FontSizeTablet',
					'template'  => 'font-size: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'FontSize', 'tablet' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'LineHeightTablet',
					'template'  => 'line-height: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'LineHeight', 'tablet' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'LetterSpacingTablet',
					'template'  => 'letter-spacing: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'LetterSpacing', 'tablet' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'WordSpacingTablet',
					'template'  => 'word-spacing: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'WordSpacing', 'tablet' ) . ';',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'FontSizeMobile',
					'template'  => 'font-size: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'FontSize', 'mobile' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'LineHeightMobile',
					'template'  => 'line-height: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'LineHeight', 'mobile' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'LetterSpacingMobile',
					'template'  => 'letter-spacing: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'LetterSpacing', 'mobile' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'WordSpacingMobile',
					'template'  => 'word-spacing: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'WordSpacing', 'mobile' ) . ';',
				),
			),
			'mobile'
		);

		return $block_css->get_css();
	}
}
