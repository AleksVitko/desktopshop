<?php

use XTS\Modules\Layouts\Main;
use XTS\Modules\Shipping_Progress_Bar\Main as Shipping_Progress_Bar_Module;

if ( ! function_exists( 'wd_gutenberg_checkout_billing_details' ) ) {
	function wd_gutenberg_checkout_billing_details( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		if ( ! empty( $block_attributes['align'] ) || ! empty( $block_attributes['alignTablet'] ) || ! empty( $block_attributes['alignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		Main::setup_preview();

		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			Main::restore_preview();

			return '';
		}

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-billing-details<?php echo esc_attr( $classes ); ?>">
				<?php WC()->checkout()->checkout_form_billing(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
