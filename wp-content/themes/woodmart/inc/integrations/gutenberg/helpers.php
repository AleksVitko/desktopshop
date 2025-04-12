<?php
/**
 * Gutenberg helpers.
 *
 * @package Woodmart
 */

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'xts_parse_blocks_from_content' ) ) {
	/**
	 * Parse blocks from content.
	 *
	 * @param string $content Post content.
	 * @return array[]
	 */
	function xts_parse_blocks_from_content( $content ) {
		global $wp_version;

		return ( version_compare( $wp_version, '5', '>=' ) ) ? parse_blocks( $content ) : gutenberg_parse_blocks( $content );
	}
}

if ( ! function_exists( 'wd_replace_boolean_to_yes_no' ) ) {
	/**
	 * Transfer variable value.
	 *
	 * @param array $variable_keys Keys.
	 * @param array $attributes Element attributes.
	 * @return void
	 */
	function wd_replace_boolean_to_yes_no( $variable_keys, &$attributes ) {
		foreach ( $variable_keys as $key ) {
			$attributes[ $key ] = ! empty( $attributes[ $key ] ) ? 'yes' : 'no';
		}
	}
}

if ( ! function_exists( 'wd_get_gutenberg_element_classes' ) ) {
	/**
	 * Get custom element classes.
	 *
	 * @param array  $attributes Element attributes.
	 * @param string $classes Extra classes.
	 * @return string
	 */
	function wd_get_gutenberg_element_classes( $attributes, $classes = '' ) {
		if ( wp_is_serving_rest_request() ) {
			return '';
		}

		$transform_attrs_raw = new Block_Attributes();

		$transform_attrs_raw->add_attr( wd_get_transform_control_attrs( $transform_attrs_raw, 'transform' ) );
		$transform_attrs_raw->add_attr( wd_get_transform_control_attrs( $transform_attrs_raw, 'transformHover' ) );
		$transform_attrs_raw->add_attr( wd_get_transform_control_attrs( $transform_attrs_raw, 'transformParentHover' ) );

		$transform_attrs = $transform_attrs_raw->get_attr();

		if ( isset( $transform_attrs['blockId'] ) ) {
			unset( $transform_attrs['blockId'] );
		}

		$transform_attrs_keys = array_keys( $transform_attrs );

		if ( $transform_attrs_keys ) {
			foreach ( $transform_attrs_keys as $key ) {
				if ( ! empty( $attributes[ $key ] ) && ! stripos( $key, 'units' ) && ( is_string( $attributes[ $key ] ) || is_numeric( $attributes[ $key ] ) ) ) {
					$classes .= ' wd-transform';

					break;
				}
			}
		}

		if ( ! empty( $attributes['displayWidth'] ) || ! empty( $attributes['displayWidthTablet'] ) || ! empty( $attributes['displayWidthMobile'] ) ) {
			$classes .= ' wd-custom-width';
		}

		if ( ! empty( $attributes['alignSelf'] ) ) {
			$classes .= ' wd-align-s-' . $attributes['alignSelf'];
		}
		if ( ! empty( $attributes['alignSelfTablet'] ) ) {
			$classes .= ' wd-align-s-' . $attributes['alignSelfTablet'] . '-md';
		}
		if ( ! empty( $attributes['alignSelfMobile'] ) ) {
			$classes .= ' wd-align-s-' . $attributes['alignSelfMobile'] . '-sm';
		}

		if ( ! empty( $attributes['hideOnDesktop'] ) ) {
			$classes .= ' wd-hide-lg';
		}
		if ( ! empty( $attributes['hideOnTablet'] ) ) {
			$classes .= ' wd-hide-md-sm';
		}
		if ( ! empty( $attributes['hideOnMobile'] ) ) {
			$classes .= ' wd-hide-sm';
		}

		if ( ! empty( $attributes['animation'] ) ) {
			$classes .= ' wd-animation';
			$classes .= ' wd-anim-' . $attributes['animation'];

			if ( ! empty( $attributes['animationDelay'] ) ) {
				$classes .= ' wd_delay_' . $attributes['animationDelay'];
			}

			if ( ! strpos( $attributes['animation'], 'wd-transform' ) ) {
				$classes .= ' wd-transform';
			}
		}

		if ( ! empty( $attributes['parallaxScroll'] ) ) {
			$classes .= ' wd-parallax-on-scroll';
			$classes .= ' wd_scroll_x_' . $attributes['parallaxScrollX'];
			$classes .= ' wd_scroll_y_' . $attributes['parallaxScrollY'];
			$classes .= ' wd_scroll_z_' . $attributes['parallaxScrollZ'];
			$classes .= ' wd_scroll_smoothness_' . $attributes['parallaxSmoothness'];
		}

		if ( ! empty( $attributes['className'] ) ) {
			$classes .= ' ' . $attributes['className'];
		}

		return $classes;
	}
}

if ( ! function_exists( 'wd_get_gutenberg_element_id' ) ) {
	/**
	 * Get element ID.
	 *
	 * @param array $attributes Element attributes.
	 * @return string
	 */
	function wd_get_gutenberg_element_id( $attributes ) {
		if ( ! empty( $attributes['blockId'] ) ) {
			return 'wd-' . substr( $attributes['blockId'], 0, 8 );
		}

		return '';
	}
}

if ( ! function_exists( 'wd_get_inherit_responsive_value' ) ) {
	/**
	 * Get inherit responsive value.
	 *
	 * @param array  $attributes Element attributes.
	 * @param string $key Attribute key.
	 * @param string $device Device type.
	 * @return string
	 */
	function wd_get_inherit_responsive_value( $attributes, $key, $device = '' ) {
		if ( ! empty( $attributes[ $key . ucfirst( $device ) ] ) ) {
			return $attributes[ $key . ucfirst( $device ) ];
		}

		if ( 'mobile' === $device && ! empty( $attributes[ $key . ucfirst( 'tablet' ) ] ) ) {
			return $attributes[ $key . ucfirst( 'tablet' ) ];
		}

		if ( ( ! $device || 'tablet' === $device || 'mobile' === $device ) && isset( $attributes[ $key ] ) ) {
			return $attributes[ $key ];
		}

		return '';
	}
}

if ( ! function_exists( 'wd_gutenberg_is_rest_api' ) ) {
	/**
	 * Is render block element via server side render.
	 *
	 * @return bool
	 */
	function wd_gutenberg_is_rest_api() {
		return ! empty( $_SERVER['REQUEST_URI'] ) && false !== strpos( $_SERVER['REQUEST_URI'], trailingslashit( rest_get_url_prefix() ) ); //phpcs:ignore
	}
}
