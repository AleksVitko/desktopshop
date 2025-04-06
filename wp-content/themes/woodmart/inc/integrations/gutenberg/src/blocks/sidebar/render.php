<?php
if ( ! function_exists( 'wd_gutenberg_sidebar' ) ) {
	function wd_gutenberg_sidebar( $block_attributes ) {
		if ( empty( $block_attributes['sidebar_id'] ) ) {
			return '';
		}
		$attributes = '';
		$el_class   = wd_get_gutenberg_element_classes( $block_attributes );

		if ( $el_class ) {
			$attributes .= ' class="' . $el_class . '"';
		}

		ob_start();

		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>"<?php echo wp_kses( $attributes, true ); ?>>
			<?php dynamic_sidebar( $block_attributes['sidebar_id'] ); ?>
		</div>
		<?php

		return ob_get_clean();
	}
}
