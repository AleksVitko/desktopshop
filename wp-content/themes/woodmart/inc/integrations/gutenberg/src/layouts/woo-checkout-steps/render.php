<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_woo_checkout_step' ) ) {
	function wd_gutenberg_woo_checkout_step( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$classes = '';

		if ( ! empty( $block_attributes['textAlign'] ) || ! empty( $block_attributes['textAlignTablet'] ) || ! empty( $block_attributes['textAlignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		if ( wp_is_serving_rest_request() && ! is_checkout() && ! is_cart() ) {
			add_filter( 'woocommerce_is_checkout', '__return_true', 100 );
		}

		Main::setup_preview();

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-checkout-steps-wrapp<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes, $classes ) ); ?>">
				<?php woodmart_checkout_steps(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
