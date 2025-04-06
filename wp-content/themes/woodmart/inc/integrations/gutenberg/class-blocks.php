<?php
/**
 * Gutenberg blocks class.
 *
 * @package Woodmart
 */

namespace XTS\Gutenberg;

use XTS\Singleton;

/**
 * Blocks modules.
 *
 * @package Woodmart
 */
class Blocks extends Singleton {

	/**
	 * Blocks config.
	 *
	 * @var array
	 */
	public $blocks = array();
	public $layouts = array();

	/**
	 * Register hooks and load base data.
	 */
	public function init() {
		$this->load_blocks_from_config();

		add_action( 'init', array( $this, 'register_block_types' ), 20 );
	}

	/**
	 * Get blocks config.
	 *
	 * @return array|mixed
	 */
	public function get_blocks() {
		return $this->blocks;
	}

	/**
	 * Get block config by slug.
	 *
	 * @param string $slug Block slug.
	 *
	 * @return false|mixed
	 */
	public function get_block_config( $slug ) {
		$config = false;

		if ( isset( $this->blocks[ $slug ] ) ) {
			$config = $this->blocks[ $slug ];

			$config['type'] = 'blocks';
		} elseif ( isset( $this->layouts[ $slug ] ) ) {
			$config = $this->layouts[ $slug ];

			$config['type'] = 'layouts';
		}

		return $config;
	}

	/**
	 * Load blocks from config file.
	 *
	 * @return mixed
	 */
	public function load_blocks_from_config() {
		$this->blocks  = require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/gutenberg/configs/blocks.php' );
		$this->layouts = require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/gutenberg/configs/layouts.php' );
	}

	/**
	 * Register blocks.
	 *
	 * @return void
	 */
	public function register_block_types() {
		$all_blocks = array(
			'blocks'  => $this->blocks,
			'layouts' => $this->layouts,
		);

		foreach ( $all_blocks as $type => $blocks ) {
			foreach ( $blocks as $slug => $block ) {
				$block_name = $this->get_block_name( $slug );

				if ( ! empty( $block['subfolder'] ) ) {
					$block_name = $block['subfolder'] . '/' . $block_name;
				}

				if ( ! empty( $block['render_callback'] ) ) {
					require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/gutenberg/src/' . $type . '/' . $block_name . '/render.php' );
				}

				register_block_type( $this->get_block_folder_path( $block_name, $type ), $block );
			}
		}
	}

	/**
	 * Get folder path for block.
	 *
	 * @param string $name Block name.
	 * @return string
	 */
	private function get_block_folder_path( $name, $type = 'blocks' ) {
		return get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/gutenberg/build/' . $type . '/' . $name );
	}

	/**
	 * Get folder name based on the name of the block wd/section will generate section.
	 *
	 * @param string $slug Block slug.
	 * @return string
	 */
	private function get_block_name( $slug ) {
		$name_parts = explode( '/', $slug );
		return $name_parts[1];
	}
}

Blocks::get_instance();
