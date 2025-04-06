<?php
if ( ! function_exists( 'wd_gutenberg_marquee' ) ) {
	function wd_gutenberg_marquee( $block_attributes, $content ) {
		$el_class = wd_get_gutenberg_element_classes( $block_attributes );

		if ( ! empty( $block_attributes['pauseOnHover'] ) ) {
			$el_class .= ' wd-with-pause';
		}
		if ( ! empty( $block_attributes['colorScheme'] ) ) {
			$el_class .= ' color-scheme-' . $block_attributes['colorScheme'];
		}

		ob_start();

		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-marquee<?php echo esc_attr( $el_class ); ?>" >
			<div class="wd-marquee-content">
				<?php echo do_shortcode( $content ); ?>
			</div>
			<div class="wd-marquee-content">
				<?php echo do_shortcode( $content ); ?>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}
}
