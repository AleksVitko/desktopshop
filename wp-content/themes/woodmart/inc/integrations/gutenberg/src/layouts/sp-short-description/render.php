<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_short_description' ) ) {
	function wd_gutenberg_single_product_short_description( $block_attributes ) {
		$classes = '';

		if ( ! empty( $block_attributes['textAlign'] ) || ! empty( $block_attributes['textAlignTablet'] ) || ! empty( $block_attributes['textAlignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		Main::setup_preview();

		global $post;

		$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

		if ( ! $short_description ) {
			Main::restore_preview();

			return '';
		}

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-short-desc<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes, $classes ) ); ?>">
				<?php wc_get_template( 'single-product/short-description.php' ); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
