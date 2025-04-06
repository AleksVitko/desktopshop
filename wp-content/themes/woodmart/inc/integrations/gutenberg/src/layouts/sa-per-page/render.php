<?php

use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
	use XTS\Modules\Layouts\Global_Data as Builder_Data;
	use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_shop_archive_per_page' ) ) {
	function wd_gutenberg_shop_archive_per_page( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		ob_start();

		Main::setup_preview();

		woodmart_enqueue_inline_style( 'woo-shop-el-products-per-page' );

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-shop-prod-per-page<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php woodmart_products_per_page_select( false, $block_attributes ); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
