<?php
/**
 * Compare images shortcode.
 *
 * @package WoodMart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_shortcode_compare_images' ) ) {
	function woodmart_shortcode_compare_images( $atts ) {
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		$atts = shortcode_atts(
			array(
				'css'                 => '',
				'woodmart_css_id'     => '',
				'first_image'         => '',
				'first_image_size'    => 'full',
				'second_image'        => '',
				'second_image_size'   => 'full',
				'alignment'           => '',
				'handle_color_scheme' => 'inherit',
			),
			$atts
		);

		$wrapper_classes .= ' wd-compare-img-wrapp';
		$wrapper_classes .= ! empty( $atts['alignment'] ) ? ' text-' . $atts['alignment'] : '';
		$wrapper_classes .= ' wd-wpb';

		if ( 'inherit' !== $atts['handle_color_scheme'] && 'custom' !== $atts['handle_color_scheme'] ) {
			$wrapper_classes .= ' color-scheme-' . $atts['handle_color_scheme'];
		}

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $atts['css'] );
		}

		$image_keys = array(
			'after'  => 'second_image',
			'before' => 'first_image',
		);

		$images_output = '';

		foreach ( $image_keys as $key => $image_key ) {
			$image_output = '';

			if ( empty( $atts[ $image_key ] ) ) {
				continue;
			}

			$image_size_key = $image_key . '_size';

			if ( ! empty( $atts[ $image_key ] ) ) {
				$image_data   = wp_get_attachment_image_src( $atts[ $image_key ], $atts[ $image_size_key ] );
				$image_output = woodmart_otf_get_image_html( $atts[ $image_key ], $atts[ $image_size_key ] );

				if ( isset( $image_data[0] ) && woodmart_is_svg( $image_data[0] ) ) {
					$image_output = woodmart_get_svg_html(
						$atts[ $image_key ],
						$atts[ $image_size_key ]
					);
				}
			}

			ob_start();
			?>
				<div class="wd-<?php echo esc_attr( $key ); ?>-img">
					<?php echo $image_output; // phpcs:ignore. ?>
				</div>
			<?php
			$images_output .= ob_get_clean();
		}

		if ( empty( $images_output ) ) {
			return;
		}

		ob_start();

		woodmart_enqueue_inline_style( 'el-compare-img' );
		woodmart_enqueue_js_script( 'compare-images-element' );
		?>
		<div class="<?php echo esc_attr( trim( $wrapper_classes ) ); ?>">
			<div class="wd-compare-img">
				<?php echo $images_output; // phpcs:ignore. ?>
				<div class="wd-compare-img-handle">
					<span></span>
				</div>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}
}
