<?php
/**
 * Provide basic functionality for compatibility with ACF vendor.
 *
 * @see https://wordpress.org/plugins/advanced-custom-fields
 *
 * @since 8.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Class Wpb_Acf_Provider.
 *
 * @since 8.1
 */
class Wpb_Acf_Provider {
	/**
	 * Get field value.
	 *
	 * @since 8.1
	 * @param string $field_key
	 * @param int|false $post_id
	 *
	 * @return scalar
	 */
	public function get_field_value( $field_key, $post_id = false ) {
		if ( ! $post_id ) {
			$post_id = get_the_ID();
		}

		if ( $this->is_acf_version( '6.3.0' ) && ! acf_get_setting( 'enable_shortcode' ) ) {
			$value = get_field( $field_key, $post_id );

			if ( is_array( $value ) ) {
				$value = implode( ', ', $value );
			}

			if ( ! is_scalar( $value ) ) {
				$value = false;
			}
		} else {
			$value = do_shortcode( '[acf field="' . $field_key . '" post_id="' . $post_id . '"]' );
		}

		return $value;
	}

	/**
	 * Check ACF version.
	 *
	 * @since 8.1
	 * @param string $version
	 *
	 * @return bool
	 */
	public function is_acf_version( $version ) {
		if ( ! function_exists( 'acf_version_compare' ) || ! function_exists( 'acf_get_db_version' ) ) {
			return false;
		}

		if ( acf_version_compare( acf_get_db_version(), '>=', $version ) ) {
			return true;
		}

		return false;
	}
}
