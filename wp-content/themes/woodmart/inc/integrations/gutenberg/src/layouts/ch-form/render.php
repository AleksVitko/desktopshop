<?php

use XTS\Modules\Layouts\Main;
use XTS\Modules\Shipping_Progress_Bar\Main as Shipping_Progress_Bar_Module;

if ( ! function_exists( 'wd_gutenberg_checkout_form' ) ) {
	function wd_gutenberg_checkout_form( $block_attributes, $content ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		Main::setup_preview();

		ob_start();

		?>
			<?php if ( function_exists( 'WC' ) && ! WC()->checkout()->is_registration_enabled() && WC()->checkout()->is_registration_required() && ! is_user_logged_in() ) : ?>
				<?php echo wp_kses_post( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) ); ?>
			<?php else : ?>
				<form id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" name="checkout" method="post" class="checkout woocommerce-checkout wd-checkout-form<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">
					<?php echo do_shortcode( $content ); ?>
				</form>
			<?php endif; ?>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
