<?php
/**
 * This file describes class for render view waiting lists in WordPress admin panel.
 *
 * @package Woodmart.
 */

namespace XTS\Modules\Abandoned_Cart\List_Table;

use WP_List_Table;
use XTS\Modules\Abandoned_Cart\Abandoned_Cart;
use WC_Tax;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Cart_Content_Table extends WP_List_Table {
	/**
	 * Abandoned cart.
	 *
	 * @var WC_Cart
	 */
	public $cart;

	public function __construct( $cart ) {
		$this->cart = $cart;

		parent::__construct(
			array(
				'singular' => 'product',
				'plural'   => 'products',
				'ajax'     => false,
			)
		);
	}

	public function column_default( $item, $column_name ) {
		return array_key_exists( $column_name, $item ) ? esc_html( $item[ $column_name ] ) : '';
	}

	public function column_thumb( $item ) {
		if ( ! $item['product_permalink'] ) {
			echo $item['thumbnail']; // phpcs:ignore.
		} else {
			printf( '<a href="%s">%s</a>', esc_url( $item['product_permalink'] ), $item['thumbnail'] ); // phpcs:ignore.
		}
	}

	public function column_name( $item ) {
		if ( ! $item['product_permalink'] ) {
			echo wp_kses_post( $item['product_name'] . '&nbsp;' );
		} else {
			echo wp_kses_post( sprintf( '<a href="%s">%s</a>', esc_url( $item['product_permalink'] ), $item['product_name'] ) );
		}
	}

	public function column_price( $item ) {
		echo $item['price']; // phpcs:ignore.
	}

	public function column_quantity( $item ) {
		echo $item['quantity']; // phpcs:ignore.
	}

	public function column_subtotal( $item ) {
		echo $item['subtotal']; // phpcs:ignore.
	}

	public function get_columns() {
		return array(
			'thumb'    => '<span class="wc-image tips" data-tip="' . esc_attr__( 'Image', 'woodmart' ) . '">' . __( 'Image', 'woodmart' ) . '</span>',
			'name'     => esc_html__( 'Name', 'woodmart' ),
			'price'    => esc_html__( 'Price', 'woodmart' ),
			'quantity' => esc_html__( 'Quantity', 'woodmart' ),
			'subtotal' => esc_html__( 'Subtotal', 'woodmart' ),
		);
	}

	public function prepare_items() {
		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = array();
		$this->_column_headers = array( $columns, $hidden, $sortable );

		$data        = $this->table_data();
		$this->items = $data;
	}

	public function table_data() {
		$data = array();

		foreach ( $this->cart->get_cart_contents() as $cart_item_key => $cart_item ) {
			$_product = $cart_item['data'];
			$quantity = $cart_item['quantity'];

			if ( ! $_product || ! $_product->exists() || $quantity <= 0 ) {
				continue;
			}

			$data[] = array(
				'product_permalink' => $_product->is_visible() ? $_product->get_permalink() : '',
				'thumbnail'         => $_product->get_image(),
				'product_name'      => $_product->get_name(),
				'price'             => $this->cart->get_product_price( $_product ),
				'quantity'          => $quantity,
				'subtotal'          => $this->cart->get_product_subtotal( $_product, $quantity ),
			);
		}

		return $data;
	}
}
