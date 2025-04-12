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
<p>
	<?php
	echo wp_kses(
		sprintf(
			// translators: Product name with link.
			esc_html__( 'Great news! The %s on your waitlist is now back in stock!', 'woodmart' ),
			'<a href="' . esc_url( $email->object->get_permalink() ) . '">' . esc_html( $email->object->get_name() ) . '</a>'
		),
		true
	);
	?>
</p>
<p><?php _e( 'Since you requested to be notified, we wanted to make sure you\'re the first to know. However, we can\'t guarantee how long it will be available.', 'woodmart' ); // phpcs:ignore. ?></p>
<p><?php echo _e( 'Click the link below to grab it before it\'s gone!', 'woodmart' ); // phpcs:ignore.?></p>
<table class="td xts-prod-table" cellspacing="0" cellpadding="6" border="1">
	<thead>
		<tr>
			<th class="td" scope="col"></th>
			<th class="td xts-align-start" scope="col"><?php esc_html_e( 'Product', 'woodmart' ); ?></th>
			<th class="td xts-align-start" scope="col"><?php esc_html_e( 'Price', 'woodmart' ); ?></th>
			<th class="td xts-align-end" scope="col"><?php esc_html_e( 'Add to cart', 'woodmart' ); ?></th>
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
			<td class="td xts-tbody-td xts-align-start">
				<?php
					echo wp_kses( $email->product_price, true );
				?>
			</td>
			<td class="td xts-tbody-td xts-align-end">
				<a href="<?php echo esc_url( add_query_arg( 'add-to-cart', $email->object->get_id(), $email->object->get_permalink() ) ); ?>" class="xts-add-to-cart">
					<?php esc_html_e( "Add to cart\n", 'woodmart' ); ?>
				</a>
			</td>
		</tr>
	</tbody>
</table>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
