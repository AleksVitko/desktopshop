<?php
/**
 * MC4WP: Mailchimp for WordPress.
 *
 * @package woodmart
 */

if ( ! defined( 'MC4WP_VERSION' ) ) {
	return;
}

if ( ! function_exists( 'woodmart_mc4wp_enqueue_scripts' ) ) {
	/**
	 * Fixes the conflict of options that overwrite the checkout template.
	 *
	 * @param bool $load_scripts .
	 *
	 * @return bool
	 */
	function woodmart_mc4wp_enqueue_scripts( $load_scripts ) {
		woodmart_enqueue_js_script( 'mailchimp' );

		return $load_scripts;
	}

	add_filter( 'mc4wp_load_form_scripts', 'woodmart_mc4wp_enqueue_scripts', 9 );
}
