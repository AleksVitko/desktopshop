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
$email_attr      = '';

if ( ! empty( $data['product_id'] ) ) {
	$submit_attr = sprintf(
		'data-product-id=%s',
		esc_attr( $data['product_id'] )
	);
}

if ( ! empty( $data['email'] ) ) {
	$email_attr = sprintf(
		'value=%s',
		esc_attr( $data['email'] )
	);
}
?>

<div class="wd-wtl-form<?php echo esc_attr( $wrapper_classes ); ?>" data-state="not-signed">
	<h4>
		<?php esc_html_e( 'This product is currently sold out.', 'woodmart' ); ?>
	</h4>
	<p>
		<?php esc_html_e( 'No worries! Enter your email, and we\'ll let you know as soon as it\'s back in stock.', 'woodmart' ); ?>
	</p>

	<div class="wd-wtl-form-fields">
		<input type="email" name="wd-wtl-user-subscribe-email" id="wd-wtl-user-subscribe-email" placeholder="<?php esc_attr_e( 'Enter your email address', 'woodmart' ); ?>" <?php echo $email_attr; // phpcs:ignore. ?> />

		<?php do_action( 'woodmart_before_waitlist_submit' ); ?>

		<a href="#" class="button wd-wtl-subscribe" <?php echo $submit_attr; // phpcs:ignore. ?>>
			<?php esc_attr_e( 'Add to waitlist', 'woodmart' ); ?>
		</a>

		<?php do_action( 'woodmart_after_waitlist_submit' ); ?>
	</div>
	<?php if ( woodmart_get_opt( 'waitlist_enable_privacy_checkbox', '1' ) ) : ?>
		<?php
		$woodmart_wtl_default_privacy_text = sprintf(
			// translators: %1$s Open <a> tag. %2$s Close <a> tag.
			esc_html__( 'I have read and accept the %1$s Privacy Policy %2$s', 'woodmart' ),
			'<a href="#">',
			'</a>'
		);

		$woodmart_wtl_privacy_text = woodmart_get_opt( 'waitlist_privacy_checkbox_text', $woodmart_wtl_default_privacy_text );

		if ( function_exists( 'wc_replace_policy_page_link_placeholders' ) ) {
			$woodmart_wtl_privacy_text = wc_replace_policy_page_link_placeholders( $woodmart_wtl_privacy_text );
		}
		?>
		<label for="wd-wtl-policy-check<?php echo ! isset( $data ) ? '-tmpl' : ''; ?>">
			<input type="checkbox" name="wd-wtl-policy-check" id="wd-wtl-policy-check<?php echo ! isset( $data ) ? '-tmpl' : ''; ?>" class="wd-wtl-policy-check" value="0">
			<span>
				<?php echo wp_kses_post( $woodmart_wtl_privacy_text ); ?>
			</span>
		</label>
	<?php endif; ?>

	<div class="wd-loader-overlay wd-fill"></div>
</div>
