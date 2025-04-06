<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'formColorCode',
			'template'  => '--wd-form-color: {{value}};',
		),
		array(
			'attr_name' => 'formColorVariable',
			'template'  => '--wd-form-color: var({{value}});',
		),
		array(
			'attr_name' => 'formPlaceholderColorCode',
			'template'  => '--wd-form-placeholder-color: {{value}};',
		),
		array(
			'attr_name' => 'formPlaceholderColorVariable',
			'template'  => '--wd-form-placeholder-color: var({{value}});',
		),
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
		array(
			'attr_name' => 'buttonTextColorCode',
			'template'  => '--btn-accented-color: {{value}};',
		),
		array(
			'attr_name' => 'buttonTextColorVariable',
			'template'  => '--btn-accented-color: var({{value}});',
		),
		array(
			'attr_name' => 'buttonBgColorCode',
			'template'  => '--btn-accented-bgcolor: {{value}};',
		),
		array(
			'attr_name' => 'buttonBgColorVariable',
			'template'  => '--btn-accented-bgcolor: var({{value}});',
		),
		array(
			'attr_name' => 'buttonTextColorHoverCode',
			'template'  => '--btn-accented-color-hover: {{value}};',
		),
		array(
			'attr_name' => 'buttonTextColorHoverVariable',
			'template'  => '--btn-accented-color-hover: var({{value}});',
		),
		array(
			'attr_name' => 'buttonBgColorHoverCode',
			'template'  => '--btn-accented-bgcolor-hover: {{value}};',
		),
		array(
			'attr_name' => 'buttonBgColorHoverVariable',
			'template'  => '--btn-accented-bgcolor-hover: var({{value}});',
		),
		array(
			'attr_name' => 'formShape',
			'template'  => '--wd-form-brd-radius: {{value}}px;',
		),
	)
);

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
