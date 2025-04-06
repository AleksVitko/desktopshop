<?php
use XTS\Gutenberg\Block_CSS;

$slide_selector = $block_selector . ' .wd-slide';
$block_css      = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$slide_selector,
	array(
		array(
			'attr_name' => 'height',
			'template'  => 'min-height: {{value}}' . $block_css->get_units_for_attribute( 'height' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav-pagin-wrap',
	array(
		array(
			'attr_name' => 'paginationAlign',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$slide_selector,
	array(
		array(
			'attr_name' => 'heightTablet',
			'template'  => 'min-height: {{value}}' . $block_css->get_units_for_attribute( 'height', 'tablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav-pagin-wrap',
	array(
		array(
			'attr_name' => 'paginationAlignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$slide_selector,
	array(
		array(
			'attr_name' => 'heightMobile',
			'template'  => 'min-height: {{value}}' . $block_css->get_units_for_attribute( 'height', 'mobile' ) . ';',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector . ' .wd-nav-pagin-wrap',
	array(
		array(
			'attr_name' => 'paginationAlignMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'mobile'
);

if ( ! empty( $attrs['arrowsCustomSettings'] ) ) {
	$block_css->add_css_rules(
		$block_selector . ' .wd-slider-arrows',
		array(
			array(
				'attr_name' => 'arrowsSize',
				'template'  => '--wd-arrow-size: {{value}}' . $block_css->get_units_for_attribute( 'arrowsSize' ) . ';',
			),
			array(
				'attr_name' => 'arrowsIconSize',
				'template'  => '--wd-arrow-icon-size: {{value}}' . $block_css->get_units_for_attribute( 'arrowsIconSize' ) . ';',
			),
			array(
				'attr_name' => 'arrowsOffsetH',
				'template'  => '--wd-arrow-offset-h: {{value}}' . $block_css->get_units_for_attribute( 'arrowsOffsetH' ) . ';',
			),
			array(
				'attr_name' => 'arrowsOffsetV',
				'template'  => '--wd-arrow-offset-v: {{value}}' . $block_css->get_units_for_attribute( 'arrowsOffsetV' ) . ';',
			),
			array(
				'attr_name' => 'arrowsBorderRadius',
				'template'  => '--wd-arrow-radius: {{value}}' . $block_css->get_units_for_attribute( 'arrowsBorderRadius' ) . ';',
			),
			array(
				'attr_name' => 'arrowsBorderWidth',
				'template'  => '--wd-arrow-brd: {{value}}' . $block_css->get_units_for_attribute( 'arrowsBorderWidth' ) . ' ' . $attrs['arrowsBorderType'] . ';',
			),

			array(
				'attr_name' => 'arrowsNormalColorCode',
				'template'  => '--wd-arrow-color: {{value}};',
			),
			array(
				'attr_name' => 'arrowsNormalColorVariable',
				'template'  => '--wd-arrow-color: var({{value}});',
			),
			array(
				'attr_name' => 'arrowsHoverColorCode',
				'template'  => '--wd-arrow-color-hover: {{value}};',
			),
			array(
				'attr_name' => 'arrowsHoverColorVariable',
				'template'  => '--wd-arrow-color-hover: var({{value}});',
			),

			array(
				'attr_name' => 'arrowsNormalBgColorCode',
				'template'  => '--wd-arrow-bg: {{value}};',
			),
			array(
				'attr_name' => 'arrowsNormalBgColorVariable',
				'template'  => '--wd-arrow-bg: var({{value}});',
			),
			array(
				'attr_name' => 'arrowsHoverBgColorCode',
				'template'  => '--wd-arrow-bg-hover: {{value}};',
			),
			array(
				'attr_name' => 'arrowsHoverBgColorVariable',
				'template'  => '--wd-arrow-bg-hover: var({{value}});',
			),
			array(
				'attr_name' => 'arrowsBorderColorCode',
				'template'  => '--wd-arrow-brd-color: {{value}};',
			),
			array(
				'attr_name' => 'arrowsBorderColorVariable',
				'template'  => '--wd-arrow-brd-color: var({{value}});',
			),
			array(
				'attr_name' => 'arrowsBorderHoverColorCode',
				'template'  => '--wd-arrow-brd-color-hover: {{value}};',
			),
			array(
				'attr_name' => 'arrowsBorderHoverColorVariable',
				'template'  => '--wd-arrow-brd-color-hover: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-slider-arrows',
		array(
			array(
				'attr_name' => 'arrowsSizeTablet',
				'template'  => '--wd-arrow-size: {{value}}' . $block_css->get_units_for_attribute( 'arrowsSize', 'tablet' ) . ';',
			),
			array(
				'attr_name' => 'arrowsIconSizeTablet',
				'template'  => '--wd-arrow-icon-size: {{value}}' . $block_css->get_units_for_attribute( 'arrowsIconSize', 'tablet' ) . ';',
			),
			array(
				'attr_name' => 'arrowsOffsetHTablet',
				'template'  => '--wd-arrow-offset-h: {{value}}' . $block_css->get_units_for_attribute( 'arrowsOffsetH', 'tablet' ) . ';',
			),
			array(
				'attr_name' => 'arrowsOffsetVTablet',
				'template'  => '--wd-arrow-offset-v: {{value}}' . $block_css->get_units_for_attribute( 'arrowsOffsetV', 'tablet' ) . ';',
			),
			array(
				'attr_name' => 'arrowsBorderRadiusTablet',
				'template'  => '--wd-arrow-radius: {{value}}' . $block_css->get_units_for_attribute( 'arrowsBorderRadius', 'tablet' ) . ';',
			),
			array(
				'attr_name' => 'arrowsBorderWidthTablet',
				'template'  => '--wd-arrow-brd: {{value}}' . $block_css->get_units_for_attribute( 'arrowsBorderWidth', 'tablet' ) . ' ' . $attrs['arrowsBorderType'] . ';',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-slider-arrows',
		array(
			array(
				'attr_name' => 'arrowsSizeMobile',
				'template'  => '--wd-arrow-size: {{value}}' . $block_css->get_units_for_attribute( 'arrowsSize', 'mobile' ) . ';',
			),
			array(
				'attr_name' => 'arrowsIconSizeMobile',
				'template'  => '--wd-arrow-icon-size: {{value}}' . $block_css->get_units_for_attribute( 'arrowsIconSize', 'mobile' ) . ';',
			),
			array(
				'attr_name' => 'arrowsOffsetHMobile',
				'template'  => '--wd-arrow-offset-h: {{value}}' . $block_css->get_units_for_attribute( 'arrowsOffsetH', 'mobile' ) . ';',
			),
			array(
				'attr_name' => 'arrowsOffsetVMobile',
				'template'  => '--wd-arrow-offset-v: {{value}}' . $block_css->get_units_for_attribute( 'arrowsOffsetV', 'mobile' ) . ';',
			),
			array(
				'attr_name' => 'arrowsBorderRadiusMobile',
				'template'  => '--wd-arrow-radius: {{value}}' . $block_css->get_units_for_attribute( 'arrowsBorderRadius', 'mobile' ) . ';',
			),
			array(
				'attr_name' => 'arrowsBorderWidthMobile',
				'template'  => '--wd-arrow-brd: {{value}}' . $block_css->get_units_for_attribute( 'arrowsBorderWidth', 'mobile' ) . ' ' . $attrs['arrowsBorderType'] . ';',
			),
		),
		'mobile'
	);

	$block_css->merge_with( wd_get_block_box_shadow_css( $block_selector . ' .wd-slider-arrows', $attrs, 'arrowsBoxShadow', '--wd-arrow-shadow' ) );
}

if ( ! empty( $attrs['paginationCustomSettings'] ) ) {
	$block_css->add_css_rules(
		$block_selector . ' .wd-nav-pagin-wrap',
		array(
			array(
				'attr_name' => 'paginationSize',
				'template'  => '--wd-pagin-size: {{value}}' . $block_css->get_units_for_attribute( 'paginationSize' ) . ';',
			),
			array(
				'attr_name' => 'paginationBorderRadius',
				'template'  => '--wd-pagin-radius: {{value}}' . $block_css->get_units_for_attribute( 'paginationBorderRadius' ) . ';',
			),
			array(
				'attr_name' => 'paginationBorderWidth',
				'template'  => '--wd-pagin-brd: {{value}}' . $block_css->get_units_for_attribute( 'paginationBorderWidth' ) . ' ' . $attrs['paginationBorderType'] . ';',
			),

			array(
				'attr_name' => 'paginationNormalBgColorCode',
				'template'  => '--wd-pagin-bg: {{value}};',
			),
			array(
				'attr_name' => 'paginationNormalBgColorVariable',
				'template'  => '--wd-pagin-bg: var({{value}});',
			),
			array(
				'attr_name' => 'paginationHoverBgColorCode',
				'template'  => '--wd-pagin-bg-hover: {{value}};',
			),
			array(
				'attr_name' => 'paginationHoverBgColorVariable',
				'template'  => '--wd-pagin-bg-hover: var({{value}});',
			),
			array(
				'attr_name' => 'paginationActiveBgColorCode',
				'template'  => '--wd-pagin-bg-act: {{value}};',
			),
			array(
				'attr_name' => 'paginationActiveBgColorVariable',
				'template'  => '--wd-pagin-bg-act: var({{value}});',
			),
			array(
				'attr_name' => 'paginationWrapperBgColorCode',
				'template'  => '--wd-pagin-wrap-bg: {{value}};',
			),
			array(
				'attr_name' => 'paginationWrapperBgColorVariable',
				'template'  => '--wd-pagin-wrap-bg: var({{value}});',
			),

			array(
				'attr_name' => 'paginationNormalColorCode',
				'template'  => '--wd-pagin-color: {{value}};',
			),
			array(
				'attr_name' => 'paginationNormalColorVariable',
				'template'  => '--wd-pagin-color: var({{value}});',
			),
			array(
				'attr_name' => 'paginationHoverColorCode',
				'template'  => '--wd-pagin-color-hover: {{value}};',
			),
			array(
				'attr_name' => 'paginationHoverColorVariable',
				'template'  => '--wd-pagin-color-hover: var({{value}});',
			),
			array(
				'attr_name' => 'paginationActiveColorCode',
				'template'  => '--wd-pagin-color-act: {{value}};',
			),
			array(
				'attr_name' => 'paginationActiveColorVariable',
				'template'  => '--wd-pagin-color-act: var({{value}});',
			),

			array(
				'attr_name' => 'paginationBorderColorCode',
				'template'  => '--wd-pagin-brd-color: {{value}};',
			),
			array(
				'attr_name' => 'paginationBorderColorVariable',
				'template'  => '--wd-pagin-brd-color: var({{value}});',
			),
			array(
				'attr_name' => 'paginationBorderHoverColorCode',
				'template'  => '--wd-pagin-brd-color-hover: {{value}};',
			),
			array(
				'attr_name' => 'paginationBorderHoverColorVariable',
				'template'  => '--wd-pagin-brd-color-hover: var({{value}});',
			),
			array(
				'attr_name' => 'paginationBorderActiveColorCode',
				'template'  => '--wd-pagin-brd-color-act: {{value}};',
			),
			array(
				'attr_name' => 'paginationBorderActiveColorVariable',
				'template'  => '--wd-pagin-brd-color-act: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-nav-pagin-wrap',
		array(
			array(
				'attr_name' => 'paginationSizeTablet',
				'template'  => '--wd-pagin-size: {{value}}' . $block_css->get_units_for_attribute( 'paginationSize', 'tablet' ) . ';',
			),
			array(
				'attr_name' => 'paginationBorderRadiusTablet',
				'template'  => '--wd-pagin-radius: {{value}}' . $block_css->get_units_for_attribute( 'paginationBorderRadius', 'tablet' ) . ';',
			),
			array(
				'attr_name' => 'paginationBorderWidthTablet',
				'template'  => '--wd-pagin-brd: {{value}}' . $block_css->get_units_for_attribute( 'paginationBorderWidth', 'tablet' ) . ' ' . $attrs['paginationBorderType'] . ';',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-nav-pagin-wrap',
		array(
			array(
				'attr_name' => 'paginationSizeMobile',
				'template'  => '--wd-pagin-size: {{value}}' . $block_css->get_units_for_attribute( 'paginationSize', 'mobile' ) . ';',
			),
			array(
				'attr_name' => 'paginationBorderRadiusMobile',
				'template'  => '--wd-pagin-radius: {{value}}' . $block_css->get_units_for_attribute( 'paginationBorderRadius', 'mobile' ) . ';',
			),
			array(
				'attr_name' => 'paginationBorderWidthMobile',
				'template'  => '--wd-pagin-brd: {{value}}' . $block_css->get_units_for_attribute( 'paginationBorderWidth', 'mobile' ) . ' ' . $attrs['paginationBorderType'] . ';',
			),
		),
		'mobile'
	);
}

$block_css->merge_with( wd_get_block_shape_divider_css( $block_selector, $attrs, 'shapeDividerTop' ) );
$block_css->merge_with( wd_get_block_shape_divider_css( $block_selector, $attrs, 'shapeDividerBottom', 'bottom' ) );

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
