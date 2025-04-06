<?php

use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_shape_divider_css' ) ) {
	function wd_get_block_shape_divider_css( $selector, $attributes, $attr_prefix, $position = 'top' ) {
		$svg_wrapper_selector = $selector . ' .wd-pos-' . $position;
		$svg_selector         = $svg_wrapper_selector . ' svg';
		$block_css            = new Block_CSS( $attributes );

		$block_css->add_css_rules(
			$svg_selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'ColorCode',
					'template'  => 'color: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'ColorVariable',
					'template'  => 'color: var({{value}});',
				),
				array(
					'attr_name' => $attr_prefix . 'Width',
					'template'  => 'width: calc({{value}}% + 2px);',
				),
				array(
					'attr_name' => $attr_prefix . 'Height',
					'template'  => 'height: {{value}}px;',
				),
			)
		);
		$block_css->add_css_rules(
			$svg_selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'WidthTablet',
					'template'  => 'width: calc({{value}}% + 2px);',
				),
				array(
					'attr_name' => $attr_prefix . 'HeightTablet',
					'template'  => 'height: {{value}}px;',
				),
			),
			'tablet'
		);
		$block_css->add_css_rules(
			$svg_selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'WidthMobile',
					'template'  => 'width: calc({{value}}% + 2px);',
				),
				array(
					'attr_name' => $attr_prefix . 'HeightMobile',
					'template'  => 'height: {{value}}px;',
				),
			),
			'mobile'
		);
		return $block_css->get_css();
	}
}
