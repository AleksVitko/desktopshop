<?php

use XTS\Modules\Layouts\Main;
use XTS\Modules\Shipping_Progress_Bar\Main as Shipping_Progress_Bar_Module;

if ( ! function_exists( 'wd_gutenberg_cart_total' ) ) {
	function wd_gutenberg_cart_total( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		Main::setup_preview();

		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			Main::restore_preview();

			return '';
		}

		$nonce_value = wc_get_var( $_REQUEST['woocommerce-shipping-calculator-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) ); // @codingStandardsIgnoreLine.

		// Update Shipping. Nonce check uses new value and old value (woocommerce-cart). @todo remove in 4.0.
		if ( ! empty( $_POST['calc_shipping'] ) && ( wp_verify_nonce( $nonce_value, 'woocommerce-shipping-calculator' ) || wp_verify_nonce( $nonce_value, 'woocommerce-cart' ) ) ) { // WPCS: input var ok.
			$shortcode_cart = new WC_Shortcode_Cart();
			$shortcode_cart->calculate_shipping();
		}

		WC()->cart->calculate_fees();
		WC()->cart->calculate_shipping();
		WC()->cart->calculate_totals();

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-cart-totals<?php echo esc_attr( $classes ); ?>">
				<?php woocommerce_cart_totals(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
