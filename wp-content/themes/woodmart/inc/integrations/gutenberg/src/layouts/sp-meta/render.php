<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_meta' ) ) {
	function wd_gutenberg_single_product_meta( $block_attributes ) {
		$classes = '';

		if ( 'justify' !== $block_attributes['layout'] && ( ! empty( $block_attributes['textAlign'] ) || ! empty( $block_attributes['textAlignTablet'] ) || ! empty( $block_attributes['textAlignMobile'] ) ) ) {
			$classes .= ' wd-align';
		}

		ob_start();

		Main::setup_preview();
		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-meta<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes, $classes ) ); ?>">
				<?php
					wc_get_template(
						'single-product/meta.php',
						array(
							'builder_meta_classes' => ' wd-layout-' . $block_attributes['layout'],
							'show_sku'             => $block_attributes['showSku'] ? 'yes' : 'no',
							'show_categories'      => $block_attributes['showCategories'] ? 'yes' : 'no',
							'show_tags'            => $block_attributes['showTags'] ? 'yes' : 'no',
							'show_brand'           => $block_attributes['showBrand'] ? 'yes' : 'no',
						)
					);
				?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
