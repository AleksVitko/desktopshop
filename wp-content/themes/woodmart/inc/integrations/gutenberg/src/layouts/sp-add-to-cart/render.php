<?php

use XTS\Modules\Layouts\Global_Data as Builder;
use XTS\Modules\Layouts\Main;
use XTS\Modules\Waitlist\Frontend as Waitlist_Frontend;

if ( ! function_exists( 'wd_gutenberg_single_product_add_to_cart' ) ) {
	function wd_gutenberg_single_product_add_to_cart( $block_attributes ) {
		if ( woodmart_get_opt( 'catalog_mode' ) || ! is_user_logged_in() && woodmart_get_opt( 'login_prices' ) ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		$form_classes  = ' wd-reset-' . $block_attributes['clearButtonPosition'] . '-lg';
		$form_classes .= ' wd-reset-' . $block_attributes['clearButtonPositionTablet'] . '-md';

		$form_classes .= ' wd-label-' . $block_attributes['labelPosition'] . '-lg';
		$form_classes .= ' wd-label-' . $block_attributes['labelPositionTablet'] . '-md';

		if ( 'justify' === $block_attributes['design'] ) {
			woodmart_enqueue_inline_style( 'woo-single-prod-el-add-to-cart-opt-design-justify-builder' );

			remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation' );
			add_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation' );
		}

		Main::setup_preview();
		Builder::get_instance()->set_data( 'form_classes', $form_classes );
		Builder::get_instance()->set_data( 'layout_id', get_the_ID() );

		if ( ! empty( $block_attributes['align'] ) ) {
			$classes .= ' text-' . $block_attributes['align'];
		}

		if ( ! empty( $block_attributes['buttonDesign'] ) ) {
			$classes .= ' wd-btn-design-' . $block_attributes['buttonDesign'];
		}

		if ( ! empty( $block_attributes['design'] ) ) {
			$classes .= ' wd-design-' . $block_attributes['design'];
		}

		if ( ! empty( $block_attributes['swatchLayout'] ) ) {
			$classes .= ' wd-swatch-layout-' . $block_attributes['swatchLayout'];
		}

		if ( empty( $block_attributes['stockStatus'] ) ) {
			$classes .= ' wd-stock-status-off';
		}

		global $product;

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-add-cart<?php echo esc_attr( $classes ); ?>">
				<?php woocommerce_template_single_add_to_cart(); ?>

				<?php
				if ( $product && woodmart_get_opt( 'waitlist_enabled' ) && ( ! woodmart_get_opt( 'waitlist_for_loggined' ) || is_user_logged_in() ) ) {
					$waitlist_frontend = Waitlist_Frontend::get_instance();

					if ( ( 'variable' === $product->get_type() && ! empty( $waitlist_frontend->get_out_of_stock_variations_ids( $product ) ) ) || ( 'simple' === $product->get_type() && ! $product->is_in_stock() ) ) {
						$waitlist_frontend->render_waitlist_subscribe_form();
						$waitlist_frontend->render_template_subscribe_form();
					}
				}
				?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
