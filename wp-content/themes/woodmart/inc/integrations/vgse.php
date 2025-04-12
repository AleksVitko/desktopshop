<?php

if ( ! defined( 'VGSE_MAIN_FILE' ) ) {
	return;
}

if ( ! function_exists( 'woodmart_send_waitlist_instock_emails' ) ) {
	function woodmart_send_waitlist_instock_emails( $post_type, $post_id, $key, $new_value, $cell_args, $spreadsheet_columns, $item ) {
		if ( woodmart_get_opt( 'waitlist_enabled' ) && 'product' === $post_type && '_stock_status' === $key && 'instock' === $new_value ) {
			$db_storage = XTS\Modules\Waitlist\DB_Storage::get_instance();
			$product    = wc_get_product( $post_id );

			$waitlists       = $db_storage->get_subscriptions_by_product( $product );
			$waitlists_chunk = array_chunk( $waitlists, apply_filters( 'woodmart_waitlist_scheduled_email_chunk', 50 ) );
			$schedule_time   = time();

			foreach ( $waitlists_chunk as $waitlist_chunk ) {
				wp_schedule_single_event(
					$schedule_time,
					'woodmart_waitlist_send_in_stock',
					array( $waitlist_chunk )
				);

				$schedule_time += apply_filters( 'woodmart_waitlist_schedule_time', intval( woodmart_get_opt( 'waitlist_wait_interval', HOUR_IN_SECONDS ) ) );
			}
		}
	}

	add_action( 'vg_sheet_editor/save_rows/after_saving_cell', 'woodmart_send_waitlist_instock_emails', 10, 7 );
}
