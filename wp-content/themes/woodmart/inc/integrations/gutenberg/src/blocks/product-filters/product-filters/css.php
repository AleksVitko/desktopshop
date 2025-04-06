<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .title-text',
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
	$block_selector . ' .wd-pf-checkboxes:hover .title-text, ' . $block_selector . ' .wd-pf-checkboxes.wd-opened .title-text',
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
	$block_selector . '.wd-product-filters',
	array(
		array(
			'attr_name' => 'formBrdColorCode',
			'template'  => '--wd-form-brd-color: {{value}};',
		),
		array(
			'attr_name' => 'formBrdColorVariable',
			'template'  => '--wd-form-brd-color: var({{value}});',
		),

		array(
			'attr_name' => 'formBrdColorFocusCode',
			'template'  => '--wd-form-brd-color-focus: {{value}};',
		),
		array(
			'attr_name' => 'formBrdColorFocusVariable',
			'template'  => '--wd-form-brd-color-focus: var({{value}});',
		),

		array(
			'attr_name' => 'formBgCode',
			'template'  => '--wd-form-bg: {{value}};',
		),
		array(
			'attr_name' => 'formBgVariable',
			'template'  => '--wd-form-bg: var({{value}});',
		),
	)
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .title-text', $attrs, 'title' ) );
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
