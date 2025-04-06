<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'blocksGap',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'alignItems',
			'template'  => 'align-items: {{value}};',
		),
		array(
			'attr_name' => 'alignItems',
			'template'  => 'align-content: {{value}};',
		),
		array(
			'attr_name' => 'justifyContent',
			'template'  => 'justify-content: {{value}};',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'blocksGapTablet',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'alignItemsTablet',
			'template'  => 'align-items: {{value}};',
		),
		array(
			'attr_name' => 'alignItemsTablet',
			'template'  => 'align-content: {{value}};',
		),
		array(
			'attr_name' => 'justifyContentTablet',
			'template'  => 'justify-content: {{value}};',
		),
	),
	'tablet'
);


$block_css->add_css_rules(
	':root ' . $block_selector,
	array(
		array(
			'attr_name' => 'blocksGapMobile',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'alignItemsMobile',
			'template'  => 'align-items: {{value}};',
		),
		array(
			'attr_name' => 'alignItemsMobile',
			'template'  => 'align-content: {{value}};',
		),
		array(
			'attr_name' => 'justifyContentMobile',
			'template'  => 'justify-content: {{value}};',
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
