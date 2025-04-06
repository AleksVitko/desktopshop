<?php

use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
	use XTS\Modules\Layouts\Global_Data as Builder_Data;
	use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_shop_archive_order_by' ) ) {
	function wd_gutenberg_shop_archive_order_by( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		ob_start();

		Main::setup_preview();

		woodmart_enqueue_inline_style( 'woo-shop-el-order-by' );

		$ordering_classes = ' wd-style-' . $block_attributes['style'];

		if ( ! empty( $block_attributes['mobileIcon'] ) ) {
			$ordering_classes .= ' wd-ordering-mb-icon';
		}

		Builder_Data::get_instance()->set_data( 'builder_ordering_classes', $ordering_classes );

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-shop-ordering<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php woocommerce_catalog_ordering(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
