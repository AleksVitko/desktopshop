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

<p>
	<?php
	echo esc_html(
		sprintf(
			// translators: %s User name.
			__(
				'Hi, %s!',
				'woodmart'
			),
			$email->user_name
		)
	);
	?>
</p>
<p><?php esc_html_e( 'Thank you for requesting to join the waitlist for this item:', 'woodmart' ); ?></p>
<table class="td xts-prod-table" cellspacing="0" cellpadding="6" border="1">
	<thead>
		<tr>
			<th class="td" scope="col"></th>
			<th class="td xts-align-start" scope="col"><?php esc_html_e( 'Product', 'woodmart' ); ?></th>
			<th class="td xts-align-end" scope="col"><?php esc_html_e( 'Price', 'woodmart' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="td xts-tbody-td xts-img-col xts-align-start">
				<a href="<?php echo esc_url( $email->object->get_permalink() ); ?>">
					<?php echo wp_kses( $email->product_image, true ); ?>
				</a>
			</td>
			<td class="td xts-tbody-td xts-align-start">
				<a href="<?php echo esc_url( $email->object->get_permalink() ); ?>">
					<?php echo esc_html( $email->object->get_name() ); ?>
				</a>
			</td>
			<td class="td xts-tbody-td xts-align-end">
				<?php
					echo wp_kses( $email->product_price, true );
				?>
			</td>
		</tr>
	</tbody>
</table>
<p><?php esc_html_e( 'Please click the button below to confirm your email address. Once confirmed, we will notify you when the item is back in stock:', 'woodmart' ); ?></p>
<div style="margin:0 0 16px;">
	<a class="xts-add-to-cart" href="<?php echo esc_url( $email->confirm_url ); ?>">
		<?php echo esc_html( apply_filters( 'woodmart_waitlist_label_confirm_button', __( 'Confirm now', 'woodmart' ) ) ); ?>
	</a>
</div>
<p><?php esc_html_e( 'Note: The confirmation period is 2 days.', 'woodmart' ); ?></p>
<p><?php esc_html_e( 'If you did not request to join this waitlist, please ignore this message.', 'woodmart' ); ?></p>
<p><?php esc_html_e( 'Cheers', 'woodmart' ); ?></p>
<p><?php echo esc_html( $email->get_blogname() ); ?></p>

<p>
	<small>
		<?php
		echo wp_kses(
			sprintf(
				// translators: %s Unsubscribe link html.
				esc_html__( 'If you don\'t want to receive any further notification, please %s', 'woodmart' ),
				'<a href="' . esc_url( $unsubscribe_link ) . '">' . esc_html__( 'unsubscribe', 'woodmart' ) . '</a>'
			),
			true
		);
		?>
	</small>
</p>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
