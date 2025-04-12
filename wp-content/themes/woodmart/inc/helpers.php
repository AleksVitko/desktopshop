<?php
/**
 * Helpers.
 *
 * @package Woodmart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Config;
use XTS\Modules\Layouts\Main as Builder;
	use XTS\Registry;

if ( ! function_exists( 'woodmart_is_opt_changed' ) ) {
	/**
	 * Check if option is changed.
	 *
	 * @param string $slug Option slug.
	 * @return bool|void
	 */
	function woodmart_is_opt_changed( $slug ) {
		global $xts_woodmart_options;

		$global_options = get_option( 'xts-woodmart-options' );
		$current        = isset( $xts_woodmart_options[ $slug ] ) ? $xts_woodmart_options[ $slug ] : false;
		$global         = isset( $global_options[ $slug ] ) ? $global_options[ $slug ] : false;

		if ( is_array( $current ) && is_array( $global ) ) {
			foreach ( $current as $key => $data ) {
				if ( ! isset( $global[ $key ] ) || $data != $global[ $key ] ) { // phpcs:ignore
					return true;
				}
			}
		} elseif ( is_array( $global ) && ! empty( $global ) && empty( $current ) ) { // When the preset rewrite the option that has several values ​​on false.
			return true;
		} else {
			return (string) $current != (string) $global; // phpcs:ignore
		}
	}
}

if ( ! function_exists( 'woodmart_has_sidebar_in_page' ) ) {
	/**
	 * Check if page has sidebar.
	 *
	 * @return mixed
	 */
	function woodmart_has_sidebar_in_page() {
		return Registry::getInstance()->layout->has_sidebar_in_page();
	}
}

if ( ! function_exists( 'woodmart_is_core_installed' ) ) {
	/**
	 * Check if Woodmart Core plugin is installed.
	 *
	 * @return bool
	 */
	function woodmart_is_core_installed() {
		return defined( 'WOODMART_CORE_PLUGIN_VERSION' );
	}
}

if ( ! function_exists( 'woodmart_is_elementor_installed' ) ) {
	/**
	 * Check if Elementor is activated
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	function woodmart_is_elementor_installed() {
		return did_action( 'elementor/loaded' ) && 'elementor' === woodmart_get_current_page_builder();
	}
}

if ( ! function_exists( 'woodmart_is_elementor_pro_installed' ) ) {
	/**
	 * Check if Elementor PRO is activated
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	function woodmart_is_elementor_pro_installed() {
		return defined( 'ELEMENTOR_PRO_VERSION' ) && woodmart_is_elementor_installed();
	}
}

if ( ! function_exists( 'woodmart_is_css_encode' ) ) {
	/**
	 * Check if CSS is encoded.
	 *
	 * @param string $data Data.
	 * @return bool
	 */
	function woodmart_is_css_encode( $data ) {
		return strlen( $data ) > 50;
	}
}

if ( ! function_exists( 'wd_add_cssclass' ) ) {
	/**
	 * Adds a CSS class to a string.
	 *
	 * @since 2.7.0
	 *
	 * @param string $class_to_add  The CSS class to add.
	 * @param string $classes  The string to add the CSS class to.
	 *
	 * @return string The string with the CSS class added.
	 */
	function wd_add_cssclass( $class_to_add, $classes ) {
		if ( empty( $classes ) ) {
			return $class_to_add;
		}

		return $classes . ' ' . $class_to_add;
	}
}

if ( ! function_exists( 'str_contains' ) ) {
	/**
	 * str_contains php8 fix.
	 */
	function str_contains( $haystack, $needle ) {
		return $needle !== '' && mb_strpos( $haystack, $needle ) !== false;
	}
}

if ( ! function_exists( 'woodmart_page_css_files_disable' ) ) {
	/**
	 * Page css files disable.
	 *
	 * @param string $description Term description.
	 * @return string
	 * @since 1.0.0
	 */
	function woodmart_page_css_files_disable( $description ) {
		$GLOBALS['wd_page_css_ignore'] = true;

		return $description;
	}
}

if ( ! function_exists( 'woodmart_page_css_files_enable' ) ) {
	/**
	 * Page css files enable.
	 *
	 * @param string $description Term description.
	 * @return string
	 * @since 1.0.0
	 */
	function woodmart_page_css_files_enable( $description ) {
		unset( $GLOBALS['wd_page_css_ignore'] );

		return $description;
	}
}

if ( ! function_exists( 'woodmart_cookie_secure_param' ) ) {
	/**
	 * Cookie secure param.
	 *
	 * @since 1.0.0
	 */
	function woodmart_cookie_secure_param() {
		return apply_filters( 'woodmart_cookie_secure_param', is_ssl() );
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_selectors_array' ) ) {
	/**
	 * Get selectors array.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_selectors_array() {
		return woodmart_get_config( 'typography-selectors' );
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_css_files_name_array' ) ) {
	/**
	 * Get css files array.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_css_files_name_array() {
		return woodmart_get_theme_settings_css_files_array( 'name' );
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_css_files_array' ) ) {
	/**
	 * Get css files array.
	 *
	 * @param string $name_format Result name format.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_css_files_array( $name_format = 'title' ) {
		$config_styles  = woodmart_get_config( 'css-files' );
		$styles_options = array();

		foreach ( $config_styles as $key => $styles ) {
			foreach ( $styles as $style ) {
				if ( isset( $styles_options[ $style['name'] ] ) ) {
					continue;
				}

				$styles_options[ $key ] = array(
					'name'  => $style['title'],
					'value' => $key,
				);

				if ( 'name' === $name_format ) {
					$styles_options[ $key ]['name'] = 'wd-' . $style['name'] . '-css';
				}
			}
		}

		asort( $styles_options );

		return $styles_options;
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_js_scripts_files_array' ) ) {
	/**
	 * Get js files array.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_js_scripts_files_array() {
		$config_scripts  = woodmart_get_config( 'js-scripts' );
		$scripts_options = array();

		foreach ( $config_scripts as $key => $scripts ) {
			foreach ( $scripts as $script ) {
				if ( isset( $scripts_options[ $script['name'] ] ) ) {
					continue;
				}

				$scripts_options[ $script['name'] ] = array(
					'name'  => $script['title'],
					'value' => $script['name'],
				);
			}
		}

		asort( $scripts_options );

		return $scripts_options;
	}
}

if ( ! function_exists( 'woodmart_get_current_page_builder' ) ) {
	/**
	 * Get current page builder.
	 * If both builders are activated then 'wpb' will be returned.
	 * If no builder is active, an empty ribbon will be returned.
	 *
	 * @since 6.1.0
	 */
	function woodmart_get_current_page_builder() {
		if ( defined( 'WPB_VC_VERSION' ) ) {
			return 'wpb';
		}

		if ( did_action( 'elementor/loaded' ) ) {
			return 'elementor';
		}

		return 'gutenberg';
	}
}

if ( ! function_exists( 'woodmart_is_blog_design_new' ) ) {
	/**
	 * Is blog design new.
	 *
	 * @since 6.1.0
	 *
	 * @param string $design Design.
	 */
	function woodmart_is_blog_design_new( $design ) {
		$old = array(
			'default',
			'default-alt',
			'small-images',
			'chess',
			'masonry',
			'mask',
		);

		return ! in_array( $design, $old, true );
	}
}

if ( ! function_exists( 'woodmart_get_blog_design_name' ) ) {
	/**
	 * Is blog design new.
	 *
	 * @param string $design Design.
	 * @param string $default Default design.
	 * @return string
	 * @since 6.1.0
	 */
	function woodmart_get_blog_design_name( $design, $default = 'default' ) {
		$old = array(
			'default',
			'small-images',
			'chess',
			'masonry',
			'mask',
		);

		return ! in_array( $design, $old, true ) ? $design : $default;
	}
}

if ( ! function_exists( 'woodmart_get_element_template' ) ) {
	/**
	 * Loads a template part into a template.
	 *
	 * @since 6.1.0
	 *
	 * @param string $element_name  Template name.
	 * @param array  $args          Arguments.
	 * @param string $template_name Module name.
	 */
	function woodmart_get_element_template( $element_name, $args, $template_name ) {
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args ); // phpcs:ignore
		}

		include WOODMART_THEMEROOT . '/inc/template-tags/elements/' . $element_name . '/' . $template_name;
	}
}

if ( ! function_exists( 'woodmart_get_old_classes' ) ) {
	/**
	 * Get old classes.
	 *
	 * @since 6.0.0
	 *
	 * @param string $classes Classes.
	 *
	 * @return string
	 */
	function woodmart_get_old_classes( $classes ) {
		if ( ! apply_filters( 'woodmart_show_deprecated_css_classes', false ) ) {
			$classes = '';
		}

		return esc_html( $classes );
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_selectors_array' ) ) {
	/**
	 * Get selectors array.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_selectors_array() {
		return woodmart_get_config( 'typography-selectors' );
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_buttons_selectors_array' ) ) {
	/**
	 * Get buttons selectors array.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_buttons_selectors_array() {
		return woodmart_get_config( 'buttons-selectors' );
	}
}

if ( ! function_exists( 'woodmart_get_current_url' ) ) {
	/**
	 * Get current url.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function woodmart_get_current_url() {
		global $wp;

		return home_url( $wp->request );
	}
}

if ( ! function_exists( 'woodmart_get_document_title' ) ) {
	/**
	 * Returns document title for the current page.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	function woodmart_get_document_title() {
		$title = wp_get_document_title();

		$post_meta = get_post_meta( woodmart_get_the_ID(), '_yoast_wpseo_title', true );
		if ( is_object( get_queried_object() ) && property_exists( get_queried_object(), 'term_id' ) && function_exists( 'YoastSEO' ) ) {
			$taxonomy_helper = YoastSEO()->helpers->taxonomy;
			$meta            = $taxonomy_helper->get_term_meta( get_queried_object() );

			if ( isset( $meta['wpseo_title'] ) && $meta['wpseo_title'] ) {
				$title = wpseo_replace_vars( $meta['wpseo_title'], get_queried_object() );
			}
		} elseif ( $post_meta && function_exists( 'wpseo_replace_vars' ) ) {
			$title = wpseo_replace_vars( $post_meta, get_post( woodmart_get_the_ID() ) );
		}

		return $title;
	}
}

if ( ! function_exists( 'woodmart_get_new_size_classes' ) ) {
	/**
	 * Get new size classes.
	 *
	 * @param mixed $element Element.
	 * @param mixed $old_key Old key.
	 * @param mixed $selector Selector.
	 *
	 * @return string
	 */
	function woodmart_get_new_size_classes( $element, $old_key, $selector ) {
		$array = array(
			'banner'       => array(
				'small'       => array(
					'subtitle' => 'xs',
					'title'    => 's',
				),
				'default'     => array(
					'subtitle' => 'xs',
					'title'    => 'l',
					'content'  => 'xs',
				),
				'large'       => array(
					'subtitle' => 's',
					'title'    => 'xl',
					'content'  => 'm',
				),
				'extra-large' => array(
					'subtitle' => 'm',
					'title'    => 'xxl',
				),
				'medium'      => array(
					'content' => 's',
				),
			),
			'infobox'      => array(
				'small'       => array(
					'subtitle' => 'xs',
					'title'    => 's',
				),
				'default'     => array(
					'subtitle' => 'xs',
					'title'    => 'm',
				),
				'large'       => array(
					'subtitle' => 's',
					'title'    => 'xl',
				),
				'extra-large' => array(
					'subtitle' => 'm',
					'title'    => 'xxl',
				),
			),
			'title'        => array(
				'small'       => array(
					'subtitle'    => 'xs',
					'title'       => 'm',
					'after_title' => 'xs',
				),
				'default'     => array(
					'subtitle'    => 'xs',
					'title'       => 'l',
					'after_title' => 'xs',
				),
				'medium'      => array(
					'subtitle'    => 'xs',
					'title'       => 'xl',
					'after_title' => 's',
				),
				'large'       => array(
					'subtitle'    => 'xs',
					'title'       => 'xxl',
					'after_title' => 's',
				),
				'extra-large' => array(
					'subtitle'    => 'm',
					'title'       => 'xxxl',
					'after_title' => 's',
				),
			),
			'text'         => array(
				'small'       => array(
					'title' => 'm',
				),
				'default'     => array(
					'title' => 'l',
				),
				'medium'      => array(
					'title' => 'xl',
				),
				'large'       => array(
					'title' => 'xxl',
				),
				'extra-large' => array(
					'title' => 'xxxl',
				),
			),
			'list'         => array(
				'default'     => array(
					'text' => 'xs',
				),
				'medium'      => array(
					'text' => 's',
				),
				'large'       => array(
					'text' => 'm',
				),
				'extra-large' => array(
					'text' => 'l',
				),
			),
			'testimonials' => array(
				'small'  => array(
					'text' => 'xs',
				),
				'medium' => array(
					'text' => 's',
				),
				'large'  => array(
					'text' => 'm',
				),
			),
		);

		return isset( $array[ $element ][ $old_key ][ $selector ] ) ? 'wd-fontsize-' . $array[ $element ][ $old_key ][ $selector ] : '';
	}
}

if ( ! function_exists( 'woodmart_vc_parse_multi_attribute' ) ) {
	function woodmart_vc_parse_multi_attribute( $value ) {
		$result = array(
			'url'    => '',
			'title'  => '',
			'target' => '',
			'rel'    => '',
		);

		if ( $value && ! is_array( $value ) && strpos( $value, 'url:' ) === false && strpos( $value, 'title:' ) === false && strpos( $value, 'target:' ) === false && strpos( $value, 'rel:' ) === false ) { // Fix for widget Banner.
			$result['url'] = $value;

			return $result;
		}

		if ( is_array( $value ) ) {
			$params_pairs = $value;
		} else {
			$params_pairs = explode( '|', $value );
		}

		if ( ! empty( $params_pairs ) ) {
			foreach ( $params_pairs as $pair ) {
				$param = preg_split( '/\:/', $pair );
				if ( ! empty( $param[0] ) && isset( $param[1] ) ) {
					$result[ $param[0] ] = rawurldecode( $param[1] );
				}
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'woodmart_get_size_guides_array' ) ) {
	/**
	 * Get size guides array.
	 *
	 * @param string $style Array style.
	 * @return array|string[]
	 */
	function woodmart_get_size_guides_array( $style = 'default' ) {
		if ( 'default' === $style ) {
			$output = array(
				esc_html__( 'Select', 'woodmart' ) => '',
				esc_html__( 'Inherit current product', 'woodmart' ) => 'inherit',
			);
		} elseif ( 'elementor' === $style ) {
			$output = array(
				'0'       => esc_html__( 'Select', 'woodmart' ),
				'inherit' => esc_html__( 'Inherit current product', 'woodmart' ),
			);
		}

		$posts = get_posts(
			array(
				'posts_per_page' => 200, // phpcs:ignore
				'post_type'      => 'woodmart_size_guide',
			)
		);

		foreach ( $posts as $post ) {
			if ( 'default' === $style ) {
				$output[ $post->post_title ] = $post->ID;
			} elseif ( 'elementor' === $style ) {
				$output[ $post->ID ] = $post->post_title;
			}
		}

		return $output;
	}
}

if ( ! function_exists( 'woodmart_remove_https' ) ) {
	/**
	 * Remove https.
	 *
	 * @param string $link Link.
	 * @return string
	 */
	function woodmart_remove_https( $link ) {
		return preg_replace( '#^https?:#', '', $link );
	}
}

if ( ! function_exists( 'woodmart_needs_header' ) ) {
	/**
	 * Check if page needs header.
	 *
	 * @return bool
	 */
	function woodmart_needs_header() {
		return ( ! isset( $GLOBALS['wd_maintenance'] ) && ! is_singular( 'woodmart_slide' ) && ! is_singular( 'cms_block' ) );
	}
}

if ( ! function_exists( 'woodmart_needs_footer' ) ) {
	/**
	 * Check if page needs footer.
	 *
	 * @return bool
	 */
	function woodmart_needs_footer() {
		return ( ! isset( $GLOBALS['wd_maintenance'] ) && ! is_singular( 'woodmart_slide' ) && ! is_singular( 'cms_block' ) );
	}
}

if ( ! function_exists( 'woodmart_is_blog_archive' ) ) {
	/**
	 * Check if current page is blog archive.
	 *
	 * @return bool
	 */
	function woodmart_is_blog_archive() {
		return ( is_home() || ( is_search() && ( ! isset( $_GET['post_type'] ) || 'product' !== $_GET['post_type'] ) ) || is_tag() || is_category() || is_date() || is_author() ); // phpcs:ignore
	}
}

if ( ! function_exists( 'woodmart_is_portfolio_archive' ) ) {
	/**
	 * Check if current page is portfolio archive.
	 *
	 * @return bool
	 */
	function woodmart_is_portfolio_archive() {
		return ( is_post_type_archive( 'portfolio' ) || is_tax( 'project-cat' ) );
	}
}

if ( ! function_exists( 'woodmart_get_config' ) ) {
	/**
	 * Get config file.
	 *
	 * @param string $name Config name.
	 * @return mixed
	 */
	function woodmart_get_config( $name ) {
		return Config::get_instance()->get_config( $name );
	}
}

if ( ! function_exists( 'woodmart_tpl2id' ) ) {
	/**
	 * Get page ID by it's template name.
	 *
	 * @param string $tpl Template name.
	 * @return int|void
	 */
	function woodmart_tpl2id( $tpl = '' ) {
		$pages = get_pages(
			array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => $tpl,
			)
		);
		foreach ( $pages as $page ) {
			return $page->ID;
		}
	}
}

if ( ! function_exists( 'woodmart_get_portfolio_page_id' ) ) {
	/**
	 * Get portfolio page id.
	 */
	function woodmart_get_portfolio_page_id() {
		return woodmart_get_opt( 'portfolio_page' ) ? woodmart_get_opt( 'portfolio_page' ) : woodmart_tpl2id( 'portfolio.php' );
	}
}

if ( ! function_exists( 'ar' ) ) {
	/**
	 * Function print array within a pre tags.
	 *
	 * @param mixed $array Value.
	 * @return void
	 */
	function ar( $array ) {
		echo '<pre>';
			print_r( $array ); // phpcs:ignore
		echo '</pre>';
	}
}

if ( ! function_exists( 'woodmart_http' ) ) {
	/**
	 * Get protocol (http or https).
	 *
	 * @return string
	 */
	function woodmart_http() {
		if ( ! is_ssl() ) {
			return 'http';
		} else {
			return 'https';
		}
	}
}

if ( ! function_exists( 'woodmart_get_theme_info' ) ) {
	/**
	 * Get theme info.
	 *
	 * @param string $parameter Parameter.
	 * @return array|false|string
	 */
	function woodmart_get_theme_info( $parameter ) {
		$theme_info = wp_get_theme();
		if ( is_child_theme() && is_object( $theme_info->parent() ) ) {
			$theme_info = wp_get_theme( $theme_info->parent()->template );
		}
			return $theme_info->get( $parameter );
	}
}

if ( ! function_exists( 'woodmart_is_social_link_enable' ) ) {
	/**
	 * Check if social link is enabled.
	 *
	 * @param string $type Social type.
	 * @return bool
	 */
	function woodmart_is_social_link_enable( $type ) {
		$result = false;
		if ( 'share' === $type && ( woodmart_get_opt( 'share_fb' ) || woodmart_get_opt( 'share_twitter' ) || woodmart_get_opt( 'share_linkedin' ) || woodmart_get_opt( 'share_pinterest' ) || woodmart_get_opt( 'share_ok' ) || woodmart_get_opt( 'share_whatsapp' ) || woodmart_get_opt( 'share_email' ) || woodmart_get_opt( 'share_vk' ) || woodmart_get_opt( 'share_tg' ) || woodmart_get_opt( 'share_viber' ) ) ) {
			$result = true;
		}

		if ( 'follow' === $type && ( woodmart_get_opt( 'fb_link' ) || woodmart_get_opt( 'twitter_link' ) || woodmart_get_opt( 'bluesky_link' ) || woodmart_get_opt( 'google_link' ) || woodmart_get_opt( 'isntagram_link' ) || woodmart_get_opt( 'threads_link' ) || woodmart_get_opt( 'pinterest_link' ) || woodmart_get_opt( 'youtube_link' ) || woodmart_get_opt( 'tumblr_link' ) || woodmart_get_opt( 'linkedin_link' ) || woodmart_get_opt( 'vimeo_link' ) || woodmart_get_opt( 'flickr_link' ) || woodmart_get_opt( 'github_link' ) || woodmart_get_opt( 'dribbble_link' ) || woodmart_get_opt( 'behance_link' ) || woodmart_get_opt( 'soundcloud_link' ) || woodmart_get_opt( 'spotify_link' ) || woodmart_get_opt( 'ok_link' ) || woodmart_get_opt( 'whatsapp_link' ) || woodmart_get_opt( 'vk_link' ) || woodmart_get_opt( 'snapchat_link' ) || woodmart_get_opt( 'tg_link' ) || woodmart_get_opt( 'tiktok_link' ) || woodmart_get_opt( 'discord_link' ) || woodmart_get_opt( 'yelp_link' ) || woodmart_get_opt( 'social_email_links' ) ) ) {
			$result = true;
		}

		return $result;
	}
}

if ( ! function_exists( 'woodmart_is_svg' ) ) {
	/**
	 * Check if image is SVG.
	 *
	 * @param string $src Image source.
	 * @return bool
	 */
	function woodmart_is_svg( $src ) {
		return 'svg' === substr( $src, -3, 3 );
	}
}

if ( ! function_exists( 'woodmart_get_explode_size' ) ) {
	/**
	 * Get explode size.
	 *
	 * @param string $img_size Image size.
	 * @param string $default_size Default size.
	 * @return array|string[]
	 */
	function woodmart_get_explode_size( $img_size, $default_size ) {
		$sizes = explode( 'x', $img_size );
		if ( count( $sizes ) < 2 ) {
			$sizes[0] = $default_size;
			$sizes[1] = $default_size;
		}
		return $sizes;
	}
}

if ( ! function_exists( 'woodmart_is_license_activated' ) ) {
	/**
	 * Check is theme is activated with a purchase code.
	 *
	 * @return boolean
	 */
	function woodmart_is_license_activated() {
		return get_option( 'woodmart_is_activated', false );
	}
}

if ( ! function_exists( 'woodmart_get_allowed_html' ) ) {
	/**
	 * Return allowed html tags
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function woodmart_get_allowed_html() {
		return apply_filters(
			'woodmart_allowed_html',
			array(
				'h1'     => array(),
				'h2'     => array(),
				'h3'     => array(),
				'h4'     => array(),
				'h5'     => array(),
				'h6'     => array(),
				'pre'    => array(),
				'p'      => array(),
				'br'     => array(),
				'i'      => array(),
				'b'      => array(),
				'u'      => array(),
				'em'     => array(),
				'del'    => array(),
				'a'      => array(
					'href'   => true,
					'class'  => true,
					'target' => true,
					'title'  => true,
					'rel'    => true,
				),
				'strong' => array(),
				'span'   => array(
					'style' => true,
					'class' => true,
				),
				'ol'     => array(),
				'ul'     => array(),
				'li'     => array(),
			)
		);
	}
}

if ( ! function_exists( 'woodmart_clean' ) ) {
	/**
	 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
	 * Non-scalar values are ignored.
	 *
	 * @param string|array $var Data to sanitize.
	 * @return string|array
	 */
	function woodmart_clean( $var ) {
		if ( is_array( $var ) ) {
			return array_map( 'woodmart_clean', $var );
		} else {
			return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		}
	}
}

if ( ! function_exists( 'woodmart_get_mailchimp_forms' ) ) {
	/**
	 * This function return form list for mailchimp.
	 *
	 * @return array
	 */
	function woodmart_get_mailchimp_forms() {
		$forms = get_posts(
			array(
				'post_type'   => 'mc4wp-form',
				'numberposts' => -1,
			)
		);

		$mailchimp_forms = array();

		if ( $forms ) {
			foreach ( $forms as $form ) {
				$mailchimp_forms[ $form->post_title ] = $form->ID;
			}
		}

		return $mailchimp_forms;
	}
}

if ( ! function_exists( 'woodmart_is_compressed_data' ) ) {
	/**
	 * Check $variable to compressed.
	 *
	 * @param string $variable need check data.
	 * @return bool
	 */
	function woodmart_is_compressed_data( $variable ) {
		if ( ! function_exists( 'woodmart_compress' ) || ! function_exists( 'woodmart_decompress' ) ) {
			return '';
		}
		return woodmart_compress( woodmart_decompress( $variable ) ) === $variable;
	}
}

if ( ! function_exists( 'woodmart_get_center_coords' ) ) {
	/**
	 * This function accepts a list of coords and returns a prepared array with the coordinates of the center.
	 * If the token list is empty, the method will return an empty array.
	 *
	 * @param array $coords List of coords.
	 * @return array
	 */
	function woodmart_get_center_coords( $coords ) {
		if ( empty( $coords ) ) {
			return array();
		}

		$count_coords = count( $coords );
		$xcos         = 0.0;
		$ycos         = 0.0;
		$zsin         = 0.0;

		foreach ( $coords as $lnglat ) {
			$lat = floatval( $lnglat['lat'] ) * pi() / 180;
			$lon = floatval( $lnglat['lng'] ) * pi() / 180;

			$acos  = cos( $lat ) * cos( $lon );
			$bcos  = cos( $lat ) * sin( $lon );
			$csin  = sin( $lat );
			$xcos += $acos;
			$ycos += $bcos;
			$zsin += $csin;
		}

		$xcos /= $count_coords;
		$ycos /= $count_coords;
		$zsin /= $count_coords;
		$lon   = atan2( $ycos, $xcos );
		$sqrt  = sqrt( $xcos * $xcos + $ycos * $ycos );
		$lat   = atan2( $zsin, $sqrt );

		return array( $lat * 180 / pi(), $lon * 180 / pi() );
	}
}
