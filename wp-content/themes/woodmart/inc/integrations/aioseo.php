<?php
/**
 * AIOSEO.
 *
 * @package woodmart
 */

if ( ! function_exists( 'aioseo' ) ) {
	return;
}

add_action( 'wp_head', 'woodmart_page_css_files_disable', 0 );
add_action( 'wp_head', 'woodmart_page_css_files_enable', 2 );

if ( ! function_exists( 'woodmart_page_css_files_disable' ) ) {
	/**
	 * Exclude layout posts from AIOSEO.
	 *
	 * @param array  $ids post ids.
	 * @param string $type post type.
	 * @return array
	 */
	function woodmart_aioseo_exclude_layout( $ids, $type ) {
		$query = new WP_Query(
			array(
				'post_type'      => 'woodamrt_layout',
				'post_status'    => 'publish',
				'fields'         => 'ids',
				'posts_per_page' => -1,
			)
		);

		if ( $query->have_posts() ) {
			$ids = array_merge( $ids, $query->posts );
		}

		return $ids;
	}

	add_filter( 'aioseo_sitemap_exclude_posts', 'woodmart_aioseo_exclude_layout', 10, 2 );
}
