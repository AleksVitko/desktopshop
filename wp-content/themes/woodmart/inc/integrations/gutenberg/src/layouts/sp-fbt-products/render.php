<?php

use XTS\Modules\Frequently_Bought_Together\Frontend;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_fbt_products' ) ) {
	function wd_gutenberg_single_product_fbt_products( $block_attributes, $inner_content ) {
		if ( ! woodmart_get_opt( 'bought_together_enabled', 1 ) ) {
			return '';
		}

		$classes = wd_get_gutenberg_element_classes( $block_attributes );

		$block_attributes['is_builder'] = true;

		$block_attributes['slides_per_view_tablet'] = isset( $block_attributes['slides_per_viewTablet'] ) ? $block_attributes['slides_per_viewTablet'] : '';
		$block_attributes['slides_per_view_tablet'] = isset( $block_attributes['slides_per_viewMobile'] ) ? $block_attributes['slides_per_viewMobile'] : '';

		$block_attributes['hide_prev_next_buttons_tablet'] = ! empty( $block_attributes['hide_prev_next_buttonsTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_prev_next_buttons_mobile'] = ! empty( $block_attributes['hide_prev_next_buttonsMobile'] ) ? 'yes' : 'no';

		$block_attributes['hide_pagination_control_tablet'] = ! empty( $block_attributes['hide_pagination_controlTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_pagination_control_mobile'] = ! empty( $block_attributes['hide_pagination_controlMobile'] ) ? 'yes' : 'no';

		$block_attributes['hide_scrollbar_tablet'] = ! empty( $block_attributes['hide_scrollbarTablet'] ) ? 'yes' : 'no';
		$block_attributes['hide_scrollbar_mobile'] = ! empty( $block_attributes['hide_scrollbarMobile'] ) ? 'yes' : 'no';

		$block_attributes['form_color_scheme'] = isset( $block_attributes['formColorScheme'] ) ? $block_attributes['formColorScheme'] : '';

		wd_replace_boolean_to_yes_no( array( 'hide_pagination_control', 'hide_prev_next_buttons', 'hide_scrollbar' ), $block_attributes );

		Main::setup_preview();

		ob_start();

		Frontend::get_instance()->get_bought_together_products( $block_attributes, $inner_content );

		$content = ob_get_clean();

		if ( ! $content ) {
			Main::restore_preview();

			return '';
		}

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-fbt<?php echo esc_attr( $classes ); ?>">
				<?php echo $content; // phpcs:ignore ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
