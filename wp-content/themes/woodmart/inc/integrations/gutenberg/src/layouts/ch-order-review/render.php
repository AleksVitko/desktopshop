<?php

use XTS\Modules\Checkout_Order_Table;
use XTS\Modules\Layouts\Main;
use Automattic\WooCommerce\Internal\Orders\OrderAttributionController;
use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! function_exists( 'wd_gutenberg_checkout_order_review' ) ) {
	function wd_gutenberg_checkout_order_review( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		if ( Checkout_Order_Table::get_instance()->is_enable_woodmart_product_table_template() ) {
			$classes .= ' wd-manage-on';
		}

		Main::setup_preview();

		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			Main::restore_preview();

			return '';
		}

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-order-table<?php echo esc_attr( $classes ); ?>">
				<?php
				woocommerce_order_review();

				// Render order attribution inputs if feature is enabled.
				if ( FeaturesUtil::feature_is_enabled( 'order_attribution' ) ) {
					$order_attribution_controller = new OrderAttributionController();

					$order_attribution_controller->stamp_html_element();
				}
				?>
			</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
