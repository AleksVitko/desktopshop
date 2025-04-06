<?php
/**
 * Single product extra content block.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_extra_content' ) ) {
	function wd_gutenberg_single_product_extra_content( $block_attributes ) {
		Main::setup_preview();

		$id = get_post_meta( get_the_ID(), '_woodmart_extra_content', true );

		if ( ! $id || wp_is_serving_rest_request() ) {
			Main::restore_preview();

			return '';
		}

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-ex-content wd-entry-content<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php echo woodmart_get_html_block( $id ); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
