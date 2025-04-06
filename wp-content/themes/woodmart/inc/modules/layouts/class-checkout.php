<?php

namespace XTS\Modules\Layouts;

class Checkout extends Layout_Type {
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

		if ( 'checkout_form' === $type ) {
			switch ( $condition['condition_type'] ) {
				case 'checkout_form':
					$is_active = ( is_checkout() && ! is_order_received_page() && ! is_wc_endpoint_url( 'order-pay' ) ) || ( is_singular( 'woodmart_layout' ) && Main::is_layout_type( 'checkout_content' ) );
					break;
			}
		} elseif ( 'checkout_content' === $type ) {
			switch ( $condition['condition_type'] ) {
				case 'checkout_content':
					$is_active = ( is_checkout() && ! is_order_received_page() && ! is_wc_endpoint_url( 'order-pay' ) ) || ( is_singular( 'woodmart_layout' ) && Main::is_layout_type( 'checkout_form' ) );
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
		if ( woodmart_woocommerce_installed() && is_checkout() && ! is_order_received_page() && ! is_wc_endpoint_url( 'order-pay' ) && ( Main::get_instance()->has_custom_layout( 'checkout_content' ) || Main::get_instance()->has_custom_layout( 'checkout_form' ) ) ) {
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
			<?php if ( 'native' === woodmart_get_opt( 'current_builder' ) ) : ?>
				<?php if ( Main::get_instance()->has_custom_layout( 'checkout_form' ) ) : ?>
					<?php $this->template_content( 'checkout_form' ); ?>
				<?php elseif ( Main::get_instance()->has_custom_layout( 'checkout_content' ) ) : ?>
					<?php $this->template_content( 'checkout_content' ); ?>
				<?php endif; ?>
			<?php else : ?>
				<?php if ( Main::get_instance()->has_custom_layout( 'checkout_content' ) ) : ?>
					<?php $this->template_content( 'checkout_content' ); ?>
				<?php else : ?>
					<?php $this->get_default_top_content(); ?>
				<?php endif; ?>

				<?php if ( function_exists( 'WC' ) && ! WC()->checkout()->is_registration_enabled() && WC()->checkout()->is_registration_required() && ! is_user_logged_in() ) : ?>
					<?php echo wp_kses_post( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) ); ?>
				<?php else : ?>
					<form name="checkout" method="post" class="checkout woocommerce-checkout wd-checkout-form" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">
						<?php $this->template_content( 'checkout_form' ); ?>
					</form>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php
		$this->after_template_content();
	}

	/**
	 * Get default top content.
	 *
	 * @return void
	 */
	protected function get_default_top_content() {
		woocommerce_output_all_notices();

		ob_start();

		woocommerce_checkout_coupon_form();

		$coupon_form = ob_get_clean();

		if ( $coupon_form ) {
			echo '<div class="wd-checkout-coupon">' . $coupon_form . '</div>';
		}

		ob_start();

		woocommerce_checkout_login_form();

		$login_form = ob_get_clean();

		if ( $login_form ) {
			echo '<div class="wd-checkout-login">' . $login_form . '</div>';
		}
	}
}

Checkout::get_instance();
