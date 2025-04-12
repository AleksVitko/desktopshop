<?php
/**
 * This file describes class for render view waiting lists in WordPress admin panel.
 *
 * @package Woodmart.
 */

namespace XTS\Modules\Abandoned_Cart\List_Table;

use WP_List_Table;
use XTS\Modules\Abandoned_Cart\Abandoned_Cart;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Create a new table class that will extend the WP_List_Table.
 */
class Abandoned_Cart_Table extends WP_List_Table {
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
	 * Prints column for .
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="carts_ids[]" value="%1$s" />',
			$item['ID']
		);
	}

	/**
	 * Print user name.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_name( $item ) {
		$user_name = '';

		if ( ! empty( $item['_user_id'] ) ) {
			$user      = get_user_by( 'id', $item['_user_id'] );
			$user_name = $user->user_login;
		} else {
			if ( ! empty( $item['_user_first_name'] ) ) {
				$user_name .= $item['_user_first_name'];
			}

			if ( ! empty( $item['_user_last_name'] ) ) {
				$user_name .= ' ' . $item['_user_last_name'];
			}

			if ( empty( $user_name ) ) {
				$user_name = esc_html__( 'guest', 'woodmart' );
			}
		}

		$abandoned_cart_url = admin_url( 'post.php?post=' . $item['ID'] . '&action=edit' );
		$delete_cart_url    = add_query_arg(
			array(
				'action'  => 'woodmart_delete_abandoned_cart',
				'cart_id' => $item['ID'],
			),
			wp_nonce_url( admin_url( 'edit.php?post_type=product' ), 'woodmart_delete_abandoned_cart', 'security' )
		);

		$actions = array();

		if ( $item['_user_id'] ) {
			$actions['ID'] = sprintf( 'ID: %s', esc_html( $item['_user_id'] ) );
		}

		$actions = array_merge(
			$actions,
			array(
				'view_cart' => sprintf( '<a href="%s" title="%s">%s</a>', $abandoned_cart_url, esc_html__( 'View customer cart', 'woodmart' ), esc_html__( 'View cart', 'woodmart' ) ),
				'delete'    => sprintf( '<a href="%s">%s</a>', esc_url( $delete_cart_url ), esc_html__( 'Delete', 'woodmart' ) ),
			)
		);

		$row_actions = $this->row_actions( $actions );

		ob_start();
		?>
			<strong>
				<?php echo esc_html( $user_name ); ?>
			</strong>
			<?php echo $row_actions; // phpcs:ignore. ?>
		<?php
		return ob_get_clean();
	}

	/**
	 * Prints user email.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_email( $item ) {
		return $item['_user_email'];
	}

	/**
	 * Prints cart subtotal.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_subtotal( $item ) {
		$cart     = $item['_cart'];
		$total    = 0;
		$currency = get_woocommerce_currency();

		if ( ! $cart ) {
			return 0;
		}

		foreach ( $cart->get_cart_contents() as $cart_item_key => $cart_item ) {
			$_product = $cart_item['data'];
			$quantity = $cart_item['quantity'];

			if ( ! $_product || ! $_product->exists() || $quantity <= 0 ) {
				continue;
			}

			if ( $cart->display_prices_including_tax() ) {
				$product_price = wc_get_price_including_tax( $_product );
			} else {
				$product_price = wc_get_price_excluding_tax( $_product );
			}

			$product_subtotal = $product_price * $quantity;

			$total += $product_subtotal;
		}

		return wc_price( $total, array( 'currency' => $currency ) );
	}

	/**
	 * Prints cart status.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_status( $item ) {
		return $item['_cart_status'];
	}

	/**
	 * Prints action button.
	 *
	 * @param array $item Item to use to print record.
	 * @return string
	 */
	public function column_last_update( $item ) {
		$row = '';

		if ( isset( $item['post_modified_gmt'] ) ) {
			$last_update = strtotime( $item['post_modified_gmt'] );
			$time_diff   = time() - $last_update;

			if ( $time_diff < DAY_IN_SECONDS ) {
				// translators: 1. Date diff since wishlist creation (EG: 1 hour, 2 seconds, etc...).
				$row = sprintf( esc_html__( '%s ago', 'woodmart' ), human_time_diff( $last_update ) );
			} else {
				$row = date_i18n( wc_date_format(), $last_update );
			}
		}

		return $row;
	}

	/**
	 * Override the parent columns method. Defines the columns to use in your listing table.
	 *
	 * @return array
	 */
	public function get_columns() {
		return array(
			'cb'          => '<input type="checkbox" />',
			'name'        => esc_html__( 'Name', 'woodmart' ),
			'email'       => esc_html__( 'Email', 'woodmart' ),
			'subtotal'    => esc_html__( 'Subtotal', 'woodmart' ),
			'status'      => esc_html__( 'Status', 'woodmart' ),
			'last_update' => esc_html__( 'Last views', 'woodmart' ),
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
			'name'        => array( 'name', false ),
			'email'       => array( 'email', false ),
			'subtotal'    => array( 'subtotal', false ),
			'status'      => array( 'status', false ),
			'last_update' => array( 'last_update', false ),
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
	 * @return void
	 */
	public function process_bulk_action() {
		if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-' . $this->_args['plural'] ) ) { // phpcs:ignore.
			return;
		}

		// Detect when a bulk action is being triggered...
		$carts_ids = isset( $_REQUEST['carts_ids'] ) ? array_map( 'intval', (array) $_REQUEST['carts_ids'] ) : false;

		if ( 'delete' === $this->current_action() && ! empty( $carts_ids ) ) {
			foreach ( $carts_ids as $cart_id ) {
				wp_delete_post( $cart_id, true );
			}

			wp_safe_redirect( admin_url( '/edit.php?post_type=product&page=xts-abandoned-cart-page' ) );
			die();
		}
	}

	/**
	 * Prepare the items for the table to process.
	 *
	 * @return void
	 */
	public function prepare_items() {
		$columns  = $this->get_columns();
		$hidden   = $this->get_hidden_columns();
		$sortable = $this->get_sortable_columns();
		$user_id  = get_current_user_id();

		$data = $this->table_data();
		usort( $data, array( $this, 'sort_data' ) );

		$per_page     = ! empty( get_user_meta( $user_id, 'abandoned_cart_per_page', true ) ) ? get_user_meta( $user_id, 'abandoned_cart_per_page', true ) : 20;
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
		$items     = array();
		$posts     = get_posts(
			array(
				'post_type'      => Abandoned_Cart::get_instance()->post_type_name,
				'posts_per_page' => -1,
				'meta_query'     => array( //phpcs:ignore
					array(
						'key'   => '_cart_status',
						'value' => 'abandoned',
					),
				),
			)
		);
		$meta_keys = array(
			'_user_id',
			'_user_email',
			'_user_first_name',
			'_user_last_name',
			'_cart_status',
			'_language',
			'_cart',
		);

		foreach ( $posts as $post ) {
			$item_data = array(
				'ID'                => $post->ID,
				'title'             => $post->post_title,
				'post_modified_gmt' => $post->post_modified_gmt,
			);

			foreach ( $meta_keys as $meta_key ) {
				$item_data[ $meta_key ] = maybe_unserialize( get_post_meta( $post->ID, $meta_key, true ) );
			}

			$items[] = $item_data;
		}

		return $items;
	}

	/**
	 * Allows you to sort the data by the variables set in the $_GET.
	 *
	 * @param array $a First array.
	 * @param array $b Next array.
	 * @return int
	 */
	private function sort_data( $a, $b ) {
		// Set defaults.
		$order_by = 'last_update';
		$order    = 'desc';

		// If orderby is set, use this as the sort column.
		if ( ! empty( $_GET['orderby'] ) ) { // phpcs:ignore.
			$order_by = $_GET['orderby']; // phpcs:ignore.
		}

		// If order is set use this as the order.
		if ( ! empty( $_GET['order'] ) ) { // phpcs:ignore.
			$order = $_GET['order']; // phpcs:ignore.
		}

		if ( ! isset( $a[ $order_by ] ) || ! isset( $b[ $order_by ] ) ) {
			return 0;
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
}
