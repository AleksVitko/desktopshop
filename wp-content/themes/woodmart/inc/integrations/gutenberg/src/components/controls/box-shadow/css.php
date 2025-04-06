<?php
/**
 * Gutenberg box shadow CSS.
 *
 * @package Woodmart
 */

use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_box_shadow_css' ) ) {
	/**
	 * Get box shadow CSS.
	 *
	 * @param string $selector CSS selector.
	 * @param array  $attributes CSS attributes.
	 * @param string $attr_prefix Attribute prefix.
	 * @param string $rule CSS rule.
	 * @return array
	 */
	function wd_get_block_box_shadow_css( $selector, $attributes, $attr_prefix, $rule = 'box-shadow' ) {
		$block_css = new Block_CSS( $attributes );

		$border_position = ! empty( $attributes[ $attr_prefix . 'Position' ] ) && 'outline' !== $attributes[ $attr_prefix . 'Position' ] ? ' ' . $attributes[ $attr_prefix . 'Position' ] : '';

		$horizontal = ! empty( $attributes[ $attr_prefix . 'Horizontal' ] ) ? $attributes[ $attr_prefix . 'Horizontal' ] : 0;
		$vertical   = ! empty( $attributes[ $attr_prefix . 'Vertical' ] ) ? $attributes[ $attr_prefix . 'Vertical' ] : 0;
		$blur       = isset( $attributes[ $attr_prefix . 'Blur' ] ) && '' !== $attributes[ $attr_prefix . 'Blur' ] ? $attributes[ $attr_prefix . 'Blur' ] : 10;
		$spread     = ! empty( $attributes[ $attr_prefix . 'Spread' ] ) ? $attributes[ $attr_prefix . 'Spread' ] : 0;

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'ColorCode',
					'template'  => $rule . ': ' . $horizontal . 'px ' . $vertical . 'px ' . $blur . 'px ' . $spread . 'px {{value}}' . $border_position . ';',
				),
				array(
					'attr_name' => $attr_prefix . 'ColorVariable',
					'template'  => $rule . ': ' . $horizontal . 'px ' . $vertical . 'px ' . $blur . 'px ' . $spread . 'px var({{value}})' . $border_position . ';',
				),
			)
		);

		if ( ! empty( $attributes[ $attr_prefix . 'HorizontalTablet' ] ) || ! empty( $attributes[ $attr_prefix . 'VerticalTablet' ] ) || ! empty( $attributes[ $attr_prefix . 'BlurTablet' ] ) || ! empty( $attributes[ $attr_prefix . 'SpreadTablet' ] ) ) {
			$horizontal = ! empty( $attributes[ $attr_prefix . 'HorizontalTablet' ] ) ? $attributes[ $attr_prefix . 'HorizontalTablet' ] : 0;
			$vertical   = ! empty( $attributes[ $attr_prefix . 'VerticalTablet' ] ) ? $attributes[ $attr_prefix . 'VerticalTablet' ] : 0;
			$blur       = ! empty( $attributes[ $attr_prefix . 'BlurTablet' ] ) ? $attributes[ $attr_prefix . 'BlurTablet' ] : 10;
			$spread     = ! empty( $attributes[ $attr_prefix . 'SpreadTablet' ] ) ? $attributes[ $attr_prefix . 'SpreadTablet' ] : 0;

			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'ColorCode',
						'template'  => $rule . ': ' . $horizontal . 'px ' . $vertical . 'px ' . $blur . 'px ' . $spread . 'px {{value}} ' . $border_position . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'ColorVariable',
						'template'  => $rule . ': ' . $horizontal . 'px ' . $vertical . 'px ' . $blur . 'px ' . $spread . 'px var({{value}}) ' . $border_position . ';',
					),
				),
				'tablet'
			);
		}

		if ( ! empty( $attributes[ $attr_prefix . 'HorizontalMobile' ] ) || ! empty( $attributes[ $attr_prefix . 'VerticalMobile' ] ) || ! empty( $attributes[ $attr_prefix . 'BlurMobile' ] ) || ! empty( $attributes[ $attr_prefix . 'SpreadMobile' ] ) ) {
			$horizontal = ! empty( $attributes[ $attr_prefix . 'HorizontalMobile' ] ) ? $attributes[ $attr_prefix . 'HorizontalMobile' ] : 0;
			$vertical   = ! empty( $attributes[ $attr_prefix . 'VerticalMobile' ] ) ? $attributes[ $attr_prefix . 'VerticalMobile' ] : 0;
			$blur       = ! empty( $attributes[ $attr_prefix . 'BlurMobile' ] ) ? $attributes[ $attr_prefix . 'BlurMobile' ] : 10;
			$spread     = ! empty( $attributes[ $attr_prefix . 'SpreadMobile' ] ) ? $attributes[ $attr_prefix . 'SpreadMobile' ] : 0;

			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'ColorCode',
						'template'  => $rule . ': ' . $horizontal . 'px ' . $vertical . 'px ' . $blur . 'px ' . $spread . 'px {{value}} ' . $border_position . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'ColorVariable',
						'template'  => $rule . ': ' . $horizontal . 'px ' . $vertical . 'px ' . $blur . 'px ' . $spread . 'px var({{value}}) ' . $border_position . ';',
					),
				),
				'mobile'
			);
		}

		return $block_css->get_css();
	}
}