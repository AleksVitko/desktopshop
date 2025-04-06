<?php

use XTS\Modules\Layouts\Global_Data as Builder;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_price' ) ) {
	function wd_gutenberg_single_product_price( $block_attributes ) {
		$classes = '';

		if ( ! empty( $block_attributes['align'] ) || ! empty( $block_attributes['alignTablet'] ) || ! empty( $block_attributes['alignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		ob_start();

		Main::setup_preview();
		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-price<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes, $classes ) ); ?>">
				<?php wc_get_template( 'single-product/price.php' ); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
