<?php
/**
 * WooPayments
 *
 * @package woodmart
 */

use WCPay\MultiCurrency\MultiCurrency;

if ( ! defined( 'WCPAY_VERSION_NUMBER' ) ) {
	return;
}

if ( ! function_exists( 'woodmart_wcpay_convert_price_limit' ) ) {
	/**
	 * Converse shipping progress bar limit.
	 *
	 * @param float $limit
	 * @return float
	 */
	function woodmart_wcpay_convert_price_limit( $limit ) {
		if ( 'wc' === woodmart_get_opt( 'shipping_progress_bar_calculation', 'custom' ) ) {
			return $limit;
		}

		$limit *= MultiCurrency::instance()->get_selected_currency()->get_rate();

		return $limit;
	}

	add_action( 'woodmart_shipping_progress_bar_amount', 'woodmart_wcpay_convert_price_limit' );
}
