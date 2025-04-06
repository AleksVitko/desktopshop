<?php

use XTS\Modules\Layouts\Main;
use XTS\Modules\Shipping_Progress_Bar\Main as Shipping_Progress_Bar_Module;

if ( ! function_exists( 'wd_gutenberg_woo_shipping_progress_bar' ) ) {
	function wd_gutenberg_woo_shipping_progress_bar( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() || ! woodmart_get_opt( 'shipping_progress_bar_enabled' ) ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		if ( ! empty( $block_attributes['textAlign'] ) || ! empty( $block_attributes['textAlignTablet'] ) || ! empty( $block_attributes['textAlignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		Main::setup_preview();

		ob_start();

		woodmart_enqueue_inline_style( 'woo-opt-free-progress-bar' );
		woodmart_enqueue_inline_style( 'woo-mod-progress-bar' );

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-shipping-progress-bar<?php echo esc_attr( $classes ); ?>">
				<?php Shipping_Progress_Bar_Module::get_instance()->render_shipping_progress_bar(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
