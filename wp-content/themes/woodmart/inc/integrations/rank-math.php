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

if ( ! function_exists( 'woodmart_rank_math_update_shortcode_title' ) ) {
	/**
	 * Update WoodMart title shortcode to work with Rank Math.
	 *
	 * @return void
	 */
	function woodmart_rank_math_update_shortcode_title() {
		if ( 'wpb' !== woodmart_get_current_page_builder() ) {
			return;
		}

		?>
		<script type="text/javascript">
			(function ($) {
				wp.hooks.addFilter('rank_math_content', 'rank-math', function (content) {
					return content.replace(/\[woodmart_title\s+([^\]]+)\]/g, function (match, attrString) {
						const parseAttributes = (str) => {
							const attrs = {};
							const regex = /(\w+)=(["'])(.*?)\2/g;
							let m;
							while ((m = regex.exec(str)) !== null) {
								attrs[m[1]] = m[3];
							}
							return attrs;
						};

						const attrs = parseAttributes(attrString);

						const tag = attrs.tag || 'h4';

						if (attrs.title) {
							const wrappedTitle = `<${tag}>${attrs.title}</${tag}>`;

							const newAttrString = attrString.replace(/title=(["'])(.*?)\1/, `title="${wrappedTitle}"`);

							return `[woodmart_title ${newAttrString}]`;
						}

						return match;
					});
				}, 9);
			})(jQuery);
		</script>
		<?php
	}

	add_filter( 'admin_footer-post.php', 'woodmart_rank_math_update_shortcode_title' );
}
