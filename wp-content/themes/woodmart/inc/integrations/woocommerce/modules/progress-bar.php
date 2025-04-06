<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_stock_progress_bar' ) ) {
	function woodmart_stock_progress_bar() {
		$product_id  = get_the_ID();
		$total_stock = (int) get_post_meta( $product_id, 'woodmart_total_stock_quantity', true );

		if ( ! $total_stock ) {
			return;
		}

		$current_stock = round( (int) get_post_meta( $product_id, '_stock', true ) );

		$total_sold = $total_stock > $current_stock ? $total_stock - $current_stock : 0;
		$percentage = $total_sold > 0 ? round( $total_sold / $total_stock * 100 ) : 0;

		if ( $current_stock > 0 ) {
			woodmart_enqueue_inline_style( 'woo-mod-progress-bar' );

			echo '<div class="wd-progress-bar wd-stock-progress-bar">';
				echo '<div class="stock-info">';
					echo '<div class="total-sold">' . esc_html__( 'Ordered:', 'woodmart' ) . '<span>' . esc_html( $total_sold ) . '</span></div>';
					echo '<div class="current-stock">' . esc_html__( 'Items available:', 'woodmart' ) . '<span>' . esc_html( $current_stock ) . '</span></div>';
				echo '</div>';
				echo '<div class="progress-area" title="' . esc_html__( 'Sold', 'woodmart' ) . ' ' . esc_attr( $percentage ) . '%">';
					echo '<div class="progress-bar" style="width:' . esc_attr( $percentage ) . '%;"></div>';
				echo '</div>';
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'woodmart_total_stock_quantity_output_control_in_bulk_edit' ) ) {
	function woodmart_total_stock_quantity_output_control_in_bulk_edit() {
		?>
			<div class="inline-edit-group dimensions">
				<label class="alignleft">
				<span class="title">
					<?php esc_html_e( 'Initial number in stock', 'woodmart' ); ?>
				</span>
					<span class="input-text-wrap">
					<select class="change_dimensions change_to" name="change_woodmart_total_stock_quantity">
						<option value=""><?php esc_html_e( '— No change —', 'woocommerce' ); ?></option>
						<option value="1"><?php esc_html_e( 'Change to:', 'woocommerce' ); ?></option>
					</select>
				</span>
				</label>
				<label class="change-input">
					<input type="text" name="woodmart_total_stock_quantity" class="text stock woodmart_total_stock_quantity" placeholder="<?php esc_attr_e( 'Initial number in stock', 'woodmart' ); ?>" value="">
				</label>
			</div>
		<?php
	}

	add_action( 'woocommerce_product_bulk_edit_end', 'woodmart_total_stock_quantity_output_control_in_bulk_edit' );
}

if ( ! function_exists( 'woodmart_total_stock_quantity_save_control_in_bulk_edit' ) ) {
	function woodmart_total_stock_quantity_save_control_in_bulk_edit() {
		if ( ! isset( $_GET['post'] ) || ! isset( $_GET['change_woodmart_total_stock_quantity'] ) || ! $_GET['change_woodmart_total_stock_quantity'] || ! isset( $_GET['woodmart_total_stock_quantity'] ) ) { //phpcs:ignore
			return;
		}

		$posts_id = woodmart_clean( $_GET['post'] ); //phpcs:ignore
		$option   = wp_kses( $_GET['woodmart_total_stock_quantity'], true ); //phpcs:ignore

		if ( $posts_id ) {
			foreach ( $posts_id as $id ) {
				update_post_meta( $id, 'woodmart_total_stock_quantity', $option );
			}
		}
	}

	add_action( 'save_post_product', 'woodmart_total_stock_quantity_save_control_in_bulk_edit' );
}

if ( ! function_exists( 'woodmart_total_stock_quantity_input' ) ) {
	function woodmart_total_stock_quantity_input() {
		echo '<div class="options_group">';
			woocommerce_wp_text_input(
				array(
					'id'          => 'woodmart_total_stock_quantity',
					'label'       => esc_html__( 'Initial number in stock', 'woodmart' ),
					'desc_tip'    => 'true',
					'description' => esc_html__( 'Required for stock progress bar option', 'woodmart' ),
					'type'        => 'text',
				)
			);
		echo '</div>';
	}

	add_action( 'woocommerce_product_options_inventory_product_data', 'woodmart_total_stock_quantity_input' );
}

if ( ! function_exists( 'woodmart_save_total_stock_quantity' ) ) {
	function woodmart_save_total_stock_quantity( $post_id ) { // phpcs:ignore
		$stock_quantity = isset( $_POST['woodmart_total_stock_quantity'] ) && $_POST['woodmart_total_stock_quantity'] ? wc_clean( $_POST['woodmart_total_stock_quantity'] ) : ''; // phpcs:ignore

		update_post_meta( $post_id, 'woodmart_total_stock_quantity', $stock_quantity );
	}

	add_action( 'woocommerce_process_product_meta_simple', 'woodmart_save_total_stock_quantity' );
	add_action( 'woocommerce_process_product_meta_variable', 'woodmart_save_total_stock_quantity' );
	add_action( 'woocommerce_process_product_meta_grouped', 'woodmart_save_total_stock_quantity' );
	add_action( 'woocommerce_process_product_meta_external', 'woodmart_save_total_stock_quantity' );
}
