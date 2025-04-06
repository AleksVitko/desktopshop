<?php
/**
 * Compare images Elementor widget.
 *
 * @package WoodMart
 */

namespace XTS\Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Compare_Images extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_compare_img';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Compare images', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-compare-images';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-elements' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'before', 'after', 'compare', 'image' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * Content tab
		 */

		/**
		 * General settings
		 */
		$this->start_controls_section(
			'general_content_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
			)
		);

		$this->add_control(
			'first_image',
			array(
				'label'   => esc_html__( 'Before image', 'woodmart' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'first_image',
				'default'   => 'full',
				'separator' => 'none',
			)
		);

		$this->add_control(
			'second_image',
			array(
				'label'   => esc_html__( 'After image', 'woodmart' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'second_image',
				'default'   => 'full',
				'separator' => 'none',
			)
		);

		$this->add_control(
			'note',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Note: For the best appearance, both images should have identical dimensions and aspect ratios.', 'woodmart' ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
			)
		);

		$this->end_controls_section();

		/**
		 * Style tab.
		 */

		/**
		 * Design settings.
		 */
		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Style', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'alignment',
			array(
				'label'            => esc_html__( 'Alignment', 'woodmart' ),
				'type'             => 'wd_buttons',
				'options'          => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
				),
				'default'          => '',
				'allowed_unselect' => '1',
			)
		);

		$this->add_control(
			'rounding_size',
			array(
				'label'     => esc_html__( 'Rounding', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''       => esc_html__( 'Inherit', 'woodmart' ),
					'0'      => esc_html__( '0', 'woodmart' ),
					'5'      => esc_html__( '5', 'woodmart' ),
					'8'      => esc_html__( '8', 'woodmart' ),
					'12'     => esc_html__( '12', 'woodmart' ),
					'custom' => esc_html__( 'Custom', 'woodmart' ),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}' => '--wd-brd-radius: {{VALUE}}px;',
				),
			)
		);

		$this->add_control(
			'custom_rounding_size',
			array(
				'label'      => esc_html__( 'Custom rounding', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 300,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--wd-brd-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'rounding_size' => array( 'custom' ),
				),
			)
		);

		$this->add_control(
			'handle_color_scheme',
			array(
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
					'custom'  => esc_html__( 'Custom', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->add_control(
			'custom_handle_color',
			array(
				'label'     => esc_html__( 'Custom handle color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-compare-img-handle' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'handle_color_scheme' => 'custom',
				),
			)
		);

		$this->add_control(
			'custom_handle_background',
			array(
				'label'     => esc_html__( 'Custom handle background', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-compare-img-handle' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'handle_color_scheme' => 'custom',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			array(
				'wrapper' => array(
					'class' => array(
						'wd-compare-img-wrapp',
					),
				),
			)
		);

		if ( ! empty( $settings['alignment'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'text-' . $settings['alignment'] );
		}

		if ( 'inherit' !== $settings['handle_color_scheme'] && 'custom' !== $settings['handle_color_scheme'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'color-scheme-' . $settings['handle_color_scheme'] );
		}

		$image_keys = array(
			'after'  => 'second_image',
			'before' => 'first_image',
		);

		$images_output = '';

		foreach ( $image_keys as $key => $image_key ) {
			$image_output = '';

			if ( empty( $settings[ $image_key ] ) ) {
				continue;
			}

			$image_size_key        = $image_key . '_size';
			$image_custom_size_key = $image_key . '_custom_dimension';

			if ( isset( $settings[ $image_key ]['id'] ) && $settings[ $image_key ]['id'] ) {
				$image_output = woodmart_otf_get_image_html(
					$settings[ $image_key ]['id'],
					isset( $settings[ $image_size_key ] ) ? $settings[ $image_size_key ] : 'thumbnail',
					isset( $settings[ $image_custom_size_key ] ) ? $settings[ $image_custom_size_key ] : array()
				);

				if ( woodmart_is_svg( $settings[ $image_key ]['url'] ) ) {
					if ( ! empty( $settings[ $image_size_key ] ) && 'custom' !== $settings[ $image_key . '_size' ] ) {
						$image_size = $settings['first_image_size'];
					} elseif ( ! empty( $settings[ $image_custom_size_key ] ) && ! empty( $settings[ $image_custom_size_key ]['width'] ) ) {
						$image_size = $settings[ $image_custom_size_key ];
					} else {
						$image_size = array(
							'width'  => 128,
							'height' => 128,
						);
					}

					$image_output = woodmart_get_svg_html(
						$settings[ $image_key ]['id'],
						$image_size
					);
				}
			} elseif ( isset( $settings[ $image_key ]['url'] ) && $settings[ $image_key ]['url'] ) {
				ob_start();

				Group_Control_Image_Size::print_attachment_image_html( $settings, $image_key );

				$image_output = ob_get_clean();
			}

			ob_start();
			?>
				<div class="wd-<?php echo esc_attr( $key ); ?>-img">
					<?php echo $image_output; // phpcs:ignore. ?>
				</div>
			<?php
			$images_output .= ob_get_clean();
		}

		if ( empty( $images_output ) ) {
			return;
		}

		woodmart_enqueue_inline_style( 'el-compare-img' );
		woodmart_enqueue_js_script( 'compare-images-element' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore ?>>
			<div class="wd-compare-img">
				<?php echo $images_output; // phpcs:ignore. ?>
				<div class="wd-compare-img-handle">
					<span></span>
				</div>
			</div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Compare_Images() );
