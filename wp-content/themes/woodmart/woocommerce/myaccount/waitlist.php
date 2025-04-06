<?php
/**
 * Waitlist table.
 *
 * @var array $data Data for render table.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$mailer                     = WC()->mailer();
$confirm_subscription_email = $mailer->emails['woodmart_waitlist_confirm_subscription_email'];
$show_confirmed_column      = $confirm_subscription_email->is_enabled() && 'all' === $confirm_subscription_email->get_option( 'send_to' );
?>

<div class="wd-wtl-content">
	<?php
	// Add the styles in the wrapper so that they are updated with Ajax.
	if ( ! $data ) {
		woodmart_enqueue_inline_style( 'woo-page-empty-page' );
	} else {
		woodmart_enqueue_inline_style( 'woo-mod-stock-status' );
	}

	woodmart_enqueue_inline_style( 'woo-page-wtl' );
	?>

	<?php do_action( 'woodmart_before_waitlist_table' ); ?>

	<?php if ( $data ) : ?>
		<table class="wd-wtl-table shop_table shop_table_responsive shop-table-with-img">
			<thead>
				<tr>			
					<th class="product-remove"></th>
					<th class="product-thumbnail"></th>
					<th class="product-name">
						<?php esc_html_e( 'Product', 'woodmart' ); ?>
					</th>
					<th>
						<?php esc_html_e( 'Stock', 'woodmart' ); ?>
					</th>
					<?php if ( $show_confirmed_column ) : ?>
						<th>
							<?php esc_html_e( 'Confirmed', 'woodmart' ); ?>
							<span class="wd-hint wd-tooltip">
								<?php esc_html_e( 'Please confirm your subscription to the waitlist through the email that we have just sent to you within 2 days.', 'woodmart' ); ?>
							</span>
						</th>
					<?php endif; ?>
				</tr>
			</thead>

			<tbody>
			<?php
			foreach ( $data as $waitlist ) {
				$product_id = $waitlist->variation_id ? $waitlist->variation_id : $waitlist->product_id;
				$product    = wc_get_product( $product_id );

				if ( empty( $product ) ) {
					continue;
				}

				$confirmed     = $waitlist->confirmed;
				$product_link  = $product->get_permalink();
				$product_image = $product->get_image( 'shop_thumbnail' );
				$product_name  = $product->get_name();
				$attributes    = array();

				if ( 'variation' === $product->get_type() ) {
					foreach ( $product->get_attributes() as $taxonomy => $value ) {
						$attributes[] = array(
							'key'     => ucfirst( wc_attribute_label( $taxonomy ) ),
							'value'   => ucfirst( $value ),
							'display' => ucfirst( $value ),
						);
					}
				}

				if ( count( $attributes ) > 2 ) {
					$product_name = $product->get_title();
				}
				?>
				<tr>
					<td class="product-remove">
						<a href="#" class="wd-wtl-unsubscribe" data-product-id="<?php echo esc_attr( $product_id ); ?>">
							&times;
						</a>
					</td>
					<td class="product-thumbnail">
						<a class="product-image" href="<?php echo esc_url( $product_link ); ?>">
							<?php echo $product_image; // phpcs:ignore. ?>
						</a>
					</td>
					<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woodmart' ); ?>">
						<a class="product-title" href="<?php echo esc_url( $product_link ); ?>">
							<?php echo esc_html( $product_name ); ?>
						</a>
						<?php if ( isset( $attributes ) && ! empty( $attributes ) && count( $attributes ) > 2 ) : ?>
							<?php wc_get_template( 'cart/cart-item-data.php', array( 'item_data' => $attributes ) ); ?>
						<?php endif; ?>
					</td>
					<td data-title="<?php esc_attr_e( 'Stock', 'woodmart' ); ?>">
						<?php
						$status              = $product->get_availability(); //phpcs:ignore.
						$status_label        = $product->is_in_stock() ? esc_html__( 'In stock', 'woodmart' ) : esc_html__( 'Out of stock', 'woodmart' );  //phpcs:ignore.
						$stock_status_design = woodmart_get_opt( 'stock_status_design', 'default' );

						if ( isset( $status['class'] ) ) {
							$status['class'] .= ' wd-style-' . $stock_status_design;
						}

						if ( in_array( $stock_status_design, array( 'with-bg', 'bordered' ), true ) ) {
							$status_label = '<span>' . $status_label . '</span>';
						}
						?>

						<p class="stock <?php echo esc_attr( $status['class'] ); ?>">
							<?php echo wp_kses( $status_label, array( 'span' => array() ) ); ?>
						</p>
					</td>
					<?php if ( $show_confirmed_column ) : ?>
						<td data-title="<?php esc_attr_e( 'Confirmed', 'woodmart' ); ?>">
							<span class="<?php echo $confirmed ? esc_attr( 'wd-confirmed' ) : esc_attr( 'wd-not-confirmed' ); ?>"></span>
						</td>
					<?php endif; ?>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>

		<div class="wd-loader-overlay wd-fill"></div>

		<?php wc_get_template( 'loop/pagination.php', $paginate_args ); ?>
	<?php else : ?>
		<p class="wd-empty-wtl wd-empty-page">
			<?php esc_html_e( 'This waitlist is empty.', 'woodmart' ); ?>
		</p>

		<div class="wd-empty-page-text">
			<?php echo wp_kses( __( 'You don\'t have any products in the waiting list yet. Go to the shop and add out-of-stock items to your waitlist so you don\'t miss out when they\'re back in stock.', 'woodmart' ), woodmart_get_allowed_html() ); ?>
		</div>

		<p class="return-to-shop">
			<a class="button" href="<?php echo esc_url( apply_filters( 'woodmart_waitlist_return_to_shop_url', wc_get_page_permalink( 'shop' ) ) ); ?>">
				<?php esc_html_e( 'Return to shop', 'woodmart' ); ?>
			</a>
		</p>
	<?php endif; ?>

	<?php do_action( 'woodmart_after_waitlist_table' ); ?>
</div>
