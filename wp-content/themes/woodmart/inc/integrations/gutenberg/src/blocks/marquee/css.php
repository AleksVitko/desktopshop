<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'speed',
			'template'  => '--wd-marquee-speed: {{value}}s;',
		),
		array(
			'attr_name' => 'direction',
			'template'  => '--wd-marquee-direction: {{value}};',
		),
		array(
			'attr_name' => 'colorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'colorVariable',
			'template'  => 'color: var({{value}});',
		),
		array(
			'attr_name' => 'blockGap',
			'template'  => '--wd-marquee-gap: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'speedTablet',
			'template'  => '--wd-marquee-speed: {{value}}s;',
		),
		array(
			'attr_name' => 'blockGapTablet',
			'template'  => '--wd-marquee-gap: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'speedMobile',
			'template'  => '--wd-marquee-speed: {{value}}s;',
		),
		array(
			'attr_name' => 'blockGapMobile',
			'template'  => '--wd-marquee-gap: {{value}}px;',
		),
	),
	'mobile'
);

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
