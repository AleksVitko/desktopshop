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
		array(
			'attr_name' => 'contentAlignHorizontal',
			'template'  => '--wd-justify-content: {{value}};',
		),
		array(
			'attr_name' => 'contentAlignVertical',
			'template'  => '--wd-align-items: {{value}};',
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
		array(
			'attr_name' => 'contentAlignHorizontalTablet',
			'template'  => '--wd-justify-content: {{value}};',
		),
		array(
			'attr_name' => 'contentAlignVerticalTablet',
			'template'  => '--wd-align-items: {{value}};',
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
		array(
			'attr_name' => 'contentAlignHorizontalMobile',
			'template'  => '--wd-justify-content: {{value}};',
		),
		array(
			'attr_name' => 'contentAlignVerticalMobile',
			'template'  => '--wd-align-items: {{value}};',
		),
	),
	'mobile'
);

if ( ! isset( $attrs['size'] ) || 'custom' === $attrs['size'] ) {
	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'height',
				'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'height' ) . ';',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'heightTablet',
				'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'height', 'tablet' ) . ';',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector,
		array(
			array(
				'attr_name' => 'heightMobile',
				'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'height', 'mobile' ) . ';',
			),
		),
		'mobile'
	);
} elseif ( 'aspectRatio' === $attrs['size'] ) {
	if ( isset( $attrs['aspectRatio'] ) ) {
		if ( 'asImage' === $attrs['aspectRatio'] ) {
			$block_css->add_css_rules(
				$block_selector,
				array(
					array(
						'attr_name' => 'imageAspectRatio',
						'template'  => '--wd-aspect-ratio: {{value}};',
					),
				)
			);
		} elseif ( 'custom' === $attrs['aspectRatio'] ) {
			$block_css->add_css_rules(
				$block_selector,
				array(
					array(
						'attr_name' => 'customAspectRatio',
						'template'  => '--wd-aspect-ratio: {{value}};',
					),
				)
			);
		} else {
			$block_css->add_css_rules(
				$block_selector,
				array(
					array(
						'attr_name' => 'aspectRatio',
						'template'  => '--wd-aspect-ratio: {{value}};',
					),
				)
			);
		}
	}

	if ( isset( $attrs['aspectRatioTablet'] ) ) {
		if ( 'asImage' === $attrs['aspectRatioTablet'] ) {
			$block_css->add_css_rules(
				$block_selector,
				array(
					array(
						'attr_name' => 'imageAspectRatioTablet',
						'template'  => '--wd-aspect-ratio: {{value}};',
					),
				),
				'tablet'
			);
		} elseif ( 'custom' === $attrs['aspectRatioTablet'] ) {
			$block_css->add_css_rules(
				$block_selector,
				array(
					array(
						'attr_name' => 'customAspectRatioTablet',
						'template'  => '--wd-aspect-ratio: {{value}};',
					),
				),
				'tablet'
			);
		} else {
			$block_css->add_css_rules(
				$block_selector,
				array(
					array(
						'attr_name' => 'aspectRatioTablet',
						'template'  => '--wd-aspect-ratio: {{value}};',
					),
				),
				'tablet'
			);
		}
	}

	if ( isset( $attrs['aspectRatioMobile'] ) ) {
		if ( 'asImage' === $attrs['aspectRatioMobile'] ) {
			$block_css->add_css_rules(
				$block_selector,
				array(
					array(
						'attr_name' => 'imageAspectRatioMobile',
						'template'  => '--wd-aspect-ratio: {{value}};',
					),
				),
				'mobile'
			);
		} elseif ( 'custom' === $attrs['aspectRatioMobile'] ) {
			$block_css->add_css_rules(
				$block_selector,
				array(
					array(
						'attr_name' => 'customAspectRatioMobile',
						'template'  => '--wd-aspect-ratio: {{value}};',
					),
				),
				'mobile'
			);
		} else {
			$block_css->add_css_rules(
				$block_selector,
				array(
					array(
						'attr_name' => 'aspectRatioMobile',
						'template'  => '--wd-aspect-ratio: {{value}};',
					),
				),
				'mobile'
			);
		}
	}
}

$block_css->merge_with(
	wd_get_block_advanced_css(
		array(
			'selector'                 => $block_selector,
			'selector_hover'           => $block_selector_hover,
			'selector_bg'              => $block_selector . ' .wd-block-cover-img',
			'selector_bg_hover'        => $block_selector_hover . ' .wd-block-cover-img',
			'selector_bg_parent_hover' => '.wd-hover-parent:hover ' . $block_selector . ' .wd-block-cover-img',
			'selector_transition'      => $block_selector . ' .wd-block-cover-img, ' . $block_selector,
		),
		$attrs
	)
);

return $block_css->get_css_for_devices();
