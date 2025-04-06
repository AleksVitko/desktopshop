<?php
if ( ! function_exists( 'wd_gutenberg_mailchimp' ) ) {
	function wd_gutenberg_mailchimp( $block_attributes ) {
		if ( empty( $block_attributes['form_id'] ) || ! defined( 'MC4WP_VERSION' ) ) {
			return '<div id="' . wd_get_gutenberg_element_id( $block_attributes ) . '" class="wd-notice wd-info' . wd_get_gutenberg_element_classes( $block_attributes ) . '"><span>' . esc_html__( 'You need to create a form using MC4WP: Mailchimp for WordPress plugin to be able to display it using this element.', 'woodmart' ) . '</span></div>';
		}

		$el_class = wd_get_gutenberg_element_classes( $block_attributes );

		if ( ! empty( $block_attributes['color_scheme'] ) ) {
			$el_class .= ' color-scheme-' . $block_attributes['color_scheme'];
		}

		return do_shortcode( '[mc4wp_form id="' . esc_attr( $block_attributes['form_id'] ) . '" element_id="' . wd_get_gutenberg_element_id( $block_attributes ) . '" element_class="' . esc_attr( $el_class ) . '"]' );
	}
}
