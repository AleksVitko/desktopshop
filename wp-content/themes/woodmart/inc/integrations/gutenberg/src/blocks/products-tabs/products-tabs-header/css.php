<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .tabs-name',
	array(
		array(
			'attr_name' => 'titleColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'titleColorVariable',
			'template'  => 'color: var({{value}});',
		),
		array(
			'attr_name' => 'activeBorderColorCode',
			'template'  => 'border-color: {{value}};',
		),
		array(
			'attr_name' => 'activeBorderColorVariable',
			'template'  => 'border-color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav.wd-nav-tabs li > a',
	array(
		array(
			'attr_name' => 'titlesColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'titlesColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav.wd-nav-tabs li:hover > a',
	array(
		array(
			'attr_name' => 'titlesHoverColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'titlesHoverColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav.wd-nav-tabs li.wd-active > a, .wd-tabs:not(.wd-inited) ' . $block_selector . ' .wd-nav-tabs > li:first-child > a',
	array(
		array(
			'attr_name' => 'titlesActiveColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'titlesActiveColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-tabs-desc',
	array(
		array(
			'attr_name' => 'descrColorCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'descrColorVariable',
			'template'  => 'color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav-tabs',
	array(
		array(
			'attr_name' => 'menuGap',
			'template'  => '--nav-gap: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav-tabs',
	array(
		array(
			'attr_name' => 'menuGapTablet',
			'template'  => '--nav-gap: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav-tabs',
	array(
		array(
			'attr_name' => 'menuGapMobile',
			'template'  => '--nav-gap: {{value}}px;',
		),
	),
	'mobile'
);

if ( ! isset( $attrs['design'] ) || 'default' === $attrs['design'] ) {
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
} elseif ( 'aside' === $attrs['design'] ) {
	$block_css->add_css_rules(
		'.wp-block-wd-products-tabs:has(' . $block_selector . ')',
		array(
			array(
				'attr_name' => 'sideHeadingWidth',
				'template'  => '--wd-side-width: {{value}}' . $block_css->get_units_for_attribute( 'sideHeadingWidth' ) . ';',
			),
		)
	);

	$block_css->add_css_rules(
		'.wp-block-wd-products-tabs:has(' . $block_selector . ')',
		array(
			array(
				'attr_name' => 'sideHeadingWidthTablet',
				'template'  => '--wd-side-width: {{value}}' . $block_css->get_units_for_attribute( 'sideHeadingWidth', 'tablet' ) . ';',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		'.wp-block-wd-products-tabs:has(' . $block_selector . ')',
		array(
			array(
				'attr_name' => 'sideHeadingWidthMobile',
				'template'  => '--wd-side-width: {{value}}' . $block_css->get_units_for_attribute( 'sideHeadingWidth', 'mobile' ) . ';',
			),
		),
		'mobile'
	);

}

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .tabs-name', $attrs, 'titleTp' ) );
$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-nav.wd-nav-tabs .wd-nav-link', $attrs, 'titlesTp' ) );

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
