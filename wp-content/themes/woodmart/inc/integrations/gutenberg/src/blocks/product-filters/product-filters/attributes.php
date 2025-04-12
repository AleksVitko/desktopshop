<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_product_filters_attrs' ) ) {
	function wd_get_block_product_filters_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'show_selected_values'   => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'show_dropdown_on'       => array(
					'type'    => 'string',
					'default' => 'click',
				),

				'style'                  => array(
					'type'    => 'string',
					'default' => 'form',
				),
				'display_grid'           => array(
					'type'    => 'string',
					'default' => 'stretch',
				),
				'display_grid_col'       => array(
					'type'    => 'number',
					'default' => 4,
				),
				'display_grid_colTablet' => array(
					'type'    => 'number',
					'default' => 3,
				),
				'display_grid_colMobile' => array(
					'type'    => 'number',
					'default' => 1,
				),
				'space_between'          => array(
					'type'       => 'string',
					'default'    => '10',
					'responsive' => true,
					'units'      => 'px',
				),
				'woodmart_color_scheme'  => array(
					'type' => 'string',
				),
			)
		);

		$attr->add_attr( wd_get_color_control_attrs( 'titleIdleColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'titleHoverColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formBrdColor' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formBrdColorFocus' ) );
		$attr->add_attr( wd_get_color_control_attrs( 'formBg' ) );

		$attr->add_attr( wd_get_typography_control_attrs(), 'title' );
		wd_get_advanced_tab_attrs( $attr );

		return $attr->get_attr();
	}
}
