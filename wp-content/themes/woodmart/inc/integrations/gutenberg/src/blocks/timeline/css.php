<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'dotSize',
			'template'  => '--wd-timeline-dot-size: {{value}}px;',
		),
		array(
			'attr_name' => 'dotColorCode',
			'template'  => '--wd-timeline-dot-bg: {{value}};',
		),
		array(
			'attr_name' => 'dotColorVariable',
			'template'  => '--wd-timeline-dot-bg: var({{value}});',
		),
		array(
			'attr_name' => 'lineStyle',
			'template'  => '--wd-timeline-line-style: {{value}};',
		),
		array(
			'attr_name' => 'lineColorCode',
			'template'  => '--wd-timeline-line-color: {{value}};',
		),
		array(
			'attr_name' => 'lineColorVariable',
			'template'  => '--wd-timeline-line-color: var({{value}});',
		),
		array(
			'attr_name' => 'lineWidth',
			'template'  => '--wd-timeline-line-width: {{value}}px;',
		),
		array(
			'attr_name' => 'blockGap',
			'template'  => '--wd-timeline-gap: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'blockGapTablet',
			'template'  => '--wd-timeline-gap: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'blockGapMobile',
			'template'  => '--wd-timeline-gap: {{value}}px;',
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

return $block_css->get_css_for_devices();
