<?php

use XTS\Modules\Compare\Ui as Compare;
use XTS\Modules\Layouts\Main;
use XTS\Modules\Linked_Variations\Frontend as Linked_Variations;
use XTS\Modules\Shipping_Progress_Bar\Main as Shipping_Progress_Bar;
use XTS\WC_Wishlist\Ui as Wishlist;
use XTS\Modules\Visitor_Counter\Main as Visitor_Counter;
use XTS\Modules\Sold_Counter\Main as Sold_Counter;
use XTS\Modules\Estimate_Delivery\Frontend as Estimate_Delivery_Frontend;
use XTS\Modules\Dynamic_Discounts\Frontend as Dynamic_Discounts_Frontend;

if ( ! function_exists( 'wd_gutenberg_woo_hook' ) ) {
	function wd_gutenberg_woo_hook( $block_attributes ) {
		if ( empty( $block_attributes['hook'] ) ) {
			return '';
		}

		Main::setup_preview();

		if ( ! empty( $block_attributes['cleanActions'] ) ) {
			if ( 'woocommerce_checkout_billing' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_checkout_billing', array( WC()->checkout(), 'checkout_form_billing' ) );
				remove_action( 'woocommerce_checkout_billing', array( Shipping_Progress_Bar::get_instance(), 'render_shipping_progress_bar_with_wrapper' ) );
			} elseif ( 'woocommerce_checkout_shipping' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_checkout_shipping', array( WC()->checkout(), 'checkout_form_shipping' ) );
			} elseif ( 'woocommerce_checkout_before_customer_details' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_checkout_before_customer_details', 'wc_get_pay_buttons', 30 );
			} elseif ( 'woocommerce_before_checkout_form' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
			} elseif ( 'woocommerce_cart_collaterals' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 20 );
				remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );
			} elseif ( 'woocommerce_before_cart' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
			} elseif ( 'woocommerce_before_single_product' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices' );
				remove_action( 'woocommerce_before_single_product', 'wc_print_notices' );
				remove_action( 'woocommerce_before_single_product', 'woodmart_product_extra_content', 20 );
			} elseif ( 'woocommerce_before_single_product_summary' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
				remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			} elseif ( 'woocommerce_product_thumbnails' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
			} elseif ( 'woocommerce_single_product_summary' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_stock_progress_bar', 16 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_product_brand', 3 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_product_brand', 8 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_product_share_buttons', 62 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_display_product_attributes', 21 );
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_add_to_cart', 30 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_sguide_display', 38 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_before_add_to_cart_area', 25 );
				remove_action( 'woocommerce_single_product_summary', 'woodmart_after_add_to_cart_area', 31 );
				remove_action( 'woocommerce_single_product_summary', array( $GLOBALS['woocommerce']->structured_data, 'generate_product_data' ), 60 );

				if ( woodmart_get_opt( 'linked_variations' ) ) {
					remove_action( 'woocommerce_single_product_summary', array( Linked_Variations::get_instance(), 'output' ), 25 );
				}
				if ( woodmart_get_opt( 'wishlist' ) ) {
					remove_action( 'woocommerce_single_product_summary', array( Wishlist::get_instance(), 'add_to_wishlist_single_btn' ), 33 );
				}
				if ( woodmart_get_opt( 'compare' ) ) {
					remove_action( 'woocommerce_single_product_summary', array( Compare::get_instance(), 'add_to_compare_single_btn' ), 33 );
				}
				if ( woodmart_get_opt( 'counter_visitor_enabled' ) ) {
					remove_action( 'woocommerce_single_product_summary', array( Visitor_Counter::get_instance(), 'output_count_visitors' ), 38 );
				}
				if ( woodmart_get_opt( 'sold_counter_enabled' ) ) {
					remove_action( 'woocommerce_single_product_summary', array( Sold_Counter::get_instance(), 'render' ), 25 );
				}
				if ( woodmart_get_opt( 'estimate_delivery_enabled' ) && woodmart_get_opt( 'estimate_delivery_show_on_single_product' ) ) {
					remove_action( 'woocommerce_single_product_summary', array( Estimate_Delivery_Frontend::get_instance(), 'render_on_single_product' ), 39 );
				}
				if ( woodmart_get_opt( 'discounts_enabled' ) && woodmart_get_opt( 'show_discounts_table' ) ) {
					remove_action( 'woocommerce_single_product_summary', array( Dynamic_Discounts_Frontend::get_instance(), 'render_dynamic_discounts_table' ), 25 );
				}
			} elseif ( 'woocommerce_before_add_to_cart_form' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_before_add_to_cart_form', 'woodmart_single_product_add_to_cart_scripts' );
			} elseif ( 'woocommerce_before_variations_form' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation' );
			} elseif ( 'woocommerce_single_variation' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation' );
				remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
				remove_action( 'woocommerce_before_variations_form', 'woocommerce_single_variation' );
			} elseif ( 'woocommerce_after_single_product_summary' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
				remove_action( 'woocommerce_after_single_product_summary', 'woodmart_wc_comments_template', 50 );
			} elseif ( 'woocommerce_checkout_order_review' === $block_attributes['hook'] ) {
				remove_action( 'woocommerce_checkout_order_review', 'woodmart_open_table_wrapper_div', 7 );
				remove_action( 'woocommerce_checkout_order_review', 'woodmart_close_table_wrapper_div', 13 );
				remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
				remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 20 );
				remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
				remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 10 );
			}
		}

		if ( ! has_action( $block_attributes['hook'] ) ) {
			Main::restore_preview();

			return '';
		}

		ob_start();
		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-el-hook<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
			<?php
			if ( 'woocommerce_before_checkout_form' === $block_attributes['hook'] || 'woocommerce_after_checkout_form' === $block_attributes['hook'] ) {
				do_action( $block_attributes['hook'], WC()->checkout() );
			} else {
				do_action( $block_attributes['hook'] );
			}
			?>
		</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
