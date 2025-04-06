<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .shop_attributes',
	array(
		array(
			'attr_name' => 'columns',
			'template'  => '--wd-attr-col: {{value}};',
		),
		array(
			'attr_name' => 'columnGap',
			'template'  => '--wd-attr-h-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'rowGap',
			'template'  => '--wd-attr-v-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'imageWidth',
			'template'  => '--wd-attr-img-width: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-product-attributes-item__label',
	array(
		array(
			'attr_name' => 'attrNameColumnWidth',
			'template'  => 'width: {{value}}' . $block_css->get_units_for_attribute( 'attrNameColumnWidth' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .shop_attributes',
	array(
		array(
			'attr_name' => 'columnsTablet',
			'template'  => '--wd-attr-col: {{value}};',
		),
		array(
			'attr_name' => 'columnGapTablet',
			'template'  => '--wd-attr-h-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'rowGapTablet',
			'template'  => '--wd-attr-v-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'imageWidthTablet',
			'template'  => '--wd-attr-img-width: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-product-attributes-item__label',
	array(
		array(
			'attr_name' => 'attrNameColumnWidthTablet',
			'template'  => 'width: {{value}}' . $block_css->get_units_for_attribute( 'attrNameColumnWidth', 'tablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .shop_attributes',
	array(
		array(
			'attr_name' => 'columnsMobile',
			'template'  => '--wd-attr-col: {{value}};',
		),
		array(
			'attr_name' => 'columnGapMobile',
			'template'  => '--wd-attr-h-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'rowGapMobile',
			'template'  => '--wd-attr-v-gap: {{value}}px;',
		),
		array(
			'attr_name' => 'imageWidthMobile',
			'template'  => '--wd-attr-img-width: {{value}}px;',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-product-attributes-item__label',
	array(
		array(
			'attr_name' => 'attrNameColumnWidthMobile',
			'template'  => 'width: {{value}}' . $block_css->get_units_for_attribute( 'attrNameColumnWidth', 'mobile' ) . ';',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-product-attributes-item__label',
	array(
		array(
			'attr_name' => 'attrNameColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'attrNameColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .woocommerce-product-attributes-item__label', $attrs, 'attrNameTp' ) );

$block_css->add_css_rules(
	$block_selector . ' .woocommerce-product-attributes-item__value',
	array(
		array(
			'attr_name' => 'attrTermColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'attrTermColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .woocommerce-product-attributes-item__value', $attrs, 'attrTermTp' ) );

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
