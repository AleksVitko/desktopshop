<?php
/**
 * Gutenberg.
 *
 * @package xts
 */

use XTS\Modules\Layouts\Global_Data;
use XTS\Modules\Styles_Storage;

if ( ! function_exists( 'woodmart_gutenberg_deregister_styles' ) ) {
	/**
	 * Remove classic.css from the editor.
	 *
	 * @param object $styles Styles object.
	 * @return void
	 */
	function woodmart_gutenberg_deregister_styles( $styles ) {
		$style = $styles->query( 'wp-editor-classic-layout-styles', 'registered' );
		if ( $style ) {
			$styles->remove( 'wp-editor-classic-layout-styles' );
		}

		$styles->add( 'wp-editor-classic-layout-styles', '', array(), false, 'all' );

	}
	add_action( 'wp_default_styles', 'woodmart_gutenberg_deregister_styles', 20 );
}

if ( ! function_exists( 'woodmart_filter_block_categories_when_post_provided' ) ) {
	/**
	 * Added xtemos category from blocks.
	 *
	 * @param array[]                 $block_categories Array of categories for block types.
	 * @param WP_Block_Editor_Context $editor_context The current block editor context.
	 * @return array[]
	 */
	function woodmart_filter_block_categories_when_post_provided( $block_categories, $editor_context ) {
		array_unshift(
			$block_categories,
			array(
				'slug'  => 'xtemos_woo_elements',
				'title' => __( '[XTemos] WooCommerce', 'woodmart' ),
				'icon'  => null,
			),
			array(
				'slug'  => 'xtemos_single_product',
				'title' => __( '[XTemos] Single product', 'woodmart' ),
				'icon'  => null,
			),
			array(
				'slug'  => 'xtemos_archive_elements',
				'title' => __( '[XTemos] Products archive', 'woodmart' ),
				'icon'  => null,
			),
			array(
				'slug'  => 'xtemos_cart_elements',
				'title' => __( '[XTemos] Cart', 'woodmart' ),
				'icon'  => null,
			),
			array(
				'slug'  => 'xtemos_checkout_elements',
				'title' => __( '[XTemos] Checkout', 'woodmart' ),
				'icon'  => null,
			)
		);

		array_unshift(
			$block_categories,
			array(
				'slug'  => 'xtemos',
				'title' => __( 'Xtemos', 'woodmart' ),
				'icon'  => null,
			)
		);

		return $block_categories;
	}

	add_filter( 'block_categories_all', 'woodmart_filter_block_categories_when_post_provided', 100000, 2 );
}

// Make custom sizes selectable from WordPress admin.
// TODO: register woocommerce sizes here.
if ( ! function_exists( 'woodmart_custom_image_size_names' ) ) {
	/**
	 * Custom sizes for gutenberg controls.
	 *
	 * @param array $sizes Sizes config.
	 * @return array
	 */
	function woodmart_custom_image_size_names( $sizes ) {
		$new_sizes = array(
			'woocommerce_thumbnail' => __( 'WooCommerce Thumbnail', 'woodmart' ),
		);

		return array_merge( $sizes, $new_sizes );
	}

	add_action( 'image_size_names_choose', 'woodmart_custom_image_size_names', 30 );
}

if ( ! function_exists( 'woodmart_gutenberg_disable_svg' ) ) {
	/**
	 * Gutenberg disable svg.
	 */
	function woodmart_gutenberg_disable_svg() {
		if ( woodmart_get_opt( 'disable_gutenberg_css' ) ) {
			remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
			remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		}
	}

	add_action( 'init', 'woodmart_gutenberg_disable_svg' );
}

if ( ! function_exists( 'woodmart_gutenberg_show_widgets' ) ) {
	/**
	 * Gutenberg show widgets.
	 *
	 * @return array
	 */
	function woodmart_gutenberg_show_widgets() {
		return array();
	}

	add_action( 'widget_types_to_hide_from_legacy_widget_block', 'woodmart_gutenberg_show_widgets', 100 );
}

if ( ! function_exists( 'woodmart_gutenberg_custom_scripts' ) ) {
	/**
	 * Gutenberg custom scripts.
	 *
	 * @since 1.0.0
	 */
	function woodmart_gutenberg_custom_scripts() {
		if ( ! woodmart_get_opt( 'gutenberg_blocks' ) || ! is_admin() ) {
			return;
		}

		add_filter( 'woodmart_localized_string_array', 'woodmart_gutenberg_update_localized' );

		woodmart_register_libraries_scripts();
		woodmart_register_scripts();
		woodmart_enqueue_base_scripts();

		wp_enqueue_script( 'imagesloaded' );
		woodmart_enqueue_js_script( 'woodmart-theme' );

		woodmart_enqueue_js_library( 'swiper' );
		woodmart_enqueue_js_library( 'isotope-bundle' );

		woodmart_enqueue_js_script( 'product-hover' );
		woodmart_enqueue_js_script( 'swiper-carousel' );
		woodmart_enqueue_js_script( 'shop-masonry' );
		woodmart_enqueue_js_script( 'masonry-layout' );
		woodmart_enqueue_js_script( 'woocommerce-quantity' );

		woodmart_enqueue_js_library( 'panr-parallax-bundle' );
		woodmart_enqueue_js_script( 'portfolio-effect' );
		woodmart_enqueue_js_script( 'portfolio-wd-nav-portfolios' );

		woodmart_enqueue_js_library( 'countdown-bundle' );

		wp_enqueue_script( 'wd-swiper-elements-bundle', WOODMART_THEME_DIR . '/inc/integrations/gutenberg/assets/js/swiper-element-bundle.min.js', array(), woodmart_get_theme_info( 'Version' ), true );

		wp_deregister_style( 'wc-blocks-style-coming-soon' );
		wp_dequeue_style( 'wc-blocks-style-coming-soon' );
	}

	add_action( 'enqueue_block_assets', 'woodmart_gutenberg_custom_scripts' );
}

if ( ! function_exists( 'woodmart_gutenberg_editor_custom_styles' ) ) {
	/**
	 * Gutenberg styles.
	 *
	 * @since 1.0.0
	 */
	function woodmart_gutenberg_editor_custom_styles() {
		if ( apply_filters( 'woodmart_disable_gutenberg_backend_css', false ) || ! is_admin() ) {
			return;
		}

		$rtl = is_rtl() ? '-rtl' : '';

		wp_enqueue_style( 'wd-gutenberg-editor-style', WOODMART_THEME_DIR . '/css/parts/wp-editor' . $rtl . '.min.css', array(), woodmart_get_theme_info( 'Version' ) );

		if ( woodmart_get_opt( 'gutenberg_blocks' ) ) {
			wp_enqueue_style( 'wd-gutenberg-editor-blocks-style', WOODMART_THEME_DIR . '/css/parts/wp-editor-blocks' . $rtl . '.min.css', array(), woodmart_get_theme_info( 'Version' ) );
		}

		wp_enqueue_style( 'wd-admin-base', WOODMART_ASSETS . '/css/parts/base.min.css', array(), WOODMART_VERSION );

		$bg_settings = array(
			'body[class*="xts-wrapper-boxed"] div.editor-styles-wrapper' => woodmart_get_opt( 'body-background' ),
			'body:not([class*="xts-wrapper-boxed"]) div.editor-styles-wrapper, [class*="xts-wrapper-boxed"] div.is-root-container, body.block-editor-iframe__body' => woodmart_get_opt( 'pages-background' ),
		);
		$storage     = new Styles_Storage( 'theme_settings_default' );

		$icon_font      = woodmart_get_opt(
			'icon_font',
			array(
				'font'   => '1',
				'weight' => '400',
			)
		);
		$font_display   = woodmart_get_opt( 'icons_font_display', 'disable' );
		$icon_font_name = 'woodmart-font-';

		if ( ! empty( $icon_font['font'] ) ) {
			$icon_font_name .= $icon_font['font'];
		}
		if ( ! empty( $icon_font['weight'] ) ) {
			$icon_font_name .= '-' . $icon_font['weight'];
		}

		ob_start();

		?>

		<?php foreach ( $bg_settings as $selector => $value ) : ?>
			<?php if ( ! empty( $value['color'] ) || ! empty( $value['url'] ) ) : ?>
				<?php echo $selector; ?> {
					<?php if ( ! empty( $value['color'] ) ) : ?>
						background-color: <?php echo esc_attr( $value['color'] ); ?>!important;
					<?php endif; ?>
					<?php if ( ! empty( $value['url'] ) ) : ?>
						background-image: url(<?php echo esc_html( $value['url'] ); ?>);

						<?php if ( ! empty( $value['repeat'] ) ) : ?>
							background-repeat: <?php echo esc_attr( $value['repeat'] ); ?>;
						<?php endif; ?>
						<?php if ( ! empty( $value['size'] ) ) : ?>
							background-size: <?php echo esc_attr( $value['size'] ); ?>;
						<?php endif; ?>
						<?php if ( ! empty( $value['attachment'] ) ) : ?>
							background-attachment: <?php echo esc_attr( $value['attachment'] ); ?>;
						<?php endif; ?>
						<?php if ( ! empty( $value['position'] ) ) : ?>
							background-position: <?php echo esc_attr( $value['position'] ); ?>;
						<?php endif; ?>
					<?php endif; ?>
				}
			<?php endif; ?>
		<?php endforeach; ?>

		@font-face { <?php // Added font face with 'http' or 'https' for preview editor in iframe. ?>
			font-weight: normal;
			font-style: normal;
			font-family: "woodmart-font";
			src: url("<?php echo WOODMART_THEME_DIR . '/fonts/' . $icon_font_name . '.woff2?v=' . woodmart_get_theme_info( 'Version' ); //phpcs:ignore ?>") format("woff2");

			<?php if ( 'disable' !== $font_display ) : ?>
				font-display: <?php echo esc_attr( $font_display ); ?>;
			<?php endif; ?>
		}
		<?php

		echo $storage->get_inline_css(); //phpcs:ignore

		$style = ob_get_clean();

		wp_register_style( 'wd-gutenberg-editor-custom', false );
		wp_enqueue_style( 'wd-gutenberg-editor-custom' );
		wp_add_inline_style( 'wd-gutenberg-editor-custom', $style );
	}

	// TODO: Check this hook later. They should fix something there to load Google fonts properly.
	add_action( 'enqueue_block_assets', 'woodmart_gutenberg_editor_custom_styles', 30 );
}

if ( ! function_exists( 'woodmart_gutenberg_update_localized' ) ) {
	/**
	 * Gutenberg update localized settings.
	 *
	 * @param array $localized Localized settings.
	 * @return array
	 */
	function woodmart_gutenberg_update_localized( $localized ) {
		$localized['google_map_api_key'] = woodmart_get_opt( 'google_map_api_key', '' );

		return $localized;
	}
}

if ( ! function_exists( 'woodmart_gutenberg_enabled_sidebar_button' ) ) {
	/**
	 * Enable sticky sidebar button.
	 *
	 * @param string $block_content Block content.
	 * @return string
	 */
	function woodmart_gutenberg_enabled_sidebar_button( $block_content ) {
		Global_Data::get_instance()->set_data( 'wd_show_sticky_sidebar_button', true );

		return $block_content;
	}

	add_action( 'render_block_wd/off-canvas-button', 'woodmart_gutenberg_enabled_sidebar_button' );
}
