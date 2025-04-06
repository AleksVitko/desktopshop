<?php

use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_shop_archive_active_filter' ) ) {
	function wd_gutenberg_shop_archive_active_filter( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		ob_start();

		Main::setup_preview();

		$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();
		$min_price          = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : 0; // phpcs:ignore.
		$max_price          = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : 0; // phpcs:ignore.
		$rating_filter      = isset( $_GET['rating_filter'] ) ? array_filter( array_map( 'absint', explode( ',', wp_unslash( $_GET['rating_filter'] ) ) ) ) : array(); // phpcs:ignore.

		if ( 0 === count( $_chosen_attributes ) && empty( $min_price ) && empty( $max_price ) && empty( $rating_filter ) ) {
			return '';
		}

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-shop-active-filters<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php woodmart_get_active_filters(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
