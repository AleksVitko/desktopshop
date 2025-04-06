<?php

use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_position_css' ) ) {
	function wd_get_block_position_css( $selector, $attributes, $attr_prefix ) {
		$block_css = new Block_CSS( $attributes );

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'Type',
					'template'  => 'position: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'ZIndex',
					'template'  => 'z-index: {{value}};',
				),
			)
		);

		if ( ! empty( $attributes[ $attr_prefix . 'Type' ] ) ) {
			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'Top',
						'template'  => 'top: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix ) . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'Right',
						'template'  => 'right: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix ) . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'Bottom',
						'template'  => 'bottom: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix ) . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'Left',
						'template'  => 'left: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix ) . ';',
					),
				)
			);
		}

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'TypeTablet',
					'template'  => 'position: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'ZIndexTablet',
					'template'  => 'z-index: {{value}};',
				),
			),
			'tablet'
		);

		if ( ! empty( $attributes[ $attr_prefix . 'Type' ] ) || ! empty( $attributes[ $attr_prefix . 'TypeTablet' ] ) ) {
			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'TopTablet',
						'template'  => 'top: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, 'tablet' ) . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'RightTablet',
						'template'  => 'right: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, 'tablet' ) . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'BottomTablet',
						'template'  => 'bottom: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, 'tablet' ) . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'LeftTablet',
						'template'  => 'left: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, 'tablet' ) . ';',
					),
				),
				'tablet'
			);
		}

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'TypeMobile',
					'template'  => 'position: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'ZIndexMobile',
					'template'  => 'z-index: {{value}};',
				),
			),
			'mobile'
		);

		if ( ! empty( $attributes[ $attr_prefix . 'Type' ] ) || ! empty( $attributes[ $attr_prefix . 'TypeTablet' ] ) || ! empty( $attributes[ $attr_prefix . 'TypeMobile' ] ) ) {
			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'TopMobile',
						'template'  => 'top: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, 'mobile' ) . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'RightMobile',
						'template'  => 'right: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, 'mobile' ) . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'BottomMobile',
						'template'  => 'bottom: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, 'mobile' ) . ';',
					),
					array(
						'attr_name' => $attr_prefix . 'LeftMobile',
						'template'  => 'left: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, 'mobile' ) . ';',
					),
				),
				'mobile'
			);
		}

		return $block_css->get_css();
	}
}
