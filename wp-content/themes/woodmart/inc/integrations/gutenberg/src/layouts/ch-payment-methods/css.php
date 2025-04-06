<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .payment_methods li > label',
	array(
		array(
			'attr_name' => 'titleColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'titleColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .payment_box',
	array(
		array(
			'attr_name' => 'descriptionColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'descriptionColorVariable',
			'template'  => 'color: var({{value}});',
		),
		array(
			'attr_name' => 'descriptionBgColorCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'descriptionBgColorVariable',
			'template'  => 'background-color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .payment_box:before',
	array(
		array(
			'attr_name' => 'descriptionBgColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'descriptionBgColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-terms-and-conditions',
	array(
		array(
			'attr_name' => 'termsConditionsColorCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'termsConditionsColorVariable',
			'template'  => 'background-color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'btnAlign',
			'template'  => '--wd-btn-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'btnAlignTablet',
			'template'  => '--wd-btn-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'btnAlignMobile',
			'template'  => '--wd-btn-align: var(--wd-{{value}});',
		),
	),
	'mobile'
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .payment_methods li > label', $attrs, 'titleTp' ) );

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .payment_box', $attrs, 'descriptionTp' ) );
$block_css->merge_with( wd_get_block_box_shadow_css( $block_selector . ' .payment_box', $attrs, 'descriptionBoxShadow' ) );
$block_css->merge_with( wd_get_block_padding_css( $block_selector . ' .payment_box', $attrs, 'descriptionPadding' ) );

$block_css->merge_with( wd_get_block_box_shadow_css( $block_selector . ' .woocommerce-terms-and-conditions', $attrs, 'termsConditionsBoxShadow' ) );
$block_css->merge_with( wd_get_block_padding_css( $block_selector . ' .woocommerce-terms-and-conditions', $attrs, 'termsConditionsPadding' ) );

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
