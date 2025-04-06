<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .wd-insta-item',
	array(
		array(
			'attr_name' => 'custom_rounding_size',
			'template'  => '--wd-brd-radius: {{value}}' . $block_css->get_units_for_attribute( 'custom_rounding_size' ) . ';',
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
