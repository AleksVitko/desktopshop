<?php
/**
 * Gutenberg block css module.
 *
 * @package Woodmart
 */

namespace XTS\Gutenberg;

/**
 * Gutenberg block css module.
 */
class Block_CSS {

	/**
	 * Block CSS.
	 *
	 * @var array
	 */
	private $css = array();

	/**
	 * Block attributes.
	 *
	 * @var array
	 */
	private $attributes;

	/**
	 * Block_CSS constructor.
	 *
	 * @param array $attributes Block attributes.
	 */
	public function __construct( $attributes ) {
		$this->attributes = $attributes;
	}

	/**
	 * Add CSS rules.
	 *
	 * @param string $selector CSS selector.
	 * @param array  $rules CSS rules.
	 * @param string $device Device type.
	 *
	 * @return void
	 */
	public function add_css_rules( $selector, $rules, $device = 'global' ) {
		$styles = '';

		foreach ( $rules as $rule ) {
			$has_value       = false;
			$value           = '';
			$attr_name_parts = explode( ',', $rule['attr_name'] );
			// works with 2-dimensional attribute array like [image][url].
			// Attribute name should be 'image,url'.
			if ( isset( $attr_name_parts[1] ) && isset( $this->attributes[ $attr_name_parts[0] ] ) ) {
				if ( isset( $this->attributes[ $attr_name_parts[0] ][ $attr_name_parts[1] ] ) && '' !== $this->attributes[ $attr_name_parts[0] ][ $attr_name_parts[1] ] ) {
					$has_value = true;
					$value     = $this->attributes[ $attr_name_parts[0] ][ $attr_name_parts[1] ];
				}
			} elseif ( isset( $this->attributes[ $attr_name_parts[0] ] ) && '' !== $this->attributes[ $attr_name_parts[0] ] ) {
				$has_value = true;
				$value     = $this->attributes[ $attr_name_parts[0] ];
			}

			if ( $has_value ) {
				$styles .= $this->template_to_rule( $rule['template'], $value );
			}
		}

		$this->add_to_selector( $selector, $styles, $device );
	}

	/**
	 * Template to rule.
	 *
	 * @param string $template CSS rule template.
	 * @param string $value CSS rule value.
	 * @return array|string|string[]
	 */
	public function template_to_rule( $template, $value ) {
		return str_replace( '{{value}}', $value, $template );
	}

	/**
	 * Get units for attribute.
	 *
	 * @param string $attr_name Attribute name.
	 * @param string $device Device type.
	 * @return mixed|string
	 */
	public function get_units_for_attribute( $attr_name, $device = '' ) {
		$units_attr_name = $attr_name . 'Units';
		$units           = '';

		if ( 'tablet' === $device ) {
			$units_attr_name .= 'Tablet';
		} elseif ( 'mobile' === $device ) {
			$units_attr_name .= 'Mobile';
		}

		if ( ! empty( $this->attributes[ $units_attr_name ] ) ) {
			if ( 'custom' !== $this->attributes[ $units_attr_name ] ) {
				$units = $this->attributes[ $units_attr_name ];
			}
		} else {
			$units = 'px';
		}

		return $units;
	}

	/**
	 * Get units for attribute.
	 *
	 * @param string $attr_name Attribute name.
	 * @param string $device Device type.
	 * @return string
	 */
	public function get_value_from_sides( $attr_name, $device = '' ) {
		$values      = '';
		$unit        = $this->get_units_for_attribute( $attr_name, $device );
		$device_name = 'global' !== $device ? ucfirst( $device ) : '';

		foreach ( array( 'Top', 'Right', 'Bottom', 'Left' ) as $side ) {
			if ( isset( $this->attributes[ $attr_name . $side . $device_name ] ) && '' !== $this->attributes[ $attr_name . $side . $device_name ] ) {
				$values .= ' ' . $this->attributes[ $attr_name . $side . $device_name ] . $unit;
			} else {
				$values .= ' 0' . $unit;
			}
		}

		$values_array = explode( ' ', trim( $values ) );

		if ( count( array_unique( $values_array ) ) === 1 ) {
			$values = ' ' . $values_array[0];
		}

		return $values;
	}

	/**
	 * Add CSS to selector.
	 *
	 * @param string $selector CSS selector.
	 * @param string $styles CSS styles.
	 * @param string $device CSS device.
	 *
	 * @return void
	 */
	public function add_to_selector( $selector, $styles, $device = 'global' ) {
		$found = false;

		foreach ( $this->css as $i => $css_block ) {
			if ( $selector === $css_block['selector'] && $device === $css_block['device'] ) {
				$found                      = true;
				$this->css[ $i ]['styles'] .= $styles;
				break;
			}
		}

		if ( ! $found ) {
			$this->css[] = array(
				'selector' => $selector,
				'styles'   => $styles,
				'device'   => $device,
			);
		}
	}

	/**
	 * Get CSS for devices.
	 *
	 * @return array
	 */
	public function get_css_for_devices() {
		if ( empty( $this->css ) ) {
			return array();
		}

		$css_global      = '';
		$css_desktop     = '';
		$css_tablet      = '';
		$css_only_tablet = '';
		$css_mobile      = '';

		foreach ( $this->css as $css_block ) {
			$piece = ( ! empty( $css_block['styles'] ) ) ? $css_block['selector'] . '{' . $css_block['styles'] . '}' : '';

			switch ( $css_block['device'] ) :
				case 'global':
					$css_global .= $piece;
					break;
				case 'desktop':
					$css_desktop .= $piece;
					break;
				case 'tablet':
					$css_tablet .= $piece;
					break;
				case 'only_tablet':
					$css_only_tablet .= $piece;
					break;
				case 'mobile':
					$css_mobile .= $piece;
					break;
			endswitch;
		}

		return array(
			'desktop'      => $css_global,
			'only_desktop' => $css_desktop,
			'tablet'       => $css_tablet,
			'only_tablet'  => $css_only_tablet,
			'mobile'       => $css_mobile,
		);
	}

	/**
	 * Get CSS.
	 *
	 * @return array
	 */
	public function get_css() {
		return $this->css;
	}

	/**
	 * Merge with other CSS.
	 *
	 * @param array $other_css Other CSS.
	 * @return void
	 */
	public function merge_with( $other_css ) {
		foreach ( $other_css as $other_css_block ) {
			$found = false;

			foreach ( $this->css as $i => $css_block ) {
				if ( $css_block['selector'] === $other_css_block['selector'] && $css_block['device'] === $other_css_block['device'] ) {
					$found                      = true;
					$this->css[ $i ]['styles'] .= $other_css_block['styles'];
				}
			}

			if ( ! $found ) {
				$this->css[] = $other_css_block;
			}
		}
	}
}
