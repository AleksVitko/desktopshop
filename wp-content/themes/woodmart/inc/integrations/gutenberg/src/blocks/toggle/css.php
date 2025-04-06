<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );
$block_css->add_css_rules(
	$block_selector . ' .wd-toggle-content',
	array(
		array(
			'attr_name' => 'blockGap',
			'template'  => 'margin-top: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-toggle-content',
	array(
		array(
			'attr_name' => 'blockGapTablet',
			'template'  => 'margin-top: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .wd-toggle-content',
	array(
		array(
			'attr_name' => 'blockGapMobile',
			'template'  => 'margin-top: {{value}}px;',
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
