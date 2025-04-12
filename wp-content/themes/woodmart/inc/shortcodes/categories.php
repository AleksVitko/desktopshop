<?php

use XTS\Modules\Layouts\Global_Data;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Categories grid shortcode
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_shortcode_categories' ) ) {
	function woodmart_shortcode_categories( $atts, $content ) {
		$extra_class = $carousel_classes = '';

		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_carousel_atts(),
				array(
					// Query.
					'data_source'               => 'custom_query',
					'number'                    => null,
					'orderby'                   => '',
					'order'                     => 'ASC',
					'ids'                       => '',

					'type'                      => 'grid',
					'images'                    => 'yes',
					'product_count'             => 'yes',
					'mobile_accordion'          => 'yes',
					'shop_categories_ancestors' => 'no',
					'show_categories_neighbors' => 'no',
					'grid_product_count'        => '',

					// Layout.
					'columns'                   => '4',
					'columns_tablet'            => 'auto',
					'columns_mobile'            => 'auto',
					'hide_empty'                => 'yes',
					'parent'                    => '',
					'style'                     => 'default',
					'title'                     => esc_html__( 'Categories', 'woodmart' ),
					'grid_different_sizes'      => '',

					// Design.
					'categories_design'              => woodmart_get_opt( 'categories_design' ),
					'color_scheme'                   => woodmart_get_opt( 'categories_color_scheme' ),
					'categories_with_shadow'         => woodmart_get_opt( 'categories_with_shadow' ),
					'nav_alignment'                  => '',
					'nav_color_scheme'               => '',
					'img_size'                       => '',
					'image_container_width'          => '',
					'categories_bordered_grid'       => '',
					'categories_bordered_grid_style' => 'outside',
					'categories_with_background'     => '',
					'subcategories'                  => '',

					// Hidden sidebar.
					'mobile_categories_menu_layout'            => 'dropdown',
					'mobile_categories_drilldown_animation'    => 'slide',
					'mobile_categories_submenu_opening_action' => 'only_arrow',
					'mobile_categories_position'               => 'left',
					'mobile_categories_color_scheme'           => 'default',
					'mobile_categories_close_btn'              => 'no',

					// Extra.
					'spacing'                   => woodmart_get_opt( 'products_spacing' ),
					'spacing_tablet'            => '',
					'spacing_mobile'            => '',
					'lazy_loading'              => 'no',
					'scroll_carousel_init'      => 'no',
					'el_class'                  => '',
					'el_id'                     => 'wd-' . uniqid(),
					'css'                       => '',
					'woodmart_css_id'           => '',

					// Width option.
					'width_desktop'             => '',
					'width_tablet'              => '',
					'width_mobile'              => '',
					'slides_per_view'           => '3',
					'slides_per_view_tablet'    => 'auto',
					'slides_per_view_mobile'    => 'auto',
				)
			),
			$atts
		);

		extract( $parsed_atts );

		$extra_class            = '';
		$carousel_classes       = '';
		$extra_wrapper_classes  = 'wd-cats-element';
		$extra_wrapper_classes .= apply_filters( 'vc_shortcodes_css_class', '', '', $parsed_atts );
		$extra_wrapper_classes .= $el_class ? ' ' . $el_class : '';

		if ( 'wpb' === woodmart_get_current_page_builder() ) {
			$extra_wrapper_classes .= ' wd-wpb';
		}

		if ( $parsed_atts['css'] ) {
			$extra_wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $parsed_atts['css'] );
		}

		if ( ! empty( $img_size ) ) {
			woodmart_set_loop_prop( 'product_categories_image_size', $img_size );
		}

		if ( woodmart_is_old_category_structure( $categories_design ) ) {
			woodmart_set_loop_prop( 'old_structure', true );
		}

		if ( in_array( $categories_design, array( 'alt', 'side' ), true ) && ! empty( $image_container_width ) ) {
			$extra_class .= ' wd-img-width';
		}

		if ( isset( $ids ) ) {
			$ids = explode( ',', $ids );
			$ids = array_map( 'trim', $ids );
		} else {
			$ids = array();
		}

		$hide_empty = ( $hide_empty == 'yes' || $hide_empty == 1 ) ? 1 : 0;

		// get terms and workaround WP bug with parents/pad counts.
		$args = array(
			'taxonomy'   => 'product_cat',
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $parent,
		);

		if ( $orderby ) {
			$args['orderby'] = $orderby;
		}

		if ( 'navigation' === $type ) {
			$wrapper_classes = '';

			if ( $nav_alignment ) {
				if ( function_exists( 'woodmart_vc_get_control_data' ) ) {
					$wrapper_classes .= ' text-' . woodmart_vc_get_control_data( $nav_alignment, 'desktop' );
				} else {
					$wrapper_classes .= ' text-' . $nav_alignment;
				}
			}

			$wrapper_classes .= ' wd-nav-product-cat-wrap';

			Global_Data::get_instance()->set_data( 'mobile_categories_is_side_hidden', 'side-hidden' === $mobile_accordion ? 'yes' : 'no' );
			Global_Data::get_instance()->set_data( 'shop_categories_ancestors', $shop_categories_ancestors );

			if ( 'yes' === $mobile_accordion ) {
				woodmart_enqueue_inline_style( 'woo-categories-loop-nav-mobile-accordion' );
				$wrapper_classes .= ' wd-nav-accordion-mb-on';
			} elseif ( 'side-hidden' === $mobile_accordion ) {
				$wrapper_classes .= ' wd-nav-side-hidden-mb-on';
			}

			if ( $nav_color_scheme ) {
				$wrapper_classes .= ' color-scheme-' . $nav_color_scheme;
			}

			ob_start();
			?>
			<div id="<?php echo esc_attr( $el_id ); ?>" class="<?php echo esc_attr( $extra_wrapper_classes ); ?>">
				<div class="<?php echo esc_attr( $wrapper_classes ); ?>">
					<?php woodmart_product_categories_nav( $args, $parsed_atts ); ?>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}

		if ( 'wc_query' === $data_source ) {
			if ( 'yes' !== $hide_empty ) {
				add_filter( 'woocommerce_product_subcategories_hide_empty', '__return_false' );
			}
			$product_categories = woocommerce_get_product_subcategories( is_product_category() ? get_queried_object_id() : 0 );
		} else {
			$product_categories = get_terms( 'product_cat', $args );
		}

		if ( '' !== $parent ) {
			$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
		}

		if ( $hide_empty ) {
			foreach ( $product_categories as $key => $category ) {
				if ( $category->count == 0 ) {
					unset( $product_categories[ $key ] );
				}
			}
		}

		if ( $number ) {
			$product_categories = array_slice( $product_categories, 0, $number );
		}

		if ( woodmart_is_compressed_data( $columns ) ) {
			$columns_desktop = woodmart_vc_get_control_data( $columns, 'desktop' );
			$columns_tablet  = woodmart_vc_get_control_data( $columns, 'tablet' );
			$columns_mobile  = woodmart_vc_get_control_data( $columns, 'mobile' );
		} else {
			$columns_desktop = absint( $columns );
		}

		woodmart_set_loop_prop( 'product_categories_color_scheme', $color_scheme );
		woodmart_set_loop_prop( 'product_categories_is_element', true );

		woodmart_set_loop_prop( 'products_different_sizes', false );

		if ( 'masonry' === $style || 'masonry-first' === $style ) {
			if ( 'masonry-first' === $style ) {
				woodmart_set_loop_prop( 'products_different_sizes', array( 1 ) );
				$columns_desktop = 4;

				$extra_class .= ' wd-masonry-first';
			}

			$extra_class .= ' wd-masonry wd-grid-f-col';

			wp_enqueue_script( 'imagesloaded' );
			woodmart_enqueue_js_library( 'isotope-bundle' );
			woodmart_enqueue_js_script( 'shop-masonry' );
		} elseif ( 'default' === $style ) {
			$extra_class .= ' wd-grid-g';
		}

		if ( empty( $categories_design ) || $categories_design == 'inherit' ) {
			$categories_design = woodmart_get_opt( 'categories_design' );
		}

		woodmart_set_loop_prop( 'product_categories_design', $categories_design );
		woodmart_set_loop_prop( 'product_categories_shadow', $categories_with_shadow );
		woodmart_set_loop_prop( 'product_categories_style', $style );

		woodmart_set_loop_prop( 'products_columns', $columns_desktop );
		woodmart_set_loop_prop( 'products_columns_tablet', $columns_tablet );
		woodmart_set_loop_prop( 'products_columns_mobile', $columns_mobile );

		if ( ! empty( $el_id ) ) {
			$carousel_id = $el_id;
		} else {
			$carousel_id = 'carousel-' . wp_rand( 100, 999 );
		}
		if ( ! empty( $grid_product_count ) ) {
			woodmart_set_loop_prop( 'hide_categories_product_count', 'disable' === $grid_product_count );
		}

		if ( ! empty( $subcategories ) ) {
			woodmart_set_loop_prop( 'hide_categories_subcategories', 'disable' === $subcategories );
		}

		ob_start();

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_init( true );
			woodmart_enqueue_inline_style( 'lazy-loading' );
		}

		if ( 'alt' !== $categories_design && 'inherit' !== $categories_design ) {
			if ( 'light' === $color_scheme && 'default' === $categories_design ) {
				woodmart_enqueue_inline_style( 'categories-loop-' . $categories_design . '-scheme-light' );
			} else {
				woodmart_enqueue_inline_style( 'categories-loop-' . $categories_design );
			}
		}

		if ( 'masonry' === $style || 'masonry-first' === $style ) {
			woodmart_enqueue_inline_style( 'woo-categories-loop-layout-masonry' );
		}

		woodmart_enqueue_inline_style( 'woo-categories-loop' );

		if ( woodmart_loop_prop( 'old_structure' ) ) {
			woodmart_enqueue_inline_style( 'categories-loop' );
		}

		if ( ! empty( $categories_bordered_grid ) ) {
			woodmart_enqueue_inline_style( 'bordered-product' );

			woodmart_set_loop_prop( 'products_bordered_grid', true );
			woodmart_set_loop_prop( 'products_bordered_grid_style', $categories_bordered_grid_style );

			if ( 'outside' === $categories_bordered_grid_style ) {
				$extra_class .= ' products-bordered-grid';
			} elseif ( 'inside' === $categories_bordered_grid_style ) {
				$extra_class .= ' products-bordered-grid-ins';
			}
		} else {
			woodmart_set_loop_prop( 'products_bordered_grid', false );
		}

		if ( ! empty( $categories_with_background ) ) {
			woodmart_enqueue_inline_style( 'woo-opt-products-bg' );

			woodmart_set_loop_prop( 'products_with_background', true );

			$extra_class .= ' wd-products-with-bg';
		} else {
			woodmart_set_loop_prop( 'products_with_background', false );
		}

		if ( '' === $parsed_atts['spacing'] ) {
			$parsed_atts['spacing'] = woodmart_get_opt( 'products_spacing' );

			if ( '' === $parsed_atts['spacing_tablet'] ) {
				$parsed_atts['spacing_tablet'] = woodmart_get_opt( 'products_spacing_tablet' );
			}
			if ( '' === $parsed_atts['spacing_mobile'] ) {
				$parsed_atts['spacing_mobile'] = woodmart_get_opt( 'products_spacing_mobile' );
			}
		}

		if ( $product_categories ) {
			if ( 'alt' !== $categories_design && 'inherit' !== $categories_design ) {
				woodmart_enqueue_inline_style( 'categories-loop-' . $categories_design );
			}

			if ( 'carousel' === $style ) {
				woodmart_enqueue_inline_style( 'owl-carousel' );
				$custom_sizes = apply_filters( 'woodmart_categories_shortcode_custom_sizes', false );

				$parsed_atts['carousel_id']  = $carousel_id;
				$parsed_atts['post_type']    = 'product';
				$parsed_atts['custom_sizes'] = $custom_sizes;
				$extra_class                .= ' wd-cats';

				if ( 'yes' === $scroll_carousel_init ) {
					woodmart_enqueue_js_library( 'waypoints' );
					$carousel_classes .= ' scroll-init';
				}

				if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
					$extra_class .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
				}

				if ( ( 'auto' !== $slides_per_view_tablet && ! empty( $slides_per_view_tablet ) ) || ( 'auto' !== $slides_per_view_mobile && ! empty( $slides_per_view_mobile ) ) ) {
					$parsed_atts['custom_sizes'] = array(
						'desktop' => $slides_per_view,
						'tablet'  => $slides_per_view_tablet,
						'mobile'  => $slides_per_view_mobile,
					);
				}

				if ( ! empty( $parsed_atts['carousel_arrows_position'] ) ) {
					$nav_classes = ' wd-pos-' . $parsed_atts['carousel_arrows_position'];
				} else {
					$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
				}

				$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

				if ( 'disable' !== $arrows_hover_style ) {
					$nav_classes .= ' wd-hover-' . $arrows_hover_style;
				}

				woodmart_set_loop_prop( 'category_extra_classes', 'wd-carousel-item' );

				woodmart_enqueue_js_library( 'swiper' );
				woodmart_enqueue_js_script( 'swiper-carousel' );
				woodmart_enqueue_inline_style( 'swiper' );

				?>
				<div id="<?php echo esc_attr( $carousel_id ); ?>" class="products woocommerce wd-carousel-container <?php echo esc_attr( $extra_wrapper_classes . $extra_class ); ?>">
					<div class="wd-carousel-inner">
						<div class="wd-carousel wd-grid<?php echo esc_attr( $carousel_classes ); ?>" <?php echo woodmart_get_carousel_attributes( $parsed_atts ); ?>>
							<div class="wd-carousel-wrap">
								<?php foreach ( $product_categories as $category ) : ?>
									<div class="wd-carousel-item">
										<?php
											wc_get_template(
												'content-product-cat.php',
												array(
													'category' => $category,
												)
											);
										?>
									</div>
								<?php endforeach; ?>
							</div>
						</div>

						<?php woodmart_get_carousel_nav_template( $nav_classes, $parsed_atts ); ?>
					</div>

					<?php woodmart_get_carousel_pagination_template( $parsed_atts ); ?>
					<?php woodmart_get_carousel_scrollbar_template( $parsed_atts ); ?>
				</div>
				<?php
			} else {
				if ( ! empty( $grid_different_sizes ) ) {
					woodmart_set_loop_prop( 'grid_items_different_sizes', explode( ',', $grid_different_sizes ) );
				}

				$extra_class .= ' wd-cats elements-grid';
				$style_attrs  = woodmart_get_grid_attrs(
					array(
						'columns'        => woodmart_loop_prop( 'products_columns' ),
						'columns_tablet' => woodmart_loop_prop( 'products_columns_tablet' ),
						'columns_mobile' => woodmart_loop_prop( 'products_columns_mobile' ),
						'spacing'        => $parsed_atts['spacing'],
						'spacing_tablet' => $parsed_atts['spacing_tablet'],
						'spacing_mobile' => $parsed_atts['spacing_mobile'],
						'post_type'      => 'product',
					)
				);

				?>
				<div id="<?php echo esc_attr( $el_id ); ?>" class="<?php echo esc_attr( $extra_wrapper_classes ); ?>">
					<div class="products woocommerce <?php echo esc_attr( $extra_class ); ?> columns-<?php echo esc_attr( $columns_desktop ); ?>" style="<?php echo esc_attr( $style_attrs ); ?>">
					<?php
					foreach ( $product_categories as $category ) {
						wc_get_template( 'content-product-cat.php', array( 'category' => $category ) );
					}
					?>
					</div>
				</div>
				<?php
			}
		}

		woodmart_reset_loop();

		if ( function_exists( 'woocommerce_reset_loop' ) ) {
			woocommerce_reset_loop();
		}

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_deinit();
		}

		return ob_get_clean();
	}
}
