<?php

use Elementor\Group_Control_Image_Size;

if ( ! function_exists( 'woodmart_otf_get_image_html' ) ) {
	/**
	 * Get image html with custom size.
	 *
	 * @param integer      $image_id Image ID.
	 * @param string|array $size Image size.
	 * @param array        $custom_size Image custom size.
	 * @param array        $attr Image attribute.
	 * @return string
	 */
	function woodmart_otf_get_image_html( $image_id, $size = 'thumbnail', $custom_size = array(), $attr = array() ) {
		if ( apply_filters( 'woodmart_old_image_size_function', false ) ) {
			if ( woodmart_is_elementor_installed() ) {
				$image_html = Group_Control_Image_Size::get_attachment_image_html(
					array(
						'image'                  => array(
							'id' => $image_id,
						),
						'image_size'             => $size,
						'image_custom_dimension' => $custom_size,
					)
				);
			} elseif ( function_exists( 'wpb_getImageBySize' ) ) {
				$img = wpb_getImageBySize(
					array(
						'attach_id'  => $image_id,
						'thumb_size' => $size,
					)
				);

				$image_html = isset( $img['thumbnail'] ) ? $img['thumbnail'] : '';
			} else {
				$image_html = wp_get_attachment_image( $image_id, $size, false, $attr );
			}

			return apply_filters( 'woodmart_get_image_html', $image_html, $image_id, $size, $attr );
		}

		if ( 'custom' === $size ) {
			if ( $custom_size ) {
				if ( is_array( $custom_size ) ) {
					$size = array( null, null );

					if ( ! empty( $custom_size['width'] ) ) {
						$size[0] = $custom_size['width'];
					}

					if ( ! empty( $custom_size['height'] ) ) {
						$size[1] = $custom_size['height'];
					}

					if ( ! $size[0] && ! $size[1] ) {
						$size = 'full';
					}
				} elseif ( is_string( $custom_size ) && strpos( $custom_size, 'x' ) ) {
					$size = explode( 'x', $custom_size );
				}
			} else {
				$size = 'full';
			}
		} elseif ( is_string( $size ) && strpos( $size, 'x' ) && 'woodmart_shop_catalog_x2' !== $size ) {
			$size = explode( 'x', $size );
		}

		if ( is_array( $size ) ) {
			if ( ! function_exists( 'gambit_otf_regen_thumbs_media_downsize' ) ) {
				require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/modules/images/library/otf-regenerate-thumbnails.php' );
			}

			add_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
		}

		$image_html = wp_get_attachment_image( $image_id, $size, false, $attr );

		if ( is_array( $size ) ) {
			remove_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
		}

		return apply_filters( 'woodmart_get_image_html', $image_html, $image_id, $size, $attr );
	}
}

if ( ! function_exists( 'woodmart_otf_get_image_url' ) ) {
	/**
	 * Get image url with custom size.
	 *
	 * @param integer      $image_id Image ID.
	 * @param string|array $size Image size.
	 * @param array        $custom_size Image custom size.
	 * @return string
	 */
	function woodmart_otf_get_image_url( $image_id, $size = 'thumbnail', $custom_size = array() ) {
		if ( apply_filters( 'woodmart_old_image_size_function', false ) ) {
			if ( woodmart_is_elementor_installed() ) {
				$image_url = Group_Control_Image_Size::get_attachment_image_src(
					$image_id,
					'image',
					array(
						'image_size'             => $size,
						'image_custom_dimension' => $custom_size,
					)
				);
			} elseif ( function_exists( 'wpb_resize' ) && ( in_array( $size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true ) || ( is_string( $size ) && preg_match_all( '/\d+/', $size ) ) ) ) {
				$thumb_size = woodmart_get_image_size( $size );
				$img        = wpb_resize( $image_id, null, $thumb_size[0], $thumb_size[1], true );

				$image_url = isset( $img['url'] ) ? $img['url'] : '';
			} else {
				$image_url = wp_get_attachment_image_url( $image_id, $size );
			}

			return apply_filters( 'woodmart_get_image_src', $image_url, $image_id, $size );
		}

		if ( 'custom' === $size ) {
			if ( $custom_size ) {
				if ( is_array( $custom_size ) ) {
					$size = array( null, null );

					if ( ! empty( $custom_size['width'] ) ) {
						$size[0] = $custom_size['width'];
					}

					if ( ! empty( $custom_size['height'] ) ) {
						$size[1] = $custom_size['height'];
					}

					if ( ! $size[0] && ! $size[1] ) {
						$size = 'full';
					}
				} elseif ( is_string( $custom_size ) && strpos( $custom_size, 'x' ) ) {
					$size = explode( 'x', $custom_size );
				}
			} else {
				$size = 'full';
			}
		} elseif ( is_string( $size ) && strpos( $size, 'x' ) && 'woodmart_shop_catalog_x2' !== $size ) {
			$size = explode( 'x', $size );
		}

		if ( is_array( $size ) ) {
			if ( ! function_exists( 'gambit_otf_regen_thumbs_media_downsize' ) ) {
				require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/modules/images/library/otf-regenerate-thumbnails.php' );
			}

			add_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
		}

		$image_src = wp_get_attachment_image_url( $image_id, $size );

		if ( is_array( $size ) ) {
			remove_filter( 'image_downsize', 'gambit_otf_regen_thumbs_media_downsize', 10, 3 );
		}

		return apply_filters( 'woodmart_get_image_src', $image_src, $image_id, $size );
	}
}

if ( ! function_exists( 'woodmart_get_all_image_sizes' ) ) {
	/**
	 * Retrieve available image sizes
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function woodmart_get_all_image_sizes() {
		global $_wp_additional_image_sizes;

		$default_image_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );
		$image_sizes         = array();

		foreach ( $default_image_sizes as $size ) {
			$image_sizes[ $size ] = array(
				'width'  => (int) get_option( $size . '_size_w' ),
				'height' => (int) get_option( $size . '_size_h' ),
				'crop'   => (bool) get_option( $size . '_crop' ),
			);
		}

		if ( $_wp_additional_image_sizes ) {
			$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
		}

		$image_sizes['full'] = array();

		return $image_sizes;
	}
}


if ( ! function_exists( 'woodmart_get_image_dimensions_by_size_key' ) ) {
	/**
	 * This function return size array by size key.
	 *
	 * @param string $size_key enter 'thumbnail' if you want to get size thumbnail array.
	 * @return array
	 */
	function woodmart_get_image_dimensions_by_size_key( $size_key ) {
		global $_wp_additional_image_sizes;

		if ( isset( $_wp_additional_image_sizes[ $size_key ] ) ) {
			$res = $_wp_additional_image_sizes[ $size_key ];
		} else {
			$res = woodmart_get_image_size( $size_key );
		}

		if ( strpos( $size_key, 'x' ) && 'woodmart_shop_catalog_x2' !== $size_key ) {
			$res = woodmart_get_explode_size( $size_key, '600' );
		}

		return $res;
	}
}

if ( ! function_exists( 'woodmart_get_image_size' ) ) {
	function woodmart_get_image_size( $thumb_size ) {
		if ( in_array( $thumb_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true ) ) {
			$images_sizes = woodmart_get_all_image_sizes();
			$image_size   = $images_sizes[ $thumb_size ];
			if ( 'full' === $thumb_size ) {
				$image_size['width']  = 3000;
				$image_size['height'] = 3000;
			}
			return array( $image_size['width'], $image_size['height'] );
		} elseif ( is_string( $thumb_size ) ) {
			preg_match_all( '/\d+/', $thumb_size, $thumb_matches );
			if ( isset( $thumb_matches[0] ) ) {
				$thumb_size = array();
				if ( count( $thumb_matches[0] ) > 1 ) {
					$thumb_size[] = $thumb_matches[0][0]; // Width.
					$thumb_size[] = $thumb_matches[0][1]; // Height.
				} elseif ( count( $thumb_matches[0] ) > 0 && count( $thumb_matches[0] ) < 2 ) {
					$thumb_size[] = $thumb_matches[0][0]; // Width.
					$thumb_size[] = $thumb_matches[0][0]; // Height.
				} else {
					$thumb_size = false;
				}
			}
		}

		return $thumb_size;
	}
}

if ( ! function_exists( 'woodmart_get_image_src' ) ) {
	function woodmart_get_image_src( $thumb_id, $thumb_size ) {
		if ( ! $thumb_size ) {
			return false;
		}

		$thumb_size = woodmart_get_image_size( $thumb_size );
		$thumbnail  = wpb_resize( $thumb_id, null, $thumb_size[0], $thumb_size[1], true );

		return isset( $thumbnail['url'] ) ? $thumbnail['url'] : '';
	}
}

if ( ! function_exists( 'woodmart_allow_wp_kses_allowed_html' ) ) {
	/**
	 * Allowed SVG tags.
	 *
	 * @param array  $tags Allowed tags.
	 * @param string $context Context.
	 * @return array
	 */
	function woodmart_allow_wp_kses_allowed_html( $tags, $context ) {
		if ( woodmart_get_opt( 'gutenberg_blocks' ) ) {
			$tags['iframe'] = array(
				'src'             => true,
				'width'           => true,
				'height'          => true,
				'frameborder'     => true,
				'allow'           => true,
				'allowfullscreen' => true,
				'loading'         => true,
				'data-*'          => true,
			);
		}

		if ( ! woodmart_get_opt( 'allow_upload_svg' ) ) {
			return $tags;
		}

		$tags_config = array(
			'style'               => array(
				'id'    => true,
				'class' => true,
				'type'  => true,
			),
			'svg'                 => array(
				'viewbox'             => true,
				'filter'              => true,
				'enablebackground'    => true,
				'xmlns'               => true,
				'class'               => true,
				'preserveaspectratio' => true,
				'aria-hidden'         => true,
				'aria-expanded'       => true,
				'aria-level'          => true,
				'data-*'              => true,
				'role'                => true,
				'tabindex'            => true,
				'height'              => true,
				'width'               => true,
				'style'               => true,
				'xml:space'           => true,
				'size'                => true,
				'viewBox'             => true,
				'version'             => true,
				'xmlns:xlink'         => true,
				'x'                   => true,
				'y'                   => true,
			),
			'path'                => array(
				'd' => true,
			),
			'circle'              => array(
				'cx' => true,
				'cy' => true,
				'r'  => true,
			),
			'polygon'             => array(
				'points' => true,
			),
			'polyline'            => array(
				'points' => true,
			),
			'rect'                => array(
				'x'      => true,
				'y'      => true,
				'width'  => true,
				'height' => true,
				'rx'     => true,
				'ry'     => true,
			),
			'line'                => array(
				'x1' => true,
				'x2' => true,
				'y1' => true,
				'y2' => true,
			),
			'fegaussianblur'      => array(
				'in'           => true,
				'stddeviation' => true,
			),
			'fecomponenttransfer' => array(),
			'fefunca'             => array(
				'type'  => true,
				'slope' => true,
			),
			'femerge'             => array(),
			'femergenode'         => array(
				'in' => true,
			),
			'defs'                => array(),
			'stop'                => array(
				'offset'       => true,
				'style'        => true,
				'stop-color'   => true,
				'stop-opacity' => true,
			),
			'lineargradient'      => array(
				'id'                => true,
				'x1'                => true,
				'x2'                => true,
				'y1'                => true,
				'y2'                => true,
				'gradientunits'     => true,
				'gradienttransform' => true,
			),
		);

		foreach ( $tags_config as $tag => $attributes ) {
			if ( ! isset( $tags[ $tag ] ) ) {
				$tags[ $tag ] = $attributes;
			} else {
				$tags[ $tag ] = array_merge( $tags[ $tag ], $attributes );
			}
		}

		foreach ( array( 'svg', 'path', 'circle', 'polygon', 'polyline', 'line', 'rect', 'g', 'clippath', 'filter' ) as $tag ) {
			$tags[ $tag ]['id']                = true;
			$tags[ $tag ]['class']             = true;
			$tags[ $tag ]['style']             = true;
			$tags[ $tag ]['fill']              = true;
			$tags[ $tag ]['fill-rule']         = true;
			$tags[ $tag ]['fill-opacity']      = true;
			$tags[ $tag ]['fill-*']            = true;
			$tags[ $tag ]['clip-path']         = true;
			$tags[ $tag ]['transform']         = true;
			$tags[ $tag ]['stroke']            = true;
			$tags[ $tag ]['stroke-width']      = true;
			$tags[ $tag ]['stroke-linejoin']   = true;
			$tags[ $tag ]['stroke-miterlimit'] = true;
			$tags[ $tag ]['stroke-*']          = true;
			$tags[ $tag ]['opacity']           = true;
		}

		return $tags;
	}

	add_filter( 'wp_kses_allowed_html', 'woodmart_allow_wp_kses_allowed_html', 10, 2 );
}

if ( ! function_exists( 'woodmart_allow_svg_css_rules' ) ) {
	/**
	 * Allow rules for SVG element.
	 *
	 * @param array $rules CSS rules.
	 * @return array
	 */
	function woodmart_allow_svg_css_rules( $rules ) {
		if ( ! woodmart_get_opt( 'allow_upload_svg' ) ) {
			return $rules;
		}

		$rules[] = 'fill';
		$rules[] = 'fill-rule';
		$rules[] = 'stroke';
		$rules[] = 'enable-background';

		return $rules;
	}

	add_filter( 'safe_style_css', 'woodmart_allow_svg_css_rules' );
}

if ( ! function_exists( 'woodmart_get_svg_content' ) ) {
	/**
	 * Get content of the SVG icon located in images/svg folder.
	 *
	 * @param string $name Icon name.
	 * @return false|string
	 */
	function woodmart_get_svg_content( $name ) {
		$folder = WOODMART_THEMEROOT . '/images/svg';
		$file   = $folder . '/' . $name . '.svg';

		return ( file_exists( $file ) ) ? woodmart_get_any_svg( $file ) : false;
	}
}

if ( ! function_exists( 'woodmart_get_any_svg' ) ) {
	/**
	 * Get content of the SVG icon.
	 *
	 * @param string  $file File.
	 * @param integer $id ID.
	 * @return false|string
	 */
	function woodmart_get_any_svg( $file, $id = false ) {
		$content   = function_exists( 'woodmart_get_svg' ) ? woodmart_get_svg( $file ) : '';
		$start_tag = '<svg';
		if ( $id ) {
			$pattern = '/id="(\w)+"/';
			if ( preg_match( $pattern, $content ) ) {
				$content = preg_replace( $pattern, 'id="' . $id . '"', $content, 1 );
			} else {
				$content = preg_replace( '/<svg/', '<svg id="' . $id . '"', $content );
			}
		}
		// Strip doctype.
		$position = strpos( $content, $start_tag );

		return substr( $content, $position );
	}
}

if ( ! function_exists( 'woodmart_get_svg_html' ) ) {
	/**
	 * Function to show SVG images.
	 *
	 * @param string|int  $image_id image id.
	 * @param null|string $size Needed image size. Default = thumbnail.
	 * @param null|string $attributes List of attributes. If a whip then the data is taken from $attachment object.
	 * @return string html tag img string.
	 */
	function woodmart_get_svg_html( $image_id, $size = 'thumbnail', $attributes = array() ) {
		$html       = '';
		$thumb_size = array();

		$image_id = apply_filters( 'wpml_object_id', $image_id, 'attachment', true );

		$attributes = wp_parse_args(
			$attributes,
			array(
				'alt'     => get_post_meta( $image_id, '_wp_attachment_image_alt', true ),
				'src'     => wp_get_attachment_image_url( $image_id, 'full' ),
				'title'   => get_the_title( $image_id ),
				'loading' => ! woodmart_get_opt( 'disable_wordpress_lazy_loading' ) ? 'lazy' : '',
			)
		);

		if ( 'string' === gettype( $size ) ) {
			$thumb_size = woodmart_get_image_size( $size );
		} elseif ( is_array( $size ) ) {
			if ( array_key_exists( 'width', $size ) && array_key_exists( 'height', $size ) ) {
				$thumb_size[0] = $size['width'];
				$thumb_size[1] = $size['height'];
			} else {
				$thumb_size = $size;
			}
		}

		if ( isset( $attributes ) ) {
			$attributes['width']  = isset( $thumb_size[0] ) ? $thumb_size[0] : '';
			$attributes['height'] = isset( $thumb_size[1] ) ? $thumb_size[1] : '';

			$attributes = array_map( 'esc_attr', $attributes );

			foreach ( $attributes as $name => $value ) {
				if ( ! empty( $value ) ) {
					$html .= " $name=" . '"' . $value . '"';
				}
			}
		}
		return apply_filters( 'woodmart_image', '<img ' . $html . '>' );
	}
}
