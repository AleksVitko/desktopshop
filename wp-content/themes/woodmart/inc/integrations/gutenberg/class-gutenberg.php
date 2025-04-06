<?php
/**
 * Gutenberg blocks class.
 *
 * @package Woodmart
 */

namespace XTS\Gutenberg;

use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Gutenberg module.
 *
 * @package Woodmart
 */
class Gutenberg extends Singleton {
	/**
	 * Register new controls.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'init', array( $this, 'files_include' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts_styles' ), 30 );
		add_filter( 'pre_render_block', array( $this, 'pre_render_block' ), 10, 2 );
	}

	/**
	 * Include module files.
	 *
	 * @since 1.0.0
	 */
	public function files_include() {
		if ( ! woodmart_get_opt( 'gutenberg_blocks' ) ) {
			return;
		}

		$files = array(
			'integrations/gutenberg/helpers',
			'integrations/gutenberg/inc/class-block-css',
			'integrations/gutenberg/inc/class-block-attributes',
			'integrations/gutenberg/inc/class-template-library',
			'integrations/gutenberg/class-block',
			'integrations/gutenberg/class-post-css',
			'integrations/gutenberg/class-blocks-assets',
			'integrations/gutenberg/class-google-fonts',
			'integrations/gutenberg/class-widget-block',

			// Controls CSS helpers.
			'/integrations/gutenberg/src/components/controls/position/css',
			'/integrations/gutenberg/src/components/controls/padding/css',
			'/integrations/gutenberg/src/components/controls/margin/css',
			'/integrations/gutenberg/src/components/controls/background/css',
			'/integrations/gutenberg/src/components/controls/advanced/css',
			'/integrations/gutenberg/src/components/controls/transition/css',
			'/integrations/gutenberg/src/components/controls/shape-divider/css',
			'/integrations/gutenberg/src/components/controls/border/css',
			'/integrations/gutenberg/src/components/controls/box-shadow/css',
			'/integrations/gutenberg/src/components/controls/typography/css',
			'/integrations/gutenberg/src/components/controls/transform/css',
			'/integrations/gutenberg/src/components/controls/carousel/css',

			// Controls attributes helpers.
			'/integrations/gutenberg/src/components/controls/position/attributes',
			'/integrations/gutenberg/src/components/controls/padding/attributes',
			'/integrations/gutenberg/src/components/controls/margin/attributes',
			'/integrations/gutenberg/src/components/controls/background/attributes',
			'/integrations/gutenberg/src/components/controls/border/attributes',
			'/integrations/gutenberg/src/components/controls/box-shadow/attributes',
			'/integrations/gutenberg/src/components/controls/animation/attributes',
			'/integrations/gutenberg/src/components/controls/parallax-scroll/attributes',
			'/integrations/gutenberg/src/components/controls/responsive-visibility/attributes',
			'/integrations/gutenberg/src/components/controls/transition/attributes',
			'/integrations/gutenberg/src/components/controls/shape-divider/attributes',
			'/integrations/gutenberg/src/components/controls/typography/attributes',
			'/integrations/gutenberg/src/components/controls/advanced-color-picker/attributes',
			'/integrations/gutenberg/src/components/controls/transform/attributes',
			'/integrations/gutenberg/src/components/controls/advanced/attributes',
			'/integrations/gutenberg/src/components/controls/carousel/attributes',

			// Block attributes helpers.
			'/integrations/gutenberg/src/blocks/products/attributes',
			'/integrations/gutenberg/src/blocks/product-categories/attributes',
			'/integrations/gutenberg/src/blocks/blog/attributes',
			'/integrations/gutenberg/src/blocks/portfolio/attributes',
			'/integrations/gutenberg/src/blocks/product-filters/product-filters/attributes',
			'/integrations/gutenberg/src/blocks/product-filters/product-filters-attributes/attributes',
			'/integrations/gutenberg/src/blocks/product-filters/product-filters-categories/attributes',
			'/integrations/gutenberg/src/blocks/product-filters/product-filters-stock-status/attributes',
			'/integrations/gutenberg/src/blocks/product-filters/product-filters-prices/attributes',
			'/integrations/gutenberg/src/blocks/product-filters/product-filters-orderby/attributes',
			'/integrations/gutenberg/src/blocks/brands/attributes',
			'/integrations/gutenberg/src/blocks/social-buttons/attributes',
			'/integrations/gutenberg/src/blocks/hotspot-product/attributes',
			'/integrations/gutenberg/src/blocks/menu/attributes',
			'/integrations/gutenberg/src/blocks/ajax-search/attributes',
			'/integrations/gutenberg/src/blocks/instagram/attributes',
			'/integrations/gutenberg/src/blocks/sidebar/attributes',
			'/integrations/gutenberg/src/blocks/contact-form-7/attributes',
			'/integrations/gutenberg/src/blocks/mailchimp/attributes',
			'/integrations/gutenberg/src/blocks/container/attributes',
			'/integrations/gutenberg/src/blocks/video/attributes',
			'/integrations/gutenberg/src/blocks/slider/attributes',
			'/integrations/gutenberg/src/blocks/google-map/attributes',
			'/integrations/gutenberg/src/blocks/open-street-map/attributes',
			'/integrations/gutenberg/src/blocks/size-guide/attributes',

			// Single product blocks.
			'/integrations/gutenberg/src/layouts/sp-add-to-cart/attributes',
			'/integrations/gutenberg/src/layouts/sp-short-description/attributes',
			'/integrations/gutenberg/src/layouts/sp-title/attributes',
			'/integrations/gutenberg/src/layouts/sp-gallery/attributes',
			'/integrations/gutenberg/src/layouts/sp-content/attributes',
			'/integrations/gutenberg/src/layouts/sp-meta/attributes',
			'/integrations/gutenberg/src/layouts/sp-price/attributes',
			'/integrations/gutenberg/src/layouts/sp-navigation/attributes',
			'/integrations/gutenberg/src/layouts/sp-rating/attributes',
			'/integrations/gutenberg/src/layouts/sp-reviews/attributes',
			'/integrations/gutenberg/src/layouts/sp-stock-progress-bar/attributes',
			'/integrations/gutenberg/src/layouts/sp-additional-info-table/attributes',
			'/integrations/gutenberg/src/layouts/sp-extra-content/attributes',
			'/integrations/gutenberg/src/layouts/sp-brand-info/attributes',
			'/integrations/gutenberg/src/layouts/sp-brands/attributes',
			'/integrations/gutenberg/src/layouts/sp-compare-btn/attributes',
			'/integrations/gutenberg/src/layouts/sp-wishlist-btn/attributes',
			'/integrations/gutenberg/src/layouts/sp-size-guide-btn/attributes',
			'/integrations/gutenberg/src/layouts/sp-stock-status/attributes',
			'/integrations/gutenberg/src/layouts/sp-visitor-counter/attributes',
			'/integrations/gutenberg/src/layouts/sp-dynamic-discount/attributes',
			'/integrations/gutenberg/src/layouts/sp-fbt-products/attributes',
			'/integrations/gutenberg/src/layouts/sp-linked-variations/attributes',
			'/integrations/gutenberg/src/layouts/sp-meta-value/attributes',
			'/integrations/gutenberg/src/layouts/sp-sold-counter/attributes',
			'/integrations/gutenberg/src/layouts/sp-countdown/attributes',
			'/integrations/gutenberg/src/layouts/sp-tabs/attributes',
			'/integrations/gutenberg/src/layouts/sp-estimate-delivery/attributes',

			// Shop archive blocks.
			'/integrations/gutenberg/src/layouts/sa-active-filters/attributes',
			'/integrations/gutenberg/src/layouts/sa-archive-description/attributes',
			'/integrations/gutenberg/src/layouts/sa-archive-extra-description/attributes',
			'/integrations/gutenberg/src/layouts/sa-archive-products/attributes',
			'/integrations/gutenberg/src/layouts/sa-archive-title/attributes',
			'/integrations/gutenberg/src/layouts/sa-filters-area/attributes',
			'/integrations/gutenberg/src/layouts/sa-filters-area-btn/attributes',
			'/integrations/gutenberg/src/layouts/sa-orderby/attributes',
			'/integrations/gutenberg/src/layouts/sa-per-page/attributes',
			'/integrations/gutenberg/src/layouts/sa-result-count/attributes',
			'/integrations/gutenberg/src/layouts/sa-view/attributes',

			// WooCommerce blocks.
			'/integrations/gutenberg/src/layouts/woo-breadcrumbs/attributes',
			'/integrations/gutenberg/src/layouts/woo-checkout-steps/attributes',
			'/integrations/gutenberg/src/layouts/woo-hook/attributes',
			'/integrations/gutenberg/src/layouts/woo-notices/attributes',
			'/integrations/gutenberg/src/layouts/woo-page-title/attributes',
			'/integrations/gutenberg/src/layouts/woo-shipping-progress-bar/attributes',

			// Checkout blocks.
			'/integrations/gutenberg/src/layouts/ch-billing-details/attributes',
			'/integrations/gutenberg/src/layouts/ch-coupon-form/attributes',
			'/integrations/gutenberg/src/layouts/ch-login-form/attributes',
			'/integrations/gutenberg/src/layouts/ch-order-review/attributes',
			'/integrations/gutenberg/src/layouts/ch-payment-methods/attributes',
			'/integrations/gutenberg/src/layouts/ch-shipping-details/attributes',

			// Cart blocks.
			'/integrations/gutenberg/src/layouts/ct-table/attributes',
			'/integrations/gutenberg/src/layouts/ct-totals/attributes',
			'/integrations/gutenberg/src/layouts/ct-empty-cart/attributes',
			'/integrations/gutenberg/src/layouts/ct-free-gifts/attributes',

			'integrations/gutenberg/class-blocks',
		);

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/' . $file . '.php' );
		}
	}

	/**
	 * Styles and scripts to be loaded on backend.
	 *
	 * @return void
	 */
	public function scripts_styles() {
		if ( ! woodmart_get_opt( 'gutenberg_blocks' ) || ! is_admin() ) {
			return;
		}

		wp_register_script( 'xts-blocks', WOODMART_THEME_DIR . '/inc/integrations/gutenberg/build/index.js', array(), WOODMART_VERSION, true );
		wp_register_style( 'xts-blocks', WOODMART_THEME_DIR . '/inc/integrations/gutenberg/build/index.css', array(), WOODMART_VERSION );

		wp_set_script_translations( 'xts-blocks', 'woodmart', trailingslashit( WP_LANG_DIR ) . 'themes' );

		wp_localize_script(
			'xts-blocks',
			'wdBlocksData',
			array(
				'theme_custom_fonts' => $this->get_theme_custom_fonts(),
			)
		);

		wp_enqueue_script(
			'webfontloader',
			'https://ajax.googleapis.com/ajax/libs/webfont/1.5.0/webfont.js',
			array( 'jquery' ),
			'1.5.0',
			true
		);
	}

	/**
	 * Get custom theme fonts.
	 *
	 * @return array
	 */
	public function get_theme_custom_fonts() {
		$custom_fonts_data = woodmart_get_opt( 'multi_custom_fonts' );
		$custom_fonts      = array();
		if ( isset( $custom_fonts_data['{{index}}'] ) ) {
			unset( $custom_fonts_data['{{index}}'] );
		}

		if ( is_array( $custom_fonts_data ) ) {
			foreach ( $custom_fonts_data as $font ) {
				if ( ! $font['font-name'] ) {
					continue;
				}

				$custom_fonts[] = $font['font-name'];
			}
		}

		$typekit_fonts = woodmart_get_opt( 'typekit_fonts' );

		if ( $typekit_fonts ) {
			$typekit = explode( ',', $typekit_fonts );
			foreach ( $typekit as $font ) {
				$custom_fonts[] = trim( $font );
			}
		}

		return $custom_fonts;
	}

	/**
	 * Pre render block hook.
	 *
	 * @param string|null $value The pre-rendered content. Default null.
	 * @param array       $block The block being rendered.
	 */
	public function pre_render_block( $value, $block ) {
		if ( woodmart_get_opt( 'gutenberg_blocks' ) && wp_is_serving_rest_request() && woodmart_woocommerce_installed() && ! empty( $block['blockName'] ) && ( 'wd/products' === $block['blockName'] || 'wd/products-tabs-products' === $block['blockName'] ) ) {
			include_once WC_ABSPATH . 'includes/wc-template-hooks.php';

			woodmart_woocommerce_init_hooks();
		}

		return $value;
	}
}

Gutenberg::get_instance();
