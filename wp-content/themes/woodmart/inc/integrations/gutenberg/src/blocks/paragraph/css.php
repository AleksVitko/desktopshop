<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

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
			'attr_name' => 'textAlign',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' a',
	array(
		array(
			'attr_name' => 'linksColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'linksColorVariable',
			'template'  => 'color: var({{value}});',
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
	$block_selector . ' a:hover',
	array(
		array(
			'attr_name' => 'linksColorHoverCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'linksColorHoverVariable',
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
	'.wd-hover-parent:hover ' . $block_selector . ' a',
	array(
		array(
			'attr_name' => 'linksColorParentHoverCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'linksColorParentHoverVariable',
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
	$block_selector . ' .wd-highlight',
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

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-highlight', $attrs, 'mark' ) );
$block_css->merge_with( wd_get_block_typography_css( $block_selector, $attrs, 'tp' ) );
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
