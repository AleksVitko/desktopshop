<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .wd-compare-img-handle',
	array(
		array(
			'attr_name' => 'handleColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'handleColorVariable',
			'template'  => 'color: var({{value}});',
		),
		array(
			'attr_name' => 'handleBgCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'handleBgVariable',
			'template'  => 'background-color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'align',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'mobile'
);

$block_css->merge_with(
	wd_get_block_advanced_css(
		array(
			'selector'                     => $block_selector,
			'selector_hover'               => $block_selector_hover,

			'selector_border'              => $block_selector . ' .wd-compare-img',
			'selector_border_hover'        => $block_selector . ' .wd-compare-img:hover',
			'selector_border_parent_hover' => '.wd-hover-parent:hover ' . $block_selector . ' .wd-compare-img',

			'selector_shadow'              => $block_selector . ' .wd-compare-img',
			'selector_shadow_hover'        => $block_selector . ' .wd-compare-img:hover',
			'selector_shadow_parent_hover' => '.wd-hover-parent:hover ' . $block_selector . ' .wd-compare-img',

			'selector_transition'          => $block_selector . ',' . $block_selector . ' .wd-compare-img',
		),
		$attrs
	)
);

return $block_css->get_css_for_devices();
