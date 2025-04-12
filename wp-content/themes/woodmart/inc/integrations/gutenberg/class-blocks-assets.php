<?php
/**
 * Gutenberg Blocks Assets class.
 *
 * @package Woodmart
 */

namespace XTS\Gutenberg;

use XTS\Singleton;

/**
 * Blocks Assets module.
 *
 * @package Woodmart
 */
class Blocks_Assets extends Singleton {

	/**
	 * Init
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_parts' ), 10050 );
		add_action( 'render_block_core/block', array( $this, 'enqueue_parts_pattern' ), 10, 2 );

		add_filter( 'woocommerce_format_content', array( $this, 'enqueue_parts_for_wc_page' ) );

		add_action( 'save_post', array( $this, 'delete_blocks_assets_meta' ), 20 );
		add_action( 'save_post', array( $this, 'prepare_blocks_assets' ), 30 );
	}

	/**
	 * Generate CSS files for blocks.
	 *
	 * @param int $post_id Post ID.
	 * @return void
	 */
	public function prepare_blocks_assets( $post_id ) {
		$post = get_post( $post_id );

		if ( empty( $post ) || empty( $post->ID ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_autosave( $post ) || wp_is_post_revision( $post ) ) {
			return;
		}

		if ( ! empty( $post->post_content ) && has_blocks( $post->post_content ) ) {
			$blocks = xts_parse_blocks_from_content( $post->post_content );

			if ( ! is_array( $blocks ) || empty( $blocks ) ) {
				return;
			}

			$assets = $this->get_blocks_assets( $blocks );
		}

		if ( ! empty( $assets ) ) {
			foreach ( $assets as $key => $value ) {
				$assets[ $key ] = array_values( array_unique( $value ) );
			}
		}

		if ( empty( $assets ) || ( empty( $assets['styles'] ) && empty( $assets['scripts'] ) && empty( $assets['libraries'] ) ) ) {
			delete_post_meta( $post_id, $this->get_meta_key() );

			return;
		}

		update_post_meta( $post_id, $this->get_meta_key(), $assets );
	}

	/**
	 * Enqueue blocks assets for WooCommerce pages.
	 *
	 * @param string $content Content.
	 * @return string
	 */
	public function enqueue_parts_for_wc_page( $content ) {
		$post_id = '';

		if ( is_shop() ) {
			$post_id = wc_get_page_id( 'shop' );
		} elseif ( is_checkout() ) {
			$post_id = wc_terms_and_conditions_page_id();
		}

		if ( $post_id ) {
			$parts = $this->get_inline_scripts( $post_id );

			if ( $parts ) {
				$content = $parts . $content;
			}
		}

		return $content;
	}

	/**
	 * Enqueue blocks assets.
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	public function get_inline_scripts( $post_id ) {
		ob_start();

		$assets = get_post_meta( $post_id, $this->get_meta_key(), true );

		if ( ! empty( $assets['styles'] ) ) {
			foreach ( $assets['styles'] as $style ) {
				woodmart_enqueue_inline_style( $style );
			}
		}
		if ( ! empty( $assets['libraries'] ) ) {
			foreach ( $assets['libraries'] as $library ) {
				if ( 'imagesloaded' === $library ) {
					wp_enqueue_script( 'imagesloaded' );

					continue;
				}

				woodmart_enqueue_js_library( $library );
			}
		}
		if ( ! empty( $assets['scripts'] ) ) {
			foreach ( $assets['scripts'] as $script ) {
				if ( 'google-map-element' === $script ) {
					$this->enqueue_google_map_scripts();
				}

				woodmart_enqueue_js_script( $script );
			}
		}

		return ob_get_clean();
	}

	/**
	 * Enqueue blocks assets for patterns.
	 *
	 * @param string $content Block content.
	 * @param array  $block Block attributes.
	 * @return string
	 */
	public function enqueue_parts_pattern( $content, $block ) {
		if ( ! empty( $block['attrs']['ref'] ) ) {
			$content = $this->get_inline_scripts( $block['attrs']['ref'] ) . $content;
		}

		return $content;
	}

	/**
	 * Enqueue blocks assets.
	 *
	 * @return void
	 */
	public function enqueue_parts() {
		global $post;

		if ( empty( $post ) || empty( $post->ID ) || is_admin() ) {
			return;
		}
		$assets = get_post_meta( $post->ID, $this->get_meta_key(), true );

		if ( ! empty( $assets['styles'] ) ) {
			foreach ( $assets['styles'] as $style ) {
				woodmart_force_enqueue_style( $style, woodmart_is_combined_needed( 'combined_css' ) );
			}
		}
		if ( ! empty( $assets['libraries'] ) ) {
			foreach ( $assets['libraries'] as $library ) {
				if ( 'imagesloaded' === $library ) {
					wp_enqueue_script( 'imagesloaded' );

					continue;
				}

				woodmart_enqueue_js_library( $library );
			}
		}
		if ( ! empty( $assets['scripts'] ) ) {
			foreach ( $assets['scripts'] as $script ) {
				if ( 'google-map-element' === $script ) {
					$this->enqueue_google_map_scripts();
				}

				woodmart_enqueue_js_script( $script );
			}
		}
	}

	/**
	 * Get blocks assets.
	 *
	 * @param array $blocks Blocks config.
	 * @return array[]
	 */
	public function get_blocks_assets( $blocks ) {
		$all_assets = array(
			'styles'    => array(),
			'scripts'   => array(),
			'libraries' => array(),
		);

		foreach ( $blocks as $i => $block ) {
			if ( ! empty( $block['innerBlocks'] ) && is_array( $block['innerBlocks'] ) ) {
				$inner_blocks_assets = $this->get_blocks_assets( $block['innerBlocks'] );

				if ( ! empty( $inner_blocks_assets['styles'] ) ) {
					$all_assets['styles'] = array_merge( $all_assets['styles'], $inner_blocks_assets['styles'] );
				}
				if ( ! empty( $inner_blocks_assets['scripts'] ) ) {
					$all_assets['scripts'] = array_merge( $all_assets['scripts'], $inner_blocks_assets['scripts'] );
				}
				if ( ! empty( $inner_blocks_assets['libraries'] ) ) {
					$all_assets['libraries'] = array_merge( $all_assets['libraries'], $inner_blocks_assets['libraries'] );
				}
			}

			if ( ! is_array( $block ) || empty( $block['blockName'] ) || ! isset( $block['attrs']['blockId'] ) ) {
				continue;
			}

			$config = Blocks::get_instance()->get_block_config( $block['blockName'] );

			if ( ! $config ) {
				continue;
			}

			$block_obj = new Block( $block['blockName'], $config, $block['attrs'] );

			$block_assets = $this->get_block_advanced_assets( $block_obj->get_assets(), $block['attrs'] );

			if ( ! is_array( $block_assets ) ) {
				continue;
			}

			$all_assets['styles']    = array_merge( $all_assets['styles'], $block_assets['styles'] );
			$all_assets['scripts']   = array_merge( $all_assets['scripts'], $block_assets['scripts'] );
			$all_assets['libraries'] = array_merge( $all_assets['libraries'], $block_assets['libraries'] );
		}

		return $all_assets;
	}

	/**
	 * Added assets scripts in advanced tab.
	 *
	 * @param array $assets Block assets.
	 * @param array $attrs Block attributes.
	 * @return array
	 */
	public function get_block_advanced_assets( $assets, $attrs ) {
		if ( ! empty( $attrs['parallaxScroll'] ) ) {
			$assets['libraries'][] = 'parallax-scroll-bundle';
		}

		if ( ! empty( $attrs['animation'] ) ) {
			$assets['scripts'][] = 'css-animations';

			$assets['styles'][] = 'block-animation';
			$assets['styles'][] = 'block-transform';
		}

		if ( ! empty( $attrs['overlay'] ) || ! empty( $attrs['bgType'] ) && 'video' === $attrs['bgType'] && ( ! empty( $attrs['bgExternalVideo'] ) || ! empty( $attrs['bgVideo'] ) ) ) {
			$assets['styles'][] = 'block-background';
		}

		$transform_attrs_raw = new Block_Attributes();

		$transform_attrs_raw->add_attr( wd_get_transform_control_attrs( $transform_attrs_raw, 'transform' ) );
		$transform_attrs_raw->add_attr( wd_get_transform_control_attrs( $transform_attrs_raw, 'transformHover' ) );
		$transform_attrs_raw->add_attr( wd_get_transform_control_attrs( $transform_attrs_raw, 'transformParentHover' ) );

		$transform_attrs = $transform_attrs_raw->get_attr();

		if ( isset( $transform_attrs['blockId'] ) ) {
			unset( $transform_attrs['blockId'] );
		}

		$transform_attrs_keys = array_keys( $transform_attrs );

		if ( $transform_attrs_keys ) {
			foreach ( $transform_attrs_keys as $key ) {
				if ( ! empty( $attrs[ $key ] ) && ! stripos( $key, 'units' ) && ( is_string( $attrs[ $key ] ) || is_numeric( $attrs[ $key ] ) ) ) {
					$assets['styles'][] = 'block-transform';

					break;
				}
			}
		}

		return $assets;
	}

	/**
	 * Delete blocks assets meta.
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return void
	 */
	public function delete_blocks_assets_meta( $post_id ) {
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
			return;
		}

		delete_post_meta( $post_id, $this->get_meta_key() );
	}

	/**
	 * Get meta key.
	 *
	 * @return string
	 */
	public function get_meta_key() {
		return 'xts_blocks_assets';
	}

	/**
	 * Enqueue Google Map scripts.
	 *
	 * @return void
	 */
	public function enqueue_google_map_scripts() {
		$minified = woodmart_is_minified_needed() ? '.min' : '';
		$version  = woodmart_get_theme_info( 'Version' );

		wp_enqueue_script( 'wd-google-map-api', 'https://maps.google.com/maps/api/js?libraries=geometry&callback=woodmartThemeModule.googleMapsCallback&v=weekly&key=' . woodmart_get_opt( 'google_map_api_key' ), array( 'woodmart-theme' ), $version, true );
		wp_enqueue_script( 'wd-maplace', WOODMART_THEME_DIR . '/js/libs/maplace' . $minified . '.js', array( 'wd-google-map-api' ), $version, true );
	}

}

Blocks_Assets::get_instance();
