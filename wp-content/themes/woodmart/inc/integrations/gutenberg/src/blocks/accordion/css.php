<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'paneSize',
			'template'  => '--wd-accordion-spacing: {{value}}px;',
		),
		array(
			'attr_name' => 'blockGap',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'paneSizeTablet',
			'template'  => '--wd-accordion-spacing: {{value}}px;',
		),
		array(
			'attr_name' => 'blockGapTablet',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'paneSizeMobile',
			'template'  => '--wd-accordion-spacing: {{value}}px;',
		),
		array(
			'attr_name' => 'blockGapMobile',
			'template'  => '--wd-row-gap: {{value}}px;',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector . ' > .wd-accordion-item > .wd-accordion-title > .wd-accordion-title-text',
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
	$block_selector . ' > .wd-accordion-item > .wd-accordion-title:hover > .wd-accordion-title-text',
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
	$block_selector . ' > .wd-accordion-item > .wd-accordion-title.wd-active > .wd-accordion-title-text',
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
	$block_selector . ' > .wd-accordion-item > .wd-accordion-title > .wd-accordion-opener',
	array(
		array(
			'attr_name' => 'openerSize',
			'template'  => 'font-size: {{value}}' . $block_css->get_units_for_attribute( 'openerSize' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' > .wd-accordion-item > .wd-accordion-title > .wd-accordion-opener',
	array(
		array(
			'attr_name' => 'openerSizeTablet',
			'template'  => 'font-size: {{value}}' . $block_css->get_units_for_attribute( 'openerSize', 'tablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' > .wd-accordion-item > .wd-accordion-title > .wd-accordion-opener',
	array(
		array(
			'attr_name' => 'openerSizeMobile',
			'template'  => 'font-size: {{value}}' . $block_css->get_units_for_attribute( 'openerSize', 'mobile' ) . ';',
		),
	),
	'mobile'
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' > .wd-accordion-item > .wd-accordion-title > .wd-accordion-title-text', $attrs, 'titleTp' ) );
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
