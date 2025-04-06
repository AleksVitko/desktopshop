<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'custom_rounding_size',
			'template'  => '--wd-cat-brd-radius: {{value}}' . $block_css->get_units_for_attribute( 'custom_rounding_size' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'image_container_width',
			'template'  => '--wd-cat-img-width: {{value}}' . $block_css->get_units_for_attribute( 'image_container_width' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'image_container_widthTablet',
			'template'  => '--wd-cat-img-width: {{value}}' . $block_css->get_units_for_attribute( 'image_container_width', 'tablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'image_container_widthMobile',
			'template'  => '--wd-cat-img-width: {{value}}' . $block_css->get_units_for_attribute( 'image_container_width', 'mobile' ) . ';',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav[class*=wd-style-] > li > a',
	array(
		array(
			'attr_name' => 'titleIdleColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'titleIdleColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav[class*=wd-style-] > li:hover > a',
	array(
		array(
			'attr_name' => 'titleHoverColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'titleHoverColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-products-with-bg, ' . $block_selector . ' .wd-products-with-bg .wd-cat, ' . $block_selector . '.wd-products-with-bg, ' . $block_selector . '.wd-products-with-bg .wd-cat',
	array(
		array(
			'attr_name' => 'categoriesBackgroundCode',
			'template'  => '--wd-prod-bg: {{value}};--wd-bordered-bg: {{value}};',
		),
		array(
			'attr_name' => 'categoriesBackgroundVariable',
			'template'  => '--wd-prod-bg: var({{value}});--wd-bordered-bg: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' [class*="products-bordered-grid"], ' . $block_selector . ' [class*="products-bordered-grid"] .wd-cat,' . $block_selector . '[class*="products-bordered-grid"], ' . $block_selector . '[class*="products-bordered-grid"] .wd-cat',
	array(
		array(
			'attr_name' => 'categoriesBorderColorCode',
			'template'  => '--wd-bordered-brd: {{value}};',
		),
		array(
			'attr_name' => 'categoriesBorderColorVariable',
			'template'  => '--wd-prod-bg: var({{value}});',
		),
	)
);

if ( isset( $attrs['type'] ) && 'navigation' === $attrs['type'] ) {
	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'navAlignment',
				'template'  => '--wd-align: var(--wd-{{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'navAlignmentTablet',
				'template'  => '--wd-align: var(--wd-{{value}});',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'navAlignmentMobile',
				'template'  => '--wd-align: var(--wd-{{value}});',
			),
		),
		'mobile'
	);
}

$block_css->merge_with(
	wd_get_block_carousel_css(
		$block_selector,
		$attrs
	)
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' div.product-category .wd-entities-title, ' . $block_selector . ' .wd-nav-product-cat>li>a', $attrs, 'title' ) );

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
