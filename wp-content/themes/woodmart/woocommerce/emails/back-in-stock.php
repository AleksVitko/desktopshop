<?php
/**
 * Customer "back in stock" email
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p>
	<?php
	echo esc_html(
		sprintf(
			// translators: %s User login.
			__(
				'Hi, %s!',
				'woodmart'
			),
			$email->user->user_login
		)
	);
	?>
</p>

<p>
	<?php esc_html_e( 'The product on your wishlist is back in stock!', 'woodmart' ); ?>
</p>

<?php if ( $product_lists ) : ?>

	<table class="td xts-prod-table" cellspacing="0" cellpadding="6" border="1">
		<thead>
		<tr>
			<th class="td xts-align-start" scope="col"><?php esc_html_e( 'Product', 'woodmart' ); ?></th>
			<th class="td xts-align-start" scope="col"><?php esc_html_e( 'Price', 'woodmart' ); ?></th>
			<th class="td xts-align-end" scope="col"><?php esc_html_e( 'Add to cart', 'woodmart' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $product_lists as $product ) : ?>
			<tr>
				<td class="td xts-tbody-td  xts-align-start">
					<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="xts-thumb-link">
						<?php echo get_the_post_thumbnail( $product->get_id(), array( '70', '70' ), array( 'class' => 'xts-thumb' ) ); ?>
						<span>
							<?php echo esc_html( $product->get_title() ); ?>
						</span>
					</a>
				</td>
				<td class="td xts-tbody-td xts-align-start">
					<?php echo wp_kses( wc_price( wc_get_price_to_display( $product ) ), true ); ?>
				</td>
				<td class="td xts-tbody-td xts-align-end">
					<?php $button_link = $product->is_type( 'simple' ) ? add_query_arg( 'add-to-cart', $product->get_id(), $product->get_permalink() ) : $product->get_permalink(); ?>
					<a class="xts-add-to-cart" href="<?php echo esc_url( $button_link ); ?>">
						<?php echo esc_html( $product->add_to_cart_text() ); ?>
					</a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>

<p>
	<?php esc_html_e( 'We only have limited stock, so don\'t wait any longer, and take this chance to make it yours!', 'woodmart' ); ?>
</p>

<p>
	<small>
		<?php
		echo wp_kses(
			__( 'If you don\'t want to receive any further notification, please', 'woodmart' ) . ' <a href="' . woodmart_get_unsubscribe_link( $email->user->ID ) . '">' . __( 'unsubscribe', 'woodmart' ) . '</a>',
			true
		);
		?>
	</small>
</p>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
