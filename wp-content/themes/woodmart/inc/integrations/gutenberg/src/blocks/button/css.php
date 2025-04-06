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
			'attr_name' => 'width',
			'template'  => '--btn-width: {{value}}' . $block_css->get_units_for_attribute( 'width' ) . ';',
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
			'attr_name' => 'widthTablet',
			'template'  => '--btn-width: {{value}}' . $block_css->get_units_for_attribute( 'width', 'tablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'widthMobile',
			'template'  => '--btn-width: {{value}}' . $block_css->get_units_for_attribute( 'width', 'mobile' ) . ';',
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
