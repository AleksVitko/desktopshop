<?php
/**
 * Free gifts class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Free_Gifts;

use XTS\Singleton;
use XTS\Modules\Layouts\Main as Layouts;
use XTS\Modules\Unit_Of_Measure\Main as Unit_Of_Measure;

/**
 * Free gifts class.
 */
class Frontend extends Singleton {
	/**
	 * Manager instance.
	 *
	 * @var Manager instanse.
	 */
	public $manager;

	/**
	 * List of free gifts data.
	 *
	 * @var $free_gifts List of free gifts data.
	 */
	public $free_gifts = array();

	/**
	 * Init.
	 */
	public function init() {
		$this->manager = Manager::get_instance();

		add_action( 'woocommerce_before_mini_cart_contents', array( $this, 'enqueue_style' ) );

		add_action( woodmart_get_opt( 'free_gifts_table_location', 'woocommerce_after_cart_table' ), array( $this, 'output_free_gifts_table' ) );

		add_action( 'wp_ajax_woodmart_update_gifts_table', array( $this, 'update_gifts_table' ) );
		add_action( 'wp_ajax_nopriv_woodmart_update_gifts_table', array( $this, 'update_gifts_table' ) );

		add_filter( 'woocommerce_cart_item_remove_link', array( $this, 'cart_item_remove_link' ), 10, 2 );

		add_filter( 'woocommerce_order_item_name', array( $this, 'cart_item_name' ), 10, 2 );
		add_filter( 'woocommerce_cart_item_name', array( $this, 'cart_item_name' ), 10, 2 );

		add_filter( 'woocommerce_cart_item_price', array( $this, 'set_cart_item_price' ), 10, 3 );
		add_filter( 'woocommerce_cart_item_subtotal', array( $this, 'set_cart_item_subtotal' ), 10, 3 );

		add_filter( 'woocommerce_cart_item_quantity', array( $this, 'cart_item_quantity' ), 10, 2 );
		add_filter( 'woodmart_show_widget_cart_item_quantity', array( $this, 'widget_cart_item_quantity' ), 10, 2 );
		add_action( 'woocommerce_after_cart_item_quantity_update', array( $this, 'update_cart_item_quantity' ), 10, 4 );
	}

	/**
	 * Enqueue cart style.
	 *
	 * @return void
	 */
	public function enqueue_style() {
		if ( ! is_object( WC()->cart ) || 0 === WC()->cart->get_cart_contents_count() ) {
			return;
		}

		foreach ( WC()->cart->cart_contents as $product_cart ) {
			if ( ! empty( $product_cart['wd_is_free_gift'] ) ) {
				woodmart_enqueue_inline_style( 'woo-mod-cart-labels' );

				return;
			}
		}
	}

	/**
	 * Add render actions.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public function output_free_gifts_table() {
		if ( ! woodmart_get_opt( 'free_gifts_enabled', 0 ) || woodmart_get_opt( 'free_gifts_limit', 5 ) < 1 || Layouts::get_instance()->has_custom_layout( 'cart' ) ) {
			return;
		}

		$wrapper_classes = '';

		woodmart_enqueue_js_script( 'free-gifts-table' );

		ob_start();

		$this->render_free_gifts_table();

		$table_html = ob_get_clean();

		if ( ! $table_html ) {
			$wrapper_classes .= ' wd-hide';
		}

		?>
		<div class="wd-fg<?php echo esc_attr( $wrapper_classes ); ?>"><?php echo $table_html; ?></div>
		<?php
	}

	/**
	 * Update gift table after updated cart.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public function update_gifts_table() {
		ob_start();

		$this->render_free_gifts_table();

		$table_html = ob_get_clean();

		wp_send_json(
			array(
				'html' => '<div class="wd-fg">' . $table_html . '</div>',
			)
		);
		die();
	}

	/**
	 * Render free gifts table.
	 *
	 * @return void
	 */
	public function render_free_gifts_table( $settings = array() ) {
		$manual_gifts_ids  = array();
		$allowed_rules     = array();
		$manual_gifts_rule = $this->manager->get_rules( 'manual' );

		foreach ( WC()->cart->get_cart() as $cart ) {
			if ( isset( $cart['wd_is_free_gift'] ) ) {
				continue;
			}

			$product = $cart['data'];

			foreach ( $manual_gifts_rule as $gift_rule_id => $gift_rule ) {
				if ( empty( $gift_rule['free_gifts'] ) ) {
					continue;
				}

				if ( ! in_array( $gift_rule_id, $allowed_rules, true ) && $this->manager->check_free_gifts_condition( $gift_rule, $product ) && $this->manager->check_free_gifts_totals( $gift_rule ) ) {
					$manual_gifts_ids = array_merge( $manual_gifts_ids, $gift_rule['free_gifts'] );
					$allowed_rules[]  = $gift_rule_id;
				}
			}
		}

		$manual_gifts_ids = array_unique( $manual_gifts_ids );

		if ( empty( $manual_gifts_ids ) ) {
			return;
		}

		wc_get_template(
			'cart/free-gifts-table.php',
			array(
				'data'     => $manual_gifts_ids,
				'settings' => $settings,
			)
		);
	}

	/**
	 * Get cart item remove link.
	 *
	 * @param string $remove_link Remove link.
	 * @param string $cart_item_key Key for the product in the cart.
	 *
	 * @return string
	 */
	public function cart_item_remove_link( $remove_link, $cart_item_key ) {
		if ( ! is_object( WC()->cart ) ) {
			return $remove_link;
		}

		$cart_items = WC()->cart->get_cart();

		if ( isset( $cart_items[ $cart_item_key ]['wd_is_free_gift_automatic'] ) ) {
			return '';
		}

		return $remove_link;
	}

	/**
	 * Update title in cart for free gifts product.
	 *
	 * @codeCoverageIgnore
	 * @param string $item_name Product title.
	 * @param array  $item Product data.
	 *
	 * @return string
	 */
	public function cart_item_name( $item_name, $item ) {
		if ( ! empty( $item['wd_is_free_gift'] ) ) {
			ob_start();

			woodmart_enqueue_js_library( 'tooltips' );
			woodmart_enqueue_js_script( 'btns-tooltips' );

			?>
			<span class="wd-cart-label wd-fg-label wd-tooltip">
				<?php esc_html_e( 'Free gift', 'woodmart' ); ?>
			</span>
			<?php

			$item_name .= ob_get_clean();
		}

		return $item_name;
	}

	/**
	 * Set the cart item price html.
	 *
	 * @codeCoverageIgnore
	 * @param string $price Price html.
	 * @param array  $cart_item The product in the cart.
	 * @param string $cart_item_key Key for the product in the cart.
	 *
	 * @return string
	 */
	public function set_cart_item_price( $price, $cart_item, $cart_item_key ) {
		if ( ! isset( $cart_item['wd_is_free_gift'] ) ) {
			return $price;
		}

		return $this->get_gift_product_price( $price, $cart_item );
	}

	/**
	 * Set the cart item subtotal.
	 *
	 * @codeCoverageIgnore
	 * @param string $price Price html.
	 * @param array  $cart_item The product in the cart.
	 * @param string $cart_item_key Key for the product in the cart.
	 *
	 * @return string
	 */
	public function set_cart_item_subtotal( $price, $cart_item, $cart_item_key ) {
		if ( ! isset( $cart_item['wd_is_free_gift'] ) ) {
			return $price;
		}

		return $this->get_gift_product_price( $price, $cart_item, true );
	}

	/**
	 * Cart item quantity.
	 *
	 * @codeCoverageIgnore
	 * @param string $quantity Quantity content.
	 * @param string $cart_item_key Product key.
	 *
	 * @return string
	 */
	public function cart_item_quantity( $quantity, $cart_item_key ) {
		$item = WC()->cart->get_cart_item( $cart_item_key );

		if ( isset( $item['wd_is_free_gift'] ) && ! $item['data']->is_sold_individually() ) {
			return '<span>' . $item['quantity'] . '</span>';
		}

		return $quantity;
	}

	/**
	 * Widget cart item quantity.
	 *
	 * @param boolean $show Show quantity.
	 * @param string  $cart_item_key Product key.
	 *
	 * @return bool
	 */
	public function widget_cart_item_quantity( $show, $cart_item_key ) {
		$item = WC()->cart->get_cart_item( $cart_item_key );

		if ( isset( $item['wd_is_free_gift'] ) ) {
			return false;
		}

		return $show;
	}

	/**
	 * Set the quantity limit for gift products.
	 *
	 * @param string  $cart_item_key Item key.
	 * @param integer $quantity New quantity.
	 * @param integer $old_quantity Old quantity.
	 * @param object  $cart Cart data.
	 *
	 * @return void
	 */
	public function update_cart_item_quantity( $cart_item_key, $quantity, $old_quantity, $cart ) {
		if ( ! isset( $cart->cart_contents[ $cart_item_key ]['wd_is_free_gift'] ) || ( ! isset( $cart->cart_contents[ $cart_item_key ]['wd_is_free_gift_automatic'] ) && woodmart_get_opt( 'free_gifts_allow_multiple_identical_gifts' ) ) ) { //phpcs:ignore
			return;
		}

		if ( $quantity > 1 ) {
			if ( ! isset( $cart->cart_contents[ $cart_item_key ]['wd_is_free_gift_automatic'] ) && ! wc_has_notice( $this->manager->get_notices( 'already_added' ), 'error' ) ) {
				wc_add_notice( $this->manager->get_notices( 'already_added' ), 'error' );
			}

			$cart->cart_contents[ $cart_item_key ]['quantity'] = 1;
		}
	}

	/**
	 * Get the gift product price.
	 *
	 * @codeCoverageIgnore
	 * @param string $price Price html.
	 * @param array  $cart_item The product in the cart.
	 * @param bool   $multiply_qty Is multiply qty.
	 *
	 * @return string
	 */
	public function get_gift_product_price( $price, $cart_item, $multiply_qty = false ) {
		if ( ! isset( $cart_item['wd_is_free_gift'] ) ) {
			return $price;
		}

		$product_id = ! empty( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];
		$product    = wc_get_product( $product_id );

		if ( ! is_object( $product ) ) {
			return $price;
		}

		$product_price = $multiply_qty ? (float) $cart_item['quantity'] * (float) $product->get_price() : $product->get_price();

		if ( 'discount' === woodmart_get_opt( 'free_gifts_price_format', 'text' ) ) {
			ob_start();

			$unit_of_measure = Unit_Of_Measure::get_instance()->get_unit_of_measure_db( $product );
			?>
			<span class="price">
				<del><?php echo wc_price( $product_price ); // phpcs:ignore ?></del>
				<ins><?php echo wc_price( apply_filters( 'woodmart_free_gift_set_product_cart_price', 0, $cart_item ) ); // phpcs:ignore ?></ins>
			</span>
			<?php if ( ! empty( $unit_of_measure ) ) : ?>
				<span class="wd-price-unit">
					<?php echo $unit_of_measure; //phpcs:ignore. ?>
				</span>
			<?php endif; ?>
			<?php
			$display_price = ob_get_clean();
		} else {
			ob_start();
			?>
			<span class="amount">
				<?php esc_html_e( 'Free', 'woodmart' ); ?>
			</span>
			<?php
			$display_price = ob_get_clean();
		}

		return $display_price;
	}
}

Frontend::get_instance();
