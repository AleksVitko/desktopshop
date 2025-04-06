<?php

use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_brand_info' ) ) {
	function wd_gutenberg_single_product_brand_info( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() || wp_is_serving_rest_request() ) {
			return '';
		}

		ob_start();

		Main::setup_preview();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-brand-info wd-entry-content<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>"><?php woodmart_product_brand_tab_content(); ?></div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
