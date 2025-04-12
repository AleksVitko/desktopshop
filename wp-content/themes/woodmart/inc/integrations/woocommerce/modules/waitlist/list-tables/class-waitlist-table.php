<?php
/**
 * This file describes class for render view waiting lists in WordPress admin panel.
 *
 * @package Woodmart.
 */

namespace XTS\Modules\Waitlist\List_Table;

use WP_List_Table;
use XTS\Modules\Waitlist\DB_Storage;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Create a new table class that will extend the WP_List_Table.
 */
class Waitlist_Table extends WP_List_Table {
	/**
	 * DB_Storage instance.
	 *
	 * @var DB_Storage
	 */
	protected $db_storage;

	/**
	 * Define what data to show on each column of the table.
	 *
	 * @param array  $item        Data.
	 * @param string $column_name - Current column name.
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		return array_key_exists( $column_name, $item ) ? esc_html( $item[ $column_name ] ) : '';
	}

	/**
	 * Prints column for waitlist user.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="products_ids[]" value="%1$s" />',
			! empty( $item['variation_id'] ) ? $item['variation_id'] : $item['product_id']
		);
	}

	public function column_thumb( $item ) {
		$product_id = $item['variation_id'] ? $item['variation_id'] : $item['product_id'];
		$product    = wc_get_product( $product_id );

		if ( ! $product ) {
			return '';
		}
		?>
		<a href="<?php echo esc_url( get_edit_post_link( $product->get_id() ) ); ?>">
			<?php echo $product->get_image( 'thumbnail' ); // phpcs:ignore. ?>
		</a>
		<?php
	}

	/**
	 * Prints column for waitlist produt name.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_name( $item ) {
		$product_id = $item['variation_id'] ? $item['variation_id'] : $item['product_id'];
		$product    = wc_get_product( $product_id );

		if ( ! $product ) {
			return '';
		}

		$product_edit_url = get_edit_post_link( $item['product_id'] );

		$actions     = array(
			'product_id'   => sprintf( 'ID: %s', esc_html( $item['product_id'] ) ),
			'edit'         => sprintf( '<a href="%s" title="%s">%s</a>', $product_edit_url, esc_html__( 'Edit this item', 'woodmart' ), esc_html__( 'Edit', 'woodmart' ) ),
			'view_users'   => sprintf(
				'<a href="%s" title="%s">%s</a>',
				esc_url(
					add_query_arg(
						array(
							'page'         => 'xts-waitlist-page',
							'tab'          => 'users',
							'product_id'   => $item['product_id'],
							'variation_id' => $item['variation_id'],
						),
						admin_url( 'edit.php?post_type=product' )
					)
				),
				esc_html__( 'View a list with customers that have added this product to their waitlist', 'woodmart' ),
				esc_html__( 'View customers', 'woodmart' )
			),
			'view_product' => sprintf( '<a href="%s" title="%s" rel="permalink">%s</a>', $product->get_permalink(), esc_html__( 'View Product', 'woodmart' ), esc_html__( 'View Product', 'woodmart' ) ),
		);

		if ( in_array( $product->get_type(), array( 'variation', 'subscription_variation' ), true ) ) {
			$attributes = array();

			foreach ( $product->get_attributes() as $taxonomy => $value ) {
				$attributes[ wc_attribute_label( $taxonomy ) ] = $value;
			}
		}

		?>
		<div class="product-details">
			<strong>
				<a class="row-title" href="<?php echo esc_url( $product_edit_url ); ?>">
					<?php echo esc_html( $product->get_title() ); ?>
				</a>
			</strong>

			<?php if ( isset( $attributes ) && ! empty( $attributes ) ) : ?>
				<div class="xts-wtl-attributes">
					<div class="view">
						<table cellspacing="0" class="xts-wtl-variations">
							<?php foreach ( $attributes as $label => $value ) : ?>
								<tr>
									<th><?php echo wp_kses_post( ucfirst( $label ) ); ?>:</th>
									<td><?php echo wp_kses_post( ucfirst( $value ) ); ?></td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			<?php endif; ?>

			<?php echo $this->row_actions( $actions ); // phpcs:ignore. ?>
		</div>
		<?php
	}

	/**
	 * Prints column for waitlist produt status.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_is_in_stock( $item ) {
		$product_id = $item['variation_id'] ? $item['variation_id'] : $item['product_id'];
		$product    = wc_get_product( $product_id );

		if ( ! $product ) {
			return '';
		}

		if ( $product->is_in_stock() ) {
			$status_class = 'instock';
			$status_label = esc_html__( 'In stock', 'woodmart' );
		} else {
			$status_class = 'outofstock';
			$status_label = esc_html__( 'Out of stock', 'woodmart' );
		}

		ob_start();
		?>
		<mark class="<?php echo esc_attr( $status_class ); ?>">
			<?php echo esc_html( $status_label ); ?>
		</mark>
		<?php

		return ob_get_clean();
	}

	/**
	 * Prints column for waitlist number of users who are waiting for this product.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_users( $item ) {
		$column_content = $item['user_count'];

		return sprintf(
			'<a href="%s">%d</a>',
			esc_url(
				add_query_arg(
					array(
						'page'         => 'xts-waitlist-page',
						'tab'          => 'users',
						'product_id'   => $item['product_id'],
						'variation_id' => $item['variation_id'],
					),
					admin_url( 'edit.php?post_type=product' )
				)
			),
			$column_content
		);
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table.
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb'           => '<input type="checkbox" />',
			'thumb'        => '<span class="wc-image tips" data-tip="' . esc_attr__( 'Image', 'woodmart' ) . '">' . esc_html__( 'Image', 'woodmart' ) . '</span>',
			'name'         => esc_html__( 'Name', 'woodmart' ),
			'is_in_stock'  => esc_html__( 'Stock', 'woodmart' ),
			'users'        => esc_html__( 'Users', 'woodmart' ),
		);
	}

	/**
	 * Define which columns are hidden.
	 *
	 * @return array
	 */
	public function get_hidden_columns() {
		return array();
	}

	/**
	 * Define the sortable columns.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		return array(
			'users' => array( 'user_count', false ),
		);
	}

	/**
	 * Sets bulk actions for table.
	 *
	 * @return array Array of available actions.
	 */
	public function get_bulk_actions() {
		return array(
			'delete' => esc_html__( 'Delete', 'woodmart' ),
		);
	}

	/**
	 * Delete waitlist on bulk action.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public function process_bulk_action() {
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-' . $this->_args['plural'] ) ) { // phpcs:ignore.
			return;
		}

		// Detect when a bulk action is being triggered...
		$products_ids = isset( $_REQUEST['products_ids'] ) ? array_map( 'intval', (array) $_REQUEST['products_ids'] ) : false;

		if ( 'delete' === $this->current_action() && ! empty( $products_ids ) ) {
			foreach ( $products_ids as $product_id ) {
				try {
					$product = wc_get_product( $product_id );

					$this->db_storage->unsubscribe_by_product( $product );
				} catch ( Exception $e ) {
					continue;
				}
			}

			wp_safe_redirect( admin_url( '/edit.php?post_type=product&page=xts-waitlist-page' ) );
			die();
		}
	}

	/**
	 * Prepare the items for the table to process.
	 *
	 * @return void
	 */
	public function prepare_items() {
		$this->db_storage = DB_Storage::get_instance();
		$columns          = $this->get_columns();
		$hidden           = $this->get_hidden_columns();
		$sortable         = $this->get_sortable_columns();
		$user_id          = get_current_user_id();

		$data = $this->table_data();
		usort( $data, array( $this, 'sort_data' ) );

		$per_page     = ! empty( get_user_meta( $user_id, 'waitlist_per_page', true ) ) ? get_user_meta( $user_id, 'waitlist_per_page', true ) : 20;
		$current_page = $this->get_pagenum();
		$total_items  = count( $data );

		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
			)
		);

		$data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );

		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = $data;

		$this->process_bulk_action();
	}

	/**
	 * Get the table data.
	 *
	 * @return array
	 */
	private function table_data() {
		global $wpdb;

		$where_query = array();
		$search      = isset( $_REQUEST['s'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : false; // phpcs:ignore.
		$_product_id = isset( $_REQUEST['_product_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_product_id'] ) ) : false; // phpcs:ignore.
		$_user_id    = isset( $_REQUEST['_user_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_user_id'] ) ) : false; // phpcs:ignore.

		if ( $search ) {
			$where_query[] = $wpdb->prepare( "$wpdb->posts.`post_title` LIKE %s", '%' . $wpdb->esc_like( $search ) . '%' );
		}

		if ( $_product_id ) {
			$where_query[] = $wpdb->prepare( "$wpdb->wd_waitlists.`product_id` = %d OR $wpdb->wd_waitlists.`variation_id` = %d", $_product_id, $_product_id );
		}

		if ( $_user_id ) {
			$where_query[] = $wpdb->prepare( "$wpdb->wd_waitlists.user_id = %d", $_user_id );
		}

		$where_query_text = ! empty( $where_query ) ? ' WHERE ' . implode( ' AND ', $where_query ) : '';

		if ( ! wp_cache_get( 'wd_waitlist_table_data' ) ) {
			wp_cache_set(
				'wd_waitlist_table_data',
				$wpdb->get_results( //phpcs:ignore;
					"SELECT
						$wpdb->wd_waitlists.`list_id`,
						$wpdb->wd_waitlists.`product_id`,
						$wpdb->wd_waitlists.`variation_id`,
						COUNT( $wpdb->wd_waitlists.`user_id` ) as `user_count`,
						$wpdb->wd_waitlists.`created_date_gmt` as `created_date`
					FROM $wpdb->wd_waitlists
					INNER JOIN $wpdb->posts
						ON $wpdb->posts.`ID` = $wpdb->wd_waitlists.`product_id`"
					. $where_query_text .
					" GROUP BY
						$wpdb->wd_waitlists.`product_id`,
						$wpdb->wd_waitlists.`variation_id`
					;",
					ARRAY_A
				)
			);
		}

		return wp_cache_get( 'wd_waitlist_table_data' );
	}

	/**
	 * Allows you to sort the data by the variables set in the $_GET.
	 *
	 * @codeCoverageIgnore
	 *
	 * @param array $a First array.
	 * @param array $b Next array.
	 * @return int
	 */
	private function sort_data( $a, $b ) {
		// Set defaults.
		$order_by = 'created_date';
		$order    = 'desc';

		// If orderby is set, use this as the sort column.
		if ( ! empty( $_GET['orderby'] ) ) { // phpcs:ignore.
			$order_by = $_GET['orderby']; // phpcs:ignore.
		}

		// If order is set use this as the order.
		if ( ! empty( $_GET['order'] ) ) { // phpcs:ignore.
			$order = $_GET['order']; // phpcs:ignore.
		}

		$result = strcmp( $a[ $order_by ], $b[ $order_by ] );

		if ( is_numeric( $a[ $order_by ] ) && is_numeric( $a[ $order_by ] ) ) {
			$result = $a[ $order_by ] - $b[ $order_by ];
		}

		if ( 'asc' === $order ) {
			return $result;
		}

		return -$result;
	}

	/**
	 * Print filters for current table
	 *
	 * @codeCoverageIgnore
	 *
	 * @param string $which Top / Bottom.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	protected function extra_tablenav( $which ) {
		if ( 'top' !== $which ) {
			return;
		}

		$need_reset = false;
		$product_id = isset( $_REQUEST['_product_id'] ) ? intval( $_REQUEST['_product_id'] ) : false; // phpcs:ignore.
		$user_id    = isset( $_REQUEST['_user_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_user_id'] ) ) : false; // phpcs:ignore.

		if ( ! empty( $product_id ) ) {
			$product = wc_get_product( $product_id );

			if ( $product ) {
				$selected_product = '#' . $product_id . ' &ndash; ' . $product->get_title();
			}
		}

		if ( ! empty( $user_id ) ) {
			$user = get_user_by( 'id', $user_id );

			if ( $user ) {
				$selected_user = $user->get( 'user_login' );
			}
		}

		if ( $product_id || $user_id ) {
			$need_reset = true;
		}

		wp_enqueue_style(
			'xts-jquery-ui',
			WOODMART_ASSETS . '/css/jquery-ui.css',
			array(),
			WOODMART_VERSION
		);

		wp_enqueue_script(
			'xts-admin-waitlist',
			WOODMART_ASSETS . '/js/waitlist.js',
			array(
				'jquery',
				'jquery-ui-datepicker',
				'select2',
			),
			WOODMART_VERSION,
			true
		);
		?>
		<select
			id="_product_id"
			name="_product_id"
			class="wc-product-search"
			data-security="<?php echo esc_attr( wp_create_nonce( 'search-products' ) ); ?>"
			style="width: 300px;"
		>
			<?php if ( $product_id && isset( $selected_product ) ) : ?>
				<option value="<?php echo esc_attr( $product_id ); ?>" <?php selected( true, true, true ); ?> >
					<?php echo esc_html( $selected_product ); ?>
				</option>
			<?php endif; ?>
		</select>
		<select
			id="_user_id"
			name="_user_id"
			class="xts-users-search"
			data-security="<?php echo esc_attr( wp_create_nonce( 'search-users' ) ); ?>"
			style="width: 300px;"
		>
			<?php if ( $user_id && isset( $selected_user ) ) : ?>
				<option value="<?php echo esc_attr( $user_id ); ?>" <?php selected( true, true, true ); ?> >
					<?php echo esc_html( $selected_user ); ?>
				</option>
			<?php endif; ?>
		</select>
		<?php
		submit_button( esc_html__( 'Filter', 'woodmart' ), 'button', 'filter_action', false, array( 'id' => 'post-query-submit' ) );

		if ( $need_reset ) {
			echo sprintf(
				'<a href="%s" class="button button-secondary reset-button">%s</a>',
				esc_url(
					add_query_arg(
						array(
							'page' => 'xts-waitlist-page',
						),
						admin_url( '/edit.php?post_type=product' )
					)
				),
				esc_html__( 'Reset', 'woodmart' )
			);
		}
	}
}
