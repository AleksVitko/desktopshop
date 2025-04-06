<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

if ( ! isset( $attrs['design'] ) || '1' === $attrs['design'] ) {
	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'gap',
				'template'  => '--wd-row-gap: {{value}}px;',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'gapTablet',
				'template'  => '--wd-row-gap: {{value}}px;',
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
		),
		'mobile'
	);
}

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignment',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignmentTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignmentMobile',
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
