<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignment',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
		array(
			'attr_name' => 'blockGap',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' li',
	array(
		array(
			'attr_name' => 'textColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'textColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' li a',
	array(
		array(
			'attr_name' => 'linkColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'linkColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' li a:hover',
	array(
		array(
			'attr_name' => 'linkColorHoverCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'linkColorHoverVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-icon',
	array(
		array(
			'attr_name' => 'iconColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'iconColorVariable',
			'template'  => 'color: var({{value}});',
		),
		array(
			'attr_name' => 'iconSize',
			'template'  => '--li-icon-s: {{value}}' . $block_css->get_units_for_attribute( 'iconSize' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . '.wd-shape-icon .wd-icon',
	array(
		array(
			'attr_name' => 'iconBgColorCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'iconBgColorVariable',
			'template'  => 'background-color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' li:hover .wd-icon',
	array(
		array(
			'attr_name' => 'iconColorHoverCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'iconColorHoverVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . '.wd-shape-icon li:hover .wd-icon',
	array(
		array(
			'attr_name' => 'iconBgColorHoverCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'iconBgColorHoverVariable',
			'template'  => 'background-color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignmentTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
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
			'attr_name' => 'iconSizeTablet',
			'template'  => '--li-icon-s: {{value}}' . $block_css->get_units_for_attribute( 'iconSize', 'tablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignmentMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
		array(
			'attr_name' => 'blockGapMobile',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'iconSizeMobile',
			'template'  => '--li-icon-s: {{value}}' . $block_css->get_units_for_attribute( 'iconSize', 'mobile' ) . ';',
		),
	),
	'mobile'
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-list-content', $attrs, 'itemsTp' ) );

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
