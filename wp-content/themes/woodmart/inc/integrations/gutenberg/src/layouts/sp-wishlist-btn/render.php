<?php

use XTS\WC_Wishlist\Ui as Wishlist;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_wishlist_btn' ) ) {
	function wd_gutenberg_single_product_wishlist_btn( $block_attributes ) {
		if ( ! woodmart_get_opt( 'wishlist' ) || ! is_user_logged_in() && woodmart_get_opt( 'wishlist_logged' ) ) {
			return '';
		}

		$btn_classes  = 'wd-action-btn wd-wishlist-icon';
		$btn_classes .= ' wd-style-' . $block_attributes['style'];
		$btn_classes .= wd_get_gutenberg_element_classes( $block_attributes );

		ob_start();

		Main::setup_preview();

		if ( 'icon' === $block_attributes['style'] ) {
			$btn_classes .= ' wd-tooltip';

			woodmart_enqueue_js_library( 'tooltips' );
			woodmart_enqueue_js_script( 'btns-tooltips' );
		}

		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-action-btn wd-single-wishlist-btn<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
			<?php Wishlist::get_instance()->add_to_wishlist_btn( $btn_classes ); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
