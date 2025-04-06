<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'brandBgColorCode',
			'template'  => '--wd-brand-bg: {{value}};',
		),
		array(
			'attr_name' => 'brandBgColorVariable',
			'template'  => '--wd-brand-bg: var({{value}});',
		),
		array(
			'attr_name' => 'padding',
			'template'  => '--wd-brand-pd: {{value}}' . $block_css->get_units_for_attribute( 'padding' ) . ';',
		),
		array(
			'attr_name' => 'imagesWidth',
			'template'  => '--wd-brand-img-width: {{value}}' . $block_css->get_units_for_attribute( 'imagesWidth' ) . ';',
		),
		array(
			'attr_name' => 'imagesHeight',
			'template'  => '--wd-brand-img-height: {{value}}' . $block_css->get_units_for_attribute( 'imagesHeight' ) . ';',
		),
		array(
			'attr_name' => 'align',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'paddingTablet',
			'template'  => '--wd-brand-pd: {{value}}' . $block_css->get_units_for_attribute( 'paddingTablet' ) . ';',
		),
		array(
			'attr_name' => 'imagesWidthTablet',
			'template'  => '--wd-brand-img-width: {{value}}' . $block_css->get_units_for_attribute( 'imagesWidthTablet' ) . ';',
		),
		array(
			'attr_name' => 'imagesHeightTablet',
			'template'  => '--wd-brand-img-height: {{value}}' . $block_css->get_units_for_attribute( 'imagesHeightTablet' ) . ';',
		),
		array(
			'attr_name' => 'alignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'paddingMobile',
			'template'  => '--wd-brand-pd: {{value}}' . $block_css->get_units_for_attribute( 'paddingMobile' ) . ';',
		),
		array(
			'attr_name' => 'imagesWidthMobile',
			'template'  => '--wd-brand-img-width: {{value}}' . $block_css->get_units_for_attribute( 'imagesWidthMobile' ) . ';',
		),
		array(
			'attr_name' => 'imagesHeightMobile',
			'template'  => '--wd-brand-img-height: {{value}}' . $block_css->get_units_for_attribute( 'imagesHeightMobile' ) . ';',
		),
		array(
			'attr_name' => 'alignMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'mobile'
);

$block_css->merge_with(
	wd_get_block_advanced_css(
		array(
			'selector'       => $block_selector,
			'selector_hover' => $block_selector_hover,
		),
		$attrs
	)
);

$block_css->merge_with(
	wd_get_block_carousel_css(
		$block_selector,
		$attrs
	)
);

return $block_css->get_css_for_devices();
