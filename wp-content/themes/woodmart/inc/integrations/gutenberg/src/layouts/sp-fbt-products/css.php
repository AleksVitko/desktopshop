<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector . ' .wd-fbt.wd-design-side',
	array(
		array(
			'attr_name' => 'formWidth',
			'template'  => '--wd-form-width: {{value}}' . $block_css->get_units_for_attribute( 'formWidth' ) . ';',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' .wd-fbt.wd-design-side .wd-fbt-form',
	array(
		array(
			'attr_name' => 'formBgColorCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'formBgColorVariable',
			'template'  => 'background-color: var({{value}});',
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
