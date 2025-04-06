<?php
/**
 * Free gifts table.
 *
 * @var string $wrapper_classes String with wrapper classes.
 * @var array  $data Data for render table.
 *
 * @package Woodmart
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use XTS\Modules\Free_Gifts\Manager;

$add_gift_btn_disabled = false;

if ( woodmart_get_opt( 'free_gifts_allow_multiple_identical_gifts' ) && Manager::get_instance()->get_gifts_in_cart_count() >= woodmart_get_opt( 'free_gifts_limit', 5 ) ) {
	$add_gift_btn_disabled = true;
}
?>

<?php do_action( 'woodmart_before_free_gifts_table' ); ?>

<?php if ( ! isset( $settings['show_title'] ) || 'yes' === $settings['show_title'] ) : ?>
	<h4 class="title wd-el-title">
		<?php echo esc_html( _n( 'Choose your gift', 'Choose your gifts', count( $data ), 'woodmart' ) ); ?>
	</h4>
<?php endif; ?>

<table class="wd-fg-table shop_table shop_table_responsive shop-table-with-img">
	<tbody>
	<?php foreach ( $data as $free_gift_id ) : ?>
		<?php
			$free_gift_id      = apply_filters( 'wpml_object_id', $free_gift_id, 'product', true, apply_filters( 'wpml_current_language', null ) );
			$free_gift_product = wc_get_product( $free_gift_id );
			$product_permalink = apply_filters( 'woodmart_free_gift_item_permalink', $free_gift_product->is_visible() ? $free_gift_product->get_permalink() : '', $free_gift_id );
			$product_name      = apply_filters( 'woodmart_free_gift_item_name', $free_gift_product->get_name(), $free_gift_id );

			if ( ! woodmart_get_opt( 'free_gifts_allow_multiple_identical_gifts' ) ) {
				$add_gift_btn_disabled = false;

				if ( Manager::get_instance()->check_is_gift_in_cart( $free_gift_id ) ) {
					$add_gift_btn_disabled = true;
				}
			}
		?>
		<tr>
			<td class="product-thumbnail">
				<?php
				if ( ! $product_permalink ) {
					echo apply_filters( 'woodmart_free_gift_item_thumbnail', $free_gift_product->get_image(), $free_gift_id );
				} else {
					printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), apply_filters( 'woodmart_free_gift_item_thumbnail', $free_gift_product->get_image(), $free_gift_id ) );
				}
				?>
			</td>
			<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woodmart' ); ?>">
				<?php
				if ( ! $product_permalink ) {
					echo wp_kses_post( $product_name . '&nbsp;' );
				} else {
					/**
					 * This filter is documented above.
					 *
					 * @since 7.8.0
					 * @param string $product_url URL the product in the cart.
					 */
					echo wp_kses_post( apply_filters( 'woodmart_free_gift_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $free_gift_product->get_name() ), $free_gift_id ) );
				}

				if ( woodmart_get_opt( 'show_sku_in_cart' ) ) {
					?>
					<div class="wd-product-detail wd-product-sku">
						<span class="wd-label">
							<?php esc_html_e( 'SKU:', 'woodmart' ); ?>
						</span>
						<span>
							<?php if ( $free_gift_product->get_sku() ) : ?>
								<?php echo esc_html( $free_gift_product->get_sku() ); ?>
							<?php else : ?>
								<?php esc_html_e( 'N/A', 'woodmart' ); ?>
							<?php endif; ?>
						</span>
					</div>
					<?php
				}
				?>
			</td>
			<td class="product-btn">
				<a class="button wd-add-gift-product<?php echo $add_gift_btn_disabled ? ' wd-disabled' : ''; ?>" data-product-id="<?php echo esc_attr( $free_gift_id ); ?>" data-security="<?php echo esc_attr( wp_create_nonce( 'wd_free_gift_' . $free_gift_id ) ); ?>" href="#">
					<?php echo esc_html__( 'Add to cart', 'woodmart' ); ?>
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<div class="wd-loader-overlay wd-fill"></div>

<?php do_action( 'woodmart_after_free_gifts_table' ); ?>
