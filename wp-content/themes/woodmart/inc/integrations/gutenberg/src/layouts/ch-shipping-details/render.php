<?php

use XTS\Modules\Layouts\Main;
use XTS\Modules\Shipping_Progress_Bar\Main as Shipping_Progress_Bar_Module;

if ( ! function_exists( 'wd_gutenberg_checkout_shipping_details' ) ) {
	function wd_gutenberg_checkout_shipping_details( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		Main::setup_preview();

		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			Main::restore_preview();

			return '';
		}

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-shipping-details<?php echo esc_attr( $classes ); ?>">
				<?php WC()->checkout()->checkout_form_shipping(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
