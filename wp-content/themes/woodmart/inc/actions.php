<?php

use XTS\Modules\Parts_Css_Files;

if( ! function_exists( 'woodmart_body_class' ) ) {
	function woodmart_body_class( $classes ) {
		$site_width           = woodmart_get_opt( 'site_width' );
		$ajax_shop            = woodmart_get_opt( 'ajax_shop' );
		$hide_sidebar_desktop = woodmart_get_opt( 'shop_hide_sidebar_desktop' );
		$catalog_mode         = woodmart_get_opt( 'catalog_mode' );
		$categories_toggle    = woodmart_get_opt( 'categories_toggle' );
		$sticky_footer        = woodmart_get_opt( 'sticky_footer' );
		$dark                 = woodmart_get_opt( 'dark_version' );
		$form_fields_style    = ( woodmart_get_opt( 'form_fields_style' ) ) ? woodmart_get_opt( 'form_fields_style' ) : 'square';
		$form_border_width    = woodmart_get_opt( 'form_border_width' );
		$single_post_design   = woodmart_get_opt( 'single_post_design' );

		if ( $single_post_design == 'large_image' && is_single() ) {
			$classes[] = 'single-post-large-image';
		}

		$classes[] = 'wrapper-' . $site_width;

		if ( 'underlined' === $form_fields_style ) {
			$classes[] = 'form-style-' . $form_fields_style;
		} else {
			$classes[] = woodmart_get_old_classes( ' form-style-' . $form_fields_style );
		}

		$classes[] = woodmart_get_old_classes( ' form-border-width-' . $form_border_width );

		if ( woodmart_woocommerce_installed() && ( is_shop() || is_product_category() ) && ( $hide_sidebar_desktop && $sticky_footer ) ) {
			$classes[] = 'no-sticky-footer';
		} elseif ( $sticky_footer ) {
			$classes[] = 'sticky-footer-on';
		}

		if ( $dark ) {
			$classes[] = 'global-color-scheme-light';
		}

		if ( $catalog_mode ) {
			$classes[] = 'catalog-mode-on';
		}

		if ( $categories_toggle ) {
			$classes[] = 'categories-accordion-on';
		}

		if ( woodmart_is_shop_archive() ) {
			$classes[] = 'woodmart-archive-shop';
		} elseif ( woodmart_is_portfolio_archive() ) {
			$classes[] = 'woodmart-archive-portfolio';
		} elseif ( woodmart_is_blog_archive() ) {
			$classes[] = 'woodmart-archive-blog';
		}

		// Header banner.
		if ( ! woodmart_get_opt( 'header_close_btn' ) && woodmart_get_opt( 'header_banner' ) && ! isset( $GLOBALS['wd_maintenance'] ) ) {
			$classes[] = 'header-banner-display';
		}
		if ( woodmart_get_opt( 'header_banner' ) && ! isset( $GLOBALS['wd_maintenance'] ) ) {
			$classes[] = 'header-banner-enabled';
		}

		if ( $ajax_shop ) {
			$classes[] = 'woodmart-ajax-shop-on';
		}

		if ( ! is_user_logged_in() && woodmart_get_opt( 'login_prices' ) ) {
			$classes[] = 'login-see-prices';
		}

		if ( woodmart_get_opt( 'sticky_notifications' ) ) {
			$classes[] = 'notifications-sticky';
		}

		if ( woodmart_get_opt( 'sticky_toolbar' ) && ! woodmart_is_maintenance_active() ) {
			$classes[] = 'sticky-toolbar-on';
		}
		if ( woodmart_get_opt( 'hide_larger_price' ) ) {
			$classes[] = 'hide-larger-price';
		}

		if ( ! $catalog_mode && ( is_user_logged_in() || ! woodmart_get_opt( 'login_prices' ) ) && is_singular( 'product' ) && woodmart_get_opt( 'single_sticky_add_to_cart' ) ) {
			$classes[] = 'wd-sticky-btn-on';

			if ( woodmart_get_opt( 'mobile_single_sticky_add_to_cart' ) ) {
				$classes[] = 'wd-sticky-btn-on-mb';
			}
		}

		$classes = array_merge( $classes, woodmart_get_header_body_classes() );

		return $classes;
	}

	add_filter( 'body_class', 'woodmart_body_class' );
}

if ( ! function_exists( 'woodmart_fix_transitions_flicking' ) ) {
	/**
	 * Fix for transitions flicking.
	 *
	 * @since 1.0.0
	 */
	function woodmart_fix_transitions_flicking() {
		echo '<script type="text/javascript" id="wd-flicker-fix">// Flicker fix.</script>';
	}

	add_action( 'wp_body_open', 'woodmart_fix_transitions_flicking', 1 );
}

if ( ! function_exists( 'woodmart_pjax_with_pagination_fix' ) ) {
	/**
	 * Fix for pagination with PJAX.
	 *
	 * @param string $link Link.
	 *
	 * @return false|string
	 */
	function woodmart_pjax_with_pagination_fix( $link ) {
		return remove_query_arg( '_pjax', $link );
	}

	add_filter( 'paginate_links', 'woodmart_pjax_with_pagination_fix' );
}

if( ! function_exists( 'woodmart_enqueue_gallery_script' ) ) {
	function woodmart_enqueue_gallery_script( $html5 ) {
		if ( woodmart_get_opt( 'single_post_justified_gallery' ) ) {
			woodmart_enqueue_js_library( 'magnific' );
			woodmart_enqueue_js_library( 'justified' );
			woodmart_enqueue_inline_style( 'justified' );
			woodmart_enqueue_js_script( 'mfp-popup' );
			woodmart_enqueue_inline_style( 'mfp-popup' );
		}

		return $html5;
	}

	add_filter( 'use_default_gallery_style', 'woodmart_enqueue_gallery_script' );
}

if( ! function_exists( 'woodmart_get_blog_shortcode_ajax' ) ) {
	function woodmart_get_blog_shortcode_ajax() {
		if( ! empty( $_POST['atts'] ) ) {
			$atts = woodmart_clean( $_POST['atts'] );
			$paged = ( empty( $_POST['paged'] ) ) ? 2 : sanitize_text_field( (int) $_POST['paged'] ) + 1;
			$atts['ajax_page'] = $paged;

			if ( ! empty( $atts['offset'] ) ) {
				$atts['offset'] = (int) $atts['offset'] + (int) $paged * (int) $atts['items_per_page'];
			}

			if ( isset( $atts['elementor'] ) && $atts['elementor'] ) {
				$data = woodmart_elementor_blog_template( $atts );
			} else {
				$data = woodmart_shortcode_blog( $atts );
			}

			wp_send_json( $data );

			die();
		}
	}
	add_action( 'wp_ajax_woodmart_get_blog_shortcode', 'woodmart_get_blog_shortcode_ajax' );
	add_action( 'wp_ajax_nopriv_woodmart_get_blog_shortcode', 'woodmart_get_blog_shortcode_ajax' );
}

if( ! function_exists( 'woodmart_get_portfolio_shortcode_ajax' ) ) {
	function woodmart_get_portfolio_shortcode_ajax() {
		if( ! empty( $_POST['atts'] ) ) {
			$atts = woodmart_clean( $_POST['atts'] );
			$paged = (empty($_POST['paged'])) ? 2 : sanitize_text_field( (int) $_POST['paged'] ) + 1;
			$atts['ajax_page'] = $paged;

			if ( isset( $atts['elementor'] ) && $atts['elementor'] ) {
				$data = woodmart_elementor_portfolio_template( $atts );
			} else {
				$data = woodmart_shortcode_portfolio( $atts );
			}

			wp_send_json( $data );

			die();
		}
	}

	add_action( 'wp_ajax_woodmart_get_portfolio_shortcode', 'woodmart_get_portfolio_shortcode_ajax' );
	add_action( 'wp_ajax_nopriv_woodmart_get_portfolio_shortcode', 'woodmart_get_portfolio_shortcode_ajax' );
}

if ( ! function_exists( 'woodmart_get_taxonomies_by_query_autocomplete' ) ) {
	/**
	 * Autocomplete by taxonomies.
	 *
	 * @since 1.0.0
	 */
	function woodmart_get_taxonomies_by_query_autocomplete() {
		check_ajax_referer( 'woodmart_get_taxonomies_by_query_autocomplete_nonce', 'security' );

		$output = array();

		$args = array(
			'number'     => 5,
			'taxonomy'   => $_POST['value'], // phpcs:ignore
			'search'     => isset( $_POST['params']['term'] ) ? $_POST['params']['term'] : '', // phpcs:ignore.
			'hide_empty' => false,
		);

		$terms = get_terms( $args );

		if ( count( $terms ) > 0 ) { // phpcs:ignore
			foreach ( $terms as $term ) {
				$output[] = array(
					'id'   => $term->term_id,
					'text' => $term->name,
				);
			}
		}

		echo wp_json_encode( $output );
		die();
	}

	add_action( 'wp_ajax_woodmart_get_taxonomies_by_query_autocomplete', 'woodmart_get_taxonomies_by_query_autocomplete' );
	add_action( 'wp_ajax_nopriv_woodmart_get_taxonomies_by_query_autocomplete', 'woodmart_get_taxonomies_by_query_autocomplete' );
}

if ( ! function_exists( 'woodmart_get_post_by_query_autocomplete' ) ) {
	/**
	 * Autocomplete by post.
	 *
	 * @since 1.0.0
	 */
	function woodmart_get_post_by_query_autocomplete() {
		check_ajax_referer( 'woodmart_get_post_by_query_autocomplete_nonce', 'security' );

		$output = array();

		$args = array(
			'post_type'   => $_POST['value'],
			's'           => isset( $_POST['params']['term'] ) ? $_POST['params']['term'] : '', // phpcs:ignore
			'post_status' => 'publish',
			'numberposts' => apply_filters( 'woodmart_get_numberposts_by_query_autocomplete', 20 ),
			'exclude'     => isset( $_POST['selected'] ) ? $_POST['selected'] : array(),
		);

		$posts = get_posts( $args );

		if ( count( $posts ) > 0 ) { // phpcs:ignore
			foreach ( $posts as $value ) {
				$output[] = array(
					'id'   => $value->ID,
					'text' => $value->post_title . ' ID:(' . $value->ID . ')',
				);
			}
		}

		echo wp_json_encode( $output );
		die();
	}

	add_action( 'wp_ajax_woodmart_get_post_by_query_autocomplete', 'woodmart_get_post_by_query_autocomplete' );
	add_action( 'wp_ajax_nopriv_woodmart_get_post_by_query_autocomplete', 'woodmart_get_post_by_query_autocomplete' );
}


// **********************************************************************//
// ! Load menu drodpwns with AJAX actions
// **********************************************************************//

if( ! function_exists('woodmart_load_html_dropdowns_action') ) {
	function woodmart_load_html_dropdowns_action() {
		$response = array(
			'status' => 'error',
			'message' => 'Can\'t load HTML blocks with AJAX',
			'data' => array(),
		);

		if ( woodmart_is_elementor_installed() && ! apply_filters( 'woodmart_enqueue_html_dropdowns_inline_style', false ) && isset( $_REQUEST['action'] ) && 'woodmart_load_html_dropdowns' === $_REQUEST['action'] ) {
			add_filter( 'elementor/frontend/builder_content/before_print_css', '__return_false' );
		}

		if( class_exists('WPBMap') )
			WPBMap::addAllMappedShortcodes();

		if( isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {
			$ids = woodmart_clean( $_POST['ids'] );
			foreach ($ids as $id) {
				$id = (int) $id;
				$content = woodmart_get_html_block($id);
				if( ! $content ) continue;

				Parts_Css_Files::get_instance()->reset_styles_configs();

				$response['status'] = 'success';
				$response['message'] = 'At least one HTML block loaded';
				$response['data'][$id] = $content;
			}
		}

		wp_send_json( $response );
	}
	add_action( 'wp_ajax_woodmart_load_html_dropdowns', 'woodmart_load_html_dropdowns_action' );
	add_action( 'wp_ajax_nopriv_woodmart_load_html_dropdowns', 'woodmart_load_html_dropdowns_action' );
}

if ( ! function_exists( 'woodmart_remove_jquery_migrate' ) ) {
	/**
	 * Remove JQuery migrate.
	 *
	 * @param WP_Scripts $scripts wp script object.
	 */
	function woodmart_remove_jquery_migrate( $scripts ) {
		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) && woodmart_get_opt( 'remove_jquery_migrate', false ) ) {
			$script = $scripts->registered['jquery'];
			if ( $script->deps ) {
				$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
			}
		}
	}

	add_action( 'wp_default_scripts', 'woodmart_remove_jquery_migrate' );
}

if ( ! function_exists( 'woodmart_custom_404_page' ) ) {
	/**
	 * Function to set custom 404 page.
	 *
	 * @param string $template Template.
	 *
	 * @return string
	 */
	function woodmart_custom_404_page( $template ) {
		global $wp_query;
		$custom_404 = woodmart_get_opt( 'custom_404_page' );

		if ( 'default' === $custom_404 || empty( $custom_404 ) ) {
			return $template;
		}

		$wp_query->query( 'page_id=' . $custom_404 );
		$wp_query->the_post();
		$template = get_page_template();
		rewind_posts();

		return $template;
	}

	add_filter( '404_template', 'woodmart_custom_404_page', 999 );
}

if ( ! function_exists( 'woodmart_android_browser_bar_color' ) ) {
	/**
	 * Display cart widget side
	 *
	 * @since 1.0.0
	 */
	function woodmart_android_browser_bar_color() {
		$color = woodmart_get_opt( 'android_browser_bar_color' );

		if ( ! empty( $color['idle'] ) ) {
			echo '<meta name="theme-color" content="' . $color['idle'] . '">'; // phpcs:ignore
		}
	}

	add_filter( 'wp_head', 'woodmart_android_browser_bar_color' );
}

if ( ! function_exists( 'woodmart_excerpt_length' ) ) {
	/**
	 * Set excerpt length and more btn.
	 *
	 * @param int $length Length.
	 * @return int
	 */
	function woodmart_excerpt_length( $length ) {
		return 20;
	}

	add_filter( 'excerpt_length', 'woodmart_excerpt_length', 999 );
}

if ( ! function_exists( 'woodmart_new_excerpt_more' ) ) {
	/**
	 * Set excerpt more btn.
	 *
	 * @param string $more More.
	 * @return string
	 */
	function woodmart_new_excerpt_more( $more ) {
		return '';
	}

	add_filter( 'excerpt_more', 'woodmart_new_excerpt_more' );
}

if ( ! function_exists( 'woodmart_wp_title' ) ) {
	/**
	 * Filter wp_title.
	 *
	 * @param string $title Title.
	 * @param string $sep Separator.
	 * @return string
	 */
	function woodmart_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() ) {
			return $title;
		}

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		}

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 ) {
			$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'woodmart' ), max( $paged, $page ) ); // phpcs:ignore
		}

		return $title;
	}

	add_filter( 'wp_title', 'woodmart_wp_title', 10, 2 );
}
