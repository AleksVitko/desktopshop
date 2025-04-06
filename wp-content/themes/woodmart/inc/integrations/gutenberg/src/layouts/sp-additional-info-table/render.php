<?php

use XTS\Modules\Layouts\Global_Data as Builder;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_additional_info_table' ) ) {
	function wd_gutenberg_single_product_additional_info_table( $block_attributes, $inner_content ) {
		$classes  = wd_get_gutenberg_element_classes( $block_attributes );
		$classes .= ' wd-layout-' . $block_attributes['layout'];
		$classes .= ' wd-style-' . $block_attributes['style'];

		if ( empty( $block_attributes['attrImage'] ) ) {
			$classes .= ' wd-hide-image';
		}
		if ( empty( $block_attributes['attrName'] ) ) {
			$classes .= ' wd-hide-name';
		}

		Main::setup_preview();

		global $product;

		$display_dimensions = apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() );
		$attributes         = array_keys( array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' ) );

		if ( $display_dimensions && $product->has_weight() ) {
			$attributes[] = 'weight';
		}

		if ( $display_dimensions && $product->has_dimensions() ) {
			$attributes[] = 'dimensions';
		}

		$include = array();
		$exclude = array();

		if ( 'include' === $block_attributes['source'] && ! empty( $block_attributes['include'] ) ) {
			$raw_include = explode( ',', $block_attributes['include'] );
			$include     = array_map( 'wc_attribute_taxonomy_name_by_id', wp_parse_id_list( $raw_include ) );

			if ( in_array( 'weight', $raw_include, true ) ) {
				$include[] = 'weight';
			} elseif ( in_array( 'dimensions', $raw_include, true ) ) {
				$include[] = 'dimensions';
			}
		}

		if ( 'include' !== $block_attributes['source'] && ! empty( $block_attributes['exclude'] ) ) {
			$raw_exclude = explode( ',', $block_attributes['exclude'] );
			$exclude     = array_map( 'wc_attribute_taxonomy_name_by_id', wp_parse_id_list( $raw_exclude ) );

			if ( in_array( 'weight', $raw_exclude, true ) ) {
				$exclude[] = 'weight';
			} elseif ( in_array( 'dimensions', $raw_exclude, true ) ) {
				$exclude[] = 'dimensions';
			}
		}

		if ( $include ) {
			if ( $include === $exclude || ! array_intersect( $attributes, $include ) ) {
				Main::restore_preview();
				return '';
			}

			Builder::get_instance()->set_data( 'wd_product_attributes_include', $include );
		}

		if ( $exclude ) {
			if ( ! array_diff( $attributes, $exclude ) ) {
				Builder::get_instance()->set_data( 'wd_product_attributes_include', array() );
				Main::restore_preview();
				return '';
			}

			Builder::get_instance()->set_data( 'wd_product_attributes_exclude', $exclude );
		}

		ob_start();

		do_action( 'woocommerce_product_additional_information', $product );

		Builder::get_instance()->set_data( 'wd_product_attributes_include', array() );
		Builder::get_instance()->set_data( 'wd_product_attributes_exclude', array() );

		$content = ob_get_clean();

		if ( ! $content ) {
			Main::restore_preview();
			return '';
		}

		ob_start();

		?>
		<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-attrs<?php echo esc_attr( $classes ); ?>">
			<?php if ( ! empty( $block_attributes['title'] ) ) : ?>
				<?php echo do_shortcode( $inner_content ); ?>
			<?php endif; ?>

			<?php echo $content; //phpcs:ignore ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
