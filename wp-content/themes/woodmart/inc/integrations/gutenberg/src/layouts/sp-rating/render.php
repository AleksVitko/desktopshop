<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_rating' ) ) {
	function wd_gutenberg_single_product_rating( $block_attributes ) {
		$classes = '';

		if ( ! empty( $block_attributes['textAlign'] ) || ! empty( $block_attributes['textAlignTablet'] ) || ! empty( $block_attributes['textAlignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		Main::setup_preview();

		global $product;

		if ( ! wc_review_ratings_enabled() || ! $product->get_rating_count() ) {
			Main::restore_preview();
			return '';
		}

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-rating<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes, $classes ) ); ?>">
				<?php wc_get_template( 'single-product/rating.php' ); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
