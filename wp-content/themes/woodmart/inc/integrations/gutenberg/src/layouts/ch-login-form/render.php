<?php

use XTS\Modules\Layouts\Main;
use XTS\Modules\Shipping_Progress_Bar\Main as Shipping_Progress_Bar_Module;

if ( ! function_exists( 'wd_gutenberg_checkout_login_form' ) ) {
	function wd_gutenberg_checkout_login_form( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() || is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		if ( ! empty( $block_attributes['align'] ) || ! empty( $block_attributes['alignTablet'] ) || ! empty( $block_attributes['alignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		Main::setup_preview();

		ob_start();

		woodmart_enqueue_inline_style( 'woo-mod-login-form' );

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-checkout-login<?php echo esc_attr( $classes ); ?>">
				<?php woocommerce_checkout_login_form(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
