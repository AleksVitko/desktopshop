<?php
/**
 * CartFlows.
 *
 * @package woodmart
 */

if ( ! defined( 'CARTFLOWS_FILE' ) ) {
	return;
}

if ( ! function_exists( 'woodmart_cartflows_checkout_template_condition' ) ) {
	/**
	 * Fixes the conflict of options that overwrite the checkout template.
	 *
	 * @param bool $condition Is the theme trying to rewrite the template.
	 *
	 * @return bool
	 */
	function woodmart_cartflows_checkout_template_condition( $condition ) {
		$common_settings = get_option( '_cartflows_common', false );

		if ( ! empty( $common_settings ) && isset( $common_settings['override_global_checkout'] ) && 'enable' === $common_settings['override_global_checkout'] ) {
			return false;
		}

		return $condition;
	}

	add_filter( 'woodmart_replace_checkout_template_condition', 'woodmart_cartflows_checkout_template_condition' );
}
