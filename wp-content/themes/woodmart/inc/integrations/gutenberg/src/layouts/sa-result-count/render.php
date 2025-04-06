<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_shop_archive_result_count' ) ) {
	function wd_gutenberg_shop_archive_result_count( $block_attributes ) {
		ob_start();

		Main::setup_preview();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-shop-result-count<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php woocommerce_result_count(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
