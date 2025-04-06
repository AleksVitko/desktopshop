<?php
/**
 * Gutenberg google fonts class.
 *
 * @package Woodmart
 */

namespace XTS\Gutenberg;

use XTS\Singleton;
use XTS\Admin\Modules\Options\Google_Fonts as Global_Google_Fonts;

/**
 * Google Fonts module.
 *
 * @package Woodmart
 */
class Google_Fonts extends Singleton {

	/**
	 * Init.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'wp', array( $this, 'enqueue_google_fonts' ), 130 );
		add_action( 'init', array( $this, 'enqueue_google_fonts' ), 130 );
		add_action( 'save_post', array( $this, 'remove_post_meta' ), 5 );

		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_google_fonts_on_editor' ), 10 );
	}

	/**
	 * Enqueue google fonts on editor.
	 *
	 * @return void
	 */
	public function enqueue_google_fonts_on_editor() {
		if ( ! is_admin() ) {
			return;
		}

		$this->enqueue_google_fonts();
	}

	/**
	 * Remove post meta.
	 *
	 * @param int $post_id Post ID.
	 * @return void
	 */
	public function remove_post_meta( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		delete_post_meta( $post_id, 'xts_blocks_google_fonts' );
	}

	/**
	 * Add google font at block.
	 *
	 * @param array $font_data Font data.
	 * @return void
	 */
	public function add_google_font( $font_data ) {
		$font_data = wp_parse_args(
			$font_data,
			array(
				'font-family' => '',
				'font-weight' => '',
				'font-style'  => '',
				'font-subset' => '',
			)
		);

		$post_id = $this->get_post_id();

		if ( ! $post_id ) {
			return;
		}

		$fonts = (array) get_post_meta( $post_id, 'xts_blocks_google_fonts', true );

		$fonts[] = $font_data;

		update_post_meta( $post_id, 'xts_blocks_google_fonts', $fonts );
	}

	/**
	 * Enqueue google fonts in frontend.
	 *
	 * @return void
	 */
	public function enqueue_google_fonts() {
		$post_id = $this->get_post_id();

		if ( ! $post_id ) {
			return;
		}
		$fonts = get_post_meta( $post_id, 'xts_blocks_google_fonts', true );

		if ( empty( $fonts ) ) {
			return;
		}

		foreach ( $fonts as $font ) {
			Global_Google_Fonts::add_google_font( $font );
		}
	}

	/**
	 * Get post ID.
	 *
	 * @return int
	 */
	protected function get_post_id() {
		global $post;

		$post_id = '';

		if ( is_admin() && isset( $_GET['post'] ) ) { // phpcs:ignore
			$post_id = $_GET['post']; // phpcs:ignore
		} elseif ( ! empty( $post ) && ! empty( $post->ID ) ) {
			$post_id = $post->ID;
		}

		return $post_id;
	}
}

Google_Fonts::get_instance();
