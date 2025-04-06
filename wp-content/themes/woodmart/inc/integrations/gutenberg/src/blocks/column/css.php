<?php
use XTS\Gutenberg\Block_CSS;

$mobile_block_selector = ':root ' . $block_selector;
$block_css             = new Block_CSS( $attrs );

$attrs['adjacentCount']       = isset( $attrs['adjacentCount'] ) ? $attrs['adjacentCount'] : 1;
$attrs['adjacentCountTablet'] = isset( $attrs['adjacentCountTablet'] ) ? $attrs['adjacentCountTablet'] : 1;
$attrs['adjacentCountMobile'] = isset( $attrs['adjacentCountMobile'] ) ? $attrs['adjacentCountMobile'] : 1;

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'colWidth',
			'template'  => 'flex: 0 1 calc({{value}}% - var(--wd-col-gap) * ' . ( $attrs['adjacentCount'] - 1 ) . ' / ' . $attrs['adjacentCount'] . ' );',
		),
	),
	'desktop'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'blocksGap',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'direction',
			'template'  => 'flex-direction: {{value}};',
		),
		array(
			'attr_name' => 'justifyContent',
			'template'  => 'justify-content: {{value}};',
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
			'attr_name' => 'wrap',
			'template'  => 'flex-wrap: {{value}};',
		),
		array(
			'attr_name' => 'rowsGap',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'textAlign',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'colWidthTablet',
			'template'  => 'flex: 0 1 calc({{value}}% - var(--wd-col-gap) * ' . ( $attrs['adjacentCountTablet'] - 1 ) . ' / ' . $attrs['adjacentCountTablet'] . ' );',
		),
	),
	'only_tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'blocksGapTablet',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'justifyContentTablet',
			'template'  => 'justify-content: {{value}};',
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
			'attr_name' => 'textAlignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);


$block_css->add_css_rules(
	$mobile_block_selector,
	array(
		array(
			'attr_name' => 'colWidthMobile',
			'template'  => 'flex: 0 1 calc({{value}}% - var(--wd-col-gap) * ' . ( $attrs['adjacentCountMobile'] - 1 ) . ' / ' . $attrs['adjacentCountMobile'] . ' );',
		),
		array(
			'attr_name' => 'blocksGapMobile',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'justifyContentMobile',
			'template'  => 'justify-content: {{value}};',
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
			'attr_name' => 'textAlignMobile',
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

return $block_css->get_css_for_devices();
