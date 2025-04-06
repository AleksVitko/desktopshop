<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .star-rating',
	array(
		array(
			'attr_name' => 'size',
			'template'  => 'font-size: {{value}}px;',
		),
		array(
			'attr_name' => 'filledColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'filledColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .star-rating:before',
	array(
		array(
			'attr_name' => 'emptyColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'emptyColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .star-rating',
	array(
		array(
			'attr_name' => 'sizeTablet',
			'template'  => 'font-size: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .star-rating',
	array(
		array(
			'attr_name' => 'sizeMobile',
			'template'  => 'font-size: {{value}}px;',
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
