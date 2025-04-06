<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .wd-info-number, ' . $block_selector . ' .wd-info-msg',
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

if ( ! isset( $attrs['iconType'] ) || 'icon' !== $attrs['iconType'] ) {
	$block_css->add_css_rules(
		$block_selector . ' .wd-info-icon',
		array(
			array(
				'attr_name' => 'iconColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'iconColorVariable',
				'template'  => 'color: var({{value}});',
			),
			array(
				'attr_name' => 'iconSize',
				'template'  => 'font-size: {{value}}px;',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-info-icon',
		array(
			array(
				'attr_name' => 'iconSizeTablet',
				'template'  => 'font-size: {{value}}px;',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-info-icon',
		array(
			array(
				'attr_name' => 'iconSizeMobile',
				'template'  => 'font-size: {{value}}px;',
			),
		),
		'mobile'
	);
}

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-visits-count', $attrs, 'textTp' ) );

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
