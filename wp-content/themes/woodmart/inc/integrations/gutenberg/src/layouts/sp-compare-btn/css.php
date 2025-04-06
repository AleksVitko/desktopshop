<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .wd-action-btn > a:before',
	array(
		array(
			'attr_name' => 'iconColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'iconColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-action-btn > a:hover:before',
	array(
		array(
			'attr_name' => 'iconColorHoverCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'iconColorHoverVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

if ( ! isset( $attrs['style'] ) || 'text' === $attrs['style'] ) {
	$block_css->add_css_rules(
		$block_selector . ' .wd-action-btn > a span',
		array(
			array(
				'attr_name' => 'textColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'textColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-action-btn > a:hover span',
		array(
			array(
				'attr_name' => 'textColorHoverCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'textColorHoverVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-action-btn > a span', $attrs, 'textTp' ) );
}

$block_css->add_css_rules(
	$block_selector . ' .wd-action-btn',
	array(
		array(
			'attr_name' => 'iconSize',
			'template'  => '--wd-action-icon-size: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-action-btn',
	array(
		array(
			'attr_name' => 'iconSizeTablet',
			'template'  => '--wd-action-icon-size: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .wd-action-btn',
	array(
		array(
			'attr_name' => 'iconSizeMobile',
			'template'  => '--wd-action-icon-size: {{value}}px;',
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
