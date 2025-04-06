<?php
use XTS\Gutenberg\Block_CSS;

$weight = isset( $attrs['weight'] ) ? $attrs['weight'] : 1;
$svgs   = array(
	'zigzag'  => "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' preserveAspectRatio='none' overflow='visible' height='100%' viewBox='0 0 24 24' fill='none' stroke='black' stroke-width='" . $weight . "' stroke-linecap='square' stroke-miterlimit='10'%3E%3Cpolyline points='0,18 12,6 24,18 '/%3E%3C/svg%3E\")",
	'wavy'    => "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' preserveAspectRatio='none' overflow='visible' height='100%' viewBox='0 0 24 24' fill='none' stroke='black' stroke-width='" . $weight . "' stroke-linecap='square' stroke-miterlimit='10'%3E%3Cpath d='M0,6c6,0,0.9,11.1,6.9,11.1S18,6,24,6'/%3E%3C/svg%3E\")",
	'slashes' => "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' preserveAspectRatio='none' overflow='visible' height='100%' viewBox='0 0 20 16' fill='none' stroke='black' stroke-width='" . $weight . "' stroke-linecap='square' stroke-miterlimit='10'%3E%3Cg transform='translate(-12.000000, 0)'%3E%3Cpath d='M28,0L10,18'/%3E%3Cpath d='M18,0L0,18'/%3E%3Cpath d='M48,0L30,18'/%3E%3Cpath d='M38,0L20,18'/%3E%3C/g%3E%3C/svg%3E\")",
	'curved'  => "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' preserveAspectRatio='none' overflow='visible' height='100%' viewBox='0 0 24 24' fill='none' stroke='black' stroke-width='" . $weight . "' stroke-linecap='square' stroke-miterlimit='10'%3E%3Cpath d='M0,6c6,0,6,13,12,13S18,6,24,6'/%3E%3C/svg%3E\")",
);

$block_css = new Block_CSS( $attrs );
$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'weight',
			'template'  => '--wd-div-weight: {{value}}px;',
		),
		array(
			'attr_name' => 'height',
			'template'  => '--wd-div-height: {{value}}px;',
		),
		array(
			'attr_name' => 'svgSize',
			'template'  => '--wd-div-size: {{value}}px;',
		),
		array(
			'attr_name' => 'textAlign',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
		array(
			'attr_name' => 'colorCode',
			'template'  => '--wd-div-color: {{value}};',
		),
		array(
			'attr_name' => 'colorVariable',
			'template'  => '--wd-div-color: var({{value}});',
		),
		array(
			'attr_name' => 'width',
			'template'  => '--wd-div-width: {{value}}' . $block_css->get_units_for_attribute( 'width' ) . ';',
		),
		array(
			'attr_name' => 'blockGap',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
	)
);

if ( isset( $attrs['style'] ) ) {
	if ( in_array( $attrs['style'], array( 'solid', 'double', 'dotted', 'dashed' ), true ) ) {
		$block_css->add_css_rules(
			$block_selector,
			array(
				array(
					'attr_name' => 'style',
					'template'  => '--wd-div-style: {{value}};',
				),
			)
		);
	}

	if ( in_array( $attrs['style'], array( 'zigzag', 'slashes', 'wavy', 'curved' ), true ) ) {
		$block_css->add_css_rules(
			$block_selector,
			array(
				array(
					'attr_name' => 'style',
					'template'  => '--wd-div-url: ' . $svgs[ $attrs['style'] ] . ';',
				),
			)
		);
	}

	if ( ! empty( $attrs['imageSvg'] ) && 'custom-svg' === $attrs['style'] ) {
		$block_css->add_css_rules(
			$block_selector,
			array(
				array(
					'attr_name' => 'style',
					'template'  => '--wd-div-url: url("' . $attrs['imageSvg']['url'] . '");',
				),
			)
		);
	}

	if ( ! empty( $attrs['image'] ) && 'custom-image' === $attrs['style'] ) {
		$block_css->add_css_rules(
			$block_selector,
			array(
				array(
					'attr_name' => 'style',
					'template'  => '--wd-div-url: url("' . $attrs['image']['url'] . '");',
				),
			)
		);
	}
}

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'textAlignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
		array(
			'attr_name' => 'widthTablet',
			'template'  => '--wd-div-width: {{value}}' . $block_css->get_units_for_attribute( 'width', 'tablet' ) . ';',
		),
		array(
			'attr_name' => 'blockGapTablet',
			'template'  => '--wd-row-gap: {{value}}px;',
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
		array(
			'attr_name' => 'widthMobile',
			'template'  => '--wd-div-width: {{value}}' . $block_css->get_units_for_attribute( 'width', 'mobile' ) . ';',
		),
		array(
			'attr_name' => 'blockGapMobile',
			'template'  => '--wd-row-gap: {{value}}px;',
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
