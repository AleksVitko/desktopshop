<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-form-coupon',
	array(
		array(
			'attr_name' => 'formBgColorCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'formBgColorVariable',
			'template'  => 'background-color: var({{value}});',
		),
		array(
			'attr_name' => 'formWidth',
			'template'  => 'max-width: {{value}}' . $block_css->get_units_for_attribute( 'formWidth' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'align',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-form-coupon',
	array(
		array(
			'attr_name' => 'formWidthTablet',
			'template'  => 'max-width: {{value}}' . $block_css->get_units_for_attribute( 'formWidth', 'tablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-form-coupon',
	array(
		array(
			'attr_name' => 'formWidthMobile',
			'template'  => 'max-width: {{value}}' . $block_css->get_units_for_attribute( 'formWidth', 'mobile' ) . ';',
		),
	),
	'mobile'
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .woocommerce-form-coupon-toggle > div', $attrs, 'toggleTp' ) );

$block_css->merge_with( wd_get_block_border_css( $block_selector . ' .woocommerce-form-coupon', $attrs, 'formBorder' ) );

$block_css->merge_with( wd_get_block_padding_css( $block_selector . ' .woocommerce-form-coupon', $attrs, 'formPadding' ) );

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
