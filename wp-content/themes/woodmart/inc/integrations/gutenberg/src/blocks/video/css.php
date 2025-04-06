<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

if ( isset( $attrs['videoActionButton'] ) && in_array( $attrs['videoActionButton'], array( 'without', 'overlay' ), true ) ) {
	if ( isset( $attrs['videoSize'] ) && 'aspect_ratio' === $attrs['videoSize'] ) {
		if ( isset( $attrs['videoAspectRatio'] ) && 'custom' === $attrs['videoAspectRatio'] ) {
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
						'attr_name' => 'videoAspectRatio',
						'template'  => '--wd-aspect-ratio: {{value}};',
					),
				)
			);
		}
	} else {
		$block_css->add_css_rules(
			$block_selector,
			array(
				array(
					'attr_name' => 'videoHeight',
					'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'videoHeight' ) . ';',
				),
			)
		);

		$block_css->add_css_rules(
			$block_selector,
			array(
				array(
					'attr_name' => 'videoHeightTablet',
					'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'videoHeight', 'tablet' ) . ';',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$block_selector,
			array(
				array(
					'attr_name' => 'videoHeightMobile',
					'template'  => 'height: {{value}}' . $block_css->get_units_for_attribute( 'videoHeight', 'mobile' ) . ';',
				),
			),
			'mobile'
		);
	}
}

if ( isset( $attrs['videoActionButton'] ) && in_array( $attrs['videoActionButton'], array( 'play', 'overlay' ), true ) ) {
	$block_css->add_css_rules(
		$block_selector . ' .wd-el-video-play-btn',
		array(
			array(
				'attr_name' => 'playBtnIconSize',
				'template'  => 'font-size: {{value}}' . $block_css->get_units_for_attribute( 'playBtnIconSize' ) . ';',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-el-video-play-btn',
		array(
			array(
				'attr_name' => 'playBtnIconSizeTablet',
				'template'  => 'font-size: {{value}}' . $block_css->get_units_for_attribute( 'playBtnIconSize', 'tablet' ) . ';',
			),
		),
		'tablet'
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-el-video-play-btn',
		array(
			array(
				'attr_name' => 'playBtnIconSizeMobile',
				'template'  => 'font-size: {{value}}' . $block_css->get_units_for_attribute( 'playBtnIconSize', 'mobile' ) . ';',
			),
		),
		'mobile'
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-el-video-play-label',
		array(
			array(
				'attr_name' => 'btnLabelColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'btnLabelColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-el-video-play-btn',
		array(
			array(
				'attr_name' => 'playBtnIconColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'playBtnIconColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		$block_selector . ' .wd-el-video-btn:hover .wd-el-video-play-btn, ' . $block_selector . '.wd-action-overlay:hover .wd-el-video-play-btn',
		array(
			array(
				'attr_name' => 'playBtnIconHoverColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'playBtnIconHoverColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->add_css_rules(
		'.wd-hover-parent:hover ' . $block_selector . ' .wd-el-video-play-btn',
		array(
			array(
				'attr_name' => 'playBtnIconParentHoverColorCode',
				'template'  => 'color: {{value}};',
			),
			array(
				'attr_name' => 'playBtnIconParentHoverColorVariable',
				'template'  => 'color: var({{value}});',
			),
		)
	);

	$block_css->merge_with( wd_get_block_typography_css( $block_selector . ' .wd-el-video-play-label', $attrs, 'btnLabelTp' ) );
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
