<?php
/**
 * Gutenberg block class.
 *
 * @package Woodmart
 */

namespace XTS\Gutenberg;

/**
 * Block module.
 */
class Block {
	/**
	 * ID for the block.
	 *
	 * @var integer
	 */
	private $id;
	/**
	 * Name for the block.
	 *
	 * @var string
	 */
	private string $name;
	/**
	 * Config map.
	 *
	 * @var array
	 */
	private $config;
	/**
	 * Attributes from the editor.
	 *
	 * @var array
	 */
	private $attrs;
	/**
	 * Parent block name.
	 *
	 * @var string
	 */
	private $parent_block;

	/**
	 * Constructor method.
	 *
	 * @param string $name The name of block.
	 * @param array  $config Config map for this block.
	 * @param array  $attrs Attributes for the block instance.
	 */
	public function __construct( $name, $config, $attrs ) {
		$this->name   = $name;
		$this->config = $config;
		$this->attrs  = $attrs;
		$this->id     = $attrs['blockId'];
	}

	/**
	 * Includes CSS-php file for the block with its CSS code based on attributes.
	 *
	 * @return mixed
	 */
	public function generate_frontend_css() {
		$attrs                = $this->get_attributes();
		$id                   = $this->get_id();
		$selector             = '.wd-block-' . $this->get_id();
		$block_selector       = '#wd-' . $id;
		$block_selector_hover = $block_selector . ':hover';

		return include $this->get_css_file_path();
	}

	/**
	 * Get assets for the block.
	 *
	 * @return array|array[]
	 */
	public function get_assets() {
		$assets_config = require get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/gutenberg/src/' . $this->get_folder_name() . '/assets.php' );

		if ( ! is_array( $assets_config ) ) {
			return array(
				'styles'    => array(),
				'scripts'   => array(),
				'libraries' => array(),
			);
		}

		return $assets_config;
	}

	/**
	 * Get CSS file path based on its name.
	 *
	 * @return string
	 */
	private function get_css_file_path() {
		return get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/gutenberg/src/' . $this->get_folder_name() . '/css.php' );
	}

	/**
	 * Get folder name based on the name of the block wd/section will generate section.
	 *
	 * @return string
	 */
	private function get_folder_name() {
		$name_parts = 'blocks/';

		if ( ! empty( $this->config['type'] ) ) {
			$name_parts = $this->config['type'] . '/';
		}

		if ( ! empty( $this->config['subfolder'] ) ) {
			$name_parts .= $this->config['subfolder'] . '/';
		}

		$name_parts .= explode( '/', $this->name )[1];

		return $name_parts;
	}

	/**
	 * Merge attributes passed from editor with default values.
	 *
	 * @return array
	 */
	private function get_attributes() {
		return array_merge( $this->get_defaults(), (array) $this->attrs );
	}

	/**
	 * Get default values from config.
	 *
	 * @return array
	 */
	public function get_defaults() {
		if ( empty( $this->config['attributes'] ) ) {
			return array();
		}

		$attributes = array();

		foreach ( $this->config['attributes'] as $key => $attribute ) {
			if ( isset( $attribute['default'] ) ) {
				$attributes[ $key ] = $attribute['default'];
			} else {
				$attributes[ $key ] = '';
			}
		}

		return $attributes;
	}

	/**
	 * Get ID from the long blockId attribute.
	 *
	 * @return false|string
	 */
	private function get_id() {
		$attrs = $this->get_attributes();
		return substr( $attrs['blockId'], 0, 8 );
	}
}
