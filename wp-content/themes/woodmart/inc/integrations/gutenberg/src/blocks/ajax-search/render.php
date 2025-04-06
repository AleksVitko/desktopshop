<?php
if ( ! function_exists( 'wd_gutenberg_ajax_search' ) ) {
	function wd_gutenberg_ajax_search( $block_attributes ) {
		$el_class  = wd_get_gutenberg_element_classes( $block_attributes );
		$el_class .= $block_attributes['woodmart_color_scheme'] ? ' wd-color-' . $block_attributes['woodmart_color_scheme'] : '';

		ob_start();

		woodmart_search_form(
			array(
				'ajax'                   => true,
				'post_type'              => $block_attributes['search_post_type'],
				'count'                  => $block_attributes['number'],
				'thumbnail'              => $block_attributes['thumbnail'],
				'price'                  => $block_attributes['price'],
				'show_categories'        => $block_attributes['category'],
				'search_style'           => $block_attributes['form_style'],
				'cat_selector_style'     => $block_attributes['cat_selector_style'],
				'wrapper_custom_classes' => $el_class,
				'el_id'                  => wd_get_gutenberg_element_id( $block_attributes ),
			)
		);

		return ob_get_clean();
	}
}
