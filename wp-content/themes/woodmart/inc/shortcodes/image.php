<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_shortcode_image' ) ) {
	function woodmart_shortcode_image( $atts ) {
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		$atts = shortcode_atts(
			array(
				'woodmart_css_id' => uniqid(),
				'img_id'          => '',
				'img_size'        => 'medium',
				'img_align'       => 'left',
				'click_action'    => 'none',
				'img_link'        => '',
				'img_link_blank'  => 'no',
				'extra_classes'   => '',
				'css'             => '',
				'display_inline'  => 'no',
				// Global.
				'parallax_scroll' => 'no',
				'scroll_x'        => 0,
				'scroll_y'        => -80,
				'scroll_z'        => 0,
				'scroll_smooth'   => '',
			),
			$atts
		);

		if ( empty( $atts['img_id'] ) ) {
			return false;
		}

		ob_start();

		$title_id = 'wd-' . $atts['woodmart_css_id'];

		$image_link_atts  = '';
		$wrapper_classes .= ' text-' . $atts['img_align'];
		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $atts['css'] );
		}
		if ( ! empty( $atts['extra_classes'] ) ) {
			$wrapper_classes .= ' ' . $atts['extra_classes'];
		}
		if ( 'links' === $atts['click_action'] && function_exists( 'vc_value_from_safe' ) ) {
			$atts['img_link'] = vc_value_from_safe( $atts['img_link'] );
		}
		$image_data = wp_get_attachment_image_src( $atts['img_id'], $atts['img_size'] );
		$image_html = woodmart_otf_get_image_html( $atts['img_id'], $atts['img_size'] );

		if ( 'lightbox' === $atts['click_action'] ) {
			$wrapper_classes .= ' photoswipe-images';
			woodmart_enqueue_js_library( 'photoswipe-bundle' );
			woodmart_enqueue_inline_style( 'photoswipe' );
			woodmart_enqueue_js_script( 'photoswipe-images' );

			if ( ! empty( $image_data ) ) {
				$atts['img_link'] = isset( $image_data[0] ) ? $image_data[0] : '';
				$width            = isset( $image_data[1] ) ? $image_data[1] : '';
				$height           = isset( $image_data[2] ) ? $image_data[2] : '';

				$image_link_atts .= ' data-width="' . esc_attr( $width ) . '" data-height="' . esc_attr( $height ) . '"';
			}
		}

		if ( 'yes' === $atts['display_inline'] ) {
			$wrapper_classes .= ' inline-element';
		}

		if ( isset( $image_data[0] ) && woodmart_is_svg( $image_data[0] ) ) {
			$image_html = woodmart_get_svg_html(
				$atts['img_id'],
				$atts['img_size']
			);
		}

		if ( 'yes' === $atts['img_link_blank'] ) {
			$image_link_atts .= ' target="_blank"';
		}

		?>
		<div id="<?php echo esc_attr( $title_id ); ?>" class="wd-image wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php if ( 'none' !== $atts['click_action'] ) : ?>
				<a href="<?php echo esc_url( $atts['img_link'] ); ?>" <?php echo $image_link_atts; // phpcs:ignore ?>>
			<?php endif ?>

			<?php echo $image_html; // phpcs:ignore ?>

			<?php if ( 'none' !== $atts['click_action'] ) : ?>
				</a>
			<?php endif ?>
		</div>
		<?php

		return apply_filters( 'vc_shortcode_output', ob_get_clean(), new WD_WPBakeryShortCodeFix(), $atts, 'woodmart_image' );
	}
}
