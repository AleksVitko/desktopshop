<?php
/**
 * Gutenberg post CSS class.
 *
 * @package Woodmart
 */

namespace XTS\Gutenberg;

use XTS\Singleton;
use XTS\Modules\Styles_Storage;

/**
 * Post CSS module.
 *
 * @package Woodmart
 */
class Post_CSS extends Singleton {

	/**
	 * Init.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'wp', array( $this, 'print_blocks_css' ), 130 );
		add_action( 'render_block_core/block', array( $this, 'print_pattern_css' ), 10, 2 );

		add_filter( 'woocommerce_format_content', array( $this, 'add_inline_css_for_wc_page' ) );

		add_action( 'save_post', array( $this, 'prepare_assets' ), 30, 3 );
	}

	/**
	 * Generate CSS for blocks.
	 *
	 * @param int $post_id Post ID.
	 * @return void
	 */
	public function prepare_assets( $post_id, $post ) {
		if ( empty( $post ) || empty( $post->ID ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_autosave( $post ) || wp_is_post_revision( $post ) ) {
			return;
		}

		if ( has_blocks( $post->post_content ) && ! empty( $post->post_content ) ) {
			$blocks = xts_parse_blocks_from_content( $post->post_content );

			if ( ! is_array( $blocks ) || empty( $blocks ) ) {
				return;
			}

			$css = $this->get_blocks_css( $blocks );
		}

		$storage = new Styles_Storage( $this->get_storage_key( $post_id ), 'post_meta', $post_id );

		if ( empty( $css ) || ( empty( $css['desktop'] ) && empty( $css['only_desktop'] ) && empty( $css['tablet'] ) && empty( $css['only_tablet'] ) && empty( $css['mobile'] ) ) ) {
			$storage->delete_css();
			$storage->reset_data();

			return;
		}

		$storage->reset_data();

		$storage->write( $this->generate_css_string( $css ) );
	}

	/**
	 * Print blocks CSS.
	 *
	 * @return void
	 */
	public function print_blocks_css() {
		global $post;

		if ( empty( $post ) || empty( $post->ID ) || is_admin() ) {
			return;
		}

		$storage = new Styles_Storage( $this->get_storage_key( $post->ID ), 'post_meta', $post->ID );

		if ( apply_filters( 'woodmart_rerender_block_css', false ) && ! $storage->is_css_exists() && $post->post_content && str_contains( $post->post_content, '<!-- wp:wd/' ) ) {
			$this->prepare_assets( $post->ID, $post );

			$storage = new Styles_Storage( $this->get_storage_key( $post->ID ), 'post_meta', $post->ID );
		}

		$storage->print_styles();
	}

	/**
	 * Print blocks CSS.
	 *
	 * @return string
	 */
	public function get_inline_blocks_css( $post_id, $inline_css = false ) {
		$storage = new Styles_Storage( $this->get_storage_key( $post_id ), 'post_meta', $post_id );

		if ( apply_filters( 'woodmart_rerender_block_css', false ) && ! $storage->is_css_exists() ) {
			$post = get_post( $post_id );

			if ( ! $post->post_content || ! str_contains( $post->post_content, '<!-- wp:wd/' ) ) {
				return '';
			}

			$this->prepare_assets( $post->ID, $post );

			$storage = new Styles_Storage( $this->get_storage_key( $post->ID ), 'post_meta', $post->ID );
		}

		ob_start();

		if ( $inline_css ) {
			$storage->inline_css();
		} else {
			$storage->print_styles_inline();
		}

		return ob_get_clean();
	}

	/**
	 * Prints CSS for the block pattern.
	 *
	 * @param string $content The pattern block content.
	 * @param array  $block The pattern block attributes.
	 * @return string
	 */
	public function print_pattern_css( $content, $block ) {
		if ( ! empty( $block['attrs']['ref'] ) ) {
			$content = $this->get_inline_blocks_css( $block['attrs']['ref'] ) . $content;
		}

		return $content;
	}

	/**
	 * Enqueue inline CSS for WooCommerce pages.
	 *
	 * @param string $content Content.
	 * @return string
	 */
	public function add_inline_css_for_wc_page( $content ) {
		$post_id = '';

		if ( is_shop() ) {
			$post_id = wc_get_page_id( 'shop' );
		} elseif ( is_checkout() ) {
			$post_id = wc_terms_and_conditions_page_id();
		}

		if ( $post_id ) {
			$css = $this->get_inline_blocks_css( $post_id );

			if ( $css ) {
				$content = $css . $content;
			}
		}

		return $content;
	}

	/**
	 * Get blocks CSS.
	 *
	 * @param array $blocks Blocks config.
	 * @return string[]
	 */
	public function get_blocks_css( $blocks ) {
		$blocks_css = array(
			'only_desktop' => '',
			'desktop'      => '',
			'tablet'       => '',
			'only_tablet'  => '',
			'mobile'       => '',
		);

		foreach ( $blocks as $i => $block ) {
			if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
				$inner_blocks_css = $this->get_blocks_css( $block['innerBlocks'] );
				$blocks_css       = $this->concat_css( $blocks_css, $inner_blocks_css );
			}

			if ( ! is_array( $block ) || empty( $block['blockName'] ) || ! isset( $block['attrs']['blockId'] ) ) {
				continue;
			}

			$config    = Blocks::get_instance()->get_block_config( $block['blockName'] );
			$block_obj = new Block( $block['blockName'], $config, $block['attrs'] );

			$block_css = $block_obj->generate_frontend_css();

			if ( ! is_array( $block_css ) ) {
				continue;
			}

			$blocks_css = $this->concat_css( $blocks_css, $block_css );
		}

		return $blocks_css;
	}

	/**
	 * Concat block CSS.
	 *
	 * @param array $base Base CSS.
	 * @param array $addition Additional CSS.
	 * @return array
	 */
	private function concat_css( $base, $addition ) {
		if ( isset( $addition['only_desktop'] ) ) {
			$base['only_desktop'] .= $addition['only_desktop'];
		}
		if ( isset( $addition['desktop'] ) ) {
			$base['desktop'] .= $addition['desktop'];
		}
		if ( isset( $addition['tablet'] ) ) {
			$base['tablet'] .= $addition['tablet'];
		}
		if ( isset( $addition['only_tablet'] ) ) {
			$base['only_tablet'] .= $addition['only_tablet'];
		}
		if ( isset( $addition['mobile'] ) ) {
			$base['mobile'] .= $addition['mobile'];
		}
		return $base;
	}

	/**
	 * Generate CSS string for device.
	 *
	 * @param array $css CSS data.
	 * @return string
	 */
	private function generate_css_string( $css ) {
		$css_string = $css['desktop'];

		if ( $css['only_desktop'] ) {
			$css_string .= '@media (min-width: 769px) {';
			$css_string .= $css['only_desktop'];
			$css_string .= '}';
		}

		if ( $css['tablet'] ) {
			$css_string .= '@media (max-width: 1024px) {';
			$css_string .= $css['tablet'];
			$css_string .= '}';
		}

		if ( $css['only_tablet'] ) {
			$css_string .= '@media (min-width: 769px) and (max-width: 1024px) {';
			$css_string .= $css['only_tablet'];
			$css_string .= '}';
		}

		if ( $css['mobile'] ) {
			$css_string .= '@media (max-width: 768.98px) {';
			$css_string .= $css['mobile'];
			$css_string .= '}';
		}

		return $css_string;
	}

	/**
	 * Get storage key.
	 *
	 * @return string
	 */
	public function get_storage_key( $post_id ) {
		return 'blocks-' . $post_id;
	}

}

Post_CSS::get_instance();
