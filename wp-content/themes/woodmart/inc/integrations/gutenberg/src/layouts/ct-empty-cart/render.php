<?php

use XTS\Modules\Layouts\Main;
use XTS\Modules\Shipping_Progress_Bar\Main as Shipping_Progress_Bar_Module;

if ( ! function_exists( 'wd_gutenberg_empty_cart' ) ) {
	function wd_gutenberg_empty_cart( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		Main::setup_preview();

		ob_start();

		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
			<?php wc_get_template( 'cart/cart-empty.php' ); ?>
		</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
