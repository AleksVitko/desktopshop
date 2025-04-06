<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$icon_selector = $block_selector . ' .wd-spot-icon:before';
$icon_selector_hover = $block_selector . ' .wd-spot:hover .wd-spot-icon:before, ' . $block_selector . ' .wd-spot.wd-opened .wd-spot-icon:before';

$bg_selector = $block_selector . ' .wd-spot-icon-bg';
$bg_selector_hover = $block_selector . ' .wd-spot:hover .wd-spot-icon-bg, ' . $block_selector . ' .wd-spot.wd-opened .wd-spot-icon-bg';

$block_css->add_css_rules(
	$icon_selector,
	array(
		array(
			'attr_name' => 'iconColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'iconColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$icon_selector_hover,
	array(
		array(
			'attr_name' => 'iconColorHoverCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'iconColorHoverVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$bg_selector,
	array(
		array(
			'attr_name' => 'iconBgColorCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'iconBgColorVariable',
			'template'  => 'background-color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$bg_selector_hover,
	array(
		array(
			'attr_name' => 'iconBgColorHoverCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'iconBgColorHoverVariable',
			'template'  => 'background-color: var({{value}});',
		),
	)
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
