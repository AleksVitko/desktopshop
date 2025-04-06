<?php

use Elementor\Plugin;

if ( ! function_exists( 'woodmart_get_owl_atts' ) ) {
	function woodmart_get_owl_atts() {
		_deprecated_function( 'woodmart_get_owl_atts', '7.3', 'woodmart_get_carousel_atts' );

		return woodmart_get_carousel_atts();
	}
}

if ( ! function_exists( 'woodmart_get_owl_attributes' ) ) {
	function woodmart_get_owl_attributes( $atts = array(), $witout_init = false ) {
		_deprecated_function( 'woodmart_get_owl_attributes', '7.3', 'woodmart_get_carousel_attributes' );

		return woodmart_get_carousel_attributes( $atts );
	}
}

// **********************************************************************//
// Woodmart Owl Items Per Slide
// **********************************************************************//
if ( ! function_exists( 'woodmart_owl_items_per_slide' ) ) {
	function woodmart_owl_items_per_slide( $slides_per_view, $hide = array(), $post_type = false, $location = false, $custom_sizes = false ) {
		_deprecated_function( 'woodmart_owl_items_per_slide', '7.3' );

		$items   = woodmart_get_owl_items_numbers( $slides_per_view, $post_type, $custom_sizes );
		$classes = '';

		if ( woodmart_get_opt( 'thums_position' ) == 'centered' && $location == 'main-gallery' ) {
			$items['desktop'] = $items['tablet'] = $items['mobile'] = 2;
		}

		if ( ! in_array( 'lg', $hide ) ) {
			$classes .= 'owl-items-lg-' . $items['desktop'];
		}
		if ( ! in_array( 'md', $hide ) ) {
			$classes .= ' owl-items-md-' . $items['tablet_landscape'];
		}
		if ( ! in_array( 'sm', $hide ) ) {
			$classes .= ' owl-items-sm-' . $items['tablet'];
		}
		if ( ! in_array( 'xs', $hide ) ) {
			$classes .= ' owl-items-xs-' . $items['mobile'];
		}

		return $classes;
	}
}
// **********************************************************************//
// Woodmart Get Owl Items Numbers
// **********************************************************************//
if ( ! function_exists( 'woodmart_get_owl_items_numbers' ) ) {
	function woodmart_get_owl_items_numbers( $slides_per_view, $post_type = false, $custom_sizes = false ) {
		_deprecated_function( 'woodmart_get_owl_items_numbers', '7.3' );

		$items = woodmart_get_col_sizes( $slides_per_view );

		if ( $post_type == 'product' ) {
			if ( 'auto' !== woodmart_get_opt( 'products_columns_tablet' ) && ! empty( $mobile_columns ) ) {
				$items['tablet'] = woodmart_get_opt( 'products_columns_tablet' );
			}

			$items['mobile'] = woodmart_get_opt( 'products_columns_mobile' );
		}

		if ( $items['desktop'] == 1 ) {
			$items['mobile'] = 1;
		}

		if ( $custom_sizes && is_array( $custom_sizes ) ) {
			$auto_columns = woodmart_get_col_sizes( $custom_sizes['desktop'] );

			if ( empty( $custom_sizes['tablet'] ) || 'auto' === $custom_sizes['tablet'] ) {
				$custom_sizes['tablet'] = $auto_columns['tablet'];
			}

			if ( empty( $custom_sizes['mobile'] ) || 'auto' === $custom_sizes['mobile'] ) {
				$custom_sizes['mobile'] = $auto_columns['mobile'];
			}

			return $custom_sizes;
		}

		return $items;
	}
}

if ( ! function_exists( 'woodmart_elementor_get_content_css' ) ) {
	/**
	 * Retrieve builder content css.
	 *
	 * @since 1.0.0
	 *
	 * @param integer $id The post ID.
	 *
	 * @return string
	 */
	function woodmart_elementor_get_content_css( $id ) {
		_deprecated_function( 'woodmart_elementor_get_content_css', '7.3' );

		if ( ! woodmart_is_elementor_installed() ) {
			return '';
		}

		$post    = new Elementor\Core\Files\CSS\Post( $id );
		$meta    = $post->get_meta();
		$content = '';

		if ( Plugin::$instance->experiments->is_feature_active( 'additional_custom_breakpoints' ) ) {
			$content = $post->get_content();
		}

		ob_start();

		if ( $post::CSS_STATUS_FILE === $meta['status'] && apply_filters( 'woodmart_elementor_content_file_css', true ) && ! woodmart_is_woo_ajax() ) {
			?>
			<link rel="stylesheet" id="elementor-post-<?php echo esc_attr( $id ); ?>-css" href="<?php echo esc_url( $post->get_url() ); ?>" type="text/css" media="all">
			<?php
		} else {
			if ( ! $content ) {
				$content = $post->get_content();
			}

			echo '<style>' . $content . '</style>';
			Plugin::$instance->frontend->print_fonts_links();
		}

		return ob_get_clean();
	}
}

if ( ! function_exists( 'wd_array_unique_recursive' ) ) {
	function wd_array_unique_recursive( $array ) {
		_deprecated_function( 'woodmart_elementor_get_content_css', '7.6' );

		$scalars = array();
		foreach ( $array as $key => $value ) {
			if ( is_scalar( $value ) ) {
				if ( isset( $scalars[ $value ] ) ) {
					unset( $array[ $key ] );
				} else {
					$scalars[ $value ] = true;
				}
			} elseif ( is_array( $value ) ) {
				$array[ $key ] = wd_array_unique_recursive( $value );
			}
		}

		return $array;
	}
}

if ( ! function_exists( 'woodmart_text2line' ) ) {
	/**
	 * Text to one-line string
	 *
	 * @param string $str String to convert.
	 * @return string
	 */
	function woodmart_text2line( $str ) {
		_deprecated_function( 'woodmart_text2line', '7.6' );

		return trim( preg_replace( "/('|\"|\r?\n)/", '', $str ) );
	}
}

if ( ! function_exists( 'woodmart_get_wpb_font_family_options' ) ) {
	/**
	 * This function get theme font options and return array for WPBakery map.
	 *
	 * @return array
	 */
	function woodmart_get_wpb_font_family_options() {
		_deprecated_function( 'woodmart_get_wpb_font_family_options', '7.6' );

		$secondary_font = woodmart_get_opt( 'secondary-font' );
		$primary_font   = woodmart_get_opt( 'primary-font' );
		$text_font      = woodmart_get_opt( 'text-font' );

		$secondary_font_title = isset( $secondary_font[0] ) ? esc_html__( 'Secondary font', 'woodmart' ) . ' (' . $secondary_font[0]['font-family'] . ')' : esc_html__( 'Secondary font', 'woodmart' );
		$text_font_title      = isset( $text_font[0] ) ? esc_html__( 'Text font', 'woodmart' ) . ' (' . $text_font[0]['font-family'] . ')' : esc_html__( 'Text', 'woodmart' );
		$primary_font_title   = isset( $primary_font[0] ) ? esc_html__( 'Title font', 'woodmart' ) . ' (' . $primary_font[0]['font-family'] . ')' : esc_html__( 'Title font', 'woodmart' );

		return array(
			$primary_font_title   => 'primary',
			$text_font_title      => 'text',
			$secondary_font_title => 'alt',
		);
	}
}

if ( ! function_exists( 'woodmart_get_grid_el_class_new' ) ) {
	function woodmart_get_grid_el_class_new( $loop = 0, $different_sizes = false, $desktop_columns = 3, $tablet_columns = 4, $mobile_columns = 1 ) {
		_deprecated_function( 'woodmart_get_grid_el_class_new', '7.6' );

		$items_wide   = woodmart_get_wide_items_array( $different_sizes );
		$auto_columns = woodmart_get_col_sizes( $desktop_columns );
		$classes      = '';

		if ( 'auto' === $tablet_columns || empty( $tablet_columns ) ) {
			$tablet_columns = $auto_columns['tablet'];
		}

		if ( 'auto' === $mobile_columns || empty( $mobile_columns ) ) {
			$mobile_columns = $auto_columns['mobile'];
		}

		$desktop_columns_class = woodmart_get_grid_el_columns( $desktop_columns );
		$tablet_columns_class  = woodmart_get_grid_el_columns( $tablet_columns );

		if ( $different_sizes && ( in_array( $loop, $items_wide, true ) ) ) {
			$desktop_columns_class *= 2;
			$tablet_columns_class  *= 2;
		}

		$sizes = array(
			array(
				'name'  => 'col-lg',
				'value' => $desktop_columns_class,
			),
			array(
				'name'  => 'col-md',
				'value' => $tablet_columns_class,
			),
			array(
				'name'  => 'col',
				'value' => woodmart_get_grid_el_columns( $mobile_columns ),
			),
		);

		foreach ( $sizes as $value ) {
			$classes .= ' ' . $value['name'] . '-' . $value['value'];
		}

		if ( $loop > 0 && $desktop_columns > 0 ) {
			if ( 0 === ( $loop - 1 ) % $desktop_columns || 1 === $desktop_columns ) {
				$classes .= ' first ';
			}
			if ( 0 === $loop % $desktop_columns ) {
				$classes .= ' last ';
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'woodmart_get_grid_el_class' ) ) {
	function woodmart_get_grid_el_class( $loop = 0, $columns = 4, $different_sizes = false, $xs_size = false, $sm_size = 4, $lg_size = 3, $md_size = false ) {
		_deprecated_function( 'woodmart_get_grid_el_class', '7.6' );

		$classes = '';

		$items_wide = woodmart_get_wide_items_array( $different_sizes );

		if ( ! $xs_size ) {
			$xs_size = apply_filters( 'woodmart_grid_xs_default', 6 );
		}

		if ( $columns > 0 ) {
			$lg_size = 12 / $columns;
		}

		if ( ! $md_size ) {
			$md_size = $lg_size;
		}

		if ( $columns > 4 ) {
			$md_size = 3;
		}

		if ( $columns <= 3 ) {
			if ( $columns == 1 ) {
				$sm_size = 12;
				$xs_size = 12;
			} else {
				$sm_size = 6;
			}
		}

		// every third element make 2 times larger (for isotope grid)
		if ( $different_sizes && ( in_array( $loop, $items_wide ) ) ) {
			$lg_size *= 2;
			$md_size *= 2;
		}

		if ( in_array( $columns, array( 5, 7, 8, 9, 10, 11 ) ) ) {
			$lg_size = str_replace( '.', '_', round( 100 / $columns, 1 ) );
			if ( ! strpos( $lg_size, '_' ) ) {
				$lg_size = $lg_size . '_0';
			}
		}

		$sizes = array(
			array(
				'name'  => 'col-lg',
				'value' => $lg_size,
			),
			array(
				'name'  => 'col-md',
				'value' => $md_size,
			),
			array(
				'name'  => 'col-sm',
				'value' => $sm_size,
			),
			array(
				'name'  => 'col',
				'value' => $xs_size,
			),
		);

		foreach ( $sizes as $value ) {
			$classes .= ' ' . $value['name'] . '-' . $value['value'];
		}

		if ( $loop > 0 && $columns > 0 ) {
			if ( 0 == ( $loop - 1 ) % $columns || 1 == $columns ) {
				$classes .= ' first ';
			}
			if ( 0 == $loop % $columns ) {
				$classes .= ' last ';
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'woodmart_get_grid_el_columns' ) ) {
	function woodmart_get_grid_el_columns( $columns ) {
		_deprecated_function( 'woodmart_get_grid_el_columns', '7.6' );

		if ( empty( $columns ) ) {
			return false;
		}

		if ( is_array( $columns ) && isset( $columns['size'] ) ) {
			$columns = $columns['size'];
		}

		if ( in_array( $columns, array( 5, 7, 8, 9, 10, 11 ) ) ) {
			$columns = str_replace( '.', '_', round( 100 / $columns, 1 ) );
			if ( ! strpos( $columns, '_' ) ) {
				$columns = $columns . '_0';
			}
		} else {
			$columns = 12 / $columns;
		}

		return $columns;
	}
}

if ( ! function_exists( 'woodmart_is_compare_iframe' ) ) {
	/**
	 * Is compare iframe
	 *
	 * @return bool
	 */
	function woodmart_is_compare_iframe() {
		_deprecated_function( 'woodmart_is_compare_iframe', '7.6' );

		return wp_script_is( 'jquery-fixedheadertable', 'enqueued' );
	}
}

if ( ! function_exists( 'woodmart_get_attachment_placeholder' ) ) {
	/**
	 * Get placeholder image. Needs ID to generate a blurred preview and size.
	 *
	 * @param integer $id Attachment ID.
	 * @param string  $size Image size.
	 * @return mixed|null
	 */
	function woodmart_get_attachment_placeholder( $id, $size ) {
		_deprecated_function( 'woodmart_get_attachment_placeholder', '8.0', 'woodmart_lazy_get_default_preview' );

		return woodmart_lazy_get_default_preview();
	}
}

if ( ! function_exists( 'woodmart_get_placeholder_size' ) ) {
	function woodmart_get_placeholder_size( $x0, $y0 ) {
		_deprecated_function( 'woodmart_get_placeholder_size', '8.0' );

		$x = $y = 10;

		if ( $x0 && $x0 < $y0 ) {
			$y = ( $x * $y0 ) / $x0;
		}

		if ( $y0 && $x0 > $y0 ) {
			$x = ( $y * $x0 ) / $y0;
		}

		$x = ceil( $x );
		$y = ceil( $y );

		return (int) $x . 'x' . (int) $y;
	}
}

if ( ! function_exists( 'woodmart_encode_image' ) ) {
	function woodmart_encode_image( $id, $url ) {
		_deprecated_function( 'woodmart_encode_image', '8.0' );

		if ( ! wp_attachment_is_image( $id ) || preg_match( '/^data\:image/', $url ) ) {
			return $url;
		}

		$meta_key = '_base64_image.' . md5( $url );

		$img_url = get_post_meta( $id, $meta_key, true );

		if ( $img_url ) {
			return $img_url;
		}

		$image_path = preg_replace( '/^.*?wp-content\/uploads\//i', '', $url );

		if ( ( $uploads = wp_get_upload_dir() ) && ( false === $uploads['error'] ) && ( 0 !== strpos( $image_path, $uploads['basedir'] ) ) ) {
			if ( false !== strpos( $image_path, 'wp-content/uploads' ) ) {
				$image_path = trailingslashit( $uploads['basedir'] . '/' . _wp_get_attachment_relative_path( $image_path ) ) . basename( $image_path );
			} else {
				$image_path = $uploads['basedir'] . '/' . $image_path;
			}
		}

		$max_size = 150 * 1024; // MB

		if ( file_exists( $image_path ) && ( ! $max_size || ( filesize( $image_path ) <= $max_size ) ) ) {
			$filetype = wp_check_filetype( $image_path );

			// Read image path, convert to base64 encoding
			if ( function_exists( 'woodmart_compress' ) && function_exists( 'woodmart_get_file' ) ) {
				$imageData = woodmart_compress( woodmart_get_file( $image_path ) );
			} else {
				$imageData = '';
			}

			// Format the image SRC:  data:{mime};base64,{data};
			$img_url = 'data:image/' . $filetype['ext'] . ';base64,' . $imageData;

			update_post_meta( $id, $meta_key, $img_url );

			return $img_url;
		}

		return $url;
	}
}


if ( ! function_exists( 'woodmart_lazy_avatar_image' ) ) {
	/**
	 * Filters HTML <img> tag and adds lazy loading attributes. Used for avatar images.
	 *
	 * @param string $html Image html.
	 * @return string
	 */
	function woodmart_lazy_avatar_image( $html ) {
		_deprecated_function( 'woodmart_lazy_avatar_image', '8.0', 'woodmart_lazy_image_standard' );

		return woodmart_lazy_image_standard( $html );
	}
}
