<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_advanced_tab_attrs' ) ) {
	function wd_get_advanced_tab_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr( wd_get_position_control_attrs( 'position' ) );
		$attr->add_attr( wd_get_background_control_attrs( 'bg' ) );
		$attr->add_attr( wd_get_background_control_attrs( 'bgHover' ) );
		$attr->add_attr( wd_get_background_control_attrs( 'bgParentHover' ) );
		$attr->add_attr( wd_get_background_control_attrs( 'overlay' ) );
		$attr->add_attr( wd_get_background_control_attrs( 'overlayHover' ) );
		$attr->add_attr( wd_get_background_control_attrs( 'overlayParentHover' ) );
		$attr->add_attr( wd_get_margin_control_attrs( 'margin' ) );
		$attr->add_attr( wd_get_padding_control_attrs( 'padding' ) );
		$attr->add_attr( wd_get_box_shadow_control_attrs( 'boxShadow' ) );
		$attr->add_attr( wd_get_box_shadow_control_attrs( 'boxShadowHover' ) );
		$attr->add_attr( wd_get_box_shadow_control_attrs( 'boxShadowParentHover' ) );
		$attr->add_attr( wd_get_border_control_attrs( 'border' ) );
		$attr->add_attr( wd_get_border_control_attrs( 'borderHover' ) );
		$attr->add_attr( wd_get_border_control_attrs( 'borderParentHover' ) );
		$attr->add_attr( wd_get_animation_control_attrs() );
		$attr->add_attr( wd_get_paralax_srcroll_control_attrs() );
		$attr->add_attr( wd_get_responsive_visible_control_attrs() );
		$attr->add_attr( wd_get_transform_control_attrs(), 'transform' );
		$attr->add_attr( wd_get_transform_control_attrs(), 'transformHover' );
		$attr->add_attr( wd_get_transform_control_attrs(), 'transformParentHover' );
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

		return $attr->get_attr();
	}
}
