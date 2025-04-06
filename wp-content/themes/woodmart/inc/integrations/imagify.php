<?php
/**
 * Imagify.
 *
 * @package Woodmart
 */

if ( ! defined( 'IMAGIFY_VERSION' ) ) {
	return;
}

if ( ! function_exists( 'woodmart_single_product_gallery_images_webp' ) ) {
	/**
	 * Single product change class with webp.
	 *
	 * @param string $class CSS Class.
	 *
	 * @return string
	 */
	function woodmart_single_product_gallery_images_webp( $class ) {
		$class .= ' imagify-no-webp';

		return $class;
	}

	add_filter( 'woodmart_single_product_gallery_image_class', 'woodmart_single_product_gallery_images_webp' );
}

if ( ! function_exists( 'woodmart_add_webp_to_product_thumbnails_srcset' ) ) {
	/**
	 * Add extension 'webp' to srcset attribute of the image in product gallery.
	 *
	 * @param string $image_srcset Image srcset.
	 * @param string $attachment_id Image ID.
	 *
	 * @return string
	 */
	function woodmart_add_webp_to_product_thumbnails_srcset( $image_srcset, $attachment_id ) {
		if ( ! function_exists( 'imagify_path_to_nextgen' ) ) {
			return $image_srcset;
		}

		$image_path = wp_get_original_image_path( $attachment_id );

		if ( $image_path ) {
			$image_srcset_array = explode( ',', $image_srcset );

			foreach ( $image_srcset_array as $key => $srcset_line ) {
				$srcset_line_array = explode( ' ', trim( $srcset_line ) );

				if ( false === strpos( $srcset_line_array[0], '.webp' ) && woodmart_attachment_url_to_path( $srcset_line_array[0] . '.webp' ) ) {
					$srcset_line_array[0] = imagify_path_to_nextgen( $srcset_line_array[0], 'webp' );
				}

				$image_srcset_array[ $key ] = implode( ' ', $srcset_line_array );
			}

			$image_srcset = implode( ',', $image_srcset_array );
		}

		return $image_srcset;
	}

	add_filter( 'woodmart_product_thumbnails_urls_image_srcset', 'woodmart_add_webp_to_product_thumbnails_srcset', 10, 2 );
}
