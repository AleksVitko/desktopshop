<?php

use XTS\Modules\Layouts\Main;
use XTS\Modules\Free_Gifts\Frontend as Free_Gifts_Frontend;

if ( ! function_exists( 'wd_gutenberg_cart_free_gifts' ) ) {
	function wd_gutenberg_cart_free_gifts( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() || ! woodmart_get_opt( 'free_gifts_enabled', 0 ) ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		Main::setup_preview();

		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			Main::restore_preview();

			return '';
		}

		$settings = array(
			'show_title' => $block_attributes['showTitle'] ? 'yes' : 'no',
		);

		$free_gifts_frontend = Free_Gifts_Frontend::get_instance();

		ob_start();

		$free_gifts_frontend->render_free_gifts_table( $settings );

		$gifts_table = ob_get_clean();

		ob_start();

		if ( ! $gifts_table ) {
			$classes .= ' wd-hide';
		}

		woodmart_enqueue_js_script( 'free-gifts-table' );

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-fg<?php echo esc_attr( $classes ); ?>" data-settings="<?php echo esc_attr( wp_json_encode( $settings ) ); ?>">
				<?php echo $gifts_table; // phpcs:ignore. ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
