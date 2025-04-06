<?php
use XTS\Gutenberg\Block_CSS;
$heading_selector = $block_selector . ' th';
$body_selector = $block_selector . ' tbody td';
$footer_selector = $block_selector . ' tfoot td';

$block_css = new Block_CSS( $attrs );

$block_css->add_css_rules(
	$heading_selector,
	array(
		array(
			'attr_name' => 'headingCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'headingVariable',
			'template'  => 'color: var({{value}});',
		),
		array(
			'attr_name' => 'headingBgCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'headingBgVariable',
			'template'  => 'background-color: var({{value}});',
		),
	)
);

$block_css->add_css_rules(
	$footer_selector,
	array(
		array(
			'attr_name' => 'footerCode',
			'template'  => 'color: {{value}};',
		),
		array(
			'attr_name' => 'footerVariable',
			'template'  => 'color: var({{value}});',
		),
		array(
			'attr_name' => 'footerBgCode',
			'template'  => 'background-color: {{value}};',
		),
		array(
			'attr_name' => 'footerBgVariable',
			'template'  => 'background-color: var({{value}});',
		),
	)
);

if ( empty( $attrs['bodyBgType'] ) || 'body' === $attrs['bodyBgType'] ) {
	$block_css->add_css_rules(
		$body_selector,
		array(
			array(
				'attr_name' => 'bodyCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'bodyVariable',
				'template'  => 'color: var({{value}});',
			),
			array(
				'attr_name' => 'bodyBgCode',
				'template'  => 'background-color: {{value}};',
			),
			array(
				'attr_name' => 'bodyBgVariable',
				'template'  => 'background-color: var({{value}});',
			),
		)
	);
}

if ( $attrs['bodyBgType'] == 'h-even' ) {
	$block_css->add_css_rules(
		$body_selector . ':nth-child(even)',
		array(
			array(
				'attr_name' => 'bodyHEvenCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'bodyHEvenVariable',
				'template'  => 'color: var({{value}});',
			),
			array(
				'attr_name' => 'bodyHEvenBgCode',
				'template'  => 'background-color: {{value}};',
			),
			array(
				'attr_name' => 'bodyHEvenBgVariable',
				'template'  => 'background-color: var({{value}});',
			),
		)
	);
	$block_css->add_css_rules(
		$body_selector . ':nth-child(odd)',
		array(
			array(
				'attr_name' => 'bodyHOddCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'bodyHOddVariable',
				'template'  => 'color: var({{value}});',
			),
			array(
				'attr_name' => 'bodyHOddBgCode',
				'template'  => 'background-color: {{value}};',
			),
			array(
				'attr_name' => 'bodyHOddBgVariable',
				'template'  => 'background-color: var({{value}});',
			),
		)
	);
}

if ( $attrs['bodyBgType'] == 'v-even' ) {
	$block_css->add_css_rules(
		$block_selector . ' tbody tr:nth-child(even)',
		array(
			array(
				'attr_name' => 'bodyVEvenCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'bodyVEvenVariable',
				'template'  => 'color: var({{value}});',
			),
			array(
				'attr_name' => 'bodyVEvenBgCode',
				'template'  => 'background-color: {{value}};',
			),
			array(
				'attr_name' => 'bodyVEvenBgVariable',
				'template'  => 'background-color: var({{value}});',
			),
		)
	);
	$block_css->add_css_rules(
		$block_selector . ' tbody tr:nth-child(odd)',
		array(
			array(
				'attr_name' => 'bodyVOddCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'bodyVOddVariable',
				'template'  => 'color: var({{value}});',
			),
			array(
				'attr_name' => 'bodyVOddBgCode',
				'template'  => 'background-color: {{value}};',
			),
			array(
				'attr_name' => 'bodyVOddBgVariable',
				'template'  => 'background-color: var({{value}});',
			),
		)
	);
}

$block_css->merge_with( wd_get_block_typography_css( $heading_selector, $attrs, 'heading' ) );
$block_css->merge_with( wd_get_block_typography_css( $body_selector, $attrs, 'body' ) );
$block_css->merge_with( wd_get_block_typography_css( $footer_selector, $attrs, 'footer' ) );

$block_css->merge_with( wd_get_block_padding_css( $heading_selector, $attrs, 'heading' ) );
$block_css->merge_with( wd_get_block_padding_css( $body_selector, $attrs, 'body' ) );
$block_css->merge_with( wd_get_block_padding_css( $footer_selector, $attrs, 'footer' ) );

$block_css->merge_with( wd_get_block_border_css( $heading_selector, $attrs, 'headingBorder' ) );
$block_css->merge_with( wd_get_block_border_css( $body_selector, $attrs, 'bodyBorder' ) );
$block_css->merge_with( wd_get_block_border_css( $footer_selector, $attrs, 'footerBorder' ) );


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
