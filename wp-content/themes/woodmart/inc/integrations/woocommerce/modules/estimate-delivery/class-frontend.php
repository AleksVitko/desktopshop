<?php
/**
 * Estimate delivery class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Estimate_Delivery;

use XTS\Singleton;
use WC_Product;
use WC_Order;
use WC_Order_Item;
use Automattic\WooCommerce\Utilities\FeaturesUtil;

/**
 * Estimate delivery class.
 *
 * @codeCoverageIgnore
 */
class Frontend extends Singleton {
	/**
	 * Manager instance.
	 *
	 * @var Manager instanse.
	 */
	public $manager;

	/**
	 * Init.
	 */
	public function init() {
		$this->manager = Manager::get_instance();

		// Enqueue scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Single product.
		add_action( 'woocommerce_single_product_summary', array( $this, 'render_on_single_product' ), 39 );

		add_action( 'wp_ajax_woodmart_update_delivery_dates', array( $this, 'update_delivery_dates' ) );
		add_action( 'wp_ajax_nopriv_woodmart_update_delivery_dates', array( $this, 'update_delivery_dates' ) );

		// Cart.
		add_action( 'woocommerce_after_cart_item_name', array( $this, 'render_delivery_detail_on_cart' ) );
		add_action( 'woocommerce_cart_totals_after_order_total', array( $this, 'render_overall' ) );

		// Chekout.
		add_action( 'woocommerce_review_order_after_order_total', array( $this, 'render_overall' ) );

		// Order details (order confirmation or emails).
		add_action( 'woocommerce_order_item_meta_start', array( $this, 'render_delivery_detail_on_order_meta' ), 10, 2 );
		add_action( 'woocommerce_get_order_item_totals', array( $this, 'render_overall_on_order_meta' ), 10, 3 );

		// Admin order.
		add_action( 'woocommerce_before_order_itemmeta', array( $this, 'render_admin_order_item_meta' ), 10, 3 );
		add_action( 'woocommerce_admin_order_totals_after_shipping', array( $this, 'render_admin_overal_order_item_meta' ) );
	}

	/**
	 * Update delivery dates using ajax.
	 *
	 * @return void
	 */
	public function update_delivery_dates() {
		if ( empty( $_GET['product_id'] ) ) {
			return;
		}

		$product_id = absint( $_GET['product_id'] );
		$product    = wc_get_product( $product_id );

		if ( ! $product instanceof WC_Product ) {
			return;
		}

		$delivery_date        = new Delivery_Date( $product );
		$delivery_date_string = $delivery_date->get_full_date_string();

		wp_send_json(
			array(
				'fragments' => array(
					'.wd-est-del[data-product-id="' . $product_id . '"] .wd-info-msg' => $delivery_date_string,
				),
			)
		);
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {
		if ( ! woodmart_get_opt( 'estimate_delivery_enabled' ) ) {
			return;
		}

		if ( woodmart_get_opt( 'estimate_delivery_fragments_enable' ) && is_product() ) {
			woodmart_enqueue_js_script( 'update-delivery-dates' );
		}

		if ( is_cart() ) {
			woodmart_enqueue_js_script( 'estimate-delivery-on-cart' );
		}

		if (
			( woodmart_get_opt( 'estimate_delivery_show_on_single_product' ) && is_product() ) ||
			( woodmart_get_opt( 'estimate_delivery_show_overall' ) && ( is_cart() || is_checkout() ) )
		) {
			woodmart_enqueue_inline_style( 'woo-mod-product-info' );
			woodmart_enqueue_inline_style( 'woo-opt-est-del' );
		}
	}

	/**
	 * Enqueue admin scripts.
	 */
	public function enqueue_admin_scripts() {
		if ( ! woodmart_get_opt( 'estimate_delivery_enabled' ) ) {
			return;
		}

		if ( isset( $_GET['page'] ) && 'wc-orders' === $_GET['page'] ) {
			wp_enqueue_style(
				'xts-int-woo-page-orders',
				WOODMART_ASSETS . '/css/parts/int-woo-page-orders.min.css',
				array(),
				woodmart_get_theme_info( 'Version' )
			);
		}
	}

	/**
	 * Render output html.
	 *
	 * @param string $classes     Custom classes for estimate delivery wrapper.
	 * @param string $icon_output Icon html for output in estimate delivery.
	 *
	 * @return void
	 */
	public function render_on_single_product( $classes = '', $icon_output = '' ) {
		global $product;

		if ( ! woodmart_get_opt( 'estimate_delivery_show_on_single_product' ) || woodmart_loop_prop( 'is_quick_view' ) ) {
			return;
		}

		$delivery_date        = new Delivery_Date( $product );
		$delivery_date_string = $delivery_date->get_full_date_string();

		if ( empty( $delivery_date_string ) ) {
			if ( ! woodmart_get_opt( 'estimate_delivery_fragments_enable' ) ) {
				return;
			}

			$classes .= ' wd-hide';
		}

		if ( empty( $icon_output ) ) {
			$icon_output = '<span class="wd-info-icon"></span>';
		}

		$tooltip_content = $delivery_date->get_rule_meta_box( 'est_del_tooltip_content' );
		?>
		<div class="wd-product-info wd-est-del<?php echo esc_attr( $classes ); ?>" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>">
			<?php echo $icon_output; // phpcs:ignore. ?><span class="wd-info-msg"><?php echo wp_kses( $delivery_date_string, 'strong' ); ?></span>
			<?php
			if ( ! empty( $tooltip_content ) ) {
				$this->render_tooltip( $tooltip_content );
			}
			?>
		</div>
		<?php
	}

	/**
	 * Render delivery detail on cart and mini cart pages when options is enabled.
	 *
	 * @param object $cart_item Cart item.
	 * @param bool   $hide_tooltip if this value is true, then the toltip will be hidden.
	 *
	 * @return void
	 */
	public function render_delivery_detail_on_cart( $cart_item, $hide_tooltip = false ) {
		if ( is_cart() && ! woodmart_get_opt( 'estimate_delivery_show_on_cart_page' ) ) {
			return;
		}

		$this->render_delivery_detail( $cart_item['data'], false, $hide_tooltip );
	}

	/**
	 * Render delivery detail on checkout page.
	 *
	 * @param object $product Product pbject.
	 *
	 * @return void
	 */
	public function render_delivery_detail_on_checkout( $product ) {
		if ( ! is_checkout() || ! woodmart_get_opt( 'estimate_delivery_show_on_checkout_page' ) ) {
			return;
		}

		$this->render_delivery_detail( $product );
	}

	/**
	 * Render delivery date for order item on frontend.
	 *
	 * @param int|string            $order_item_id Order item id.
	 * @param WC_Order_Item_Product $order_item Instance of WC_Order_Item_Product class.
	 *
	 * @return void
	 */
	public function render_delivery_detail_on_order_meta( $order_item_id, $order_item ) {
		$is_order_detail_page  = is_wc_endpoint_url( 'view-order' ) || is_wc_endpoint_url( 'order-received' ) || is_wc_endpoint_url( 'order-pay' );
		$show_on_order_details = woodmart_get_opt( 'estimate_delivery_show_on_order_details' ) && $is_order_detail_page;
		$show_on_email         = woodmart_get_opt( 'estimate_delivery_show_on_email_order' ) && ! $is_order_detail_page;

		if ( ! $show_on_order_details && ! $show_on_email ) {
			return;
		}

		$product_id = $order_item->get_variation_id() ? $order_item->get_variation_id() : $order_item->get_product_id();
		$product    = wc_get_product( $product_id );

		if ( woodmart_is_email_preview_request() ) {
			$this->render_delivery_detail_on_preview_email();
		} else {
			$order        = wc_get_order( $order_item->get_order_id() );
			$date_created = $order->get_date_created();
			$order_date   = $date_created ? $date_created->date( 'Y-m-d H:i:s' ) : false;

			$this->render_delivery_detail( $product, $order_date );
		}
	}

	/**
	 * Render delivery date for order item on admin panel.
	 *
	 * @param int|string    $order_item_id Order item id.
	 * @param WC_Order_Item $order_item Instance of WC_Order_Item_Product class.
	 * @param WC_Product    $product Instance of WC_Product class.
	 *
	 * @return void
	 */
	public function render_admin_order_item_meta( $order_item_id, $order_item, $product ) {
		if ( ! woodmart_get_opt( 'estimate_delivery_show_on_order_details' ) || 'line_item' !== $order_item->get_type() ) {
			return;
		}

		$shipping_method_id = false;
		$order              = wc_get_order( $order_item->get_order_id() );
		$shipping_methods   = $order->get_shipping_methods();

		if ( ! empty( $shipping_methods ) ) {
			$shipping_method    = array_pop( $shipping_methods );
			$shipping_method_id = $shipping_method->get_instance_id();
		}

		$date_created = $order->get_date_created();
		$order_date   = $date_created ? $date_created->date( 'Y-m-d H:i:s' ) : false;

		$delivery_date = new Delivery_Date( $product, $shipping_method_id, $order_date );
		$text          = $delivery_date->get_label();
		$date          = $delivery_date->get_date();

		if ( empty( $date ) ) {
			return;
		}
		?>
		<div class="view">
			<table class="display_meta xts-product-detail">
				<tbody>
					<tr>
						<?php if ( ! empty( $text ) ) : ?>
							<th><?php echo esc_html( $text ) . ': '; ?></th>
						<?php endif; ?>
						<td>
							<p><?php echo esc_html( $date ); ?></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Render delivery date for order item on admin panel.
	 *
	 * @param int|string $order_item_id Order item id.
	 *
	 * @return void
	 */
	public function render_admin_overal_order_item_meta( $order_item_id ) {
		if ( ! woodmart_get_opt( 'estimate_delivery_show_overall' ) ) {
			return;
		}

		$order              = wc_get_order( $order_item_id );
		$shipping_methods   = $order->get_shipping_methods();
		$date_created       = $order->get_date_created();
		$order_date         = $date_created ? $date_created->date( 'Y-m-d H:i:s' ) : false;
		$shipping_method_id = false;

		foreach ( $shipping_methods as $shipping_method ) {
			$shipping_method_id = $shipping_method->get_instance_id();
		}

		$products     = $this->get_product_by_order( $order );
		$overal_dates = new Overal_Delivery_Date( $products, $shipping_method_id, $order_date );
		$text         = $overal_dates->get_label();
		$date         = $overal_dates->get_date();

		if ( empty( $text ) || empty( $date ) ) {
			return;
		}
		?>
		<tr>
			<?php if ( ! empty( $text ) ) : ?>
				<td class="label"><?php echo esc_html( $text ) . ': '; ?></td>
				<td width="1%"></td>
			<?php endif; ?>
			<td class="total">
				<strong><?php echo esc_html( $date ); ?></strong>
			</td>
		</tr>
		<?php
	}

	/**
	 * Render delivery detail.
	 *
	 * @param object    $product Product pbject.
	 * @param int|false $date_created Order date created.
	 * @param bool      $hide_tooltip if this value is true, then the toltip will be hidden.
	 *
	 * @return void
	 */
	public function render_delivery_detail( $product, $date_created = false, $hide_tooltip = false ) {
		$delivery_date     = new Delivery_Date( $product, false, $date_created );
		$delivery_text     = $delivery_date->get_label();
		$delivery_date_str = $delivery_date->get_date();
		$tooltip_content   = $delivery_date->get_rule_meta_box( 'est_del_tooltip_content' );

		if ( empty( $delivery_date_str ) ) {
			return;
		}
		?>
		<div class="wd-product-detail wd-delivery-detail">
			<?php if ( ! empty( $delivery_text ) ) : ?>
				<span class="wd-label">
					<?php echo esc_html( $delivery_text ) . ':'; ?>
				</span>
			<?php endif; ?>
			<span>
				<?php echo esc_html( $delivery_date_str ); ?>
			</span>
			<?php
			if ( ! $hide_tooltip && ! empty( $tooltip_content ) ) {
				$this->render_tooltip( $tooltip_content );
			}
			?>
		</div>
		<?php
	}

	/**
	 * Render delivery detail on preview email.
	 *
	 * @return void
	 */
	public function render_delivery_detail_on_preview_email() {
		$date_format        = woodmart_get_opt( 'estimate_delivery_date_format', 'M j, Y' );
		$date_format        = 'default' === $date_format ? get_option( 'date_format' ) : $date_format;
		$date_format        = apply_filters( 'woodmart_est_del_date_format', $date_format );
		$delivery_date_str  = wp_date( $date_format, strtotime( 'now' ) );
		$delivery_date_str .= apply_filters( 'woodmart_dates_separator', ' – ' );
		$delivery_date_str .= wp_date( $date_format, strtotime( '+2 days' ) );
		?>
		<div class="wd-product-detail wd-delivery-detail">
			<span class="wd-label">
				<?php echo esc_html__( 'Estimated delivery dates', 'woodmart' ) . ':'; ?>
			</span>
			<span>
				<?php echo esc_html( $delivery_date_str ); ?>
			</span>
		</div>
		<?php
	}

	/**
	 * Render tooltip.
	 *
	 * @param string $content html string.
	 *
	 * @return void
	 */
	public function render_tooltip( $content ) {
		$position = 'top';

		if ( is_wc_endpoint_url( 'view-order' ) || is_wc_endpoint_url( 'order-received' ) ) {
			$position = ! is_rtl() ? 'right' : 'left';
		}
		?>
			<div class="wd-hint wd-tltp">
				<div class="tooltip <?php echo esc_attr( $position ); ?>">
					<div class="tooltip-arrow"></div>
					<div class="tooltip-inner color-scheme-light">
					<?php echo wp_kses_post( $content ); ?>
					</div>
				</div>
			</div>
		<?php
	}

	/**
	 * Render overall delivery detail on order details.
	 *
	 * @param array    $total_rows List of order tfooter data.
	 * @param WC_Order $order Order item.
	 * @param string   $tax_display Tax to display.
	 *
	 * @return array
	 */
	public function render_overall_on_order_meta( $total_rows, $order, $tax_display ) {
		if ( ! woodmart_get_opt( 'estimate_delivery_show_overall' ) ) {
			return $total_rows;
		}

		$date_created     = $order->get_date_created();
		$order_date       = $date_created ? $date_created->date( 'Y-m-d H:i:s' ) : false;
		$products         = $this->get_product_by_order( $order );
		$overal_dates     = new Overal_Delivery_Date( $products, false, $order_date );
		$est_del_row_data = $overal_dates->get_date_array();

		if ( empty( $est_del_row_data ) ) {
			return $total_rows;
		}

		$insert_after_index = array_search( 'shipping', array_keys( $total_rows ), true );
		$est_del_row_data   = array(
			'est_del' => $est_del_row_data,
		);

		$total_rows = array_slice( $total_rows, 0, $insert_after_index + 1, true ) + $est_del_row_data + array_slice( $total_rows, $insert_after_index + 1, null, true );

		return $total_rows;
	}

	/**
	 * Render delivery overall detail html.
	 *
	 * @return void
	 */
	public function render_overall() {
		if ( ! woodmart_get_opt( 'estimate_delivery_show_overall' ) || ! isset( WC()->cart ) ) {
			return;
		}

		$cart_items = WC()->cart->get_cart();
		$products   = array();

		foreach ( $cart_items as $cart_item ) {
			$products[] = $cart_item['data'];
		}

		$overal_dates         = new Overal_Delivery_Date( $products );
		$delivery_date_string = $overal_dates->get_date_string();

		if ( empty( $delivery_date_string ) ) {
			return;
		}
		?>
		<tr class="wd-del-overall">
			<td colspan="100">
				<div class="wd-product-info wd-est-del">
					<span class="wd-info-icon"></span><span class="wd-info-msg"><?php echo wp_kses( $delivery_date_string, 'strong' ); ?></span>

					<div class="wd-loader-overlay wd-fill"></div>
				</div>
			</td>
		</tr>
		<?php
	}

	/**
	 * Get product by order.
	 *
	 * @param WC_Order $order Order item.
	 *
	 * @return WC_Product
	 */
	public function get_product_by_order( $order ) {
		$order_items = $order->get_items();
		$products    = array();

		foreach ( $order_items as $order_item ) {
			$product_id = $order_item->get_variation_id() ? $order_item->get_variation_id() : $order_item->get_product_id();
			$products[] = wc_get_product( $product_id );
		}

		return $products;
	}
}

Frontend::get_instance();
