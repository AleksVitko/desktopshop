<?php
use XTS\Gutenberg\Block_CSS;

$mark_selector = $block_selector .' .wd-highlight';
$block_css     = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'colorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'colorVariable',
			'template'  => 'color: var({{value}});',
		),

		array(
			'attr_name' => 'activeBorderColorCode',
			'template'  => '--wd-title-brd-color-act: {{value}};',
		),
		array(
			'attr_name' => 'activeBorderColorVariable',
			'template'  => '--wd-title-brd-color-act: var({{value}});',
		),
		array(
			'attr_name' => 'textAlign',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector_hover,
	array(
		array(
			'attr_name' => 'colorHoverCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'colorHoverVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	'.wd-hover-parent:hover ' . $block_selector,
	array(
		array(
			'attr_name' => 'colorParentHoverCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'colorParentHoverVariable',
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

$block_css->add_css_rules(
	$mark_selector,
	array(
		array(
			'attr_name' => 'markColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'markColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector, $attrs, 'tp' ) );
$block_css->merge_with( wd_get_block_typography_css( $mark_selector, $attrs, 'mark' ) );
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
