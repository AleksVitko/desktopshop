<?php

use XTS\Modules\Dynamic_Discounts\Frontend as Dynamic_Discounts_Module;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_dynamic_discount' ) ) {
	function wd_gutenberg_single_product_dynamic_discount( $block_attributes ) {
		if ( ! woodmart_get_opt( 'discounts_enabled', 0 ) || ( woodmart_get_opt( 'login_prices' ) && ! is_user_logged_in() ) ) {
			return '';
		}

		Main::setup_preview();

		global $product;

		ob_start();

		Dynamic_Discounts_Module::get_instance()->render_dynamic_discounts_table( $product->get_id() );

		$content = ob_get_clean();

		if ( ! $content ) {
			Main::restore_preview();

			return '';
		}

		ob_start();

		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-discounts<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
			<?php echo $content; //phpcs:ignore ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
