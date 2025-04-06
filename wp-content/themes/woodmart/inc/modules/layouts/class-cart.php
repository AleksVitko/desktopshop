<?php

namespace XTS\Modules\Layouts;

use WP_Query;

class Cart extends Layout_Type {

	/**
	 * Cart item key.
	 *
	 * @var string
	 */
	private static $cart_item_key;

	/**
	 * Before template content.
	 */
	public function before_template_content() {
		get_header();

		?>
		<div class="wd-content-area site-content">
		<?php
	}

	/**
	 * After template content.
	 */
	public function after_template_content() {
		?>
		</div>
		<?php
		get_footer();
	}

	/**
	 * Check.
	 *
	 * @param  array  $condition  Condition.
	 * @param  string $type  Layout type.
	 */
	public function check( $condition, $type = '' ) {
		$is_active = false;

		if ( 'cart' === $type ) {
			switch ( $condition['condition_type'] ) {
				case 'cart':
					$is_active = is_cart() && ! WC()->cart->is_empty();
					break;
			}
		} elseif ( 'empty_cart' === $type ) {
			switch ( $condition['condition_type'] ) {
				case 'empty_cart':
					$is_active = is_cart() && WC()->cart->is_empty();
					break;
			}
		}

		return $is_active;
	}

	/**
	 * Override templates.
	 *
	 * @param  string $template  Template.
	 *
	 * @return bool|string
	 */
	public function override_template( $template ) {
		if ( woodmart_woocommerce_installed() && is_cart() && ( Main::get_instance()->has_custom_layout( 'cart' ) || Main::get_instance()->has_custom_layout( 'empty_cart' ) ) ) {
			$this->display_template();

			return false;
		}

		return $template;
	}

	/**
	 * Display custom template on the shop page.
	 */
	private function display_template() {
		$this->before_template_content();

		?>
		<div class="woocommerce entry-content">
			<?php if ( WC()->cart->is_empty() ) : ?>
				<span class="wc-empty-cart-message"></span>
				<?php $this->template_content( 'empty_cart' ); ?>
			<?php else : ?>
				<?php $this->template_content( 'cart' ); ?>
			<?php endif; ?>
		</div>
		<?php
		$this->after_template_content();
	}

	/**
	 * Setup cart data.
	 *
	 * @throws \Exception
	 */
	public static function setup_cart() {
		if ( ( Main::is_layout_type( 'cart' ) || Main::is_layout_type( 'checkout_form' ) ) && ! is_object( WC()->cart ) ) {
			if ( wp_is_serving_rest_request() ) {
				wc_load_cart();

				wc_clear_notices();
			}

			if ( ! WC()->cart || WC()->cart->cart_contents ) {
				return;
			}

			$product_id = woodmart_get_opt( 'single_product_builder_post_data' );

			if ( ! $product_id ) {
				$random_product = wc_get_products(
					array(
						'status' => 'publish',
						'limit'  => 1,
					)
				);

				if ( ! empty( $random_product[0] ) ) {
					$product_id = $random_product[0]->get_id();
				}
			}

			if ( $product_id ) {
				self::$cart_item_key = WC()->cart->add_to_cart( $product_id );
			}
		}
	}

	/**
	 * Reset cart data.
	 */
	public static function reset_cart() {
		if ( self::$cart_item_key && is_object( WC()->cart ) ) {
			WC()->cart->remove_cart_item( self::$cart_item_key );
		}
	}

}

Cart::get_instance();
