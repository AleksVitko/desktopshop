<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
* ------------------------------------------------------------------------------------------------
* Buttons shortcode
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_shortcode_button' ) ) {
	function woodmart_shortcode_button( $atts, $popup = false ) {
		$wrap_class = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		extract(
			shortcode_atts(
				array(
					'title'                         => 'GO',
					'link'                          => '',
					'link_nofollow'                 => false,
					'color'                         => 'default',
					'style'                         => 'default',
					'shape'                         => 'rectangle',
					'size'                          => 'default',
					'align'                         => 'center',
					'button_inline'                 => 'no',
					'full_width'                    => 'no',

					'button_smooth_scroll'          => 'no',
					'button_smooth_scroll_time'     => '100',
					'button_smooth_scroll_offset'   => '100',

					'bg_color'                      => '',
					'bg_color_hover'                => '',
					'color_scheme'                  => 'light',
					'color_scheme_hover'            => 'light',
					'woodmart_css_id'               => '',
					'css'                           => '',

					'css_animation'                 => 'none',
					'el_class'                      => '',
					'wrapper_class'                 => '',
					'btn_classes'                   => '',

					'icon_fontawesome'              => '',
					'icon_openiconic'               => '',
					'icon_typicons'                 => '',
					'icon_entypo'                   => '',
					'icon_linecons'                 => '',
					'icon_monosocial'               => '',
					'icon_material'                 => '',
					'icon_library'                  => 'fontawesome',
					'icon_position'                 => 'right',
					'icon_type'                     => 'icon',
					'image'                         => '',
					'img_size'                      => '25x25',

					'wd_button_collapsible_content' => 'no',

					'generate_css'                  => true,
				),
				$atts
			)
		);

		if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && ${'icon_' . $icon_library} ) {
			vc_icon_element_fonts_enqueue( $icon_library );
		}

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrap_class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		if ( ! empty( $wrapper_class ) ) {
			$wrap_class .= ' ' . $wrapper_class;
		}

		$attributes = woodmart_get_link_attributes( $link, $popup );

		$btn_class     = 'btn';
		$wrapper_attrs = '';

		if ( ! $woodmart_css_id ) {
			$woodmart_css_id = uniqid();
		}
		$id = 'wd-' . $woodmart_css_id;

		$wrap_class .= ' wd-button-wrapper';
		$wrap_class .= woodmart_get_old_classes( ' woodmart-button-wrapper' );
		$wrap_class .= woodmart_get_css_animation( $css_animation );

		if ( $bg_color || $bg_color_hover ) {
			$style_attr = '';

			if ( in_array( $color_scheme, array( 'light', 'dark' ), true ) ) {
				$style_attr .= '--btn-color:' . ( 'light' === $color_scheme ? '#fff' : '#333' ) . ';';
			}
			if ( in_array( $color_scheme_hover, array( 'light', 'dark' ), true ) ) {
				$style_attr .= '--btn-color-hover:' . ( 'light' === $color_scheme_hover ? '#fff' : '#333' ) . ';';
			}

			if ( $style_attr ) {
				$attributes .= ' style="' . $style_attr . '"';
			}
		} elseif ( 'default' !== $color ) {
			$btn_class .= ' btn-color-' . $color;
		}

		$btn_class .= ' btn-style-' . $style;
		$btn_class .= ' btn-shape-' . $shape;
		$btn_class .= ' btn-size-' . $size;

		if ( $full_width == 'yes' ) {
			$btn_class .= ' btn-full-width';
		}

		if ( ! empty( $btn_classes ) ) {
			$btn_class .= ' ' . $btn_classes;
		}

		if ( 'yes' === $button_smooth_scroll ) {
			woodmart_enqueue_js_script( 'button-element' );
			$wrap_class    .= ' wd-smooth-scroll';
			$wrapper_attrs .= ' data-smooth-time="' . $button_smooth_scroll_time . '"';
			$wrapper_attrs .= ' data-smooth-offset="' . $button_smooth_scroll_offset . '"';
		}

		$wrap_class .= ' text-' . $align;
		if ( $button_inline == 'yes' ) {
			$wrap_class .= ' inline-element';
		}

		if ( $el_class != '' ) {
			$btn_class .= ' ' . $el_class;
		}

		if ( 'yes' === $wd_button_collapsible_content ) {
			woodmart_enqueue_js_script( 'button-show-more' );
			$wrap_class .= ' wd-collapsible-button';
		}

		// Icon settings.
		$icon = '';

		if ( 'icon' === $icon_type && ${'icon_' . $icon_library} ) {
			$btn_class .= ' btn-icon-pos-' . $icon_position;
			$icon       = '<span class="wd-btn-icon"><span class="wd-icon ' . ${'icon_' . $icon_library} . '"></span></span>';
		} elseif ( 'image' === $icon_type && ! empty( $image ) ) {
			$btn_class .= ' btn-icon-pos-' . $icon_position;

			if ( woodmart_is_svg( wp_get_attachment_image_url( $image ) ) ) {
				$image_output = woodmart_get_svg_html( $image, $img_size );
			} elseif ( ! empty( $image['id'] ) ) {
				$image_output = woodmart_otf_get_image_html( $image['id'], $img_size );
			} else {
				$image_output = woodmart_otf_get_image_html( $image, $img_size );
			}

			$icon = '<span class="wd-btn-icon">' . $image_output .  '</span>';
		}

		$attributes .= ' class="' . $btn_class . '"';

		if ( $link_nofollow ) {
			$attributes .= ' rel="nofollow"';
		}

		woodmart_enqueue_inline_style( 'button' );

		$output = '<div id="' . esc_attr( $id ) . '" class="' . esc_attr( $wrap_class ) . '"' . $wrapper_attrs . '><a ' . $attributes . '>' . esc_html( $title ) . $icon . '</a>';

		if ( is_array( $bg_color ) ) {
			$bg_color = 'rgba(' . $bg_color['r'] . ', ' . $bg_color['g'] . ', ' . $bg_color['b'] . ',' . $bg_color['a'] . ')';
		}
		if ( is_array( $bg_color_hover ) ) {
			$bg_color_hover = 'rgba(' . $bg_color_hover['r'] . ', ' . $bg_color_hover['g'] . ', ' . $bg_color_hover['b'] . ',' . $bg_color_hover['a'] . ')';
		}

		if ( ! empty( $generate_css ) && ( $bg_color && ! woodmart_is_css_encode( $bg_color ) || $bg_color_hover && ! woodmart_is_css_encode( $bg_color_hover ) ) ) {
			$css = '';
			// Custom Color
			$css .= '#' . $id . ' a {';
			if ( $style == 'bordered' || $style == 'link' ) {
				$css .= 'border-color:' . $bg_color . ';';
			} else {
				$css .= 'background-color:' . $bg_color . ';';
			}
			$css .= '}';

			$css .= '#' . $id . ' a:hover {';
			if ( $style == 'bordered' ) {
				$css .= 'border-color:' . $bg_color_hover . ';';
				$css .= 'background-color:' . $bg_color_hover . ';';
			} elseif ( $style == 'link' ) {
				$css .= 'border-color:' . $bg_color_hover . ';';
			} else {
				$css .= 'background-color:' . $bg_color_hover . ';';
			}
			$css .= '}';

			wp_add_inline_style( 'woodmart-inline-css', $css );
		}

		$output .= '</div>';

		return $output;

	}
}
