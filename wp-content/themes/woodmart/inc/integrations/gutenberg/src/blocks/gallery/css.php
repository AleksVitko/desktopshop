<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'rounding',
			'template'  => '--wd-brd-radius: {{value}}' . $block_css->get_units_for_attribute( 'rounding' ) . ';',
		),
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

$block_css->merge_with(
	wd_get_block_carousel_css(
		$block_selector,
		$attrs
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
