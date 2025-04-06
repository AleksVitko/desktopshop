<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_countdown' ) ) {
	function wd_gutenberg_single_product_countdown( $block_attributes, $content ) {
		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		if ( ! empty( $block_attributes['textAlign'] ) || ! empty( $block_attributes['textAlignTablet'] ) || ! empty( $block_attributes['textAlignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		if ( ! empty( $block_attributes['size'] ) ) {
			$block_attributes['extra_class'] = 'wd-size-' . $block_attributes['size'];
		}

		Main::setup_preview();

		ob_start();

		woodmart_product_sale_countdown( $block_attributes, $content );

		$content = ob_get_clean();

		if ( ! $content ) {
			Main::restore_preview();

			return '';
		}

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-countdown<?php echo esc_attr( $classes ); ?>">
				<?php echo $content; //phpcs:ignore ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
