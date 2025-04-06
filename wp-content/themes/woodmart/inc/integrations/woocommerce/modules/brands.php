<?php

use XTS\Modules\Layouts\Global_Data as Builder_Data;
use XTS\Modules\Layouts\Main;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_product_brand' ) ) {
	/**
	 * Show product brand.
	 *
	 * @param array $args Arguments.
	 * @return void
	 */
	function woodmart_product_brand( $args = array() ) {
		global $product;

		$attr = woodmart_get_opt( 'brands_attribute' );

		if ( ! $product || ( ! $attr && ! taxonomy_exists( 'product_brand' ) ) || ( ! woodmart_get_opt( 'product_page_brand' ) && ( woodmart_loop_prop( 'is_quick_view' ) || ! Main::get_instance()->has_custom_layout( 'single_product' ) ) ) ) {
			return;
		}

		if ( $attr ) {
			$attributes = $product->get_attributes();

			if ( empty( $attributes[ $attr ] ) ) {
				return;
			}
		} else {
			$attr = 'product_brand';
		}

		$brands   = wc_get_product_terms( $product->get_id(), $attr, array( 'fields' => 'all' ) );
		$taxonomy = get_taxonomy( $attr );

		if ( empty( $brands ) ) {
			return;
		}

		$builder_label = Builder_Data::get_instance()->get_data( 'builder_label' );

		if ( woodmart_is_shop_on_front() ) {
			$link = home_url();
		} else {
			$link = get_post_type_archive_link( 'product' );
		}

		$wrapper_attrs = '';

		$classes = 'sidebar' === woodmart_get_opt( 'product_brand_location' ) && ! woodmart_loop_prop( 'is_quick_view' ) ? ' widget sidebar-widget' : '';

		if ( ! empty( $args['classes'] ) ) {
			$classes .= $args['classes'];
		}

		if ( ! empty( $args['element_id'] ) ) {
			$wrapper_attrs .= ' id="' . esc_attr( $args['element_id'] ) . '"';
		}

		$classes .= woodmart_get_old_classes( ' woodmart-product-brands' );

		echo '<div class="wd-product-brands' . esc_attr( $classes ) . '"' . wp_kses( $wrapper_attrs, true ) . '>';

		if ( isset( $args['content'] ) ) {
			echo wp_kses( $args['content'], true );
		}

		if ( ! empty( $builder_label ) ) {
			echo '<span class="wd-label">' . esc_html( $builder_label ) . '</span>';
		}

		foreach ( $brands as $brand ) {
			$image = get_term_meta( $brand->term_id, 'image', true );
			$attrs = '';

			if ( get_term_meta( $brand->term_id, 'image_id', true ) ) {
				$data  = wp_get_attachment_image_src( get_term_meta( $brand->term_id, 'image_id', true ) );
				$attrs = ' width="' . $data['1'] . '" height="' . $data['2'] . '"';
			}

			if ( ! $image ) {
				$thumbnail_id = get_term_meta( $brand->term_id, 'thumbnail_id', true );

				if ( $thumbnail_id ) {
					$image = array(
						'id' => $thumbnail_id,
					);
				}
			}

			if ( is_object( $taxonomy ) && $taxonomy->public ) {
				$attr_link = get_term_link( $brand->term_id, $brand->taxonomy );
			} else {
				$attr_link = add_query_arg(
					'filter_' . sanitize_title( str_replace( 'pa_', '', $attr ) ),
					$brand->slug,
					$link
				);
			}

			$content = esc_attr( $brand->name );

			if ( is_array( $image ) && ! empty( $image['id'] ) ) {
				$content = wp_get_attachment_image( $image['id'], 'full', false, array( 'title' => $brand->name, 'alt' => $brand->name ) );
			} elseif ( ! is_array( $image ) && $image ) {
				$content = apply_filters( 'woodmart_image', '<img src="' . esc_url( $image ) . '" title="' . esc_attr( $brand->name ) . '" alt="' . esc_attr( $brand->name ) . '" ' . $attrs . '>' );
			}

			?>
			<a href="<?php echo esc_url( $attr_link ); ?>">
				<?php echo wp_kses( $content, true ); ?>
			</a>
			<?php
		}

		echo '</div>';
	}
}

if ( ! function_exists( 'woodmart_product_brands_links' ) ) {
	/**
	 * Show product brand on product loop.
	 *
	 * @return void
	 */
	function woodmart_product_brands_links() {
		global $product;

		if ( ! woodmart_get_opt( 'brands_under_title' ) ) {
			return;
		}

		$brand_option = woodmart_get_opt( 'brands_attribute' ) ? woodmart_get_opt( 'brands_attribute' ) : 'product_brand';
		$brands       = wc_get_product_terms( $product->get_id(), $brand_option, array( 'fields' => 'all' ) );
		$taxonomy     = get_taxonomy( $brand_option );

		if ( empty( $brands ) ) {
			return;
		}

		$link = ( woodmart_is_shop_on_front() ) ? home_url() : get_post_type_archive_link( 'product' );

		echo '<div class="wd-product-brands-links' . woodmart_get_old_classes( ' woodmart-product-brands-links' ) . '">';

		foreach ( $brands as $brand ) {
			if ( is_object( $taxonomy ) && $taxonomy->public ) {
				$attr_link = get_term_link( $brand->term_id, $brand->taxonomy );
			} else {
				$attr_link = add_query_arg( 'filter_' . sanitize_title( str_replace( 'pa_', '', $brand_option ) ), $brand->slug, $link );
			}

			$sep = ', ';
			if ( end( $brands ) === $brand ) {
				$sep = '';
			}

			echo '<a href="' . esc_url( $attr_link ) . '">' . wp_kses( $brand->name, true ) . '</a>' . esc_html( $sep );
		}

		echo '</div>';
	}
}

if ( ! function_exists( 'woodmart_product_brand_tab' ) ) {
	/**
	 * Show product brand tab to the single product page
	 *
	 * @param array $tabs Tabs.
	 * @return array
	 */
	function woodmart_product_brand_tab( $tabs ) {
		global $product;

		$attr = woodmart_get_opt( 'brands_attribute' ) ? woodmart_get_opt( 'brands_attribute' ) : 'product_brand';

		$brand_info = wc_get_product_terms( $product->get_id(), $attr, array( 'fields' => 'all' ) );

		if ( isset( $brand_info[0] ) && $brand_info[0]->description ) {
			$tabs['brand_tab'] = array(
				'title'    => woodmart_get_opt( 'brand_tab_name' ) ? sprintf( esc_html__( 'About %s', 'woodmart' ), $brand_info[0]->name ) : esc_html__( 'About brand', 'woodmart' ),
				'priority' => 50,
				'callback' => 'woodmart_product_brand_tab_content',
			);
		}

		return $tabs;
	}
}

if ( ! function_exists( 'woodmart_product_brand_tab_content' ) ) {
	/**
	 * Product brand tab content.
	 *
	 * @return void
	 */
	function woodmart_product_brand_tab_content() {
		global $product;

		$attr = 'product_brand';

		if ( woodmart_get_opt( 'brands_attribute' ) ) {
			$attr = woodmart_get_opt( 'brands_attribute' );

			$attributes = $product->get_attributes();

			if ( ! isset( $attributes[ $attr ] ) || empty( $attributes[ $attr ] ) ) {
				return;
			}
		}

		$brands = wc_get_product_terms( $product->get_id(), $attr, array( 'fields' => 'slugs' ) );

		if ( empty( $brands ) ) {
			return;
		}

		foreach ( $brands as $slug ) {
			$brand = get_term_by( 'slug', $slug, $attr );
			echo do_shortcode( $brand->description );
		}
	}
}

if ( ! function_exists( 'woodmart_admin_localized_brand_attribute' ) ) {
	/**
	 * Add brand attribute to the localized string.
	 *
	 * @param array $setting Localized string.
	 * @return mixed
	 */
	function woodmart_admin_localized_brand_attribute( $setting ) {
		if ( woodmart_woocommerce_installed() ) {
			$brand_attribute = woodmart_get_opt( 'brands_attribute' );

			if ( $brand_attribute ) {
				$setting['brand_attribute'] = wc_attribute_taxonomy_id_by_name( $brand_attribute );
			} elseif ( taxonomy_exists( 'product_brand' ) ) {
				$taxonomy = get_taxonomy( 'product_brand' );

				$setting['brand_attribute'] = $taxonomy->name;
			}
		}

		return $setting;
	}

	add_filter( 'woodmart_admin_localized_string_array', 'woodmart_admin_localized_brand_attribute' );
}

if ( ! function_exists( 'woodmart_get_product_brand_list' ) ) {
	/**
	 * Get product brand list.
	 *
	 * @return string
	 */
	function woodmart_get_product_brand_list() {
		global $product;

		$terms_name = woodmart_get_opt( 'brands_attribute' ) ? woodmart_get_opt( 'brands_attribute' ) : 'product_brand';

		$terms       = get_the_terms( $product->get_id(), $terms_name );
		$brand_count = is_array( $terms ) ? count( $terms ) : 0;

		$content = get_the_term_list(
			$product->get_id(),
			$terms_name,
			'<span class="posted_in"><span class="meta-label">' . _n( 'Brand: ', 'Brands: ', $brand_count, 'woodmart' ) . '</span>',
			'<span class="meta-sep">,</span>',
			'</span>'
		);

		if ( is_wp_error( $content ) ) {
			return '';
		}

		return $content;
	}
}

if ( ! function_exists( 'woodmart_remove_output_default_brands_on_single_page' ) ) {
	/**
	 * Remove output default brands on single page.
	 *
	 * @return void
	 */
	function woodmart_remove_output_default_brands_on_single_page() {
		if ( ! empty( $GLOBALS['WC_Brands'] ) ) {
			remove_action( 'woocommerce_product_meta_end', array( $GLOBALS['WC_Brands'], 'show_brand' ) );
		}
	}

	add_action( 'init', 'woodmart_remove_output_default_brands_on_single_page', 100 );
}
