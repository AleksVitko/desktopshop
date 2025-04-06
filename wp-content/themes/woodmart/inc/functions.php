<?php
use Elementor\Plugin;
use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
use XTS\Registry;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_opt' ) ) {
	/**
	 * Get theme option.
	 *
	 * @param string $slug Option slug.
	 * @param string $default Default value.
	 * @return mixed|null
	 */
	function woodmart_get_opt( $slug = '', $default = false ) {
		global $woodmart_options, $xts_woodmart_options;

		$opt = $default;

		if ( isset( $xts_woodmart_options[ $slug ] ) ) {
			$opt = $xts_woodmart_options[ $slug ];

			return apply_filters( 'woodmart_option', $opt, $slug );
		}

		if ( isset( $woodmart_options[ $slug ] ) ) {
			$opt = $woodmart_options[ $slug ];

			return apply_filters( 'woodmart_option', $opt, $slug );
		}

		return apply_filters( 'woodmart_option', $opt, $slug );
	}
}

if ( ! function_exists( 'woodmart_page_ID' ) ) {
	/**
	 * Get current page ID.
	 *
	 * @return mixed
	 */
	function woodmart_page_ID() {
		return Registry::getInstance()->layout->get_page_id();
	}
}

if ( ! function_exists( 'woodmart_get_content_inline_style' ) ) {
	/**
	 * Get content inline style.
	 *
	 * @return mixed
	 */
	function woodmart_get_content_inline_style() {
		return Registry::getInstance()->layout->get_content_inline_style();
	}
}

if ( ! function_exists( 'woodmart_get_page_layout' ) ) {
	/**
	 * Get page layout.
	 *
	 * @return mixed
	 */
	function woodmart_get_page_layout() {
		return Registry::getInstance()->layout->get_page_layout();
	}
}

if ( ! function_exists( 'woodmart_get_carousel_breakpoints' ) ) {
	/**
	 * Added global breakpoints for carousel config.
	 *
	 * @return array
	 */
	function woodmart_get_carousel_breakpoints() {
		return apply_filters(
			'woodmart_get_carousel_breakpoints',
			array(
				'1025'   => 'lg',
				'768.98' => 'md',
				'0'      => 'sm',
			)
		);
	}
}

if ( ! function_exists( 'woodmart_get_color_value' ) ) {
	/**
	 * Get color value.
	 *
	 * @param string $key Option key.
	 * @param string $default Default value.
	 * @return mixed
	 */
	function woodmart_get_color_value( $key, $default ) {
		$color = woodmart_get_opt( $key );

		if ( isset( $color['idle'] ) && $color['idle'] ) {
			return $color['idle'];
		} else {
			return $default;
		}
	}
}

if ( ! function_exists( 'woodmart_get_css_animation' ) ) {
	/**
	 * Get CSS animation.
	 *
	 * @param string $css_animation CSS animation.
	 * @return string
	 */
	function woodmart_get_css_animation( $css_animation ) {
		$output = '';

		if ( $css_animation && 'none' !== $css_animation ) {
			wp_enqueue_style( 'animate-css' );
			wp_enqueue_style( 'vc_animate-css' );

			woodmart_enqueue_js_library( 'waypoints' );
			woodmart_enqueue_js_script( 'animations-offset' );
			$output = ' wd-off-anim wpb_animate_when_almost_visible wpb_' . $css_animation . ' ' . $css_animation;

			$output .= ' wd-anim-name_' . $css_animation;
		}
		return $output;
	}
}

if ( ! function_exists( 'woodmart_get_link_attributes' ) ) {
	/**
	 * Get link attributes.
	 *
	 * @param string  $link Link.
	 * @param boolean $popup Popup.
	 * @return string
	 */
	function woodmart_get_link_attributes( $link, $popup = false ) {
		$link = ( '||' === $link ) ? '' : $link;
		$link = woodmart_vc_parse_multi_attribute( $link );

		$use_link = false;

		if ( isset( $link['url'] ) && strlen( $link['url'] ) > 0 ) {
			$use_link = true;
			$a_href   = apply_filters( 'woodmart_extra_menu_url', $link['url'] );
			if ( $popup ) {
				$a_href = $link['url'];
			}

			$a_title  = $link['title'];
			$a_target = $link['target'];
			$a_rel    = $link['rel'];
		}

		$attributes = array();

		if ( $use_link ) {
			$attributes[] = 'href="' . trim( $a_href ) . '"';
			$attributes[] = 'title="' . esc_attr( trim( $a_title ) ) . '"';
			if ( ! empty( $a_target ) ) {
				$attributes[] = 'target="' . esc_attr( trim( $a_target ) ) . '"';
			}
			if ( ! empty( $a_rel ) ) {
				$attributes[] = 'rel="' . esc_attr( trim( $a_rel ) ) . '"';
			}
		}

		return implode( ' ', $attributes );
	}
}

if ( ! function_exists( 'woodmart_get_taxonomies_by_ids_autocomplete' ) ) {
	/**
	 * Autocomplete by taxonomies ids.
	 *
	 * @since 1.0.0
	 *
	 * @param array $ids Posts ids.
	 *
	 * @return array
	 */
	function woodmart_get_taxonomies_by_ids_autocomplete( $ids ) {
		$output = array();

		if ( ! $ids ) {
			return $output;
		}

		if ( ! is_array( $ids ) ) {
			$ids = array( $ids );
		}

		foreach ( $ids as $id ) {
			$term = get_term( $id );

			if ( $term && ! is_wp_error( $term ) ) {
				$output[ $term->term_id ] = array(
					'name'  => $term->name,
					'value' => $term->term_id,
				);
			}
		}

		return $output;
	}
}

if ( ! function_exists( 'woodmart_get_post_by_ids_autocomplete' ) ) {
	/**
	 * Autocomplete by post ids.
	 *
	 * @since 1.0.0
	 *
	 * @param array $ids Posts ids.
	 *
	 * @return array
	 */
	function woodmart_get_post_by_ids_autocomplete( $ids ) {
		$output = array();

		if ( ! $ids ) {
			return $output;
		}

		if ( ! is_array( $ids ) ) {
			$ids = array( $ids );
		}

		foreach ( $ids as $id ) {
			$post = get_post( $id );

			if ( $post ) {
				$output[ $post->ID ] = array(
					'name'  => $post->post_title . ' ID:(' . $post->ID . ')',
					'value' => $post->ID,
				);
			}
		}

		return $output;
	}
}

if ( ! function_exists( 'woodmart_product_attributes_array' ) ) {
	/**
	 * Get product attributes array.
	 *
	 * @return array
	 */
	function woodmart_product_attributes_array() {
		if ( ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
			return array();
		}
		$attributes = array();

		foreach ( wc_get_attribute_taxonomies() as $attribute ) {
			$attributes[ 'pa_' . $attribute->attribute_name ] = array(
				'name'  => $attribute->attribute_label,
				'value' => 'pa_' . $attribute->attribute_name,
			);
		}

		return $attributes;
	}
}

if ( ! function_exists( 'woodmart_get_pages_array' ) ) {
	/**
	 * Get all pages array
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function woodmart_get_pages_array() {
		$pages = array();

		foreach ( get_pages() as $page ) {
			$pages[ $page->ID ] = array(
				'name'  => $page->post_title,
				'value' => $page->ID,
			);
		}

		return $pages;
	}
}

if ( ! function_exists( 'woodmart_get_footer_config' ) ) {
	/**
	 * Get predefined footer configuration by index.
	 *
	 * @param int $index Footer index.
	 * @return array|mixed
	 */
	function woodmart_get_footer_config( $index ) {
		if ( $index > 20 || $index < 1 ) {
			$index = 1;
		}

		$configs = apply_filters(
			'woodmart_footer_configs_array',
			array(
				1  => array(
					'cols' => array(
						'--wd-col-lg:12;',
					),
				),
				2  => array(
					'cols' => array(
						'--wd-col-xs:12;--wd-col-lg:6;',
						'--wd-col-xs:12;--wd-col-lg:6;',
					),
				),
				3  => array(
					'cols' => array(
						'--wd-col-xs:12;--wd-col-lg:4;',
						'--wd-col-xs:12;--wd-col-lg:4;',
						'--wd-col-xs:12;--wd-col-lg:4;',
					),
				),
				4  => array(
					'cols' => array(
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3',
					),
				),
				5  => array(
					'cols' => array(
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:4;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:4;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:4;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:4;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:4;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:4;--wd-col-lg:2;',
					),
				),
				6  => array(
					'cols' => array(
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:6;',
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:3;',
					),
				),
				7  => array(
					'cols' => array(
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:6;',
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:3;',
					),
				),
				8  => array(
					'cols' => array(
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:6;',
					),
				),
				9  => array(
					'cols' => array(
						'--wd-col-lg:12;',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3;',
					),
				),
				10 => array(
					'cols' => array(
						'--wd-col-sm:12;--wd-col-lg:6;',
						'--wd-col-sm:12;--wd-col-lg:6;',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3;',
					),
				),
				11 => array(
					'cols' => array(
						'--wd-col-sm:12;--wd-col-lg:6;',
						'--wd-col-sm:12;--wd-col-lg:6;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:3;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:3;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:3;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:3;--wd-col-lg:2;',
						'--wd-col-md:12;--wd-col-lg:4;',
					),
				),
				12 => array(
					'cols' => array(
						'--wd-col-lg:12;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:3;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:3;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:3;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-sm:6;--wd-col-md:3;--wd-col-lg:2;',
						'--wd-col-md:12;--wd-col-lg:4;',
					),
				),
				13 => array(
					'cols' => array(
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:6;--wd-col-lg:3;',
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:2;',
						'--wd-col-xs:12;--wd-col-md:4;--wd-col-lg:2;',
					),
				),
			)
		);

		return ( isset( $configs[ $index ] ) ) ? $configs[ $index ] : array();
	}
}

if ( ! function_exists( 'woodmart_get_the_ID' ) ) {
	/**
	 * This function is called once when initializing WOODMART_Layout object
	 * then you can use function woodmart_page_ID to get current page id
	 *
	 * @return false|int|mixed|null
	 */
	function woodmart_get_the_ID() {
		global $post;

		$page_id = 0;

		$page_for_posts    = get_option( 'page_for_posts' );
		$page_for_shop     = get_option( 'woocommerce_shop_page_id' );
		$page_for_projects = woodmart_get_portfolio_page_id();
		$custom_404_id     = woodmart_get_opt( 'custom_404_page' );

		if ( isset( $post->ID ) ) {
			$page_id = $post->ID;
		}

		if ( isset( $post->ID ) && ( is_singular( 'page' ) || is_singular( 'post' ) ) ) {
			$page_id = $post->ID;
		} elseif ( is_home() || is_singular( 'post' ) || is_search() || is_tag() || is_category() || is_date() || is_author() ) {
			$page_id = $page_for_posts;
		} elseif ( is_archive() && get_post_type() === 'portfolio' ) {
			$page_id = $page_for_projects;
		}

		if ( woodmart_woocommerce_installed() && function_exists( 'is_shop' ) ) {
			if ( is_shop() || is_product_category() || is_product_tag() || woodmart_is_product_attribute_archive() ) {
				$page_id = $page_for_shop;
			}
		}

		if ( is_404() && ( 'default' !== $custom_404_id || ! empty( $custom_404_id ) ) ) {
			$page_id = $custom_404_id;
		}

		return $page_id;
	}
}

if ( ! function_exists( 'woodmart_get_html_block' ) ) {
	/**
	 * Get HTML block content.
	 *
	 * @param int     $id Block ID.
	 * @param boolean $inline_css Inline CSS.
	 * @return string
	 */
	function woodmart_get_html_block( $id, $inline_css = false ) {
		$id      = apply_filters( 'wpml_object_id', $id, 'cms_block', true );
		$post    = get_post( $id );
		$content = '';

		if ( ! $post || 'cms_block' !== $post->post_type || ! $id ) {
			return '';
		}

		if ( woodmart_is_elementor_installed() && Plugin::$instance->documents->get( $id )->is_built_with_elementor() ) {
			$content .= woodmart_elementor_get_content( $id );
		} elseif ( has_blocks( $post->post_content ) ) {
			if ( woodmart_get_opt( 'gutenberg_blocks' ) ) {
				$content .= Blocks_Assets::get_instance()->get_inline_scripts( $id );
				$content .= Post_CSS::get_instance()->get_inline_blocks_css( $id, $inline_css );
			}

			$content .= wp_filter_content_tags( do_shortcode( do_blocks( $post->post_content ) ) );
		} else {
			$shortcodes_custom_css          = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
			$woodmart_shortcodes_custom_css = get_post_meta( $id, 'woodmart_shortcodes_custom_css', true );

			if ( ! empty( $shortcodes_custom_css ) || ! empty( $woodmart_shortcodes_custom_css ) ) {
				$content .= '<style data-type="vc_shortcodes-custom-css">';
				if ( ! empty( $shortcodes_custom_css ) ) {
					$content .= $shortcodes_custom_css;
				}

				if ( ! empty( $woodmart_shortcodes_custom_css ) ) {
					$content .= $woodmart_shortcodes_custom_css;
				}
				$content .= '</style>';
			}

			$post_content = $post->post_content;

			if ( ! str_contains( $post_content, '[vc_row' ) && ! has_blocks( $post_content ) ) {
				$post_content = wpautop( $post_content );
			} elseif ( class_exists( 'Vc_Base' ) && method_exists( 'Vc_Base', 'fixPContent' ) ) {
				$vc           = new Vc_Base();
				$post_content = $vc->fixPContent( $post_content );
			}

			if ( function_exists( 'vc_modules_manager' ) && vc_modules_manager()->is_module_on( 'vc-custom-css' ) ) {
				ob_start();

				vc_modules_manager()->get_module( 'vc-custom-css' )->output_custom_css_to_page( $id );

				$content .= ob_get_clean();
			}

			$content .= do_shortcode( $post_content );
		}

		return $content;
	}
}

if ( ! function_exists( 'woodmart_get_static_blocks_array' ) ) {
	/**
	 * Get static blocks array.
	 *
	 * @param boolean $new New.
	 * @param boolean $empty Empty.
	 * @return array
	 */
	function woodmart_get_static_blocks_array( $new = false, $empty = false ) {
		$args         = array(
			'posts_per_page' => 500, // phpcs:ignore
			'post_type'      => 'cms_block',
		);
		$blocks_posts = get_posts( $args );
		$array        = array();
		foreach ( $blocks_posts as $post ) :
			if ( $new ) {
				if ( $empty ) {
					$array[''] = array(
						'name'  => esc_html__( 'Select', 'woodmart' ),
						'value' => '',
					);
				}
				$array[ $post->ID ] = array(
					'name'  => $post->post_title . ' (ID:' . $post->ID . ')',
					'value' => $post->ID,
				);
			} else {
				if ( $empty ) {
					$array[ esc_html__( 'Select', 'woodmart' ) ] = '';
				}
				$array[ $post->post_title . ' (ID:' . $post->ID . ')' ] = $post->ID;
			}
		endforeach;
		return $array;
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_html_blocks_array' ) ) {
	/**
	 * Function to get array of HTML Blocks in theme settings array style.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_html_blocks_array() {
		return woodmart_get_static_blocks_array( true );
	}
}

if ( ! function_exists( 'woodmart_get_html_blocks_array_with_empty' ) ) {
	/**
	 * Function to get array of HTML Blocks in WPB element array style.
	 *
	 * @return array
	 */
	function woodmart_get_html_blocks_array_with_empty() {
		return woodmart_get_static_blocks_array( false, true );
	}
}

if ( ! function_exists( 'woodmart_get_elementor_html_blocks_array' ) ) {
	/**
	 * Function to get array of HTML Blocks.
	 *
	 * @return array
	 */
	function woodmart_get_elementor_html_blocks_array() {
		$output = array();

		$posts = get_posts(
			array(
				'posts_per_page' => 500, // phpcs:ignore
				'post_type'      => 'cms_block',
			)
		);

		$output['0'] = esc_html__( 'Select', 'woodmart' );

		foreach ( $posts as $post ) {
			$output[ $post->ID ] = $post->post_title;
		}

		return $output;
	}
}

if ( ! function_exists( 'woodmart_get_related_posts_args' ) ) {
	/**
	 * Get related posts args.
	 *
	 * @param integer $post_id Post ID.
	 * @return array|array[]
	 */
	function woodmart_get_related_posts_args( $post_id ) {
		$taxs = wp_get_post_tags( $post_id );
		$args = array();

		if ( $taxs ) {
			$tax_ids = array();

			foreach ( $taxs as $individual_tax ) {
				$tax_ids[] = $individual_tax->term_id;
			}

			$args = array(
				'tag__in'             => $tax_ids,
				'post__not_in'        => array( $post_id ),
				'showposts'           => 12,
				'ignore_sticky_posts' => 1,
			);

		}

		return $args;
	}
}

if ( ! function_exists( 'woodmart_get_related_projects_args' ) ) {
	/**
	 * Get related projects args.
	 *
	 * @param integer $post_id Post ID.
	 * @return array
	 */
	function woodmart_get_related_projects_args( $post_id ) {
		$taxs = wp_get_post_terms( $post_id, 'project-cat' );
		$args = array();
		if ( $taxs ) {
			$tax_ids = array();
			foreach ( $taxs as $individual_tax ) {
				$tax_ids[] = $individual_tax->term_id;
			}

			$args = array(
				'post_type'    => 'portfolio',
				'post__not_in' => array( $post_id ),
				'tax_query'    => array(
					array(
						'taxonomy'         => 'project-cat',
						'terms'            => $tax_ids,
						'include_children' => false,
					),
				),
			);
		}

		return $args;
	}
}

if ( ! function_exists( 'woodmart_strip_shortcode_gallery' ) ) {
	/**
	 * Deletes first gallery shortcode and returns content.
	 *
	 * @param string $content Content.
	 * @return array|mixed|string|string[]
	 */
	function woodmart_strip_shortcode_gallery( $content ) {
		preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );
		if ( ! empty( $matches ) ) {
			foreach ( $matches as $shortcode ) {
				if ( 'gallery' === $shortcode[2] ) {
					$pos = strpos( $content, $shortcode[0] );
					if ( $pos !== false ) {
						return substr_replace( $content, '', $pos, strlen( $shortcode[0] ) );
					}
				}
			}
		}
		return $content;
	}
}

if ( ! function_exists( 'woodmart_excerpt_from_content' ) ) {
	/**
	 * Get excerpt from post content.
	 *
	 * @param string  $post_content Post content.
	 * @param integer $limit Limit.
	 * @param string  $shortcodes Shortcodes.
	 * @return string
	 */
	function woodmart_excerpt_from_content( $post_content, $limit, $shortcodes = '' ) {
		// Strip shortcodes and HTML tags.
		if ( empty( $shortcodes ) ) {
			$post_content = preg_replace( '/\[caption(.*)\[\/caption\]/i', '', $post_content );
			$post_content = preg_replace( '`\[[^\]]*\]`', '', $post_content );
			$post_content = preg_replace( '/<!--(.*?)?-->/', '', $post_content );
		}

		$post_content = trim( stripslashes( wp_filter_nohtml_kses( $post_content ) ) );

		if ( 'letter' === woodmart_get_opt( 'blog_words_or_letters' ) ) {
			$excerpt = mb_substr( $post_content, 0, $limit );
			if ( mb_strlen( $excerpt ) >= $limit ) {
				$excerpt .= '...';
			}
		} else {
			$limit++;
			$excerpt = explode( ' ', $post_content, $limit );
			if ( count( $excerpt ) >= $limit ) {
				array_pop( $excerpt );
				$excerpt = implode( ' ', $excerpt ) . '...';
			} else {
				$excerpt = implode( ' ', $excerpt );
			}
		}

		$excerpt = strip_tags( $excerpt );

		if ( trim( $excerpt ) == '...' ) {
			return '';
		}

		return $excerpt;
	}
}

if ( ! function_exists( 'woodmart_get_projects_cats_array' ) ) {
	/**
	 * Get projects categories array.
	 *
	 * @return array|string[]
	 */
	function woodmart_get_projects_cats_array() {
		$return = array( 'All' => '' );

		if ( ! post_type_exists( 'portfolio' ) ) {
			return array();
		}

		$cats = get_terms( 'project-cat' );

		foreach ( $cats as $cat ) {
			$return[ $cat->name ] = $cat->term_id;
		}

		return $return;
	}
}

if ( ! function_exists( 'woodmart_get_menus_array' ) ) {
	/**
	 * Get menus dropdown.
	 *
	 * @param string $style Style.
	 * @return array
	 */
	function woodmart_get_menus_array( $style = 'default' ) {
		$output = array();

		$menus = wp_get_nav_menus();

		if ( 'elementor' === $style ) {
			$output[''] = esc_html__( 'Select', 'woodmart' );
		}

		foreach ( $menus as $menu ) {
			if ( 'elementor' === $style ) {
				$output[ $menu->term_id ] = $menu->name;
			} else {
				$output[ $menu->name ] = $menu->name;
			}
		}

		return $output;
	}
}

if ( ! function_exists( 'woodmart_get_sidebars_array' ) ) {
	/**
	 * Get registered sidebars dropdown.
	 *
	 * @param boolean $new New.
	 * @return array
	 */
	function woodmart_get_sidebars_array( $new = false ) {
		global $wp_registered_sidebars;
		$sidebars = array();
		if ( $new ) {
			$sidebars['none'] = array(
				'name'  => esc_html__( 'None', 'woodmart' ),
				'value' => 'none',
			);
		} else {
			$sidebars['none'] = 'none';
		}
		foreach ( $wp_registered_sidebars as $id => $sidebar ) {
			if ( $new ) {
				$sidebars[ $id ] = array(
					'name'  => $sidebar['name'],
					'value' => $id,
				);
			} else {
				$sidebars[ $id ] = $sidebar['name'];
			}
		}
		return $sidebars;
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_sidebars_array' ) ) {
	/**
	 * Get sidebars array in theme settings array style.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_sidebars_array() {
		return woodmart_get_sidebars_array( true );
	}
}

if ( ! function_exists( 'woodmart_pages_ids_from_template' ) ) {
	/**
	 * Get page id by template name.
	 *
	 * @param string $name Template name.
	 * @return array
	 */
	function woodmart_pages_ids_from_template( $name ) {
		$pages = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => $name . '.php',
			)
		);

		$return = array();

		foreach ( $pages as $page ) {
			$return[] = $page->ID;
		}

		return $return;
	}
}


if ( ! function_exists( 'woodmart_get_col_sizes' ) ) {
	/**
	 * Get auto column sizes.
	 *
	 * @param integer $desktop_columns Desktop columns.
	 * @return array
	 */
	function woodmart_get_col_sizes( $desktop_columns ) {
		$desktop_columns = (int) $desktop_columns;

		$sizes = array(
			'1'  => array(
				'desktop' => '1',
				'tablet'  => '1',
				'mobile'  => '1',
			),
			'2'  => array(
				'desktop' => '2',
				'tablet'  => '2',
				'mobile'  => '1',
			),
			'3'  => array(
				'desktop' => '3',
				'tablet'  => '3',
				'mobile'  => '1',
			),
			'4'  => array(
				'desktop' => '4',
				'tablet'  => '4',
				'mobile'  => '1',
			),
			'5'  => array(
				'desktop' => '5',
				'tablet'  => '4',
				'mobile'  => '2',
			),
			'6'  => array(
				'desktop' => '6',
				'tablet'  => '4',
				'mobile'  => '2',
			),
			'7'  => array(
				'desktop' => '7',
				'tablet'  => '4',
				'mobile'  => '2',
			),
			'8'  => array(
				'desktop' => '8',
				'tablet'  => '4',
				'mobile'  => '2',
			),
			'9'  => array(
				'desktop' => '9',
				'tablet'  => '4',
				'mobile'  => '2',
			),
			'10' => array(
				'desktop' => '10',
				'tablet'  => '4',
				'mobile'  => '2',
			),
			'11' => array(
				'desktop' => '11',
				'tablet'  => '4',
				'mobile'  => '2',
			),
			'12' => array(
				'desktop' => '12',
				'tablet'  => '4',
				'mobile'  => '2',
			),
		);

		return isset( $sizes[ $desktop_columns ] ) ? $sizes[ $desktop_columns ] : $sizes['3'];
	}
}

if ( ! function_exists( 'woodmart_get_grid_attrs' ) ) {
	/**
	 * Get grid attributes.
	 *
	 * @param array $settings Settings.
	 * @return string
	 */
	function woodmart_get_grid_attrs( $settings ) {
		$desktop_columns = isset( $settings['columns'] ) ? $settings['columns'] : '3';
		$tablet_columns  = isset( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 'auto';
		$mobile_columns  = isset( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 'auto';

		if ( isset( $tablet_columns['size'] ) ) {
			$tablet_columns = $tablet_columns['size'];
		}
		if ( isset( $mobile_columns['size'] ) ) {
			$mobile_columns = $mobile_columns['size'];
		}

		$auto_columns = woodmart_get_col_sizes( $desktop_columns );
		$style_attrs  = '';

		if ( ! $tablet_columns || 'auto' === $tablet_columns ) {
			$tablet_columns = $auto_columns['tablet'];
		}

		if ( ! $mobile_columns || 'auto' === $mobile_columns ) {
			$mobile_columns = $auto_columns['mobile'];
		}

		$style_attrs .= '--wd-col-lg:' . $desktop_columns . ';';
		$style_attrs .= '--wd-col-md:' . $tablet_columns . ';';
		$style_attrs .= '--wd-col-sm:' . $mobile_columns . ';';

		if ( isset( $settings['spacing'] ) && '' !== (string) $settings['spacing'] ) {
			$style_attrs .= '--wd-gap-lg:' . $settings['spacing'] . 'px;';
		}

		if ( isset( $settings['spacing_tablet'] ) && 'false' === $settings['spacing_tablet'] ) {
			$settings['spacing_tablet'] = '';
		}
		if ( isset( $settings['spacing_mobile'] ) && 'false' === $settings['spacing_mobile'] ) {
			$settings['spacing_mobile'] = '';
		}

		if ( isset( $settings['spacing_tablet'] ) && '' !== (string) $settings['spacing_tablet'] && ( empty( $settings['spacing'] ) || $settings['spacing'] !== $settings['spacing_tablet'] ) ) {
			$style_attrs .= '--wd-gap-md:' . $settings['spacing_tablet'] . 'px;';
		}

		if ( isset( $settings['spacing'], $settings['spacing_mobile'] ) && ! $settings['spacing_mobile'] && in_array( (int) $settings['spacing'], array( 20, 30 ), true ) ) {
			$settings['spacing_mobile'] = 10;
		}

		if ( isset( $settings['spacing_mobile'] ) && '' !== (string) $settings['spacing_mobile'] && ( empty( $settings['spacing_tablet'] ) || $settings['spacing_tablet'] !== $settings['spacing_mobile'] ) ) {
			$style_attrs .= '--wd-gap-sm:' . $settings['spacing_mobile'] . 'px;';
		}

		return $style_attrs;
	}
}

if ( ! function_exists( 'woodmart_get_wide_items_array' ) ) {
	/**
	 * Get wide items array.
	 *
	 * @param array $different_sizes Different sizes.
	 * @return mixed|null
	 */
	function woodmart_get_wide_items_array( $different_sizes = false ) {
		$items_wide = apply_filters( 'woodmart_wide_items', array( 5, 6, 7, 8, 13, 14 ) );

		if ( is_array( $different_sizes ) ) {
			$items_wide = apply_filters( 'woodmart_wide_items', $different_sizes );
		}

		return $items_wide;
	}
}
