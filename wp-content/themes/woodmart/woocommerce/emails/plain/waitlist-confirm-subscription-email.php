<?php
/**
 * Waitlist emails plain template.
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
echo esc_html__( "Thank you for requesting to join the waitlist for this item:\n", 'woodmart' );
echo esc_html( $email->object->get_name() ) . ' ' . wp_kses( $email->product_price, true ) . ' ' . esc_url( $email->object->get_permalink() ) . "\n";
echo esc_html( __( 'Please click the button below to confirm your email address. Once confirmed, we will notify you when the item is back in stock:', 'woodmart' ) . ' ' . esc_url( $email->confirm_url ) ) . "\n";
echo esc_html__( "Note: The confirmation period is 2 days.\n", 'woodmart' );
echo esc_html__( "If you did not request to join this waitlist, please ignore this message.\n", 'woodmart' );
echo esc_html__( "Cheers\n", 'woodmart' );
echo esc_html( $email->get_blogname() ) . "\n";

echo "\n----------------------------------------\n\n";

echo esc_html( __( 'If you don\'t want to receive any further notification, please follow this link', 'woodmart' ) . ' ' . $unsubscribe_link );

echo "\n----------------------------------------\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
