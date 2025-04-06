<?php

use XTS\Modules\Compare\Ui as Compare;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_compare_btn' ) ) {
	function wd_gutenberg_single_product_compare_btn( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() || ! woodmart_get_opt( 'compare' ) ) {
			return '';
		}

		$btn_classes  = 'wd-action-btn wd-compare-icon';
		$btn_classes .= ' wd-style-' . $block_attributes['style'];

		ob_start();

		Main::setup_preview();

		if ( 'icon' === $block_attributes['style'] ) {
			$btn_classes .= ' wd-tooltip';

			woodmart_enqueue_js_library( 'tooltips' );
			woodmart_enqueue_js_script( 'btns-tooltips' );
		}

		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-action-btn wd-single-compare-btn<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
			<?php Compare::get_instance()->add_to_compare_btn( $btn_classes ); ?>
		</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
