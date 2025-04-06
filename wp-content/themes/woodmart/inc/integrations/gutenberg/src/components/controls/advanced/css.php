<?php
/**
 * Gutenberg block advanced CSS.
 *
 * @package Woodmart
 */

use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_advanced_css' ) ) {
	/**
	 * Get block advanced CSS.
	 *
	 * @param array $selectors Block selectors.
	 * @param array $attributes Block attributes.
	 * @return array
	 */
	function wd_get_block_advanced_css( $selectors, $attributes ) {
		if ( empty( $selectors['selector'] ) ) {
			return array();
		}

		$block_css             = new Block_CSS( $attributes );
		$selector              = $selectors['selector'];
		$selector_hover        = ! empty( $selectors['selector_hover'] ) ? $selectors['selector_hover'] : $selector . ':hover';
		$parent_hover_selector = '.wd-hover-parent:hover ' . $selector;

		$selector_padding = ! empty( $selectors['selector_padding'] ) ? $selectors['selector_padding'] : $selector;
		$selector_margin  = ! empty( $selectors['selector_margin'] ) ? $selectors['selector_margin'] : $selector;

		$selector_border              = ! empty( $selectors['selector_border'] ) ? $selectors['selector_border'] : $selector;
		$selector_border_hover        = ! empty( $selectors['selector_border_hover'] ) ? $selectors['selector_border_hover'] : $selector_hover;
		$selector_border_parent_hover = ! empty( $selectors['selector_border_parent_hover'] ) ? $selectors['selector_border_parent_hover'] : $parent_hover_selector;

		$selector_shadow              = ! empty( $selectors['selector_shadow'] ) ? $selectors['selector_shadow'] : $selector;
		$selector_shadow_hover        = ! empty( $selectors['selector_shadow_hover'] ) ? $selectors['selector_shadow_hover'] : $selector_hover;
		$selector_shadow_parent_hover = ! empty( $selectors['selector_shadow_parent_hover'] ) ? $selectors['selector_shadow_parent_hover'] : $parent_hover_selector;

		$selector_transform              = ! empty( $selectors['selector_transform'] ) ? $selectors['selector_transform'] : $selector;
		$selector_transform_hover        = ! empty( $selectors['selector_transform_hover'] ) ? $selectors['selector_transform_hover'] : $selector_hover;
		$selector_transform_parent_hover = ! empty( $selectors['selector_transform_parent_hover'] ) ? $selectors['selector_transform_parent_hover'] : $parent_hover_selector;

		$selector_bg              = ! empty( $selectors['selector_bg'] ) ? $selectors['selector_bg'] : $selector;
		$selector_bg_hover        = ! empty( $selectors['selector_bg_hover'] ) ? $selectors['selector_bg_hover'] : $selector_hover;
		$selector_bg_parent_hover = ! empty( $selectors['selector_bg_parent_hover'] ) ? $selectors['selector_bg_parent_hover'] : $parent_hover_selector;

		$selector_overlay              = ! empty( $selectors['selector_overlay'] ) ? $selectors['selector_overlay'] : $selector . ' > .wd-bg-overlay';
		$selector_overlay_hover        = ! empty( $selectors['selector_overlay_hover'] ) ? $selectors['selector_overlay_hover'] : $selector_hover . ' > .wd-bg-overlay';
		$selector_overlay_parent_hover = ! empty( $selectors['selector_overlay_parent_hover'] ) ? $selectors['selector_overlay_parent_hover'] : $parent_hover_selector . ' > .wd-bg-overlay';

		$selector_transition = ! empty( $selectors['selector_transition'] ) ? $selectors['selector_transition'] : $selector;

		$selector_animation = ! empty( $selectors['selector_animation'] ) ? $selectors['selector_animation'] : $selector;

		$selector_position = ! empty( $selectors['selector_position'] ) ? $selectors['selector_position'] : $selector;

		$block_css->merge_with( wd_get_block_padding_css( $selector_padding, $attributes, 'padding' ) );
		$block_css->merge_with( wd_get_block_margin_css( $selector_margin, $attributes, 'margin' ) );

		$block_css->merge_with( wd_get_block_bg_css( $selector_bg, $attributes, 'bg' ) );
		$block_css->merge_with( wd_get_block_bg_css( $selector_bg_hover, $attributes, 'bgHover' ) );
		$block_css->merge_with( wd_get_block_bg_css( $selector_bg_parent_hover, $attributes, 'bgParentHover' ) );

		$block_css->merge_with( wd_get_block_bg_css( $selector_overlay, $attributes, 'overlay' ) );
		$block_css->merge_with( wd_get_block_bg_css( $selector_overlay_hover, $attributes, 'overlayHover' ) );
		$block_css->merge_with( wd_get_block_bg_css( $selector_overlay_parent_hover, $attributes, 'overlayParentHover' ) );

		$block_css->add_css_rules(
			$selector_overlay,
			array(
				array(
					'attr_name' => 'overlayOpacity',
					'template'  => 'opacity: {{value}};',
				),
				array(
					'attr_name' => 'overlayTransition',
					'template'  => 'transition: opacity {{value}}s, background {{value}}s;',
				),
			)
		);

		$block_css->add_css_rules(
			$selector_overlay,
			array(
				array(
					'attr_name' => 'overlayOpacityTablet',
					'template'  => 'opacity: {{value}};',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$selector_overlay,
			array(
				array(
					'attr_name' => 'overlayOpacityMobile',
					'template'  => 'opacity: {{value}};',
				),
			),
			'mobile'
		);

		$block_css->add_css_rules(
			$selector_overlay_hover,
			array(
				array(
					'attr_name' => 'overlayHoverOpacity',
					'template'  => 'opacity: {{value}};',
				),
			)
		);

		$block_css->add_css_rules(
			$selector_overlay_hover,
			array(
				array(
					'attr_name' => 'overlayHoverOpacityTablet',
					'template'  => 'opacity: {{value}};',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$selector_overlay_hover,
			array(
				array(
					'attr_name' => 'overlayHoverOpacityMobile',
					'template'  => 'opacity: {{value}};',
				),
			),
			'mobile'
		);

		$block_css->add_css_rules(
			$selector_overlay_parent_hover,
			array(
				array(
					'attr_name' => 'overlayParentHoverOpacity',
					'template'  => 'opacity: {{value}};',
				),
			)
		);

		$block_css->add_css_rules(
			$selector_overlay_parent_hover,
			array(
				array(
					'attr_name' => 'overlayParentHoverOpacityTablet',
					'template'  => 'opacity: {{value}};',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$selector_overlay_parent_hover,
			array(
				array(
					'attr_name' => 'overlayParentHoverOpacityMobile',
					'template'  => 'opacity: {{value}};',
				),
			),
			'mobile'
		);

		$block_css->merge_with( wd_get_block_transition_css( $selector_transition, $attributes ) );

		$block_css->merge_with( wd_get_block_border_css( $selector_border, $attributes, 'border' ) );
		$block_css->merge_with( wd_get_block_border_css( $selector_border_hover, $attributes, 'borderHover' ) );
		$block_css->merge_with( wd_get_block_border_css( $selector_border_parent_hover, $attributes, 'borderParentHover' ) );

		$block_css->merge_with( wd_get_block_box_shadow_css( $selector_shadow, $attributes, 'boxShadow' ) );
		$block_css->merge_with( wd_get_block_box_shadow_css( $selector_shadow_hover, $attributes, 'boxShadowHover' ) );
		$block_css->merge_with( wd_get_block_box_shadow_css( $selector_shadow_parent_hover, $attributes, 'boxShadowParentHover' ) );

		if ( empty( $attributes['animation'] ) ) {
			$block_css->merge_with( wd_get_block_transform_css( $selector_transform, $attributes, 'transform' ) );
			$block_css->merge_with( wd_get_block_transform_css( $selector_transform_hover, $attributes, 'transformHover' ) );
			$block_css->merge_with( wd_get_block_transform_css( $selector_transform_parent_hover, $attributes, 'transformParentHover' ) );
		}

		$block_css->merge_with( wd_get_block_position_css( $selector_position, $attributes, 'position' ) );

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => 'animationDuration',
					'template'  => '--wd-anim-duration: {{value}}ms;',
				),
				array(
					'attr_name' => 'overflowX',
					'template'  => 'overflow-x: {{value}};',
				),
				array(
					'attr_name' => 'overflowY',
					'template'  => 'overflow-y: {{value}};',
				),
				array(
					'attr_name' => 'visibility',
					'template'  => 'visibility: {{value}};',
				),
				array(
					'attr_name' => 'opacity',
					'template'  => 'opacity: {{value}};',
				),
				array(
					'attr_name' => 'alignSelf',
					'template'  => 'align-self: {{value}};',
				),
				array(
					'attr_name' => 'flexOrder',
					'template'  => 'order: {{value}};',
				),
				array(
					'attr_name' => 'minHeight',
					'template'  => 'min-height: {{value}}' . $block_css->get_units_for_attribute( 'minHeight' ) . ';',
				),
				array(
					'attr_name' => 'maxHeight',
					'template'  => 'max-height: {{value}}' . $block_css->get_units_for_attribute( 'maxHeight' ) . ';',
				),
			)
		);

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => 'alignSelfTablet',
					'template'  => 'align-self: {{value}};',
				),
				array(
					'attr_name' => 'flexOrderTablet',
					'template'  => 'order: {{value}};',
				),
				array(
					'attr_name' => 'minHeightTablet',
					'template'  => 'min-height: {{value}}' . $block_css->get_units_for_attribute( 'minHeight', 'tablet' ) . ';',
				),
				array(
					'attr_name' => 'maxHeightTablet',
					'template'  => 'max-height: {{value}}' . $block_css->get_units_for_attribute( 'maxHeight', 'tablet' ) . ';',
				),
				array(
					'attr_name' => 'visibilityTablet',
					'template'  => 'visibility: {{value}};',
				),
				array(
					'attr_name' => 'opacityTablet',
					'template'  => 'opacity: {{value}};',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$selector,
			array(
				array(
					'attr_name' => 'alignSelfMobile',
					'template'  => 'align-self: {{value}};',
				),
				array(
					'attr_name' => 'flexOrderMobile',
					'template'  => 'order: {{value}};',
				),
				array(
					'attr_name' => 'minHeightMobile',
					'template'  => 'min-height: {{value}}' . $block_css->get_units_for_attribute( 'minHeight', 'mobile' ) . ';',
				),
				array(
					'attr_name' => 'maxHeightMobile',
					'template'  => 'max-height: {{value}}' . $block_css->get_units_for_attribute( 'maxHeight', 'mobile' ) . ';',
				),
				array(
					'attr_name' => 'visibilityMobile',
					'template'  => 'visibility: {{value}};',
				),
				array(
					'attr_name' => 'opacityMobile',
					'template'  => 'opacity: {{value}};',
				),
			),
			'mobile'
		);

		$block_css->add_css_rules(
			$selector_hover,
			array(
				array(
					'attr_name' => 'visibilityHover',
					'template'  => 'visibility: {{value}};',
				),
				array(
					'attr_name' => 'opacityHover',
					'template'  => 'opacity: {{value}};',
				),
			)
		);

		$block_css->add_css_rules(
			$selector_hover,
			array(
				array(
					'attr_name' => 'visibilityHoverTablet',
					'template'  => 'visibility: {{value}};',
				),
				array(
					'attr_name' => 'opacityHoverTablet',
					'template'  => 'opacity: {{value}};',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$selector_hover,
			array(
				array(
					'attr_name' => 'visibilityHoverMobile',
					'template'  => 'visibility: {{value}};',
				),
				array(
					'attr_name' => 'opacityHoverMobile',
					'template'  => 'opacity: {{value}};',
				),
			),
			'mobile'
		);

		$block_css->add_css_rules(
			$parent_hover_selector,
			array(
				array(
					'attr_name' => 'visibilityParentHover',
					'template'  => 'visibility: {{value}};',
				),
				array(
					'attr_name' => 'opacityParentHover',
					'template'  => 'opacity: {{value}};',
				),
			)
		);

		$block_css->add_css_rules(
			$parent_hover_selector,
			array(
				array(
					'attr_name' => 'visibilityParentHoverTablet',
					'template'  => 'visibility: {{value}};',
				),
				array(
					'attr_name' => 'opacityParentHoverTablet',
					'template'  => 'opacity: {{value}};',
				),
			),
			'tablet'
		);

		$block_css->add_css_rules(
			$parent_hover_selector,
			array(
				array(
					'attr_name' => 'visibilityParentHoverMobile',
					'template'  => 'visibility: {{value}};',
				),
				array(
					'attr_name' => 'opacityParentHoverMobile',
					'template'  => 'opacity: {{value}};',
				),
			),
			'mobile'
		);

		foreach ( array( '', 'tablet', 'mobile' ) as $device ) {
			if ( isset( $attributes[ 'displayWidth' . ucfirst( $device ) ] ) ) {
				if ( 'fit-content' === $attributes[ 'displayWidth' . ucfirst( $device ) ] ) {
					$block_css->add_to_selector(
						$selector,
						'--wd-width: fit-content;',
						$device ? $device : 'global'
					);
				} elseif ( 'full-width' === $attributes[ 'displayWidth' . ucfirst( $device ) ] ) {
					$block_css->add_to_selector(
						$selector,
						'--wd-width: 100%;',
						$device ? $device : 'global'
					);
				} elseif ( 'custom' === $attributes[ 'displayWidth' . ucfirst( $device ) ] ) {
					$block_css->add_css_rules(
						$selector,
						array(
							array(
								'attr_name' => 'customWidth' . ucfirst( $device ),
								'template'  => '--wd-width: {{value}}' . $block_css->get_units_for_attribute( 'customWidth', $device ) . ';',
							),
						),
						$device ? $device : 'global'
					);
				}
			}

			if ( wd_get_inherit_responsive_value( $attributes, 'flexSize', $device ) ) {
				if ( isset( $attributes[ 'flexSize' . ucfirst( $device ) ] ) && 'none' === $attributes[ 'flexSize' . ucfirst( $device ) ] ) {
					$block_css->add_to_selector(
						$selector,
						'flex: 0 0 auto;',
						$device ? $device : 'global'
					);
				} elseif ( isset( $attributes[ 'flexSize' . ucfirst( $device ) ] ) && 'grow' === $attributes[ 'flexSize' . ucfirst( $device ) ] ) {
					$block_css->add_to_selector(
						$selector,
						'flex: 1 0 auto;',
						$device ? $device : 'global'
					);
				} elseif ( isset( $attributes[ 'flexSize' . ucfirst( $device ) ] ) && 'shrink' === $attributes[ 'flexSize' . ucfirst( $device ) ] ) {
					$block_css->add_to_selector(
						$selector,
						'flex: 0 1 auto;',
						$device ? $device : 'global'
					);
				} elseif ( 'custom' === wd_get_inherit_responsive_value( $attributes, 'flexSize', $device ) ) {
					if ( isset( $attributes[ 'flexGrow' . ucfirst( $device ) ], $attributes[ 'flexShrink' . ucfirst( $device ) ], $attributes[ 'flexBasis' . ucfirst( $device ) ] ) && '' !== $attributes[ 'flexGrow' . ucfirst( $device ) ] && '' !== $attributes[ 'flexShrink' . ucfirst( $device ) ] && '' !== $attributes[ 'flexBasis' . ucfirst( $device ) ] ) {
						$block_css->add_to_selector(
							$selector,
							'flex:' . $attributes[ 'flexGrow' . ucfirst( $device ) ] . ' ' . $attributes[ 'flexShrink' . ucfirst( $device ) ] . ' ' . $attributes[ 'flexBasis' . ucfirst( $device ) ] . $block_css->get_units_for_attribute( 'flexBasis', $device ) . ';',
							$device ? $device : 'global'
						);
					} else {
						$block_css->add_css_rules(
							$selector,
							array(
								array(
									'attr_name' => 'flexGrow' . ucfirst( $device ),
									'template'  => 'flex-grow: {{value}};',
								),
							),
							$device ? $device : 'global'
						);
						$block_css->add_css_rules(
							$selector,
							array(
								array(
									'attr_name' => 'flexShrink' . ucfirst( $device ),
									'template'  => 'flex-shrink: {{value}};',
								),
							),
							$device ? $device : 'global'
						);
						$block_css->add_css_rules(
							$selector,
							array(
								array(
									'attr_name' => 'flexBasis' . ucfirst( $device ),
									'template'  => 'flex-basis: {{value}}' . $block_css->get_units_for_attribute( 'flexBasis', $device ) . ';',
								),
							),
							$device ? $device : 'global'
						);
					}
				}
			}
		}

		return $block_css->get_css();
	}
}
