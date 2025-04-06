<?php

use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_transform_css' ) ) {
	function wd_get_block_transform_css( $selector, $attributes, $attr_prefix ) {
		$block_css = new Block_CSS( $attributes );

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'Perspective',
					'template'  => '--wd-transform-perspective: {{value}}px;',
				),
				array(
					'attr_name' => $attr_prefix . 'RotateX',
					'template'  => '--wd-transform-rotateX: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'RotateY',
					'template'  => '--wd-transform-rotateY: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'RotateZ',
					'template'  => '--wd-transform-rotateZ: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'TranslateX',
					'template'  => '--wd-transform-translateX: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'TranslateX' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'TranslateY',
					'template'  => '--wd-transform-translateY: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'TranslateY' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'ScaleX',
					'template'  => '--wd-transform-scaleX: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'ScaleY',
					'template'  => '--wd-transform-scaleY: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'SkewX',
					'template'  => '--wd-transform-skewX: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'SkewY',
					'template'  => '--wd-transform-skewY: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'OriginX',
					'template'  => '--wd-transform-origin-x: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'OriginY',
					'template'  => '--wd-transform-origin-y: {{value}};',
				),
			)
		);

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'PerspectiveTablet',
					'template'  => '--wd-transform-perspective: {{value}}px;',
				),
				array(
					'attr_name' => $attr_prefix . 'RotateXTablet',
					'template'  => '--wd-transform-rotateX: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'RotateYTablet',
					'template'  => '--wd-transform-rotateY: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'RotateYTablet',
					'template'  => '--wd-transform-rotateZ: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'TranslateXTablet',
					'template'  => '--wd-transform-translateX: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'TranslateX', 'tablet' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'TranslateYTablet',
					'template'  => '--wd-transform-translateY: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'TranslateY', 'tablet' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'ScaleXTablet',
					'template'  => '--wd-transform-scaleX: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'ScaleYTablet',
					'template'  => '--wd-transform-scaleY: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'SkewXTablet',
					'template'  => '--wd-transform-skewX: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'SkewYTablet',
					'template'  => '--wd-transform-skewY: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'OriginXTablet',
					'template'  => '--wd-transform-origin-x: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'OriginYTablet',
					'template'  => '--wd-transform-origin-y: {{value}};',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'PerspectiveMobile',
					'template'  => '--wd-transform-perspective: {{value}}px;',
				),
				array(
					'attr_name' => $attr_prefix . 'RotateXMobile',
					'template'  => '--wd-transform-rotateX: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'RotateYMobile',
					'template'  => '--wd-transform-rotateY: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'RotateYMobile',
					'template'  => '--wd-transform-rotateZ: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'TranslateXMobile',
					'template'  => '--wd-transform-translateX: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'TranslateX', 'mobile' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'TranslateYMobile',
					'template'  => '--wd-transform-translateY: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'TranslateY', 'mobile' ) . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'ScaleXMobile',
					'template'  => '--wd-transform-scaleX: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'ScaleYMobile',
					'template'  => '--wd-transform-scaleY: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'SkewXMobile',
					'template'  => '--wd-transform-skewX: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'SkewYMobile',
					'template'  => '--wd-transform-skewY: {{value}}deg;',
				),
				array(
					'attr_name' => $attr_prefix . 'OriginXMobile',
					'template'  => '--wd-transform-origin-x: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'OriginYMobile',
					'template'  => '--wd-transform-origin-y: {{value}};',
				),
			),
			'mobile'
		);

		if ( ! isset( $attributes[ $attr_prefix . 'ProportionalScale' ] ) || $attributes[ $attr_prefix . 'ProportionalScale' ] ) {
			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'ScaleX',
						'template'  => '--wd-transform-scaleY: {{value}};',
					),
				)
			);

			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'ScaleXTablet',
						'template'  => '--wd-transform-scaleY: {{value}};',
					),
				),
				'tablet'
			);

			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'ScaleXMobile',
						'template'  => '--wd-transform-scaleY: {{value}};',
					),
				),
				'mobile'
			);
		}

		return $block_css->get_css();
	}
}
