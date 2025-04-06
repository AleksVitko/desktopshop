<?php

use XTS\Modules\Layouts\Main;

if ( ! function_exists( 'wd_gutenberg_single_product_gallery' ) ) {
	function wd_gutenberg_single_product_gallery( $block_attributes ) {
		ob_start();

		wp_enqueue_script( 'zoom' );
		wp_enqueue_script( 'wc-single-product' );

		Main::setup_preview();
		?>
			<div id="<?php echo esc_attr( wd_get_gutenberg_element_id( $block_attributes ) ); ?>" class="wd-single-gallery<?php echo esc_attr( wd_get_gutenberg_element_classes( $block_attributes ) ); ?>">
				<?php
				wc_get_template(
					'single-product/product-image.php',
					array(
						'builder_thumbnails_position' => isset( $block_attributes['thumbnailsPosition'] ) ? $block_attributes['thumbnailsPosition'] : '',
						'builder_thumbnails_vertical_columns' => isset( $block_attributes['thumbnailsLeftVerticalColumns'] ) ? $block_attributes['thumbnailsLeftVerticalColumns'] : '',
						'builder_thumbnails_columns_desktop' => isset( $block_attributes['thumbnailsBottomColumns'] ) ? $block_attributes['thumbnailsBottomColumns'] : '',
						'builder_thumbnails_columns_tablet' => 'left' === $block_attributes['thumbnailsPosition'] ? $block_attributes['thumbnailsLeftVerticalColumnsTablet'] : $block_attributes['thumbnailsBottomColumnsTablet'],
						'builder_thumbnails_columns_mobile' => 'left' === $block_attributes['thumbnailsPosition'] ? $block_attributes['thumbnailsLeftVerticalColumnsMobile'] : $block_attributes['thumbnailsBottomColumnsMobile'],
						'gallery_columns_desktop'     => $block_attributes['slidesPerView'],
						'gallery_columns_tablet'      => isset( $block_attributes['slidesPerViewTablet'] ) ? $block_attributes['slidesPerViewTablet'] : '',
						'gallery_columns_mobile'      => isset( $block_attributes['slidesPerViewMobile'] ) ? $block_attributes['slidesPerViewMobile'] : '',
						'carousel_on_tablet'          => $block_attributes['carouselOnTablet'],
						'carousel_on_mobile'          => $block_attributes['carouselOnMobile'],
						'pagination_main_gallery'     => $block_attributes['paginationMainGallery'],
						'main_gallery_center_mode'    => $block_attributes['mainGalleryCenterMode'],
						'thumbnails_wrap_in_mobile_devices' => $block_attributes['thumbnailsWrapInMobileDevices'],
						'grid_columns'                => $block_attributes['gridColumns'],
						'grid_columns_tablet'         => isset( $block_attributes['gridColumnsTablet'] ) ? $block_attributes['gridColumnsTablet'] : '',
						'grid_columns_mobile'         => isset( $block_attributes['gridColumnsMobile'] ) ? $block_attributes['gridColumnsMobile'] : '',
					)
				);
				?>
			</div>
		<?php
		Main::restore_preview();

		return ob_get_clean();
	}
}
