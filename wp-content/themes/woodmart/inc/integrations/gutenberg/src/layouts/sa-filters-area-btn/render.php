<?php

use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_shop_archive_filters_area_btn' ) ) {
	function wd_gutenberg_shop_archive_filters_area_btn( $block_attributes ) {
		ob_start();

		Main::setup_preview();

		woodmart_enqueue_inline_style( 'shop-filter-area' );

		woodmart_filter_buttons(
			array(
				'id'      => wd_get_gutenberg_element_id( $block_attributes ),
				'classes' => 'wd-shop-filters-btn' . wd_get_gutenberg_element_classes( $block_attributes ),
			)
		);

		Main::restore_preview();

		return ob_get_clean();
	}
}
