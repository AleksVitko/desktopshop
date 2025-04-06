<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

if ( ! isset( $attrs['layout'] ) || 'tabs' === $attrs['layout'] ) {
	$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .woocommerce-tabs > .wd-nav-wrapper li > a', $attrs, 'tabsTitleTp' ) );

	$block_css->add_css_rules(
		$block_selector . ' .wd-nav-tabs-wrapper',
		array(
			array(
				'attr_name' => 'tabsAlignment',
				'template'  => '--wd-align: var(--wd-{{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .woocommerce-tabs > .wd-nav-wrapper li > a',
		array(
			array(
				'attr_name' => 'tabsTitleTextColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'tabsTitleTextColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .woocommerce-tabs > .wd-nav-wrapper li:hover > a',
		array(
			array(
				'attr_name' => 'tabsTitleTextHoverColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'tabsTitleTextHoverColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .woocommerce-tabs > .wd-nav-wrapper li.active > a',
		array(
			array(
				'attr_name' => 'tabsTitleTextActiveColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'tabsTitleTextActiveColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-nav-tabs',
		array(
			array(
				'attr_name' => 'tabsSpaceBetweenTabsTitleH',
				'template'  => '--nav-gap: {{value}}px;',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-nav-tabs-wrapper',
		array(
			array(
				'attr_name' => 'tabsSpaceBetweenTabsTitleV',
				'template'  => 'margin-bottom: {{value}}px;',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-nav-tabs',
		array(
			array(
				'attr_name' => 'tabsSpaceBetweenTabsTitleHTablet',
				'template'  => '--nav-gap: {{value}}px;',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-nav-tabs-wrapper',
		array(
			array(
				'attr_name' => 'tabsSpaceBetweenTabsTitleVTablet',
				'template'  => 'margin-bottom: {{value}}px;',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'tabsAlignmentTablet',
				'template'  => '--wd-align: var(--wd-{{value}});',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-nav-tabs',
		array(
			array(
				'attr_name' => 'tabsSpaceBetweenTabsTitleHMobile',
				'template'  => '--nav-gap: {{value}}px;',
			),
		),
		'mobile'
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-nav-tabs-wrapper',
		array(
			array(
				'attr_name' => 'tabsSpaceBetweenTabsTitleVMobile',
				'template'  => 'margin-bottom: {{value}}px;',
			),
		),
		'mobile'
	);

	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'tabsAlignmentMobile',
				'template'  => '--wd-align: var(--wd-{{value}});',
			),
		),
		'mobile'
	);
}

if ( 'accordion' === $attrs['layout'] ) {
	$block_css->merge_with( wd_get_block_box_shadow_css( $block_selector . ' > .wd-accordion.wd-style-shadow > .wd-accordion-item', $attrs, 'accordionBoxShadow' ) );

	$block_css->add_css_rules(
		$block_selector . ' > .wd-accordion.wd-style-shadow > .wd-accordion-item',
		array(
			array(
				'attr_name' => 'accordionShadowBgColorCode',
				'template'  => 'background-color: {{value}};',
			),
			array(
				'attr_name' => 'accordionShadowBgColorVariable',
				'template'  => 'background-color: var({{value}});',
			),
		)
	);

	$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' [class*="tab-title-"] .wd-accordion-title-text', $attrs, 'accordionTitleTp' ) );

	$block_css->add_css_rules(
		$block_selector . ' [class*="tab-title-"] .wd-accordion-title-text',
		array(
			array(
				'attr_name' => 'accordionTitleTextColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'accordionTitleTextColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-accordion-title[class*="tab-title-"]:hover .wd-accordion-title-text',
		array(
			array(
				'attr_name' => 'accordionTitleTextHoverColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'accordionTitleTextHoverColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-accordion-title[class*="tab-title-"].wd-active .wd-accordion-title-text',
		array(
			array(
				'attr_name' => 'accordionTitleTextActiveColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'accordionTitleTextActiveColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . '.wd-single-tabs > .wd-accordion > .wd-accordion-item .wd-accordion-opener',
		array(
			array(
				'attr_name' => 'accordionOpenerSize',
				'template'  => 'font-size: {{value}}px;',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . '.wd-single-tabs > .wd-accordion > .wd-accordion-item .wd-accordion-opener',
		array(
			array(
				'attr_name' => 'accordionOpenerSizeTablet',
				'template'  => 'font-size: {{value}}px;',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector . '.wd-single-tabs > .wd-accordion > .wd-accordion-item .wd-accordion-opener',
		array(
			array(
				'attr_name' => 'accordionOpenerSizeMobile',
				'template'  => 'font-size: {{value}}px;',
			),
		),
		'mobile'
	);
}

if ( 'side-hidden' === $attrs['layout'] ) {
	$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-hidden-tab-title', $attrs, 'sideHiddenTitleTp' ) );

	$block_css->add_css_rules(
		$block_selector . ' .wd-hidden-tab-title',
		array(
			array(
				'attr_name' => 'sideHiddenTitleTextColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'sideHiddenTitleTextColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-hidden-tab-title:hover',
		array(
			array(
				'attr_name' => 'sideHiddenTitleTextHoverColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'sideHiddenTitleTextHoverColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-hidden-tab-title.wd-active',
		array(
			array(
				'attr_name' => 'sideHiddenTitleTextActiveColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'sideHiddenTitleTextActiveColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		'.wd-side-hidden[class*="woocommerce-Tabs-panel--"]',
		array(
			array(
				'attr_name' => 'sideHiddenContentWidth',
				'template'  => '--wd-side-hidden-w: {{value}}' . $block_css->get_units_for_attribute( 'sideHiddenContentWidth' ) . ';',
			),
		)
	);

	$block_css->add_css_rules(
		'.wd-side-hidden[class*="woocommerce-Tabs-panel--"]',
		array(
			array(
				'attr_name' => 'sideHiddenContentWidthTablet',
				'template'  => '--wd-side-hidden-w: {{value}}' . $block_css->get_units_for_attribute( 'sideHiddenContentWidth', 'tablet' ) . ';',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		'.wd-side-hidden[class*="woocommerce-Tabs-panel--"]',
		array(
			array(
				'attr_name' => 'sideHiddenContentWidthMobile',
				'template'  => '--wd-side-hidden-w: {{value}}' . $block_css->get_units_for_attribute( 'sideHiddenContentWidth', 'mobile' ) . ';',
			),
		),
		'mobile'
	);
}

if ( 'all-open' === $attrs['layout'] ) {
	$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-all-open-title', $attrs, 'allOpenTitleTextTp' ) );

	$block_css->add_css_rules(
		$block_selector . ' .wd-all-open-title',
		array(
			array(
				'attr_name' => 'allOpenTitleTextColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'allOpenTitleTextColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-tab-wrapper:not(:last-child)',
		array(
			array(
				'attr_name' => 'allOpenVerticalSpacing',
				'template'  => 'margin-bottom: {{value}}' . $block_css->get_units_for_attribute( 'allOpenVerticalSpacing' ) . ';',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-tab-wrapper:not(:last-child)',
		array(
			array(
				'attr_name' => 'allOpenVerticalSpacingTablet',
				'template'  => 'margin-bottom: {{value}}' . $block_css->get_units_for_attribute( 'allOpenVerticalSpacing', 'tablet' ) . ';',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-tab-wrapper:not(:last-child)',
		array(
			array(
				'attr_name' => 'allOpenVerticalSpacingMobile',
				'template'  => 'margin-bottom: {{value}}' . $block_css->get_units_for_attribute( 'allOpenVerticalSpacing', 'mobile' ) . ';',
			),
		),
		'mobile'
	);

}

if ( ! isset( $attrs['enableAdditionalInfo'] ) || $attrs['enableAdditionalInfo'] ) {
	$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .woocommerce-product-attributes-item__label, .wd-single-attrs.wd-side-hidden .woocommerce-product-attributes-item__label', $attrs, 'additionalInfoNameTp' ) );

	$block_css->add_css_rules(
		$block_selector . ' .woocommerce-product-attributes-item__label, .wd-single-attrs.wd-side-hidden .woocommerce-product-attributes-item__label',
		array(
			array(
				'attr_name' => 'additionalInfoNameColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'additionalInfoNameColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .woocommerce-product-attributes-item__value, .wd-single-attrs.wd-side-hidden .woocommerce-product-attributes-item__value', $attrs, 'additionalInfoTermTp' ) );

	$block_css->add_css_rules(
		$block_selector . ' .woocommerce-product-attributes-item__value, .wd-single-attrs.wd-side-hidden .woocommerce-product-attributes-item__value',
		array(
			array(
				'attr_name' => 'additionalInfoTermColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'additionalInfoTermColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .shop_attributes, .wd-single-attrs.wd-side-hidden .shop_attributes',
		array(
			array(
				'attr_name' => 'additionalInfoColumns',
				'template'  => '--wd-attr-col: {{value}};',
			),
			array(
				'attr_name' => 'additionalInfoColumnGap',
				'template'  => '--wd-attr-h-gap: {{value}}px;',
			),
			array(
				'attr_name' => 'additionalInfoRowGap',
				'template'  => '--wd-attr-v-gap: {{value}}px;',
			),
			array(
				'attr_name' => 'additionalInfoImageWidth',
				'template'  => '--wd-attr-img-width: {{value}}px;',
			),
		),
	);

	if ( ! isset( $attrs['layout'] ) || 'tabs' === $attrs['layout'] ) {
		$block_css->add_css_rules(
			$block_selector . ' .shop_attributes',
			array(
				array(
					'attr_name' => 'additionalInfoMaxWidth',
					'template'  => 'max-width: {{value}}' . $block_css->get_units_for_attribute( 'additionalInfoMaxWidth' ) . ';',
				),
			),
		);
	}

	if ( isset( $attrs['additionalInfoLayout'] ) && 'inline' === $attrs['additionalInfoLayout'] ) {
		$block_css->add_css_rules(
			$block_selector . ' .woocommerce-product-attributes-item__label, .wd-single-attrs.wd-side-hidden .woocommerce-product-attributes-item__label',
			array(
				array(
					'attr_name' => 'attrNameColumnWidth',
					'template'  => 'width: {{value}}' . $block_css->get_units_for_attribute( 'attrNameColumnWidth' ) . ';',
				),
			),
		);

		$block_css->add_css_rules(
			$block_selector . ' .woocommerce-product-attributes-item__label, .wd-single-attrs.wd-side-hidden .woocommerce-product-attributes-item__label',
			array(
				array(
					'attr_name' => 'attrNameColumnWidthTablet',
					'template'  => 'width: {{value}}' . $block_css->get_units_for_attribute( 'attrNameColumnWidth', 'tablet' ) . ';',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$block_selector . ' .woocommerce-product-attributes-item__label, .wd-single-attrs.wd-side-hidden .woocommerce-product-attributes-item__label',
			array(
				array(
					'attr_name' => 'attrNameColumnWidthMobile',
					'template'  => 'width: {{value}}' . $block_css->get_units_for_attribute( 'attrNameColumnWidth', 'mobile' ) . ';',
				),
			),
			'mobile'
		);
	}

	$block_css->add_css_rules(
		$block_selector . ' .shop_attributes, .wd-single-attrs.wd-side-hidden .shop_attributes',
		array(
			array(
				'attr_name' => 'additionalInfoColumnsTablet',
				'template'  => '--wd-attr-col: {{value}};',
			),
			array(
				'attr_name' => 'additionalInfoColumnGapTablet',
				'template'  => '--wd-attr-h-gap: {{value}}px;',
			),
			array(
				'attr_name' => 'additionalInfoRowGapTablet',
				'template'  => '--wd-attr-v-gap: {{value}}px;',
			),
			array(
				'attr_name' => 'additionalInfoImageWidthTablet',
				'template'  => '--wd-attr-img-width: {{value}}px;',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector . ' .shop_attributes, .wd-single-attrs.wd-side-hidden .shop_attributes',
		array(
			array(
				'attr_name' => 'additionalInfoColumnsMobile',
				'template'  => '--wd-attr-col: {{value}};',
			),
			array(
				'attr_name' => 'additionalInfoColumnGapMobile',
				'template'  => '--wd-attr-h-gap: {{value}}px;',
			),
			array(
				'attr_name' => 'additionalInfoRowGapMobile',
				'template'  => '--wd-attr-v-gap: {{value}}px;',
			),
			array(
				'attr_name' => 'additionalInfoImageWidthMobile',
				'template'  => '--wd-attr-img-width: {{value}}px;',
			),
		),
		'mobile'
	);
}

if ( ! isset( $attrs['enableReviews'] ) || $attrs['enableReviews'] ) {
	$block_css->add_css_rules(
		$block_selector . ' .woocommerce-Reviews, .wd-single-reviews.wd-side-hidden .woocommerce-Reviews',
		array(
			array(
				'attr_name' => 'reviewsGap',
				'template'  => '--wd-col-gap: {{value}}px;',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .woocommerce-Reviews, .wd-single-reviews.wd-side-hidden .woocommerce-Reviews',
		array(
			array(
				'attr_name' => 'reviewsGapTablet',
				'template'  => '--wd-col-gap: {{value}}px;',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector . ' .woocommerce-Reviews, .wd-single-reviews.wd-side-hidden .woocommerce-Reviews',
		array(
			array(
				'attr_name' => 'reviewsGapMobile',
				'template'  => '--wd-col-gap: {{value}}px;',
			),
		),
		'mobile'
	);
}

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
