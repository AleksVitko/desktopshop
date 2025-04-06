<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'custom_rounding_size',
			'template'  => '--wd-brd-radius: {{value}}' . $block_css->get_units_for_attribute( 'custom_rounding_size' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-products-with-bg, ' . $block_selector . ' .wd-products-with-bg .wd-product, ' . $block_selector . '.wd-products-with-bg, ' . $block_selector . '.wd-products-with-bg .wd-product',
	array(
		array(
			'attr_name' => 'productsBackgroundCode',
			'template'  => '--wd-prod-bg: {{value}};--wd-bordered-bg: {{value}};',
		),
		array(
			'attr_name' => 'productsBackgroundVariable',
			'template'  => '--wd-prod-bg: var({{value}});--wd-bordered-bg: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' [class*="products-bordered-grid"], ' . $block_selector . ' [class*="products-bordered-grid"] .wd-product,' . $block_selector . '[class*="products-bordered-grid"], ' . $block_selector . '[class*="products-bordered-grid"] .wd-product',
	array(
		array(
			'attr_name' => 'productsBorderColorCode',
			'template'  => '--wd-bordered-brd: {{value}};',
		),
		array(
			'attr_name' => 'productsBorderColorVariable',
			'template'  => '--wd-bordered-brd: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .element-title',
	array(
		array(
			'attr_name' => 'titleColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'titleColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav-arrows',
	array(
		array(
			'attr_name' => 'paginationArrowsOffsetH',
			'template'  => '--wd-arrow-offset-h: {{value}}' . $block_css->get_units_for_attribute( 'paginationArrowsOffsetH' ) . ';',
		),
		array(
			'attr_name' => 'paginationArrowsOffsetV',
			'template'  => '--wd-arrow-offset-v: {{value}}' . $block_css->get_units_for_attribute( 'paginationArrowsOffsetV' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav-arrows',
	array(
		array(
			'attr_name' => 'paginationArrowsOffsetHTablet',
			'template'  => '--wd-arrow-offset-h: {{value}}' . $block_css->get_units_for_attribute( 'paginationArrowsOffsetHTablet' ) . ';',
		),
		array(
			'attr_name' => 'paginationArrowsOffsetVTablet',
			'template'  => '--wd-arrow-offset-v: {{value}}' . $block_css->get_units_for_attribute( 'paginationArrowsOffsetVTablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav-arrows',
	array(
		array(
			'attr_name' => 'paginationArrowsOffsetHMobile',
			'template'  => '--wd-arrow-offset-h: {{value}}' . $block_css->get_units_for_attribute( 'paginationArrowsOffsetHMobile' ) . ';',
		),
		array(
			'attr_name' => 'paginationArrowsOffsetVMobile',
			'template'  => '--wd-arrow-offset-v: {{value}}' . $block_css->get_units_for_attribute( 'paginationArrowsOffsetVMobile' ) . ';',
		),
	),
	'mobile'
);

$block_css->merge_with(
	wd_get_block_carousel_css(
		$block_selector,
		$attrs
	)
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .element-title', $attrs, 'title' ) );
$block_css->merge_with(
	wd_get_block_advanced_css(
		array(
			'selector'       => $block_selector,
			'selector_hover' => $block_selector_hover,
		),
		$attrs
	)
);

return $block_css->get_css_for_devices();
