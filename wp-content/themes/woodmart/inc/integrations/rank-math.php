<?php
/**
 * Rank Math.
 *
 * @package Woodmart
 */

if ( ! defined( 'RANK_MATH_VERSION' ) ) {
	return;
}

if ( ! function_exists( 'woodmart_rank_math_excluded_post_types' ) ) {
	/**
	 * Exclude WoodMart layout post type from Rank Math sitemap.
	 *
	 * @param array $post_type Post type.
	 * @return array
	 */
	function woodmart_rank_math_excluded_post_types( $post_type ) {
		if ( isset( $post_type['woodmart_layout'] ) ) {
			unset( $post_type['woodmart_layout'] );
		}

		return $post_type;
	}

	add_filter( 'rank_math/excluded_post_types', 'woodmart_rank_math_excluded_post_types' );
}
