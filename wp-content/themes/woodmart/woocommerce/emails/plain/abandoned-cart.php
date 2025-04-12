<?php
/**
 * Abandoned cart email plain template.
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

echo esc_html( wp_strip_all_tags( $email_heading ) ) . "\n\n";

echo esc_html(
	sprintf(
		// translators: %s User name.
		__(
			'Hi, %s!',
			'woodmart'
		),
		$email->user_name
	)
) . "\n";

echo esc_html__( "We noticed that you left a few items in your cart and didn't complete your purchase. We just wanted to remind you that those great finds are still waiting for you!\n\n", 'woodmart' );

if ( $coupon ) {
	$coupon_amount = $coupon->get_amount();
	$coupon_type   = $coupon->get_discount_type();
	$coupon_value  = '';

	if ( 'percent' === $coupon_type ) {
		$coupon_value = $coupon_amount . '%';
	} elseif ( 'fixed_cart' === $coupon_type ) {
		$coupon_value = wc_price( $coupon_amount, array( 'currency' => $email->object->_user_currency ) );
	}

	echo wp_kses(
		sprintf(
			__( 'Take %s OFF | Code: %s', 'woodmart' ),
			$coupon_value,
			strtoupper( $coupon->get_code() )
		),
		true
	) . "\n\n";
}

echo esc_html__( "Here's what you left behind:\n", 'woodmart' );

foreach ( $email->object->_cart->get_cart_contents() as $cart_id => $cart_item ) {
	$id      = isset( $cart_item['variation_id'] ) && ! empty( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];
	$product = $cart_item['data'];

	if ( ! $product ) {
		continue;
	}

	$product_quantity = $cart_item['quantity'];
	$product_subtotal = $cart_item['line_subtotal'];

	// Calculate the product subtotal including taxes.
	if ( wc_tax_enabled() ) {
		if ( 'incl' === get_option( 'woocommerce_tax_display_cart' ) ) {
			$product_subtotal = wc_get_price_including_tax( $product, array( 'qty' => $product_quantity ) );
		} else {
			$product_subtotal = wc_get_price_excluding_tax( $product, array( 'qty' => $product_quantity ) );
		}
	}

	echo esc_html( $product->get_title() ) . ' x' . esc_html( $cart_item['quantity'] ) . ' ' . wp_kses( wc_price( $product_subtotal, array( 'currency' => $email->object->_user_currency ) ), false ) . "\n";
}

$item_totals = isset( $email->object->_order_totals ) ? $email->object->_order_totals : array();

foreach ( $item_totals as $id => $total ) {
	if ( 'est_del' === $id ) {
		continue;
	}

	echo wp_kses_post( $total['label'] ) . ' ' . wp_kses_post( $total['value'] ) . "\n";
}

echo "\n";
echo esc_html__( 'Simply click the button below to complete your purchase: ', 'woodmart' ) . esc_html( $recover_button_link ) . "\n\n";
echo esc_html__( "We're eager to get these items to you. Don't miss out on them!", 'woodmart' ) . "\n";
echo esc_html__( 'Best regards,', 'woodmart' ) . esc_html( $email->get_blogname() ) . "\n\n\n";

echo wp_kses( sprintf( __( 'If you don\'t want to receive any further notification, please %s', 'woodmart' ), '<a href="' . esc_url( $unsubscribe_link ) . '">' . esc_html__( 'unsubscribe', 'woodmart' ) . '</a>' ), true );

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
