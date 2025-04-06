<?php

use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_stock_status' ) ) {
	function wd_gutenberg_single_product_stock_status( $block_attributes ) {
		ob_start();

		Main::setup_preview();

		global $product;
		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-stock-status<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php if ( ! $product->is_type( 'variable' ) ) : ?>
					<?php echo wc_get_stock_html( $product ); ?>
				<?php endif; ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
