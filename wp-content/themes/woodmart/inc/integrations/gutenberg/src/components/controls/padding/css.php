<?php

use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_padding_css' ) ) {
	function wd_get_block_padding_css( $selector, $attributes, $attr_prefix ) {
		$block_css = new Block_CSS( $attributes );

		foreach ( array( 'global', 'tablet', 'mobile' ) as $device ) {
			$device_name = 'global' !== $device ? ucfirst( $device ) : '';

			if (
				isset( $attributes[ $attr_prefix . 'Top' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'Top' . $device_name ]
				&& isset( $attributes[ $attr_prefix . 'Right' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'Right' . $device_name ]
				&& isset( $attributes[ $attr_prefix . 'Bottom' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'Bottom' . $device_name ]
				&& isset( $attributes[ $attr_prefix . 'Left' . $device_name ] ) && '' !== $attributes[ $attr_prefix . 'Left' . $device_name ]
			) {
				$block_css->add_to_selector(
					$selector,
					'padding:' . $block_css->get_value_from_sides( $attr_prefix, $device ) . ';',
					$device
				);
			} else {
				$block_css->add_css_rules(
					$selector,
					array(
						array(
							'attr_name' => $attr_prefix . 'Top' . $device_name,
							'template'  => 'padding-top: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, $device ) . ';',
						),
						array(
							'attr_name' => $attr_prefix . 'Right' . $device_name,
							'template'  => 'padding-right: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, $device ) . ';',
						),
						array(
							'attr_name' => $attr_prefix . 'Bottom' . $device_name,
							'template'  => 'padding-bottom: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, $device ) . ';',
						),
						array(
							'attr_name' => $attr_prefix . 'Left' . $device_name,
							'template'  => 'padding-left: {{value}}' . $block_css->get_units_for_attribute( $attr_prefix, $device ) . ';',
						),
					),
					$device
				);
			}
		}

		return $block_css->get_css();
	}
}
