<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );
$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'contentHeight',
			'template'  => '--wd-colps-height: {{value}}' . $block_css->get_units_for_attribute( 'contentHeight' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'contentHeightTablet',
			'template'  => '--wd-colps-height: {{value}}' . $block_css->get_units_for_attribute( 'contentHeight', 'tablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'contentHeightMobile',
			'template'  => '--wd-colps-height: {{value}}' . $block_css->get_units_for_attribute( 'contentHeight', 'mobile' ) . ';',
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
