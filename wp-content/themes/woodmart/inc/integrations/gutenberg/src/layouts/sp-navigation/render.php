<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_navigation' ) ) {
	function wd_gutenberg_single_product_navigation( $block_attributes ) {
		ob_start();

		Main::setup_preview();
		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-nav<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php wc_get_template( 'single-product/navigation.php' ); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
