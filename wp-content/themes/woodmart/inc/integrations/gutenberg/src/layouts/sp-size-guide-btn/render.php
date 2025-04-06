<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_size_guide_btn' ) ) {
	function wd_gutenberg_single_product_size_guide_btn( $block_attributes ) {
		$classes = ' wd-style-' . $block_attributes['style'];

		ob_start();

		Main::setup_preview();

		if ( 'icon' === $block_attributes['style'] ) {
			$classes .= ' wd-tooltip';
		}

		woodmart_sguide_display(
			false,
			array(
				'builder_classes' => $classes,
			)
		);

		$content = ob_get_clean();

		if ( ! trim( $content ) ) {
			Main::restore_preview();
			return '';
		}

		if ( 'icon' === $block_attributes['style'] ) {
			woodmart_enqueue_js_library( 'tooltips' );
			woodmart_enqueue_js_script( 'btns-tooltips' );
		}

		ob_start();

		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-action-btn wd-single-size-guide-btn<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
			<?php echo do_shortcode( $content ); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
