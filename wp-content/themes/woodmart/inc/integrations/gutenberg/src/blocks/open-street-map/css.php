<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .wd-map-wrapper',
	array(
		array(
			'attr_name' => 'height',
			'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'height' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'contentAlignHorizontal',
			'template'  => '--wd-justify-content: {{value}};',
		),
		array(
			'attr_name' => 'contentAlignVertical',
			'template'  => '--wd-align-items: {{value}};',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-map-wrapper',
	array(
		array(
			'attr_name' => 'heightTablet',
			'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'height', 'tablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'contentAlignHorizontalTablet',
			'template'  => '--wd-justify-content: {{value}};',
		),
		array(
			'attr_name' => 'contentAlignVerticalTablet',
			'template'  => '--wd-align-items: {{value}};',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .wd-map-wrapper',
	array(
		array(
			'attr_name' => 'heightMobile',
			'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'height', 'mobile' ) . ';',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'contentAlignHorizontalMobile',
			'template'  => '--wd-justify-content: {{value}};',
		),
		array(
			'attr_name' => 'contentAlignVerticalMobile',
			'template'  => '--wd-align-items: {{value}};',
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
