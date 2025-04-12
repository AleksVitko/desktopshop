<?php
/**
 * Import helpers.
 *
 * @package Woodmart
 */

namespace XTS\Admin\Modules\Import;

use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import helpers.
 */
class Helpers extends Singleton {
	/**
	 * Links to replace.
	 *
	 * @var array
	 */
	public $links = array(
		'uploads' => array(
			'http://dummy.xtemos.com/woodmart2/megamarket-elementor/wp-content/uploads/sites/4/',
			'https://dummy.xtemos.com/woodmart2/megamarket-elementor/wp-content/uploads/sites/4/',
			'http://dummy.xtemos.com/woodmart2/megamarket/wp-content/uploads/sites/3/',
			'https://dummy.xtemos.com/woodmart2/megamarket/wp-content/uploads/sites/3/',
			'http://dummy.xtemos.com/woodmart2/megamarket-gutenberg/wp-content/uploads/sites/25/',
			'https://dummy.xtemos.com/woodmart2/megamarket-gutenberg/wp-content/uploads/sites/25/',

			'http://dummy.xtemos.com/woodmart2/accessories-elementor/wp-content/uploads/sites/6/',
			'https://dummy.xtemos.com/woodmart2/accessories-elementor/wp-content/uploads/sites/6/',
			'http://dummy.xtemos.com/woodmart2/accessories/wp-content/uploads/sites/5/',
			'https://dummy.xtemos.com/woodmart2/accessories/wp-content/uploads/sites/5/',
			'http://dummy.xtemos.com/woodmart2/accessories-gutenberg/wp-content/uploads/sites/26/',
			'https://dummy.xtemos.com/woodmart2/accessories-gutenberg/wp-content/uploads/sites/26/',

			'http://dummy.xtemos.com/woodmart2/mega-electronics-elementor/wp-content/uploads/sites/8/',
			'https://dummy.xtemos.com/woodmart2/mega-electronics-elementor/wp-content/uploads/sites/8/',
			'http://dummy.xtemos.com/woodmart2/mega-electronics/wp-content/uploads/sites/7/',
			'https://dummy.xtemos.com/woodmart2/mega-electronics/wp-content/uploads/sites/7/',
			'http://dummy.xtemos.com/woodmart2/mega-electronics-gutenberg/wp-content/uploads/sites/27/',
			'https://dummy.xtemos.com/woodmart2/mega-electronics-gutenberg/wp-content/uploads/sites/27/',

			'http://dummy.xtemos.com/woodmart2/furniture2-elementor/wp-content/uploads/sites/10/',
			'https://dummy.xtemos.com/woodmart2/furniture2-elementor/wp-content/uploads/sites/10/',
			'http://dummy.xtemos.com/woodmart2/furniture2/wp-content/uploads/sites/9/',
			'https://dummy.xtemos.com/woodmart2/furniture2/wp-content/uploads/sites/9/',
			'http://dummy.xtemos.com/woodmart2/furniture2-gutenberg/wp-content/uploads/sites/28/',
			'https://dummy.xtemos.com/woodmart2/furniture2-gutenberg/wp-content/uploads/sites/28/',

			'http://dummy.xtemos.com/woodmart2/plants-elementor/wp-content/uploads/sites/12/',
			'https://dummy.xtemos.com/woodmart2/plants-elementor/wp-content/uploads/sites/12/',
			'http://dummy.xtemos.com/woodmart2/plants/wp-content/uploads/sites/11/',
			'https://dummy.xtemos.com/woodmart2/plants/wp-content/uploads/sites/11/',
			'http://dummy.xtemos.com/woodmart2/plants-gutenberg/wp-content/uploads/sites/29/',
			'https://dummy.xtemos.com/woodmart2/plants-gutenberg/wp-content/uploads/sites/29/',

			'http://dummy.xtemos.com/woodmart2/kids-elementor/wp-content/uploads/sites/14/',
			'https://dummy.xtemos.com/woodmart2/kids-elementor/wp-content/uploads/sites/14/',
			'http://dummy.xtemos.com/woodmart2/kids/wp-content/uploads/sites/13/',
			'https://dummy.xtemos.com/woodmart2/kids/wp-content/uploads/sites/13/',
			'http://dummy.xtemos.com/woodmart2/kids-gutenberg/wp-content/uploads/sites/30/',
			'https://dummy.xtemos.com/woodmart2/kids-gutenberg/wp-content/uploads/sites/30/',

			'http://dummy.xtemos.com/woodmart2/games-elementor/wp-content/uploads/sites/16/',
			'https://dummy.xtemos.com/woodmart2/games-elementor/wp-content/uploads/sites/16/',
			'http://dummy.xtemos.com/woodmart2/games/wp-content/uploads/sites/15/',
			'https://dummy.xtemos.com/woodmart2/games/wp-content/uploads/sites/15/',
			'http://dummy.xtemos.com/woodmart2/games-gutenberg/wp-content/uploads/sites/31/',
			'https://dummy.xtemos.com/woodmart2/games-gutenberg/wp-content/uploads/sites/31/',

			'http://dummy.xtemos.com/woodmart2/farm-elementor/wp-content/uploads/sites/22/',
			'https://dummy.xtemos.com/woodmart2/farm-elementor/wp-content/uploads/sites/22/',
			'http://dummy.xtemos.com/woodmart2/farm/wp-content/uploads/sites/20/',
			'https://dummy.xtemos.com/woodmart2/farm/wp-content/uploads/sites/20/',
			'http://dummy.xtemos.com/woodmart2/farm-gutenberg/wp-content/uploads/sites/32/',
			'https://dummy.xtemos.com/woodmart2/farm-gutenberg/wp-content/uploads/sites/32/',

			'http://dummy.xtemos.com/woodmart2/pills-elementor/wp-content/uploads/sites/23/',
			'https://dummy.xtemos.com/woodmart2/pills-elementor/wp-content/uploads/sites/23/',
			'http://dummy.xtemos.com/woodmart2/pills/wp-content/uploads/sites/21/',
			'https://dummy.xtemos.com/woodmart2/pills/wp-content/uploads/sites/21/',
			'http://dummy.xtemos.com/woodmart2/pills-gutenberg/wp-content/uploads/sites/33/',
			'https://dummy.xtemos.com/woodmart2/pills-gutenberg/wp-content/uploads/sites/33/',

			'http://dummy.xtemos.com/woodmart2/pottery-elementor/wp-content/uploads/sites/34/',
			'https://dummy.xtemos.com/woodmart2/pottery-elementor/wp-content/uploads/sites/34/',
			'http://dummy.xtemos.com/woodmart2/pottery/wp-content/uploads/sites/35/',
			'https://dummy.xtemos.com/woodmart2/pottery/wp-content/uploads/sites/35/',
			'http://dummy.xtemos.com/woodmart2/pottery-gutenberg/wp-content/uploads/sites/36/',
			'https://dummy.xtemos.com/woodmart2/pottery-gutenberg/wp-content/uploads/sites/36/',

			'http://dummy.xtemos.com/woodmart2/vegetables-elementor/wp-content/uploads/sites/19/',
			'https://dummy.xtemos.com/woodmart2/vegetables-elementor/wp-content/uploads/sites/19/',
			'http://dummy.xtemos.com/woodmart2/vegetables/wp-content/uploads/sites/18/',
			'https://dummy.xtemos.com/woodmart2/vegetables/wp-content/uploads/sites/18/',
			'http://dummy.xtemos.com/woodmart2/vegetables-gutenberg/wp-content/uploads/sites/37/',
			'https://dummy.xtemos.com/woodmart2/vegetables-gutenberg/wp-content/uploads/sites/37/',

			'http://dummy.xtemos.com/woodmart2/makeup-elementor/wp-content/uploads/sites/39/',
			'https://dummy.xtemos.com/woodmart2/makeup-elementor/wp-content/uploads/sites/39/',
			'http://dummy.xtemos.com/woodmart2/makeup/wp-content/uploads/sites/38/',
			'https://dummy.xtemos.com/woodmart2/makeup/wp-content/uploads/sites/38/',
			'http://dummy.xtemos.com/woodmart2/makeup-gutenberg/wp-content/uploads/sites/40/',
			'https://dummy.xtemos.com/woodmart2/makeup-gutenberg/wp-content/uploads/sites/40/',

			'http://dummy.xtemos.com/woodmart2/marketplace2-elementor/wp-content/uploads/sites/42/',
			'https://dummy.xtemos.com/woodmart2/marketplace2-elementor/wp-content/uploads/sites/42/',
			'http://dummy.xtemos.com/woodmart2/marketplace2/wp-content/uploads/sites/41/',
			'https://dummy.xtemos.com/woodmart2/marketplace2/wp-content/uploads/sites/41/',
			'http://dummy.xtemos.com/woodmart2/marketplace2-gutenberg/wp-content/uploads/sites/43/',
			'https://dummy.xtemos.com/woodmart2/marketplace2-gutenberg/wp-content/uploads/sites/43/',

			'http://dummy.xtemos.com/woodmart2/gutenberg/wp-content/uploads/sites/24/',
			'https://dummy.xtemos.com/woodmart2/gutenberg/wp-content/uploads/sites/24/',

			'http://dummy.xtemos.com/woodmart2/elementor/wp-content/uploads/sites/2/',
			'https://dummy.xtemos.com/woodmart2/elementor/wp-content/uploads/sites/2/',	

			'http://dummy.xtemos.com/woodmart2/wp-content/uploads/',
			'https://dummy.xtemos.com/woodmart2/wp-content/uploads/',
			'http://woodmart.xtemos.com/wp-content/uploads/',
			'https://woodmart.xtemos.com/wp-content/uploads/',
		),
		'simple'  => array(
			'http://dummy.xtemos.com/woodmart2/megamarket-elementor/',
			'https://dummy.xtemos.com/woodmart2/megamarket-elementor/',
			'http://dummy.xtemos.com/woodmart2/megamarket/',
			'https://dummy.xtemos.com/woodmart2/megamarket/',
			'http://dummy.xtemos.com/woodmart2/megamarket-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/megamarket-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/accessories-elementor/',
			'https://dummy.xtemos.com/woodmart2/accessories-elementor/',
			'http://dummy.xtemos.com/woodmart2/accessories/',
			'https://dummy.xtemos.com/woodmart2/accessories/',
			'http://dummy.xtemos.com/woodmart2/accessories-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/accessories-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/mega-electronics-elementor/',
			'https://dummy.xtemos.com/woodmart2/mega-electronics-elementor/',
			'http://dummy.xtemos.com/woodmart2/mega-electronics/',
			'https://dummy.xtemos.com/woodmart2/mega-electronics/',
			'http://dummy.xtemos.com/woodmart2/mega-electronics-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/mega-electronics-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/furniture2-elementor/',
			'https://dummy.xtemos.com/woodmart2/furniture2-elementor/',
			'http://dummy.xtemos.com/woodmart2/furniture2/',
			'https://dummy.xtemos.com/woodmart2/furniture2/',
			'http://dummy.xtemos.com/woodmart2/furniture2-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/furniture2-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/plants-elementor/',
			'https://dummy.xtemos.com/woodmart2/plants-elementor/',
			'http://dummy.xtemos.com/woodmart2/plants/',
			'https://dummy.xtemos.com/woodmart2/plants/',
			'http://dummy.xtemos.com/woodmart2/plants-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/plants-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/kids-elementor/',
			'https://dummy.xtemos.com/woodmart2/kids-elementor/',
			'http://dummy.xtemos.com/woodmart2/kids/',
			'https://dummy.xtemos.com/woodmart2/kids/',
			'http://dummy.xtemos.com/woodmart2/kids-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/kids-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/games-elementor/',
			'https://dummy.xtemos.com/woodmart2/games-elementor/',
			'http://dummy.xtemos.com/woodmart2/games/',
			'https://dummy.xtemos.com/woodmart2/games/',

			'http://dummy.xtemos.com/woodmart2/farm-elementor/',
			'https://dummy.xtemos.com/woodmart2/farm-elementor/',
			'http://dummy.xtemos.com/woodmart2/farm/',
			'https://dummy.xtemos.com/woodmart2/farm/',
			'http://dummy.xtemos.com/woodmart2/farm-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/farm-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/pills-elementor/',
			'https://dummy.xtemos.com/woodmart2/pills-elementor/',
			'http://dummy.xtemos.com/woodmart2/pills/',
			'https://dummy.xtemos.com/woodmart2/pills/',
			'http://dummy.xtemos.com/woodmart2/pills-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/pills-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/pottery-elementor/',
			'https://dummy.xtemos.com/woodmart2/pottery-elementor/',
			'http://dummy.xtemos.com/woodmart2/pottery/',
			'https://dummy.xtemos.com/woodmart2/pottery/',
			'http://dummy.xtemos.com/woodmart2/pottery-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/pottery-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/vegetables-elementor/',
			'https://dummy.xtemos.com/woodmart2/vegetables-elementor/',
			'http://dummy.xtemos.com/woodmart2/vegetables/',
			'https://dummy.xtemos.com/woodmart2/vegetables/',
			'http://dummy.xtemos.com/woodmart2/vegetables-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/vegetables-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/makeup-elementor/',
			'https://dummy.xtemos.com/woodmart2/makeup-elementor/',
			'http://dummy.xtemos.com/woodmart2/makeup/',
			'https://dummy.xtemos.com/woodmart2/makeup/',
			'http://dummy.xtemos.com/woodmart2/makeup-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/makeup-gutenberg/',

			'http://dummy.xtemos.com/woodmart2/marketplace2-elementor/',
			'https://dummy.xtemos.com/woodmart2/marketplace2-elementor/',
			'http://dummy.xtemos.com/woodmart2/marketplace2/',
			'https://dummy.xtemos.com/woodmart2/marketplace2/',
			'http://dummy.xtemos.com/woodmart2/marketplace2-gutenberg/',
			'https://dummy.xtemos.com/woodmart2/marketplace2-gutenberg/',

			'https://dummy.xtemos.com/woodmart2/gutenberg/',
			'http://dummy.xtemos.com/woodmart2/gutenberg/',

			'http://dummy.xtemos.com/woodmart2/elementor/',
			'https://dummy.xtemos.com/woodmart2/elementor/',
			'http://dummy.xtemos.com/woodmart2/',
			'https://dummy.xtemos.com/woodmart2/',
			'https://woodmart.xtemos.com/',
			'http://woodmart.xtemos.com/',
		),
	);

	/**
	 * Init.
	 */
	public function init() {}

	/**
	 * Send error.
	 *
	 * @param string $message Message.
	 */
	public function send_error_message( $message ) {
		$this->send_message( 'error', $message );
	}

	/**
	 * Send success.
	 *
	 * @param string $message Message.
	 */
	public function send_success_message( $message ) {
		$this->send_message( 'success', $message );
	}

	/**
	 * Send message.
	 *
	 * @param string $status  Status.
	 * @param string $message Message.
	 */
	public function send_message( $status, $message ) {
		echo wp_json_encode(
			array(
				'status'  => $status,
				'message' => $message,
			)
		);
	}

	/**
	 * Get file data.
	 *
	 * @param string $path File path.
	 *
	 * @return false|string
	 */
	public function get_local_file_content( $path ) {
		ob_start();
		include $path;

		return ob_get_clean();
	}

	/**
	 * Get file path.
	 *
	 * @param string $file_name File name.
	 * @param string $version   Version name.
	 *
	 * @return false|string
	 */
	public function get_file_path( $file_name, $version ) {
		$file = $this->get_version_folder_path( $version ) . $file_name;

		if ( ! file_exists( $file ) ) {
			return false;
		}

		return $file;
	}

	/**
	 * Get version folder path.
	 *
	 * @param string $version Version name.
	 *
	 * @return string
	 */
	public function get_version_folder_path( $version ) {
		return WOODMART_THEMEROOT . '/inc/admin/modules/import/dummy-data/' . $version . '/';
	}

	/**
	 * Replace link.
	 *
	 * @since 1.0.0
	 *
	 * @param string $data    Data.
	 * @param string $replace Replace.
	 *
	 * @return string|string[]
	 */
	public function links_replace( $data, $replace = '\/' ) {
		$links = $this->links;

		foreach ( $links as $key => $value ) {
			if ( 'uploads' === $key ) {
				foreach ( $value as $link ) {
					$url_data = wp_upload_dir();
					$data     = str_replace( str_replace( '/', $replace, $link ), str_replace( '/', $replace, $url_data['baseurl'] . '/' ), $data );
				}
			}

			if ( 'simple' === $key ) {
				foreach ( $value as $link ) {
					$data = str_replace( str_replace( '/', $replace, $link ), str_replace( '/', $replace, get_home_url() . '/' ), $data );
				}
			}
		}

		return $data;
	}

	/**
	 * Get imported data.
	 *
	 * @since 1.0.0
	 *
	 * @param string $version Version name.
	 *
	 * @return array
	 */
	public function get_imported_data( $version ) {
		if ( in_array( $version . '_base', $this->get_base_version(), true ) ) {
			$base = get_option( 'wd_imported_data_' . $version . '_base' );
		} else {
			$base = get_option( 'wd_imported_data_base' );
		}

		$demo = get_option( 'wd_imported_data_' . $version );

		if ( in_array( $version, $this->get_base_version(), true ) ) {
			return $demo;
		}

		if ( $demo && $base ) {
			return array_replace_recursive( $base, $demo );
		} else {
			return array();
		}
	}

	/**
	 * Get current builder.
	 *
	 * @return string
	 */
	public function get_page_builder() {
		if ( 'native' === woodmart_get_opt( 'current_builder' ) ) {
			return 'gutenberg';
		}

		return woodmart_get_current_page_builder();
	}

	/**
	 * Get base version for import.
	 *
	 * @return array
	 */
	public function get_base_version() {
		return array( 'base', 'megamarket_base', 'accessories_base', 'mega-electronics_base', 'furniture2_base', 'plants_base', 'kids_base', 'games_base-light', 'games_base-dark', 'organic-farm_base', 'pills_base', 'pottery_base', 'vegetables_base', 'makeup_base', 'marketplace2_base' );
	}
}
