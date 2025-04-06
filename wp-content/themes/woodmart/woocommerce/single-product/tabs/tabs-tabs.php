<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @var array $args This is an array of data to display this template.
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs             = apply_filters( 'woocommerce_product_tabs', array() );
$tab_count                = 0;
$content_count            = 0;
$tabs_classes             = $args['builder_tabs_classes'];
$nav_tabs_wrapper_classes = $args['builder_nav_tabs_wrapper_classes'];
$wrapper_classes          = $args['builder_tabs_wrapper_classes'];
$accordion_on_mobile      = $args['accordion_on_mobile'];
$data_attrs               = '';

woodmart_enqueue_inline_style( 'tabs' );
woodmart_enqueue_inline_style( 'woo-single-prod-el-tabs-opt-layout-tabs' );

if ( 'yes' === $accordion_on_mobile ) {
	woodmart_enqueue_inline_style( 'accordion' );
	woodmart_enqueue_js_script( 'single-product-tabs-accordion' );
	woodmart_enqueue_js_script( 'accordion-element' );

	$wrapper_classes .= ' tabs-layout-tabs';
	$wrapper_classes .= ' wd-opener-style-arrow';
}
?>
<?php if ( ! empty( $product_tabs ) ) : ?>
	<div class="woocommerce-tabs wc-tabs-wrapper<?php echo esc_attr( $wrapper_classes ); ?>" data-state="first" data-layout="tabs">
		<div class="wd-nav-wrapper wd-nav-tabs-wrapper<?php echo esc_attr( $nav_tabs_wrapper_classes ); ?>">
			<ul class="wd-nav wd-nav-tabs wd-icon-pos-left tabs wc-tabs<?php echo esc_attr( $tabs_classes ); ?>" role="tablist">
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<?php
					$li_classes = $key . '_tab';

					if ( 0 === $tab_count ) {
						$li_classes .= ' active';
					}
					?>
					<li class="<?php echo esc_attr( $li_classes ); ?>" id="tab-title-<?php echo esc_attr( $key ); ?>"
						role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<a class="wd-nav-link" href="#tab-<?php echo esc_attr( $key ); ?>">
							<?php if ( isset( $product_tab['title'] ) ) : ?>
								<span class="nav-link-text wd-tabs-title">
									<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
								</span>
							<?php endif; ?>
						</a>
					</li>

					<?php ++$tab_count; ?>
				<?php endforeach; ?>
			</ul>
		</div>

		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<?php
			$content_classes = ' woocommerce-Tabs-panel--' . $key;

			if ( 'yes' === $accordion_on_mobile ) {
				$accordion_title_wrapper_classes = ' tab-title-' . $key;

				if ( 0 === $content_count ) {
					$accordion_title_wrapper_classes .= ' wd-active';
					$content_classes                 .= ' wd-active';
				}
			}

			if ( isset( $args['builder_content_classes'] ) && ! empty( $args['builder_content_classes'] ) ) {
				$content_classes .= $args['builder_content_classes'];
			}

			if ( isset( $product_tab['callback'] ) && 'woocommerce_product_additional_information_tab' === $product_tab['callback'] ) {
				$content_classes .= ' wd-single-attrs';
				$content_classes .= $args['builder_additional_info_classes'];
			}

			if ( isset( $product_tab['callback'] ) && 'comments_template' === $product_tab['callback'] ) {
				$content_classes .= ' wd-single-reviews';
				$content_classes .= $args['builder_reviews_classes'];
			}
			?>
			<?php if ( 'yes' === $accordion_on_mobile ) : ?>
				<div class="wd-accordion-item">
					<div id="tab-item-title-<?php echo esc_attr( $key ); ?>" class="wd-accordion-title<?php echo esc_attr( $accordion_title_wrapper_classes ); ?>" data-accordion-index="<?php echo esc_attr( $key ); ?>">
						<div class="wd-accordion-title-text">
							<?php if ( isset( $product_tab['title'] ) ) : ?>
								<span>
									<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
								</span>
							<?php endif; ?>
						</div>

						<span class="wd-accordion-opener"></span>
					</div>
			<?php endif; ?>

			<div class="woocommerce-Tabs-panel panel entry-content wc-tab<?php echo esc_attr( $content_classes ); ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>" data-accordion-index="<?php echo esc_attr( $key ); ?>">
				<?php if ( isset( $product_tab['callback'] ) ) : ?>
					<?php call_user_func( $product_tab['callback'], $key, $product_tab ); ?>
				<?php endif; ?>
			</div>

			<?php if ( 'yes' === $accordion_on_mobile ) : ?>
				</div>
			<?php endif; ?>

			<?php ++$content_count; ?>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>
<?php endif; ?>
