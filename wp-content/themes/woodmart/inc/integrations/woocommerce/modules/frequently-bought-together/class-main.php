<?php
/**
 * Frequently bought together class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Frequently_Bought_Together;

use XTS\Admin\Modules\Options;
use XTS\Singleton;

/**
 * Frequently bought together class.
 */
class Main extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		add_action( 'init', array( $this, 'add_options' ) );
		add_action( 'init', array( $this, 'include_files' ), 8 );
	}

	/**
	 * Include files.
	 *
	 * @return void
	 */
	public function include_files() {
		if ( ! woodmart_get_opt( 'bought_together_enabled', 1 ) ) {
			return;
		}

		$files = array(
			'class-controls',
			'class-frontend',
			'class-render',
		);

		if ( class_exists( 'WP_List_Table' ) ) {
			$files[] = 'class-table';
		}

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/woocommerce/modules/frequently-bought-together/' . $file . '.php' );
		}
	}

	/**
	 * Add options in theme settings.
	 */
	public function add_options() {
		Options::add_field(
			array(
				'id'          => 'bought_together_enabled',
				'name'        => esc_html__( 'Enable "Frequently bought together"', 'woodmart' ),
				'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'enable-frequently-bought-together.jpg" alt="">', true ),
				'description' => wp_kses( __( 'You can configure your bundles in Dashboard -> Products -> Frequently Bought Together. Read more information in our <a href="https://xtemos.com/docs-topic/frequently-bought-together/" target="_blank">documentation</a>.', 'woodmart' ), true ),
				'type'        => 'switcher',
				'section'     => 'bought_together_section',
				'default'     => '1',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 10,
				'class'       => 'xts-preset-field-disabled',
			)
		);

		Options::add_field(
			array(
				'id'       => 'bought_together_column',
				'name'     => esc_html__( 'Products columns on desktop', 'woodmart' ),
				'type'     => 'buttons',
				'section'  => 'bought_together_section',
				'options'  => array(
					1 => array(
						'name'  => '1',
						'value' => 1,
					),
					2 => array(
						'name'  => '2',
						'value' => 2,
					),
					3 => array(
						'name'  => '3',
						'value' => 3,
					),
					4 => array(
						'name'  => '4',
						'value' => 4,
					),
					5 => array(
						'name'  => '5',
						'value' => 5,
					),
					6 => array(
						'name'  => '6',
						'value' => 6,
					),
				),
				'default'  => '3',
				't_tab'    => array(
					'id'    => 'bought_together_column_tabs',
					'tab'   => esc_html__( 'Desktop', 'woodmart' ),
					'icon'  => 'xts-i-desktop',
					'style' => 'devices',
				),
				'priority' => 20,
			)
		);

		Options::add_field(
			array(
				'id'       => 'bought_together_column_tablet',
				'name'     => esc_html__( 'Products columns on tablet', 'woodmart' ),
				'type'     => 'buttons',
				'section'  => 'bought_together_section',
				'options'  => array(
					'auto' => array(
						'name'  => esc_html__( 'Auto', 'woodmart' ),
						'value' => 'auto',
					),
					1      => array(
						'name'  => '1',
						'value' => 1,
					),
					2      => array(
						'name'  => '2',
						'value' => 2,
					),
					3      => array(
						'name'  => '3',
						'value' => 3,
					),
				),
				'default'  => 'auto',
				't_tab'    => array(
					'id'   => 'bought_together_column_tabs',
					'tab'  => esc_html__( 'Tablet', 'woodmart' ),
					'icon' => 'xts-i-tablet',
				),
				'priority' => 30,
			)
		);

		Options::add_field(
			array(
				'id'       => 'bought_together_column_mobile',
				'name'     => esc_html__( 'Products columns on mobile', 'woodmart' ),
				'type'     => 'buttons',
				'section'  => 'bought_together_section',
				'options'  => array(
					'auto' => array(
						'name'  => esc_html__( 'Auto', 'woodmart' ),
						'value' => 'auto',
					),
					1      => array(
						'name'  => '1',
						'value' => 1,
					),
					2      => array(
						'name'  => '2',
						'value' => 2,
					),
				),
				'default'  => 'auto',
				't_tab'    => array(
					'id'   => 'bought_together_column_tabs',
					'tab'  => esc_html__( 'Mobile', 'woodmart' ),
					'icon' => 'xts-i-phone',
				),
				'priority' => 40,
			)
		);

		Options::add_field(
			array(
				'id'        => 'bought_together_form_width',
				'name'      => esc_html__( 'Form width', 'woodmart' ),
				'hint'      => '<video data-src="' . WOODMART_TOOLTIP_URL . 'bought-together-form-width.mp4" autoplay loop muted></video>',
				'type'      => 'responsive_range',
				'section'   => 'bought_together_section',
				'selectors' => array(
					'.wd-builder-off .wd-fbt.wd-design-side' => array(
						'--wd-form-width: {{VALUE}}{{UNIT}};',
					),
				),
				'devices'   => array(
					'desktop' => array(
						'value' => '',
						'unit'  => 'px',
					),
				),
				'range'     => array(
					'px' => array(
						'min'  => 250,
						'max'  => 600,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'priority'  => 50,
			)
		);
	}

}

Main::get_instance();
