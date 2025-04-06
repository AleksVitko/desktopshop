<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .wd-dd-quantity',
	array(
		array(
			'attr_name' => 'quantityColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'quantityColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-dd-price .amount',
	array(
		array(
			'attr_name' => 'priceColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'priceColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-dd-discount span',
	array(
		array(
			'attr_name' => 'discountColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'discountColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-dd-quantity', $attrs, 'quantityTp' ) );
$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-dd-price .amount', $attrs, 'priceTp' ) );
$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-dd-discount span', $attrs, 'discountTp' ) );

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
