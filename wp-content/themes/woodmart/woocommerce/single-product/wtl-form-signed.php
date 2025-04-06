<?php
/**
 * Waitlist form on single product page.
 *
 * @var array $data Data for render form.
 *
 * @package Woodmart
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wrapper_classes = ! isset( $data ) ? ' wd-wtl-is-template wd-hide' : '';
$submit_attr     = '';

if ( ! empty( $data['product_id'] ) ) {
	$submit_attr = sprintf(
		'data-product-id=%s',
		esc_attr( $data['product_id'] )
	);
}
?>

<div class="wd-wtl-form<?php echo esc_attr( $wrapper_classes ); ?>" data-state="signed">
	<p>
		<?php esc_html_e( 'We added you to this product\'s waitlist and we\'ll send you an email when the product is available.', 'woodmart' ); ?>
	</p>

	<?php do_action( 'woodmart_before_waitlist_submit' ); ?>

	<a href="#" class="button wd-wtl-unsubscribe" <?php echo $submit_attr; // phpcs:ignore. ?>>
		<?php esc_html_e( 'Leave Waitlist', 'woodmart' ); ?>
	</a>

	<?php do_action( 'woodmart_after_waitlist_submit' ); ?>

	<div class="wd-loader-overlay wd-fill"></div>
</div>
