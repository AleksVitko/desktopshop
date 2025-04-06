<?php

use XTS\Modules\Layouts\Main;
use XTS\Modules\Shipping_Progress_Bar\Main as Shipping_Progress_Bar_Module;

if ( ! function_exists( 'wd_gutenberg_checkout_coupon_form' ) ) {
	function wd_gutenberg_checkout_coupon_form( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() || ( ! is_user_logged_in() || ! WC()->checkout()->is_registration_enabled() || WC()->checkout()->is_registration_required() ) && ! wc_coupons_enabled() ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		if ( ! empty( $block_attributes['align'] ) || ! empty( $block_attributes['alignTablet'] ) || ! empty( $block_attributes['alignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		Main::setup_preview();

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-checkout-coupon<?php echo esc_attr( $classes ); ?>">
				<?php if ( function_exists( 'wc_print_notice' ) ) : ?>
					<?php woocommerce_checkout_coupon_form(); ?>
				<?php endif; ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
