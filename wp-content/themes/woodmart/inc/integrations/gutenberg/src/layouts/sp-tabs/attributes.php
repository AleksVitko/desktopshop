<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_single_product_block_tabs_attrs' ) ) {
	function wd_get_single_product_block_tabs_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'layout'                         => array(
					'type'    => 'string',
					'default' => 'tabs',
				),
				'accordionOnMobile'              => array(
					'type' => 'boolean',
				),
				'enableDescription'              => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'enableAdditionalInfo'           => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'enableReviews'                  => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'tabsStyle'                      => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'tabsTitleTextColorScheme'       => array(
					'type' => 'string',
				),
				'tabsAlignment'                  => array(
					'type' => 'string',
				),
				'tabsSpaceBetweenTabsTitleH'     => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'tabsSpaceBetweenTabsTitleV'     => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'accordionState'                 => array(
					'type'    => 'string',
					'default' => 'first',
				),
				'accordionStyle'                 => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'accordionHideTopBottomBorder'   => array(
					'type' => 'boolean',
				),
				'accordionAlignment'             => array(
					'type' => 'string',
				),
				'accordionTitleTextColorScheme'  => array(
					'type' => 'string',
				),
				'sideHiddenTitleTextColorScheme' => array(
					'type' => 'string',
				),
				'accordionOpenerStyle'           => array(
					'type'    => 'string',
					'default' => 'arrow',
				),
				'accordionOpenerAlignment'       => array(
					'type'    => 'string',
					'default' => 'start',
				),
				'accordionOpenerSize'            => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'tabsContentTextColorScheme'     => array(
					'type' => 'string',
				),
				'sideHiddenContentPosition'      => array(
					'type'    => 'string',
					'default' => 'right',
				),
				'sideHiddenContentWidth'         => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'allOpenVerticalSpacing'         => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'allOpenStyle'                   => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'additionalInfoLayout'           => array(
					'type'    => 'string',
					'default' => 'list',
				),
				'additionalInfoStyle'            => array(
					'type'    => 'string',
					'default' => 'bordered',
				),
				'additionalInfoColumns'          => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'additionalInfoColumnGap'        => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'additionalInfoRowGap'           => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'additionalInfoMaxWidth'         => array(
					'type'  => 'string',
					'units' => 'px',
				),
				'attrImage'                      => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'additionalInfoImageWidth'       => array(
					'type'       => 'number',
					'responsive' => true,
				),
				'attrName'                       => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'attrNameColumnWidth'            => array(
					'type'       => 'string',
					'responsive' => true,
					'units'      => 'px',
				),
				'reviewsLayout'                  => array(
					'type'    => 'string',
					'default' => 'one-column',
				),
				'reviewsColumns'                 => array(
					'type'    => 'number',
					'default' => 1,
				),
				'reviewsColumnsTablet'           => array(
					'type'    => 'number',
					'default' => 1,
				),
				'reviewsColumnsMobile'           => array(
					'type'    => 'number',
					'default' => 1,
				),
				'reviewsGap'                     => array(
					'type'       => 'number',
					'responsive' => true,
				),
			)
		);

		$attr->add_attr( wd_get_typography_control_attrs(), 'tabsTitleTp' );
		$attr->add_attr( wd_get_color_control_attrs( 'tabsTitleTextColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'tabsTitleTextHoverColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'tabsTitleTextHoverColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'tabsTitleTextActiveColor' ) );

		$attr->add_attr( wd_get_box_shadow_control_attrs( 'accordionBoxShadow' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'accordionShadowBgColor' ) );
		$attr->add_attr( wd_get_typography_control_attrs(), 'accordionTitleTp' );
		$attr->add_attr( wd_get_color_control_attrs( 'accordionTitleTextColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'accordionTitleTextHoverColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'accordionTitleTextActiveColor' ) );

		$attr->add_attr( wd_get_typography_control_attrs(), 'sideHiddenTitleTp' );
		$attr->add_attr( wd_get_color_control_attrs( 'sideHiddenTitleTextColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'sideHiddenTitleTextHoverColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'sideHiddenTitleTextActiveColor' ) );

		$attr->add_attr( wd_get_typography_control_attrs(), 'allOpenTitleTextTp' );
		$attr->add_attr( wd_get_color_control_attrs( 'allOpenTitleTextColor' ) );

		$attr->add_attr( wd_get_typography_control_attrs(), 'additionalInfoNameTp' );
		$attr->add_attr( wd_get_color_control_attrs( 'additionalInfoNameColor' ) );

		$attr->add_attr( wd_get_typography_control_attrs(), 'additionalInfoTermTp' );
		$attr->add_attr( wd_get_color_control_attrs( 'additionalInfoTermColor' ) );

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
