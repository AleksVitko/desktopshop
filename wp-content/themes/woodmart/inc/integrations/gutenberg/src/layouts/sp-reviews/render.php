<?php

use XTS\Modules\Layouts\Global_Data;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_reviews' ) ) {
	function wd_gutenberg_single_product_reviews( $block_attributes ) {
		Global_Data::get_instance()->set_data( 'reviews_columns', $block_attributes['reviewsColumns'] );
		Global_Data::get_instance()->set_data( 'reviews_columns_tablet', $block_attributes['reviewsColumnsTablet'] );
		Global_Data::get_instance()->set_data( 'reviews_columns_mobile', $block_attributes['reviewsColumnsMobile'] );

		$classes  = wd_get_gutenberg_element_classes( $block_attributes );
		$classes .= ' wd-layout-' . $block_attributes['layout'];
		$classes .= ' wd-form-pos-' . woodmart_get_opt( 'reviews_form_location', 'after' );

		ob_start();

		Main::setup_preview();

		if ( woodmart_get_opt( 'reviews_rating_summary' ) && function_exists( 'wc_review_ratings_enabled' ) && wc_review_ratings_enabled() ) {
			woodmart_enqueue_inline_style( 'woo-single-prod-opt-rating-summary' );
		}

		woodmart_enqueue_inline_style( 'woo-single-prod-el-reviews' );
		woodmart_enqueue_inline_style( 'woo-single-prod-el-reviews-' . woodmart_get_opt( 'reviews_style', 'style-1' ) );
		woodmart_enqueue_inline_style( 'mod-comments' );

		global $withcomments;

		if ( wp_is_serving_rest_request() ) {
			$withcomments = true;
		}

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-reviews<?php echo esc_attr( $classes ); ?>">
				<?php comments_template(); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
