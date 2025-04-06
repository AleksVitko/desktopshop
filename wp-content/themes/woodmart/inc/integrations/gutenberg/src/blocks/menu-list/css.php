<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' > li > a',
	array(
		array(
			'attr_name' => 'titleColorCode',
			'template'  => '--sub-menu-color: {{value}};',
		),
		array(
			'attr_name' => 'titleColorVariable',
			'template'  => '--sub-menu-color: var({{value}});',
		),
		array(
			'attr_name' => 'titleHoverColorCode',
			'template'  => '--sub-menu-color-hover: {{value}};',
		),
		array(
			'attr_name' => 'titleHoverColorVariable',
			'template'  => '--sub-menu-color-hover: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .sub-sub-menu > li > a',
	array(
		array(
			'attr_name' => 'itemsColorCode',
			'template'  => '--sub-menu-color: {{value}};',
		),
		array(
			'attr_name' => 'itemsColorVariable',
			'template'  => '--sub-menu-color: var({{value}});',
		),
		array(
			'attr_name' => 'itemsHoverColorCode',
			'template'  => '--sub-menu-color-hover: {{value}};',
		),
		array(
			'attr_name' => 'itemsHoverColorVariable',
			'template'  => '--sub-menu-color-hover: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'blockGap',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'blockGapTablet',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'blockGapMobile',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
	),
	'mobile'
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' > li > a', $attrs, 'titleTp' ) );
$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .sub-sub-menu > li > a', $attrs, 'itemsTp' ) );

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
