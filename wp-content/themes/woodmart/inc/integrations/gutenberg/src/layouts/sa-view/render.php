<?php

use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
	use XTS\Modules\Layouts\Global_Data as Builder_Data;
	use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_shop_archive_view' ) ) {
	function wd_gutenberg_shop_archive_view( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		ob_start();

		Main::setup_preview();

		$block_attributes['products_columns_variations'] = ! empty( $block_attributes['products_columns_variations'] ) ? explode( ',', $block_attributes['products_columns_variations'] ) : array();

		$block_attributes['products_view']    = woodmart_new_get_shop_view( '', true );
		$block_attributes['products_columns'] = woodmart_new_get_products_columns_per_row( '', true );

		woodmart_enqueue_inline_style( 'woo-shop-el-products-view' );

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-shop-view<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php woodmart_products_view_select( false, $block_attributes ); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
