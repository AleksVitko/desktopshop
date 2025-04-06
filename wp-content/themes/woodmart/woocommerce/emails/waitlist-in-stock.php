<?php
/**
 * Waitlist emails html template.
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
	<?php echo wp_kses_post( $email_content ); ?>
<?php do_action( 'woocommerce_email_footer', $email ); ?>
