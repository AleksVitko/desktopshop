<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'width',
			'template'  => '--wd-icon-w: {{value}}' . $block_css->get_units_for_attribute( 'width' ) . ';',
		),
		array(
			'attr_name' => 'height',
			'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'height' ) . ';',
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
			'attr_name' => 'transitionText',
			'template'  => 'transition: color {{value}}s;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' svg',
	array(
		array(
			'attr_name' => 'fillCode',
			'template'  => 'fill: {{value}}!important;',
		),
		array(
			'attr_name' => 'fillVariable',
			'template'  => 'fill: var({{value}})!important;',
		),
		array(
			'attr_name' => 'strokeCode',
			'template'  => 'stroke: {{value}}!important;',
		),
		array(
			'attr_name' => 'strokeVariable',
			'template'  => 'stroke: var({{value}})!important;',
		),
		array(
			'attr_name' => 'transitionSvg',
			'template'  => 'transition: stroke {{value}}s, fill {{value}}s;',
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
	$block_selector_hover . ' svg',
	array(
		array(
			'attr_name' => 'fillHoverCode',
			'template'  => 'fill: {{value}}!important;',
		),
		array(
			'attr_name' => 'fillHoverVariable',
			'template'  => 'fill: var({{value}})!important;',
		),
		array(
			'attr_name' => 'strokeHoverCode',
			'template'  => 'stroke: {{value}}!important;',
		),
		array(
			'attr_name' => 'strokeHoverVariable',
			'template'  => 'stroke: var({{value}})!important;',
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
	'.wd-hover-parent:hover ' . $block_selector . ' svg',
	array(
		array(
			'attr_name' => 'fillParentHoverCode',
			'template'  => 'fill: {{value}}!important;',
		),
		array(
			'attr_name' => 'fillParentHoverVariable',
			'template'  => 'fill: var({{value}})!important;',
		),
		array(
			'attr_name' => 'strokeParentHoverCode',
			'template'  => 'stroke: {{value}}!important;',
		),
		array(
			'attr_name' => 'strokeParentHoverVariable',
			'template'  => 'stroke: var({{value}})!important;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'widthTablet',
			'template'  => '--wd-icon-w: {{value}}' . $block_css->get_units_for_attribute( 'width', 'tablet' ) . ';',
		),
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
			'attr_name' => 'widthMobile',
			'template'  => '--wd-icon-w: {{value}}' . $block_css->get_units_for_attribute( 'width', 'mobile' ) . ';',
		),
		array(
			'attr_name' => 'heightMobile',
			'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'height', 'mobile' ) . ';',
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