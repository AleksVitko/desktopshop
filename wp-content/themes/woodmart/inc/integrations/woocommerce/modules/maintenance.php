<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_maintenance_page' ) ) {
	/**
	 * Check if the current page is maintenance page.
	 *
	 * @return bool
	 */
	function woodmart_maintenance_page() {
		if ( ! woodmart_get_opt( 'maintenance_mode' ) || is_user_logged_in() || ( woodmart_get_opt( 'maintenance_mode' ) && isset( $_GET[ woodmart_get_opt( 'maintenance_access_key' ) ] ) ) ) { //phpcs:ignore
			return false;
		}

		$pages_ids = woodmart_pages_ids_from_template( 'maintenance' );

		if ( ! empty( $pages_ids ) && is_page( $pages_ids ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'woodmart_is_maintenance_active' ) ) {
	/**
	 * This function will return true if the site visitor should be redirected to the maintenance page.
	 *
	 * @return bool
	 */
	function woodmart_is_maintenance_active() {
		$maintenance_mode       = woodmart_get_opt( 'maintenance_mode' );
		$maintenance_access_key = woodmart_get_opt( 'maintenance_access_key' );
		$is_access_key          = ! empty( $maintenance_access_key ) && isset( $_GET[ $maintenance_access_key ] ); //phpcs:ignore;

		if ( ! $maintenance_mode || is_user_logged_in() || $is_access_key ) {
			return false;
		}

		return true;
	}
}

if ( ! function_exists( 'woodmart_maintenance_mode' ) ) {
	/**
	 * Maintenance mode redirect.
	 *
	 * @return void
	 */
	function woodmart_maintenance_mode() {
		if ( ! woodmart_is_maintenance_active() ) {
			return;
		}

		$page_id = woodmart_pages_ids_from_template( 'maintenance' );

		$page_id = current( $page_id );

		if ( ! $page_id ) {
			return;
		}

		if ( ! is_page( $page_id ) && ! is_user_logged_in() ) {
			wp_redirect( get_permalink( $page_id ) );
			exit();
		}
	}

	add_action( 'template_redirect', 'woodmart_maintenance_mode', 10 );
}
