<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_shop_archive_extra_description' ) ) {
	function wd_gutenberg_shop_archive_extra_description( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() || wp_is_serving_rest_request() ) {
			return '';
		}

		$classes = '';

		if ( ! empty( $block_attributes['textAlign'] ) || ! empty( $block_attributes['textAlignTablet'] ) || ! empty( $block_attributes['textAlignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		Main::setup_preview();

		ob_start();

		woodmart_get_extra_description_category();

		$content = ob_get_clean();

		if ( ! $content ) {
			Main::restore_preview();

			return '';
		}

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-shop-desc<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes, $classes ) ); ?>">
				<?php echo $content; // phpcs:ignore  ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
