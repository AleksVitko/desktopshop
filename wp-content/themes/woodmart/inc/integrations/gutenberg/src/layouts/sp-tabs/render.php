<?php

use XTS\Modules\Layouts\Global_Data;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_tabs' ) ) {
	function wd_gutenberg_single_product_tabs( $block_attributes ) {
		$wrapper_classes = wd_get_gutenberg_element_classes( $block_attributes );

		$additional_info_classes  = ' wd-layout-' . $block_attributes['additionalInfoLayout'];
		$additional_info_classes .= ' wd-style-' . $block_attributes['additionalInfoStyle'];
		$reviews_classes          = ' wd-layout-' . $block_attributes['reviewsLayout'];
		$reviews_classes         .= ' wd-form-pos-' . woodmart_get_opt( 'reviews_form_location', 'after' );
		$args                     = array();
		$title_content_classes    = '';

		if ( ! empty( $block_attributes['enableAdditionalInfo'] ) ) {
			$additional_info_classes .= empty( $block_attributes['attrName'] ) ? ' wd-hide-name' : '';
			$additional_info_classes .= empty( $block_attributes['attrImage'] ) ? ' wd-hide-image' : '';
		} else {
			add_filter( 'woocommerce_product_tabs', 'woodmart_single_product_remove_additional_information_tab', 98 );
		}

		if ( ! empty( $block_attributes['enableReviews'] ) ) {
			woodmart_enqueue_inline_style( 'mod-comments' );

			Global_Data::get_instance()->set_data( 'reviews_columns', $block_attributes['reviewsColumns'] );
			Global_Data::get_instance()->set_data( 'reviews_columns_tablet', $block_attributes['reviewsColumnsTablet'] );
			Global_Data::get_instance()->set_data( 'reviews_columns_mobile', $block_attributes['reviewsColumnsMobile'] );
		} else {
			add_filter( 'woocommerce_product_tabs', 'woodmart_single_product_remove_reviews_tab', 98 );
		}
		if ( empty( $block_attributes['enableDescription'] ) ) {
			add_filter( 'woocommerce_product_tabs', 'woodmart_single_product_remove_description_tab', 98 );
		}

		if ( ! empty( $block_attributes['tabsContentTextColorScheme'] ) ) {
			$title_content_classes .= ' color-scheme-' . $block_attributes['tabsContentTextColorScheme'];
		}

		if ( 'tabs' === $block_attributes['layout'] ) {
			$title_classes         = ' wd-style-' . $block_attributes['tabsStyle'];
			$title_wrapper_classes = '';

			if ( ! empty( $block_attributes['tabsAlignment'] ) ) {
				$title_wrapper_classes .= ' wd-align';
			}

			if ( ! empty( $block_attributes['tabsTitleTextColorScheme'] ) ) {
				$title_wrapper_classes .= ' color-scheme-' . $block_attributes['tabsTitleTextColorScheme'];
			}

			$args = array(
				'builder_tabs_classes'             => $title_classes,
				'builder_tabs_wrapper_classes'     => ! empty( $block_attributes['accordionOnMobile'] ) ? ' wd-opener-pos-end' : '',
				'builder_nav_tabs_wrapper_classes' => $title_wrapper_classes,
				'accordion_on_mobile'              => ! empty( $block_attributes['accordionOnMobile'] ) ? 'yes' : 'no',
			);
		} elseif ( 'accordion' === $block_attributes['layout'] ) {
			$accordion_classes  = ' wd-style-' . $block_attributes['accordionStyle'];
			$accordion_classes .= ' wd-opener-style-' . $block_attributes['accordionOpenerStyle'];
			$title_classes      = '';

			if ( ! empty( $block_attributes['accordionAlignment'] ) ) {
				$accordion_classes .= ' wd-titles-' . $block_attributes['accordionAlignment'];
			}
			if ( ! empty( $block_attributes['accordionOpenerAlignment'] ) ) {
				$accordion_classes .= ' wd-opener-pos-' . $block_attributes['accordionOpenerAlignment'];
			}

			if ( ! empty( $block_attributes['accordionTitleTextColorScheme'] ) ) {
				$title_classes .= ' color-scheme-' . $block_attributes['accordionTitleTextColorScheme'];
			}

			if ( ! empty( $block_attributes['accordionHideTopBottomBorder'] ) ) {
				$accordion_classes .= ' wd-border-off';
			}

			$args = array(
				'builder_accordion_classes' => $accordion_classes,
				'builder_state'             => $block_attributes['accordionState'],
				'builder_title_classes'     => $title_classes,
			);
		} elseif ( 'side-hidden' === $block_attributes['layout'] ) {
			$title_classes = '';

			if ( ! empty( $block_attributes['sideHiddenTitleTextColorScheme'] ) ) {
				$title_classes .= ' color-scheme-' . $block_attributes['sideHiddenTitleTextColorScheme'];
			}

			$title_content_classes .= ' wd-' . $block_attributes['sideHiddenContentPosition'];

			$args = array(
				'builder_title_classes' => $title_classes,
			);
		} elseif ( 'all-open' === $block_attributes['layout'] ) {
			$wrapper_classes .= ' tabs-layout-all-open';
			$wrapper_classes .= ' wd-title-style-' . $block_attributes['allOpenStyle'];
		}

		$args = array_merge(
			array(
				'builder_additional_info_classes' => $additional_info_classes,
				'builder_reviews_classes'         => $reviews_classes,
				'builder_content_classes'         => $title_content_classes,
			),
			$args
		);

		Main::setup_preview();
		ob_start();

		wp_enqueue_script( 'wc-single-product' );

		if ( woodmart_get_opt( 'hide_tabs_titles' ) || get_post_meta( get_the_ID(), '_woodmart_hide_tabs_titles', true ) ) {
			add_filter( 'woocommerce_product_description_heading', '__return_false', 20 );
			add_filter( 'woocommerce_product_additional_information_heading', '__return_false', 20 );
		}

		if ( comments_open() ) {
			if ( woodmart_get_opt( 'reviews_rating_summary' ) && function_exists( 'wc_review_ratings_enabled' ) && wc_review_ratings_enabled() ) {
				woodmart_enqueue_inline_style( 'woo-single-prod-opt-rating-summary' );
			}

			woodmart_enqueue_inline_style( 'woo-single-prod-el-reviews' );
			woodmart_enqueue_inline_style( 'woo-single-prod-el-reviews-' . woodmart_get_opt( 'reviews_style', 'style-1' ) );
			woodmart_enqueue_js_script( 'woocommerce-comments' );

			global $withcomments;

			if ( wp_is_serving_rest_request() ) {
				$withcomments = true;
			}
		}

		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-tabs<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php
				wc_get_template(
					'single-product/tabs/tabs-' . $block_attributes['layout'] . '.php',
					$args
				);
			?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
