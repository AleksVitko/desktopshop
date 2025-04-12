<?php

if ( ! function_exists( 'wd_get_advanced_tab_attrs' ) ) {
	function wd_get_advanced_tab_attrs( $attr ) {
		if ( ! wd_gutenberg_is_rest_api() ) {
			return;
		}

		wd_get_position_control_attrs( $attr, 'position' );

		wd_get_background_control_attrs( $attr, 'bg' );
		wd_get_background_control_attrs( $attr, 'bgHover' );
		wd_get_background_control_attrs( $attr, 'bgParentHover' );
		wd_get_background_control_attrs( $attr, 'overlay' );
		wd_get_background_control_attrs( $attr, 'overlayHover' );
		wd_get_background_control_attrs( $attr, 'overlayParentHover' );

		wd_get_margin_control_attrs( $attr, 'margin' );
		wd_get_padding_control_attrs( $attr, 'padding' );

		wd_get_box_shadow_control_attrs( $attr, 'boxShadow' );
		wd_get_box_shadow_control_attrs( $attr, 'boxShadowHover' );
		wd_get_box_shadow_control_attrs( $attr, 'boxShadowParentHover' );

		wd_get_border_control_attrs( $attr, 'border' );
		wd_get_border_control_attrs( $attr, 'borderHover' );
		wd_get_border_control_attrs( $attr, 'borderParentHover' );

		wd_get_transform_control_attrs( $attr, 'transform' );
		wd_get_transform_control_attrs( $attr, 'transformHover' );
		wd_get_transform_control_attrs( $attr, 'transformParentHover' );

		$attr->add_attr( wd_get_animation_control_attrs() );
		$attr->add_attr( wd_get_paralax_srcroll_control_attrs() );
		$attr->add_attr( wd_get_responsive_visible_control_attrs() );
		$attr->add_attr( wd_get_transition_control_attrs() );

		$attr->add_attr(
			array(
				'overlay'                   => array(
					'type' => 'boolean',
				),
				'overlayOpacity'            => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'overlayHoverOpacity'       => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'overlayParentHoverOpacity' => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'overlayTransition'         => array(
					'type' => 'number',
				),

				'visibility'                => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'visibilityHover'           => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'visibilityParentHover'     => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'opacity'                   => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'opacityHover'              => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'opacityParentHover'        => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'overflowX'                 => array(
					'type' => 'string',
				),
				'overflowY'                 => array(
					'type' => 'string',
				),

				'alignSelf'                 => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'flexGrow'                  => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'flexSize'                  => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'flexShrink'                => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'flexBasis'                 => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'flexOrder'                 => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'displayWidth'              => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'customWidth'               => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'minHeight'                 => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'maxHeight'                 => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
			)
		);
	}
}
