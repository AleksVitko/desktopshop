<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .wd-slide-container',
	array(
		array(
			'attr_name' => 'blockGap',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'justify',
			'template'  => '--wd-justify-content: {{value}};',
		),
		array(
			'attr_name' => 'align',
			'template'  => '--wd-align-items: {{value}};',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-slide-container',
	array(
		array(
			'attr_name' => 'blockGapTablet',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'justifyTablet',
			'template'  => '--wd-justify-content: {{value}};',
		),
		array(
			'attr_name' => 'alignTablet',
			'template'  => '--wd-align-items: {{value}};',
		),
	),
	'tablet'
);


$block_css->add_css_rules(
	$block_selector . ' .wd-slide-container',
	array(
		array(
			'attr_name' => 'blockGapMobile',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'justifyMobile',
			'template'  => '--wd-justify-content: {{value}};',
		),
		array(
			'attr_name' => 'alignMobile',
			'template'  => '--wd-align-items: {{value}};',
		),
	),
	'mobile'
);


$block_css->merge_with(
	wd_get_block_advanced_css(
		array(
			'selector'                 => $block_selector,
			'selector_hover'           => $block_selector_hover,
			'selector_bg'              => $block_selector . ' .wd-slide-bg',
			'selector_bg_hover'        => $block_selector_hover . ' .wd-slide-bg',
			'selector_bg_parent_hover' => '.wd-hover-parent:hover ' . $block_selector . ' .wd-slide-bg',
		),
		$attrs
	)
);

return $block_css->get_css_for_devices();
