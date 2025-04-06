<?php
use XTS\Gutenberg\Block_CSS;

$block_css     = new Block_CSS( $attrs );
$content_class = $block_selector . ' .wd-spot-dropdown';

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'positionX',
			'template'  => 'left: {{value}}%;',
		),
		array(
			'attr_name' => 'positionY',
			'template'  => 'top: {{value}}%;',
		),
	)
);

$block_css->add_css_rules(
	$content_class,
	array(
		array(
			'attr_name' => 'blockGap',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'alignment',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$content_class,
	array(
		array(
			'attr_name' => 'blockGapTablet',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'alignmentTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$content_class,
	array(
		array(
			'attr_name' => 'blockGapMobile',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'alignmentMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'mobile'
);

$block_css->merge_with(
	wd_get_block_advanced_css(
		array(
			'selector'       => $block_selector . ' .wd-spot-dropdown',
			'selector_hover' => $block_selector_hover . ' .wd-spot-dropdown:hover',
		),
		$attrs
	)
);

return $block_css->get_css_for_devices();
