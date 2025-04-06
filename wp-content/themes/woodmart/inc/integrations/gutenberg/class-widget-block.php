<?php
/**
 * Gutenberg post CSS class.
 *
 * @package Woodmart
 */

namespace XTS\Gutenberg;

use XTS\Singleton;

/**
 * Post CSS module.
 *
 * @package Woodmart
 */
class Widget_Block extends Singleton {
	/**
	 * Init.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'dynamic_sidebar_before', array( $this, 'init_hooks' ), 10, 3 );
		add_action( 'dynamic_sidebar_after', array( $this, 'remove_hooks' ), 10, 3 );
	}

	public function init_hooks( $index, $has_widgets ) {
		if ( ! $has_widgets ) {
			return;
		}

		add_filter( 'render_block', array( $this, 'render_block' ), 10, 2 );
	}

	public function remove_hooks( $index, $has_widgets ) {
		if ( ! $has_widgets ) {
			return;
		}

		remove_filter( 'render_block', array( $this, 'render_block' ), 10 );
	}

	/**
	 * Strip optimized block styles.
	 *
	 * @param string $block_content Block content.
	 * @param array  $block Block data.
	 * @return string
	 */
	public function render_block( $block_content, $block ) {
		if ( ! isset( $block['blockName'] ) || strpos( $block['blockName'], 'wd/' ) === false ) {
			return $block_content;
		}

		$data = $this->get_block_css( $block );

		if ( $data['css'] && is_array( $data['css'] ) ) {
			$css = $this->generate_css_string( $data['css'] );

			if ( $css ) {
				$block_content = '<style>' . $css . '</style>' . $block_content;
			}
		}

		if ( $data['assets'] && is_array( $data['assets'] ) ) {
			ob_start();
			$assets = $data['assets'];

			if ( ! empty( $assets['styles'] ) ) {
				foreach ( $assets['styles'] as $style ) {
					woodmart_force_enqueue_style( $style );
				}
			}
			if ( ! empty( $assets['libraries'] ) ) {
				foreach ( $assets['libraries'] as $library ) {
					woodmart_enqueue_js_library( $library );
				}
			}
			if ( ! empty( $assets['scripts'] ) ) {
				foreach ( $assets['scripts'] as $script ) {
					if ( 'google-map-element' === $script ) {
						Blocks_Assets::get_instance()->enqueue_google_map_scripts();
					} elseif ( 'imagesloaded' === $script ) {
						wp_enqueue_script( 'imagesloaded' );

						continue;
					}

					woodmart_enqueue_js_script( $script );
				}
			}

			$block_content = ob_get_clean() . $block_content;
		}

		return $block_content;
	}

	/**
	 * Get blocks CSS.
	 *
	 * @param array $block Block config.
	 * @return string[]
	 */
	public function get_block_css( $block ) {
		$config    = Blocks::get_instance()->get_block_config( $block['blockName'] );
		$block_obj = new Block( $block['blockName'], $config, $block['attrs'] );

		return array(
			'assets' => Blocks_Assets::get_instance()->get_block_advanced_assets( $block_obj->get_assets(), $block['attrs'] ),
			'css'    => $block_obj->generate_frontend_css(),
		);
	}

	/**
	 * Generate CSS string for device.
	 *
	 * @param array $css CSS data.
	 * @return string
	 */
	private function generate_css_string( $css ) {
		$css_string = ! empty( $css['desktop'] ) ? $css['desktop'] : '';

		if ( ! empty( $css['only_desktop'] ) ) {
			$css_string .= '@media (min-width: 769px) {';
			$css_string .= $css['only_desktop'];
			$css_string .= '}';
		}

		if ( ! empty( $css['tablet'] ) ) {
			$css_string .= '@media (max-width: 1024px) {';
			$css_string .= $css['tablet'];
			$css_string .= '}';
		}

		if ( ! empty( $css['only_tablet'] ) ) {
			$css_string .= '@media (min-width: 769px) and (max-width: 1024px) {';
			$css_string .= $css['only_tablet'];
			$css_string .= '}';
		}

		if ( ! empty( $css['mobile'] ) ) {
			$css_string .= '@media (max-width: 768.98px) {';
			$css_string .= $css['mobile'];
			$css_string .= '}';
		}

		return $css_string;
	}
}

Widget_Block::get_instance();
