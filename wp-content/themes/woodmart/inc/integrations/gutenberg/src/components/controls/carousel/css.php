<?php

use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_carousel_css' ) ) {
	/**
	 * Get control carousel CSS.
	 *
	 * @param string $selector CSS selector.
	 * @param array  $attributes Block attributes.
	 *
	 * @return array
	 */
	function wd_get_block_carousel_css( $selector, $attributes ) {
		$block_css = new Block_CSS( $attributes );

		$block_css->add_css_rules(
			$selector . ' .wd-nav-arrows',
			array(
				array(
					'attr_name' => 'carouselArrowsOffsetH',
					'template'  => '--wd-arrow-offset-h: {{value}}' . $block_css->get_units_for_attribute( 'carouselArrowsOffsetH' ) . ';',
				),
				array(
					'attr_name' => 'carouselArrowsOffsetV',
					'template'  => '--wd-arrow-offset-v: {{value}}' . $block_css->get_units_for_attribute( 'carouselArrowsOffsetV' ) . ';',
				),
			)
		);

		$block_css->add_css_rules(
			$selector . ' .wd-nav-arrows',
			array(
				array(
					'attr_name' => 'carouselArrowsOffsetHTablet',
					'template'  => '--wd-arrow-offset-h: {{value}}' . $block_css->get_units_for_attribute( 'carouselArrowsOffsetHTablet' ) . ';',
				),
				array(
					'attr_name' => 'carouselArrowsOffsetVTablet',
					'template'  => '--wd-arrow-offset-v: {{value}}' . $block_css->get_units_for_attribute( 'carouselArrowsOffsetVTablet' ) . ';',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$selector . ' .wd-nav-arrows',
			array(
				array(
					'attr_name' => 'carouselArrowsOffsetHMobile',
					'template'  => '--wd-arrow-offset-h: {{value}}' . $block_css->get_units_for_attribute( 'carouselArrowsOffsetHMobile' ) . ';',
				),
				array(
					'attr_name' => 'carouselArrowsOffsetVMobile',
					'template'  => '--wd-arrow-offset-v: {{value}}' . $block_css->get_units_for_attribute( 'carouselArrowsOffsetVMobile' ) . ';',
				),
			),
			'mobile'
		);

		return $block_css->get_css();
	}
}
