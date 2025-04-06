<?php

use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_shop_archive_filters_area' ) ) {
	function wd_gutenberg_shop_archive_filters_area( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() || wp_is_serving_rest_request() ) {
			return '';
		}

		ob_start();

		Main::setup_preview();

		woodmart_shop_filters_area(
			array(
				'id'      => wd_get_gutenberg_element_id( $block_attributes ),
				'classes' => 'wd-shop-filters-area' . wd_get_gutenberg_element_classes( $block_attributes ),
			)
		);

		Main::restore_preview();

		return ob_get_clean();
	}
}
