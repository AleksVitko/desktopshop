<?php

use XTS\Gutenberg\Post_CSS;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_stock_progress_bar' ) ) {
	function wd_gutenberg_single_product_stock_progress_bar( $block_attributes ) {
		Main::setup_preview();

		$product_id  = get_the_ID();
		$total_stock = (int) get_post_meta( $product_id, 'woodmart_total_stock_quantity', true );

		if ( ! $total_stock ) {
			Main::restore_preview();
			return '';
		}

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-stock-bar<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php woodmart_stock_progress_bar(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
