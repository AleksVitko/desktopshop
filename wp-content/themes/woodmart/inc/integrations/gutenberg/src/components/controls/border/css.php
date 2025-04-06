<?php
/**
 * Gutenberg border CSS.
 *
 * @package Woodmart
 */

use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_border_css' ) ) {
	/**
	 * Get block border CSS.
	 *
	 * @param string $selector CSS selector.
	 * @param array  $attributes CSS attributes.
	 * @param string $attr_prefix Attribute prefix.
	 * @return array
	 */
	function wd_get_block_border_css( $selector, $attributes, $attr_prefix ) {
		$block_css = new Block_CSS( $attributes );

		foreach ( array( 'global', 'tablet', 'mobile' ) as $device ) {
			$device_name    = 'global' !== $device ? ucfirst( $device ) : '';
			$add_border_css = true;

			if ( ! $device_name ) {
				if (
					isset( $attributes[ $attr_prefix . 'WidthTop' . $device_name ], $attributes[ $attr_prefix . 'WidthRight' . $device_name ], $attributes[ $attr_prefix . 'WidthBottom' . $device_name ], $attributes[ $attr_prefix . 'WidthLeft' . $device_name ] )
					&& '' !== $attributes[ $attr_prefix . 'WidthTop' . $device_name ]
					&& $attributes[ $attr_prefix . 'WidthTop' . $device_name ] === $attributes[ $attr_prefix . 'WidthRight' . $device_name ]
					&& $attributes[ $attr_prefix . 'WidthTop' . $device_name ] === $attributes[ $attr_prefix . 'WidthBottom' . $device_name ]
					&& $attributes[ $attr_prefix . 'WidthTop' . $device_name ] === $attributes[ $attr_prefix . 'WidthLeft' . $device_name ]
					&& ! empty( $attributes[ $attr_prefix . 'Type' ] )
					&& 'none' !== $attributes[ $attr_prefix . 'Type' ]
					&& ( ! empty( $attributes[ $attr_prefix . 'ColorCode' ] ) || ! empty( $attributes[ $attr_prefix . 'ColorVariable' ] ) )
				) {
					$width = $attributes[ $attr_prefix . 'WidthTop' . $device_name ];
					$unit  = $block_css->get_units_for_attribute( $attr_prefix, $device );

					$color = ! empty( $attributes[ $attr_prefix . 'ColorVariable' ] ) ? 'var(' . $attributes[ $attr_prefix . 'ColorVariable' ] . ')' : $attributes[ $attr_prefix . 'ColorCode' ];

					$block_css->add_to_selector(
						$selector,
						'border:' . $width . $unit . ' ' . $attributes[ $attr_prefix . 'Type' ] . ' ' . $color . ';',
						$device
					);

					$add_border_css = false;
				} else {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => $attr_prefix . 'Type',
								'template'  => 'border-style: {{value}};',
							),
							array(
								'attr_name' => $attr_prefix . 'ColorCode',
								'template'  => 'border-color: {{value}};',
							),
							array(
								'attr_name' => $attr_prefix . 'ColorVariable',
								'template'  => 'border-color: var({{value}});',
							),
						)
					);
				}
			}

			if (
				$add_border_css &&
				( ( isset( $attributes[ $attr_prefix . 'WidthTop' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'WidthTop' . $device_name ] )
				|| ( isset( $attributes[ $attr_prefix . 'WidthRight' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'WidthRight' . $device_name ] )
				|| ( isset( $attributes[ $attr_prefix . 'WidthBottom' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'WidthBottom' . $device_name ] )
				|| ( isset( $attributes[ $attr_prefix . 'WidthLeft' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'WidthLeft' . $device_name ] ) )
			) {
				$block_css->add_to_selector(
					$selector,
					'border-width:' . $block_css->get_value_from_sides( $attr_prefix . 'Width', $device ) . ';',
					$device
				);
			}

			if (
				( isset( $attributes[ $attr_prefix . 'RadiusTop' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'RadiusTop' . $device_name ] )
				|| ( isset( $attributes[ $attr_prefix . 'RadiusRight' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'RadiusRight' . $device_name ] )
				|| ( isset( $attributes[ $attr_prefix . 'RadiusBottom' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'RadiusBottom' . $device_name ] )
				|| ( isset( $attributes[ $attr_prefix . 'RadiusLeft' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'RadiusLeft' . $device_name ] )
			) {
				$block_css->add_to_selector(
					$selector,
					'border-radius:' . $block_css->get_value_from_sides( $attr_prefix . 'Radius', $device ) . ';',
					$device
				);
			}
		}

		return $block_css->get_css();
	}
}
