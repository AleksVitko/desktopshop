<?php
/**
 * Out of stock manager class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Out_Of_Stock_Manager;

use XTS\Admin\Modules\Options;
use XTS\Singleton;
use XTS\Modules\Layouts\Main as Builder;

/**
 * Out of stock manager class.
 */
class Main extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		add_action( 'init', array( $this, 'add_options' ) );

		if ( ! woodmart_get_opt( 'show_out_of_stock_at_the_end' ) ) {
			return;
		}

		add_filter( 'posts_clauses', array( $this, 'change_main_products_loop_query' ), 2000, 2 );
	}

	/**
	 * Add options in theme settings.
	 */
	public function add_options() {
		Options::add_field(
			array(
				'id'       => 'show_out_of_stock_at_the_end',
				'name'     => esc_html__( 'Show "Out of stock" products at the end (experimental)', 'woodmart' ),
				'hint' => '<video data-src="' . WOODMART_TOOLTIP_URL . 'show_out_of_stock_at_the_end.mp4" autoplay loop muted></video>',
				'type'     => 'switcher',
				'section'  => 'product_archive_section',
				'default'  => '0',
				'priority' => 50,
			)
		);
	}

	/**
	 * Sort out-of-stock products to display last on the main products loop.
	 *
	 * @param array    $posts_clauses Associative array of the clauses for the query.
	 * @param WP_Query $query Current query.
	 */
	public function change_main_products_loop_query( $posts_clauses, $query ) {
		global $wpdb;

		if ( is_woocommerce() && 'product_query' === $query->get( 'wc_query' ) ) {
			$posts_clauses['join']   .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
			$posts_clauses['orderby'] = ' istockstatus.meta_value ASC, ' . $posts_clauses['orderby'];
			$posts_clauses['where']   = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
		}

		return $posts_clauses;
	}
}

Main::get_instance();
