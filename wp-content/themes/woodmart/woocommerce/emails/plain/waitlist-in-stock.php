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

echo esc_html( wp_strip_all_tags( wptexturize( $email_content ) ) ) . "\n\n";

echo "\n----------------------------------------\n\n";

echo esc_html( __( 'If you don\'t want to receive any further notification, please follow this link', 'woodmart' ) . ' ' . $unsubscribe_link );

echo "\n----------------------------------------\n\n";

echo wp_kses_post( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) );
