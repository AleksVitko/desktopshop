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

echo esc_html__( "Hi {user_name}\n", 'woodmart' );

echo wp_kses(
	sprintf(
		// translators: Product name.
		esc_html__( 'Great news! The %s on your waitlist is now back in stock!', 'woodmart' ),
		esc_html( $email->object->get_name() )
	),
	true
);

echo esc_html__( "Since you requested to be notified, we wanted to make sure you're the first to know. However, we can't guarantee how long it will be available.\n", 'woodmart' );
echo esc_html__( "Click the link below to grab it before it's gone!\n", 'woodmart' );
echo esc_html( $email->object->get_name() ) . ' ' . wp_kses( $email->product_price, true ) . ' ' . esc_url( add_query_arg( 'add-to-cart', $email->object->get_id(), $email->object->get_permalink() ) ) . "\n";
echo esc_html__( "Best regards,\n", 'woodmart' );
echo esc_html( $email->get_blogname() ) . "\n";

echo "\n----------------------------------------\n\n";

echo esc_html( __( 'If you don\'t want to receive any further notification, please follow this link', 'woodmart' ) . ' ' . $unsubscribe_link );

echo "\n----------------------------------------\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
