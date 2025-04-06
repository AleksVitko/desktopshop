<?php
if ( ! function_exists( 'wd_gutenberg_contact_form' ) ) {
	function wd_gutenberg_contact_form( $block_attributes ) {
		if ( ! $block_attributes['form_id'] || ! defined( 'WPCF7_PLUGIN' ) ) {
			return '<div id="' . wd_get_gutenberg_element_id( $block_attributes ) . '" class="wd-notice wd-info' . wd_get_gutenberg_element_classes( $block_attributes ) . '"><span>' . esc_html__( 'You need to create a form using Contact form 7 plugin to be able to display it using this element.', 'woodmart' ) . '</span></div>';
		}

		$el_class = '';

		if ( ! empty( $block_attributes['color_scheme'] ) ) {
			$el_class .= ' color-scheme-' . $block_attributes['color_scheme'];
		}

		return '<div id="' . wd_get_gutenberg_element_id( $block_attributes ) . '" class="' . wd_get_gutenberg_element_classes( $block_attributes, 'wd-cf7' ) . '">' . do_shortcode( '[contact-form-7 html_class="' . esc_attr( $el_class ) . '" id="' . esc_attr( $block_attributes['form_id'] ) . '"]' ) . '</div>';
	}
}
