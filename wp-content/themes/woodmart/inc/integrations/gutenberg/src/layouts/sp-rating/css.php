<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .star-rating',
	array(
		array(
			'attr_name' => 'size',
			'template'  => 'font-size: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-review-link',
	array(
		array(
			'attr_name' => 'linkColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'linkColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-review-link:hover',
	array(
		array(
			'attr_name' => 'linkColorHoverCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'linkColorHoverVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'textAlign',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'textAlignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
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
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector . ' .star-rating',
	array(
		array(
			'attr_name' => 'sizeTablet',
			'template'  => 'font-size: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .star-rating',
	array(
		array(
			'attr_name' => 'sizeMobile',
			'template'  => 'font-size: {{value}}px;',
		),
	),
	'mobile'
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .woocommerce-review-link', $attrs, 'linkTp' ) );

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
