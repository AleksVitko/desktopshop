<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'gap',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'align',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

if ( ! isset( $attrs['iconPositionHorizontal'] ) || 'start' === $attrs['iconPositionHorizontal'] ) {
	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'iconPositionVertical',
				'template'  => 'align-items: {{value}};',
			),
		)
	);
}

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'gapTablet',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'alignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'gapMobile',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'alignMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
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
