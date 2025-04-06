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
	$block_selector . ' .meta-label',
	array(
		array(
			'attr_name' => 'labelColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'labelColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .product_meta > span > *:not(.meta-label)',
	array(
		array(
			'attr_name' => 'valueColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'valueColorVariable',
			'template'  => 'color: var({{value}});',
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

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .meta-label', $attrs, 'labelTp' ) );
$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .product_meta > span > *:not(.meta-label)', $attrs, 'valueTp' ) );

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
