<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'justify',
			'template'  => 'justify-content: {{value}};',
		),
		array(
			'attr_name' => 'align',
			'template'  => 'align-items: {{value}};',
		),
		array(
			'attr_name' => 'align',
			'template'  => 'align-content: {{value}};',
		),
		array(
			'attr_name' => 'wrap',
			'template'  => 'flex-wrap: {{value}};',
		),
		array(
			'attr_name' => 'colGap',
			'template'  => '--wd-col-gap: {{value}}' . $block_css->get_units_for_attribute( 'colGap' ) . ';',
		),
		array(
			'attr_name' => 'rowGap',
			'template'  => '--wd-row-gap: {{value}}' . $block_css->get_units_for_attribute( 'rowGap' ) . ';',
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
			'attr_name' => 'justifyTablet',
			'template'  => 'justify-content: {{value}};',
		),
		array(
			'attr_name' => 'alignTablet',
			'template'  => 'align-items: {{value}};',
		),
		array(
			'attr_name' => 'alignTablet',
			'template'  => 'align-content: {{value}};',
		),
		array(
			'attr_name' => 'wrapTablet',
			'template'  => 'flex-wrap: {{value}};',
		),
		array(
			'attr_name' => 'colGapTablet',
			'template'  => '--wd-col-gap: {{value}}' . $block_css->get_units_for_attribute( 'colGap', 'tablet' ) . ';',
		),
		array(
			'attr_name' => 'rowGapTablet',
			'template'  => '--wd-row-gap: {{value}}' . $block_css->get_units_for_attribute( 'rowGap', 'tablet' ) . ';',
		),
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
			'attr_name' => 'justifyMobile',
			'template'  => 'justify-content: {{value}};',
		),
		array(
			'attr_name' => 'alignMobile',
			'template'  => 'align-items: {{value}};',
		),
		array(
			'attr_name' => 'alignMobile',
			'template'  => 'align-content: {{value}};',
		),
		array(
			'attr_name' => 'wrapMobile',
			'template'  => 'flex-wrap: {{value}};',
		),
		array(
			'attr_name' => 'colGapMobile',
			'template'  => '--wd-col-gap: {{value}}' . $block_css->get_units_for_attribute( 'colGap', 'mobile' ) . ';',
		),
		array(
			'attr_name' => 'rowGapMobile',
			'template'  => '--wd-row-gap: {{value}}' . $block_css->get_units_for_attribute( 'rowGap', 'mobile' ) . ';',
		),
		array(
			'attr_name' => 'textAlignMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'mobile'
);

$block_css->merge_with( wd_get_block_shape_divider_css( $block_selector, $attrs, 'shapeDividerTop' ) );
$block_css->merge_with( wd_get_block_shape_divider_css( $block_selector, $attrs, 'shapeDividerBottom', 'bottom' ) );

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
