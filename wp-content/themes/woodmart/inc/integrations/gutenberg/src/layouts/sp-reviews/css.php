<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-Reviews',
	array(
		array(
			'attr_name' => 'reviewsGap',
			'template'  => '--wd-col-gap: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-Reviews',
	array(
		array(
			'attr_name' => 'reviewsGapTablet',
			'template'  => '--wd-col-gap: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-Reviews',
	array(
		array(
			'attr_name' => 'reviewsGapMobile',
			'template'  => '--wd-col-gap: {{value}}px;',
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
