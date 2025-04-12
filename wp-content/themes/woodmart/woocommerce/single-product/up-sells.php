<?php
/**
 * Single Product Up-Sells
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$position = woodmart_get_opt( 'upsells_position' );

if ( $upsells && 'hide' !== woodmart_get_opt( 'upsells_position' ) ) : ?>

	<?php if ( 'sidebar' === $position ) : ?>
		<?php woodmart_enqueue_inline_style( 'widget-product-upsells' ); ?>
		<div class="wd-widget upsells-widget widget sidebar-widget">
			<<?php echo esc_html( woodmart_get_widget_title_tag() ); ?> class="widget-title"><?php echo esc_html__( 'You may also like&hellip;', 'woocommerce' ); ?></<?php echo esc_html( woodmart_get_widget_title_tag() ); ?>>

			<?php woodmart_products_widget_template( $upsells, true ); ?>
		</div>
	<?php else : ?>
		<?php
		$product_ids = array();

		foreach ( $upsells as $upsell_product ) {
			$product_ids[] = $upsell_product->get_id();
		}

		$products_atts = apply_filters(
			'woodmart_upsells_products_args',
			array(
				'element_title'                => esc_html__( 'You may also like&hellip;', 'woocommerce' ),
				'element_title_tag'            => 'h2',
				'layout'                       => 'slider' === woodmart_get_opt( 'related_product_view' ) ? 'carousel' : 'grid',
				'post_type'                    => 'ids',
				'include'                      => implode( ',', $product_ids ),
				'slides_per_view'              => woodmart_get_opt( 'related_product_columns', 4 ),
				'slides_per_view_tablet'       => woodmart_get_opt( 'related_product_columns_tablet' ),
				'slides_per_view_mobile'       => woodmart_get_opt( 'related_product_columns_mobile' ),
				'columns'                      => woodmart_get_opt( 'related_product_columns', 4 ),
				'columns_tablet'               => woodmart_get_opt( 'related_product_columns_tablet' ),
				'columns_mobile'               => woodmart_get_opt( 'related_product_columns_mobile' ),
				'img_size'                     => 'woocommerce_thumbnail',
				'products_bordered_grid'       => woodmart_get_opt( 'products_bordered_grid' ),
				'products_bordered_grid_style' => woodmart_get_opt( 'products_bordered_grid_style' ),
				'products_with_background'     => woodmart_get_opt( 'products_with_background' ),
				'products_shadow'              => woodmart_get_opt( 'products_shadow' ),
				'products_color_scheme'        => woodmart_get_opt( 'products_color_scheme' ),
				'custom_sizes'                 => apply_filters( 'woodmart_product_related_custom_sizes', false ),
				'product_quantity'             => woodmart_get_opt( 'product_quantity' ) ? 'enable' : 'disable',
				'spacing'                      => woodmart_get_opt( 'products_spacing' ),
				'spacing_tablet'               => woodmart_get_opt( 'products_spacing_tablet', '' ),
				'spacing_mobile'               => woodmart_get_opt( 'products_spacing_mobile', '' ),
				'wrapper_classes'              => ' upsells-carousel',
				'query_post_type'              => array( 'product', 'product_variation' ),
				'items_per_page'               => woodmart_get_opt( 'related_product_count' ),
			)
		);

		echo woodmart_shortcode_products( $products_atts ); //phpcs:ignore
		?>
	<?php endif ?>

	<?php
endif;
