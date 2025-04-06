<?php
/**
 * Gutenberg background CSS.
 *
 * @package Woodmart
 */

use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_bg_css' ) ) {
	/**
	 * Get block background CSS.
	 *
	 * @param string $selector CSS selector.
	 * @param array  $attributes Block attributes.
	 * @param string $attr_prefix Attribute prefix.
	 * @return array
	 */
	function wd_get_block_bg_css( $selector, $attributes, $attr_prefix ) {
		$type      = isset( $attributes[ $attr_prefix . 'Type' ] ) ? $attributes[ $attr_prefix . 'Type' ] : 'classic';
		$block_css = new Block_CSS( $attributes );

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => $attr_prefix . 'ColorCode',
					'template'  => 'background-color: {{value}};',
				),
				array(
					'attr_name' => $attr_prefix . 'ColorVariable',
					'template'  => 'background-color: var({{value}});',
				),
			)
		);

		if ( 'classic' === $type ) {
			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'Image,url',
						'template'  => 'background-image: url({{value}});',
					),
					array(
						'attr_name' => $attr_prefix . 'Attachment',
						'template'  => 'background-attachment: {{value}};',
					),
					array(
						'attr_name' => $attr_prefix . 'Repeat',
						'template'  => 'background-repeat: {{value}};',
					),
				)
			);

			if ( isset( $attributes[ $attr_prefix . 'Position' ] ) ) {
				if ( 'custom' !== $attributes[ $attr_prefix . 'Position' ] ) {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'Position',
								'template'  => 'background-position: {{value}};',
							),
						)
					);
				} else {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'CustomPositionX',
								'template'  => 'background-position-x: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'CustomPositionX' ) . ';',
							),
							array(
								'attr_name' => $attr_prefix . 'CustomPositionY',
								'template'  => 'background-position-y: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'CustomPositionY' ) . ';',
							),
						)
					);
				}
			}

			if ( isset( $attributes[ $attr_prefix . 'DisplaySize' ] ) ) {
				if ( 'custom' !== $attributes[ $attr_prefix . 'DisplaySize' ] ) {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'DisplaySize',
								'template'  => 'background-size: {{value}};',
							),
						)
					);
				} else {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'CustomDisplaySize',
								'template'  => 'background-size: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'CustomDisplaySize' ) . ';',
							),
						)
					);
				}
			}

			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'ImageTablet,url',
						'template'  => 'background-image: url({{value}});',
					),
				),
				'tablet'
			);

			if ( isset( $attributes[ $attr_prefix . 'PositionTablet' ] ) ) {
				if ( 'custom' !== $attributes[ $attr_prefix . 'PositionTablet' ] ) {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'PositionTablet',
								'template'  => 'background-position: {{value}};',
							),
						),
						'tablet'
					);
				} else {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'CustomPositionXTablet',
								'template'  => 'background-position-x: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'CustomPositionX', 'tablet' ) . ';',
							),
							array(
								'attr_name' => $attr_prefix . 'CustomPositionYTablet',
								'template'  => 'background-position-y: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'CustomPositionY', 'tablet' ) . ';',
							),
						),
						'tablet'
					);
				}
			}

			if ( isset( $attributes[ $attr_prefix . 'DisplaySizeTablet' ] ) ) {
				if ( 'custom' !== $attributes[ $attr_prefix . 'DisplaySizeTablet' ] ) {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'DisplaySizeTablet',
								'template'  => 'background-size: {{value}};',
							),
						),
						'tablet'
					);
				} else {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'CustomDisplaySizeTablet',
								'template'  => 'background-size: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'CustomDisplaySize', 'tablet' ) . ';',
							),
						),
						'tablet'
					);
				}
			}

			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'ImageMobile,url',
						'template'  => 'background-image: url({{value}});',
					),
				),
				'mobile'
			);

			if ( isset( $attributes[ $attr_prefix . 'PositionMobile' ] ) ) {
				if ( 'custom' !== $attributes[ $attr_prefix . 'PositionMobile' ] ) {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'PositionMobile',
								'template'  => 'background-position: {{value}};',
							),
						),
						'mobile'
					);
				} else {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'CustomPositionXMobile',
								'template'  => 'background-position-x: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'CustomPositionX', 'mobile' ) . ';',
							),
							array(
								'attr_name' => $attr_prefix . 'CustomPositionYMobile',
								'template'  => 'background-position-y: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'CustomPositionY', 'mobile' ) . ';',
							),
						),
						'mobile'
					);
				}
			}

			if ( isset( $attributes[ $attr_prefix . 'DisplaySizeMobile' ] ) ) {
				if ( 'custom' !== $attributes[ $attr_prefix . 'DisplaySizeMobile' ] ) {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'DisplaySizeMobile',
								'template'  => 'background-size: {{value}};',
							),
						),
						'mobile'
					);
				} else {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'CustomDisplaySizeMobile',
								'template'  => 'background-size: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix . 'CustomDisplaySize', 'mobile' ) . ';',
							),
						),
						'mobile'
					);
				}
			}
		}

		if ( 'gradient' === $type ) {
			$gradient_position = ! empty( $attributes[ $attr_prefix . 'GradientPosition' ] ) ? $attributes[ $attr_prefix . 'GradientPosition' ] : 'center center';

			if ( ! empty( $attributes[ $attr_prefix . 'Gradient' ] ) && false !== strpos( $attributes[ $attr_prefix . 'Gradient' ], 'radial-gradient' ) ) {
				$gradient = str_replace( 'radial-gradient(', 'radial-gradient(at ' . $gradient_position . ',', $attributes[ $attr_prefix . 'Gradient' ] );

				$block_css->add_to_selector(
					$selector,
					'background-image: ' . $gradient . ';',
				);
			} else {
				$block_css->add_css_rules(
					$selector,
					array(
						array(
							'attr_name' => $attr_prefix . 'Gradient',
							'template'  => 'background-image: {{value}};',
						),
					)
				);
			}

			if ( ! empty( $attributes[ $attr_prefix . 'GradientTablet' ] ) && false !== strpos( $attributes[ $attr_prefix . 'GradientTablet' ], 'radial-gradient' ) ) {
				$gradient_position = ! empty( $attributes[ $attr_prefix . 'GradientPositionTablet' ] ) ? $attributes[ $attr_prefix . 'GradientPositionTablet' ] : $gradient_position;

				$gradient = str_replace( 'radial-gradient(', 'radial-gradient(at ' . $gradient_position . ',', $attributes[ $attr_prefix . 'GradientTablet' ] );

				$block_css->add_to_selector(
					$selector,
					'background-image: ' . $gradient . ';',
					'tablet'
				);
			} else {
				$block_css->add_css_rules(
					$selector,
					array(
						array(
							'attr_name' => $attr_prefix . 'GradientTablet',
							'template'  => 'background-image: {{value}};',
						),
					),
					'tablet'
				);
			}

			if ( ! empty( $attributes[ $attr_prefix . 'GradientMobile' ] ) && false !== strpos( $attributes[ $attr_prefix . 'GradientMobile' ], 'radial-gradient' ) ) {
				$gradient_position = ! empty( $attributes[ $attr_prefix . 'GradientPositionMobile' ] ) ? $attributes[ $attr_prefix . 'GradientPositionMobile' ] : $gradient_position;

				$gradient = str_replace( 'radial-gradient(', 'radial-gradient(at ' . $gradient_position . ',', $attributes[ $attr_prefix . 'GradientMobile' ] );

				$block_css->add_to_selector(
					$selector,
					'background-image: ' . $gradient . ';',
					'mobile'
				);
			} else {
				$block_css->add_css_rules(
					$selector,
					array(
						array(
							'attr_name' => $attr_prefix . 'GradientMobile',
							'template'  => 'background-image: {{value}};',
						),
					),
					'mobile'
				);
			}
		}

		if ( 'video' === $type ) {
			$block_css->add_css_rules(
				$selector,
				array(
					array(
						'attr_name' => $attr_prefix . 'VideoFallback,url',
						'template'  => 'background-image: url({{value}});',
					),
				)
			);
		}

		return $block_css->get_css();
	}
}
