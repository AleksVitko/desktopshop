<?php
/**
 * Abandoned cart email html template.
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>
	<p><?php echo esc_html__( 'Hi ', 'woodmart' ) . esc_html( $email->user_name ); ?></p>
	<p><?php echo wp_kses_post( __( 'We noticed that you left a few items in your cart and didn\'t complete your purchase. We just wanted to remind you that those great finds are still waiting for you!', 'woodmart' ) ); ?></p>

	<?php if ( $coupon ) : ?>
		<p>
		<?php
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
				__( 'Take %s OFF | Code: <strong>%s</strong>', 'woodmart' ),
				$coupon_value,
				strtoupper( $coupon->get_code() )
			),
			true
		);
		?>
		</p>
	<?php endif; ?>

	<p><?php echo wp_kses_post( __( 'Here\'s what you left behind:', 'woodmart' ) ); ?></p>
	<table class="td xts-prod-table" cellspacing="0" cellpadding="6" border="1">
		<thead>
			<tr>
				<th class="td" scope="col"></th>
				<th class="td xts-align-start" scope="col"><?php esc_html_e( 'Product', 'woodmart' ); ?></th>
				<th class="td xts-align-end" scope="col"><?php esc_html_e( 'Price', 'woodmart' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $email->object->_cart->get_cart_contents() as $cart_id => $cart_item ) : ?>
				<?php
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

				$product_url      = $product->get_permalink();
				$product_name     = $product->get_title();
				$product_subtotal = $product_subtotal ? wc_price( $product_subtotal, array( 'currency' => $email->object->_user_currency ) ) : '';
				?>
				<tr>
					<td class="td xts-tbody-td xts-img-col xts-align-start">
						<a href="<?php echo esc_url( $product_url ); ?>">
							<?php
								$img_styles = 'vertical-align:middle;margin-' . is_rtl() ? 'left' : 'right' . ': 10px';
								$image_size = apply_filters( 'woodmart_abandoned_cart_email_thumbnail_item_size', array( 32, 32 ) );
							?>
							<div style="margin-bottom: 5px">
								<img src="<?php echo $product->get_image_id() ? esc_url( current( wp_get_attachment_image_src( $product->get_image_id(), 'thumbnail' ) ) ) : esc_url( wc_placeholder_img_src() ); ?>" alt="<?php esc_attr_e( 'Product image', 'woodmart' ); ?>" height="<?php echo esc_attr( $image_size[1] ); ?>" width="<?php echo esc_attr( $image_size[0] ); ?>" style="<?php echo esc_attr( $img_styles ); ?>" />
							</div>
						</a>
					</td>
					<td class="td xts-tbody-td xts-align-start">
						<a href="<?php echo esc_url( $product_url ); ?>">
							<?php echo esc_html( $product_name ); ?>
						</a>
						<small>
							<?php echo 'x' . esc_html( $product_quantity ); ?>
						</small>
					</td>
					<td class="td xts-tbody-td xts-align-end">
						<?php echo wp_kses( $product_subtotal, true ); ?>
					</td>
				</tr>
			<?php endforeach; ?>

			<?php
			$item_totals = isset( $email->object->_order_totals ) ? $email->object->_order_totals : array();

			foreach ( $item_totals as $id => $total ) {
				if ( 'est_del' === $id ) {
					continue;
				}
				?>
				<tr>
					<td class="td xts-tbody-td xts-align-start" colspan="2">
						<strong><?php echo wp_kses_post( $total['label'] ); ?></strong>
					</td>
					<td class="td xts-tbody-td xts-align-end"><?php echo wp_kses_post( $total['value'] ); ?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	<p style="margin-top: 30px;">
		<?php esc_html_e( 'Simply click the button below to complete your purchase:', 'woodmart' ); ?>
	</p>
	<div style="margin:0 0 16px;">
		<a class="xts-add-to-cart" href="<?php echo esc_url( $recover_button_link ); ?>">
			<?php echo apply_filters( 'woodmart_waitlist_label_confirm_button', __( 'Recover cart', 'woodmart' ) ); ?>
		</a>
	</div>

	<p><?php echo wp_kses_post( __( 'We\'re eager to get these items to you. Don\'t miss out on them!', 'woodmart' ) ); ?></p>
	<p><?php echo wp_kses_post( __( 'Best regards, ', 'woodmart' ) ) . esc_html( $email->get_blogname() ); ?></p>
	<p>
		<small>
			<?php echo wp_kses( sprintf( __( 'If you don\'t want to receive any further notification, please %s', 'woodmart' ), '<a href="' . esc_url( $unsubscribe_link ) . '">' . esc_html__( 'unsubscribe', 'woodmart' ) . '</a>' ), true ); ?>
		</small>
	</p>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
