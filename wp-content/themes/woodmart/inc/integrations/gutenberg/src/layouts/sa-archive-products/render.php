<?php

use XTS\Modules\Layouts\Global_Data;
use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_shop_archive_products' ) ) {
	function wd_gutenberg_shop_archive_products( $block_attributes ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}

		if ( 'inherit' !== $block_attributes['layout'] ) {
			woodmart_set_loop_prop( 'products_view', woodmart_new_get_shop_view( $block_attributes['layout'], true ) );
		}

		if ( ! empty( $block_attributes['columns'] ) ) {
			woodmart_set_loop_prop( 'products_columns', woodmart_new_get_products_columns_per_row( $block_attributes['columns'], true ) );
		}

		if ( ! empty( $block_attributes['columnsTablet'] ) ) {
			woodmart_set_loop_prop( 'products_columns_tablet', $block_attributes['columnsTablet'] );
		}

		if ( ! empty( $block_attributes['columnsMobile'] ) ) {
			woodmart_set_loop_prop( 'products_columns_mobile', $block_attributes['columnsMobile'] );
		}

		if ( isset( $block_attributes['spacing'] ) && '' !== $block_attributes['spacing'] ) {
			woodmart_set_loop_prop( 'products_spacing', $block_attributes['spacing'] );
		}

		if ( isset( $block_attributes['spacingTablet'] ) && '' !== $block_attributes['spacingTablet'] ) {
			woodmart_set_loop_prop( 'products_spacing_tablet', $block_attributes['spacingTablet'] );
		}

		if ( isset( $block_attributes['spacingMobile'] ) && '' !== $block_attributes['spacingMobile'] ) {
			woodmart_set_loop_prop( 'products_spacing_mobile', $block_attributes['spacingMobile'] );
		}

		if ( ! empty( $block_attributes['productHover'] ) ) {
			woodmart_set_loop_prop( 'product_hover', $block_attributes['productHover'] );
		}

		if ( ! empty( $block_attributes['shopPagination'] ) ) {
			Global_Data::get_instance()->set_data( 'shop_pagination', $block_attributes['shopPagination'] );
		}

		if ( ! empty( $block_attributes['productsBorderedGrid'] ) ) {
			woodmart_set_loop_prop( 'products_bordered_grid', $block_attributes['productsBorderedGrid'] );

			if ( ! empty( $block_attributes['productsBorderedGridStyle'] ) ) {
				woodmart_set_loop_prop( 'products_bordered_grid_style', $block_attributes['productsBorderedGridStyle'] );
			}
		}

		if ( ! empty( $block_attributes['productsColorScheme'] ) ) {
			woodmart_set_loop_prop( 'products_color_scheme', $block_attributes['productsColorScheme'] );
		}

		if ( ! empty( $block_attributes['productsWithBackground'] ) ) {
			woodmart_set_loop_prop( 'products_with_background', 'yes' === $block_attributes['productsWithBackground'] );
		}

		if ( ! empty( $block_attributes['productsShadow'] ) ) {
			woodmart_set_loop_prop( 'products_shadow', 'yes' === $block_attributes['productsShadow'] );
		}

		if ( ! empty( $block_attributes['imgSize'] ) ) {
			woodmart_set_loop_prop( 'img_size', $block_attributes['imgSize'] );

			if ( 'custom' === $block_attributes['imgSize'] && ( ! empty( $block_attributes['imgSizeCustomHeight'] ) || ! empty( $block_attributes['imgSizeCustomWidth'] ) ) ) {
				woodmart_set_loop_prop(
					'img_size_custom',
					array(
						'width'  => $block_attributes['imgSizeCustomWidth'],
						'height' => $block_attributes['imgSizeCustomHeight'],
					)
				);
			}
		}

		Main::setup_preview();

		ob_start();

		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-shop-product wd-products-element <?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php woodmart_sticky_loader( ' wd-content-loader' ); ?>
				<?php do_action( 'woodmart_woocommerce_main_loop' ); ?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
