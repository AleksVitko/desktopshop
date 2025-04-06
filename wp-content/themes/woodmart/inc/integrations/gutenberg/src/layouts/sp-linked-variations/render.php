<?php

use XTS\Modules\Layouts\Main;
use XTS\Modules\Linked_Variations\Frontend;

if ( ! function_exists( 'wd_gutenberg_single_product_linked_variations' ) ) {
	function wd_gutenberg_single_product_linked_variations( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$wrapper_classes = '';

		if ( ! empty( $block_attributes['textAlign'] ) || ! empty( $block_attributes['textAlignTablet'] ) || ! empty( $block_attributes['textAlignMobile'] ) ) {
			$wrapper_classes .= ' wd-align';
		}

		$wrapper_classes .= ' wd-swatch-layout-' . $block_attributes['layout'];
		$wrapper_classes .= ' wd-label-' . $block_attributes['labelPosition'] . '-lg';
		$wrapper_classes .= ' wd-label-' . $block_attributes['labelPosition'] . '-md';

		ob_start();

		Main::setup_preview();

		Frontend::get_instance()->output( $wrapper_classes );

		$content = ob_get_clean();

		if ( ! $content ) {
			return '';
		}

		ob_start();
		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-linked-variations<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php echo $content; //phpcs:ignore ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
