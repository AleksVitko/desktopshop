<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'align',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	)
);

$block_css->add_css_rules(
	$block_selector . ' > ul > li > a .wd-nav-img',
	array(
		array(
			'attr_name' => 'iconWidth',
			'template'  => '--nav-img-width: {{value}}px;',
		),
		array(
			'attr_name' => 'iconHeight',
			'template'  => '--nav-img-height: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignTablet',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector . ' > ul > li > a .wd-nav-img',
	array(
		array(
			'attr_name' => 'iconWidthTablet',
			'template'  => '--nav-img-width: {{value}}px;',
		),
		array(
			'attr_name' => 'iconHeightTablet',
			'template'  => '--nav-img-height: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$block_selector,
	array(
		array(
			'attr_name' => 'alignMobile',
			'template'  => '--wd-align: var(--wd-{{value}});',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$block_selector . ' > ul > li > a .wd-nav-img',
	array(
		array(
			'attr_name' => 'iconWidthMobile',
			'template'  => '--nav-img-width: {{value}}px;',
		),
		array(
			'attr_name' => 'iconHeightMobile',
			'template'  => '--nav-img-height: {{value}}px;',
		),
	),
	'mobile'
);

$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-nav > .menu-item > a', $attrs, 'itemTp' ) );

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
