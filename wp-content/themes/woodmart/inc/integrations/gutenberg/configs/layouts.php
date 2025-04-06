<?php
	return array(
		// Single product blocks.
		'wd/sp-add-to-cart'               => array(
			'attributes'      => wd_get_single_product_block_add_to_cart_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_add_to_cart',
		),
		'wd/sp-short-description'         => array(
			'attributes'      => wd_get_single_product_block_short_description_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_short_description',
		),
		'wd/sp-title'                     => array(
			'attributes'      => wd_get_single_product_block_title_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_title',
		),
		'wd/sp-gallery'                   => array(
			'attributes'      => wd_get_single_product_block_gallery_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_gallery',
		),
		'wd/sp-content'                   => array(
			'attributes'      => wd_get_single_product_block_content_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_content',
		),
		'wd/sp-meta'                      => array(
			'attributes'      => wd_get_single_product_block_meta_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_meta',
		),
		'wd/sp-price'                     => array(
			'attributes'      => wd_get_single_product_block_price_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_price',
		),
		'wd/sp-navigation'                => array(
			'attributes'      => wd_get_single_product_block_navigation_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_navigation',
		),
		'wd/sp-rating'                    => array(
			'attributes'      => wd_get_single_product_block_rating_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_rating',
		),
		'wd/sp-reviews'                   => array(
			'attributes'      => wd_get_single_product_block_reviews_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_reviews',
		),
		'wd/sp-stock-progress-bar'        => array(
			'attributes'      => wd_get_single_product_block_stock_progress_bar_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_stock_progress_bar',
		),
		'wd/sp-additional-info-table'     => array(
			'attributes'      => wd_get_single_product_block_additional_info_table_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_additional_info_table',
		),
		'wd/sp-extra-content'             => array(
			'attributes'      => wd_get_single_product_block_extra_content_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_extra_content',
		),
		'wd/sp-brand-info'                => array(
			'attributes'      => wd_get_single_product_block_brand_info_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_brand_info',
		),
		'wd/sp-brands'                    => array(
			'attributes'      => wd_get_single_product_block_brands_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_brands',
		),
		'wd/sp-compare-btn'               => array(
			'attributes'      => wd_get_single_product_block_compare_btn_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_compare_btn',
		),
		'wd/sp-wishlist-btn'              => array(
			'attributes'      => wd_get_single_product_block_wishlist_btn_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_wishlist_btn',
		),
		'wd/sp-size-guide-btn'            => array(
			'attributes'      => wd_get_single_product_block_size_guide_btn_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_size_guide_btn',
		),
		'wd/sp-stock-status'              => array(
			'attributes'      => wd_get_single_product_block_stock_status_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_stock_status',
		),
		'wd/sp-visitor-counter'           => array(
			'attributes'      => wd_get_single_product_block_visitor_counter_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_visitor_counter',
		),
		'wd/sp-dynamic-discount'          => array(
			'attributes'      => wd_get_single_product_block_dynamic_discount_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_dynamic_discount',
		),
		'wd/sp-fbt-products'              => array(
			'attributes'      => wd_get_single_product_block_fbt_products_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_fbt_products',
		),
		'wd/sp-linked-variations'         => array(
			'attributes'      => wd_get_single_product_block_linked_variations_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_linked_variations',
		),
		'wd/sp-meta-value'                => array(
			'attributes'      => wd_get_single_product_block_meta_value_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_meta_value',
		),
		'wd/sp-sold-counter'              => array(
			'attributes'      => wd_get_single_product_block_sold_counter_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_sold_counter',
		),
		'wd/sp-countdown'                 => array(
			'attributes'      => wd_get_single_product_block_countdown_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_countdown',
		),
		'wd/sp-tabs'                      => array(
			'attributes'      => wd_get_single_product_block_tabs_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_tabs',
		),
		'wd/sp-estimate-delivery'         => array(
			'attributes'      => wd_get_single_product_block_estimate_delivery_attrs(),
			'render_callback' => 'wd_gutenberg_single_product_estimate_delivery',
		),

		// Product archive blocks.
		'wd/sa-active-filters'            => array(
			'attributes'      => wd_get_shop_archive_block_active_filters_attrs(),
			'render_callback' => 'wd_gutenberg_shop_archive_active_filter',
		),
		'wd/sa-archive-description'       => array(
			'attributes'      => wd_get_shop_archive_block_archive_description_attrs(),
			'render_callback' => 'wd_gutenberg_shop_archive_description',
		),
		'wd/sa-archive-extra-description' => array(
			'attributes'      => wd_get_shop_archive_block_archive_extra_description_attrs(),
			'render_callback' => 'wd_gutenberg_shop_archive_extra_description',
		),
		'wd/sa-archive-products'          => array(
			'attributes'      => wd_get_shop_archive_block_archive_products_attrs(),
			'render_callback' => 'wd_gutenberg_shop_archive_products',
		),
		'wd/sa-filters-area'              => array(
			'attributes'      => wd_get_shop_archive_block_filters_area_attrs(),
			'render_callback' => 'wd_gutenberg_shop_archive_filters_area',
		),
		'wd/sa-filters-area-btn'          => array(
			'attributes'      => wd_get_shop_archive_block_filters_area_button_attrs(),
			'render_callback' => 'wd_gutenberg_shop_archive_filters_area_btn',
		),
		'wd/sa-orderby'                   => array(
			'attributes'      => wd_get_shop_archive_block_order_by_attrs(),
			'render_callback' => 'wd_gutenberg_shop_archive_order_by',
		),
		'wd/sa-per-page'                  => array(
			'attributes'      => wd_get_shop_archive_block_per_page_attrs(),
			'render_callback' => 'wd_gutenberg_shop_archive_per_page',
		),
		'wd/sa-result-count'              => array(
			'attributes'      => wd_get_shop_archive_block_result_count_attrs(),
			'render_callback' => 'wd_gutenberg_shop_archive_result_count',
		),
		'wd/sa-view'                      => array(
			'attributes'      => wd_get_shop_archive_block_view_attrs(),
			'render_callback' => 'wd_gutenberg_shop_archive_view',
		),
		'wd/sa-archive-title'             => array(
			'attributes'      => wd_get_shop_archive_block_title_attrs(),
			'render_callback' => 'wd_gutenberg_shop_title',
		),

		// Cart blocks.
		'wd/ct-table'                     => array(
			'attributes'      => wd_get_cart_block_table_attrs(),
			'render_callback' => 'wd_gutenberg_cart_table',
		),
		'wd/ct-totals'                    => array(
			'attributes'      => wd_get_cart_block_total_attrs(),
			'render_callback' => 'wd_gutenberg_cart_total',
		),
		'wd/ct-empty-cart'                => array(
			'attributes'      => wd_get_cart_block_empty_cart_attrs(),
			'render_callback' => 'wd_gutenberg_empty_cart',
		),
		'wd/ct-free-gifts'                => array(
			'attributes'      => wd_get_cart_block_free_gifts_attrs(),
			'render_callback' => 'wd_gutenberg_cart_free_gifts',
		),

		// Checkout blocks.
		'wd/ch-billing-details'           => array(
			'attributes'      => wd_get_checkout_block_billing_details_attrs(),
			'render_callback' => 'wd_gutenberg_checkout_billing_details',
		),
		'wd/ch-coupon-form'               => array(
			'attributes'      => wd_get_checkout_block_coupon_form_attrs(),
			'render_callback' => 'wd_gutenberg_checkout_coupon_form',
		),
		'wd/ch-form'                      => array(
			'render_callback' => 'wd_gutenberg_checkout_form',
		),
		'wd/ch-login-form'                => array(
			'attributes'      => wd_get_checkout_block_login_form_attrs(),
			'render_callback' => 'wd_gutenberg_checkout_login_form',
		),
		'wd/ch-order-review'              => array(
			'attributes'      => wd_get_checkout_block_order_review_attrs(),
			'render_callback' => 'wd_gutenberg_checkout_order_review',
		),
		'wd/ch-payment-methods'           => array(
			'attributes'      => wd_get_checkout_block_payment_methods_attrs(),
			'render_callback' => 'wd_gutenberg_checkout_payment_methods',
		),
		'wd/ch-shipping-details'          => array(
			'attributes'      => wd_get_checkout_block_shipping_details_attrs(),
			'render_callback' => 'wd_gutenberg_checkout_shipping_details',
		),

		// WooCommerce blocks.
		'wd/woo-breadcrumbs'              => array(
			'attributes'      => wd_get_woo_block_breadcrumbs_attrs(),
			'render_callback' => 'wd_gutenberg_woo_breadcrumbs',
		),
		'wd/woo-checkout-steps'           => array(
			'attributes'      => wd_get_woo_block_checkout_step_attrs(),
			'render_callback' => 'wd_gutenberg_woo_checkout_step',
		),
		'wd/woo-hook'                     => array(
			'attributes'      => wd_get_woo_block_hook_attrs(),
			'render_callback' => 'wd_gutenberg_woo_hook',
		),
		'wd/woo-notices'                  => array(
			'attributes'      => wd_get_woo_block_notices_attrs(),
			'render_callback' => 'wd_gutenberg_woo_notices',
		),
		'wd/woo-page-title'               => array(
			'attributes'      => wd_get_woo_block_page_title_attrs(),
			'render_callback' => 'wd_gutenberg_woo_page_title',
		),
		'wd/woo-shipping-progress-bar'    => array(
			'attributes'      => wd_get_woo_block_shipping_progress_bar_attrs(),
			'render_callback' => 'wd_gutenberg_woo_shipping_progress_bar',
		),
	);
