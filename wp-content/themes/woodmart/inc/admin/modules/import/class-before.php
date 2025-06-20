<?php
/**
 * Import before.
 *
 * @package Woodmart
 */

namespace XTS\Admin\Modules\Import;

use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import before.
 */
class Before extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		$this->remove_shop_page();
		$this->import_attributes();
	}

	/**
	 * Import.
	 */
	private function import_attributes() {
		if ( get_option( 'woodmart_import_attributes' ) ) {
			return;
		}

		$attrs = array(
			'color' => array(
				'name'         => 'Color',
				'slug'         => 'color',
				'has_archives' => false,
			),
			'size'  => array(
				'name'         => 'Size',
				'slug'         => 'size',
				'has_archives' => false,
			),
		);

		foreach ( $attrs as $attr ) {
			wc_create_attribute(
				array(
					'name'         => $attr['name'],
					'slug'         => $attr['slug'],
					'type'         => 'select',
					'order_by'     => 'menu_order',
					'has_archives' => $attr['has_archives'],
				)
			);

			register_taxonomy(
				'pa_' . $attr['slug'],
				'product',
				array(
					'labels' => array(
						'name' => $attr['name'],
					),
				)
			);
		}

		flush_rewrite_rules();
		wp_cache_flush();
		delete_transient( 'wc_attribute_taxonomies' );

		update_option( 'woodmart_import_attributes', 'imported', false );
	}

	/**
	 * Remove default shop page
	 *
	 * @return void
	 */
	private function remove_shop_page() {
		$shop_page_id = get_option( 'woocommerce_shop_page_id' );

		if ( $shop_page_id ) {
			wp_delete_post( $shop_page_id, true );
		}
	}
}
