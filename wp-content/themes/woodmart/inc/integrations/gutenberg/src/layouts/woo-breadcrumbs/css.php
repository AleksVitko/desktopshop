<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'textAlign',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' :is(.wd-breadcrumbs,.yoast-breadcrumb)',
	array(
		array(
			'attr_name' => 'textColorCode',
			'template'  => '--wd-link-color: {{value}};',
		),
		array(
			'attr_name' => 'textColorVariable',
			'template'  => '--wd-link-color: var({{value}});',
		),
		array(
			'attr_name' => 'textHoverColorCode',
			'template'  => '--wd-link-color-hover: {{value}};',
		),
		array(
			'attr_name' => 'textHoverColorVariable',
			'template'  => '--wd-link-color-hover: var({{value}});',
		),
		array(
			'attr_name' => 'textActiveColorCode',
			'template'  => '--wd-bcrumb-color-active: {{value}};',
		),
		array(
			'attr_name' => 'textActiveColorVariable',
			'template'  => '--wd-bcrumb-color-active: var({{value}});',
		),
		array(
			'attr_name' => 'delimiterColorCode',
			'template'  => '--wd-bcrumb-delim-color: {{value}};',
		),
		array(
			'attr_name' => 'delimiterColorVariable',
			'template'  => '--wd-bcrumb-delim-color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'textAlignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'textAlignMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'mobile'
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector, $attrs, 'tp' ) );

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
