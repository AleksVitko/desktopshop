<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_title' ) ) {
	function wd_gutenberg_single_product_title( $block_attributes ) {
		$classes = '';

		if ( ! empty( $block_attributes['textAlign'] ) || ! empty( $block_attributes['textAlignTablet'] ) || ! empty( $block_attributes['textAlignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		ob_start();

		Main::setup_preview();
		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-title<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes, $classes ) ); ?>">
				<?php wc_get_template( 'single-product/title.php' ); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
