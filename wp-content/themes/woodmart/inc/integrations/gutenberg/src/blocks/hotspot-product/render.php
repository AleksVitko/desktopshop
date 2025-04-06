<?php
if ( ! function_exists( 'wd_gutenberg_hotspot_product_block' ) ) {
	function wd_gutenberg_hotspot_product_block( $block_attributes ) {
		$product_id = isset( $block_attributes['productId'] ) ? $block_attributes['productId'] : '';

		if( ! $product_id || ! woodmart_woocommerce_installed() ) {
			return '';
		}

		$product = wc_get_product( apply_filters( 'wpml_object_id', $product_id, 'product', true ) );

		if ( ! $product ) {
			return '';
		}

		$rating_count = $product->get_rating_count();
		$average      = $product->get_average_rating();

		if ( 'nothing' !== woodmart_get_opt( 'add_to_cart_action' ) ) {
			woodmart_enqueue_js_script( 'action-after-add-to-cart' );
		}

		if ( 'popup' === woodmart_get_opt( 'add_to_cart_action' ) ) {
			woodmart_enqueue_js_library( 'magnific' );
			woodmart_enqueue_inline_style( 'add-to-cart-popup' );
			woodmart_enqueue_inline_style( 'mfp-popup' );
		}

		$add_to_cart_args = array(
			'class'      => implode(
				' ',
				array_filter(
					array(
						'button',
						'product_type_' . $product->get_type(),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
					)
				)
			),
			'attributes' => wc_implode_html_attributes(
				array(
					'data-product_id' => $product->get_id(),
					'rel'             => 'nofollow',
				)
			),
			'url'        => $product->add_to_cart_url(),
			'text'       => $product->add_to_cart_text(),
		);

		ob_start();

		?>
		<div class="wd-spot-product">
			<div class="wd-spot-image">
				<a href="<?php echo esc_url( get_permalink( $product->get_ID() ) ); ?>">
					<?php echo $product->get_image(); ?>
				</a>
			</div>

			<h4 class="title">
				<a href="<?php echo esc_url( get_permalink( $product->get_ID() ) ); ?>">
					<?php echo esc_html( $product->get_title() ); ?>
				</a>
			</h4>

			<?php if ( wc_review_ratings_enabled() ) : ?>
				<?php echo wc_get_rating_html( $average, $rating_count ); ?>
			<?php endif; ?>

			<div class="price">
				<?php echo $product->get_price_html(); ?>
			</div>

			<div class="wd-spot-content wd-more-desc reset-last-child">
				<div class="wd-more-desc-inner">
					<?php echo do_shortcode( $product->get_short_description() ); ?>
				</div>
				<a href="#" rel="nofollow" class="wd-more-desc-btn" aria-label="<?php esc_html_e( 'Read more description', 'woodmart' ); ?>"></a>
			</div>

			<a href="<?php echo esc_url( $add_to_cart_args['url'] ); ?>" class="<?php echo esc_attr( $add_to_cart_args['class'] ); ?>" <?php echo wp_kses( $add_to_cart_args['attributes'], true ); ?>>
				<?php echo esc_html( $add_to_cart_args['text'] ); ?>
			</a>
		</div>
		<?php

		return ob_get_clean();

	}
}
