<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_shop_title' ) ) {
	function wd_gutenberg_shop_title( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$classes = '';

		if ( ! empty( $block_attributes['textAlign'] ) || ! empty( $block_attributes['textAlignTablet'] ) || ! empty( $block_attributes['textAlignMobile'] ) ) {
			$classes .= ' wd-align';
		}

		Main::setup_preview();

		ob_start();

		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-woo-page-title<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes, $classes ) ); ?>">
			<<?php echo esc_attr( $block_attributes['htmlTag'] ); ?>  class="entry-title title">
				<?php woocommerce_page_title(); ?>
			</<?php echo esc_attr( $block_attributes['htmlTag'] ); ?>>
		</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
