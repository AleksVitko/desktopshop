<?php
/**
 * Add Estimate delivery settings on wp admin page.
 *
 * @package woodmart
 */

namespace XTS\Modules\Estimate_Delivery;

use XTS\Singleton;
use XTS\Admin\Modules\Options\Metaboxes;
use XTS\Admin\Modules\Dashboard\Status_Button;
use WC_Shipping_Zones;
use WC_Shipping_Zone;
use WP_Query;

/**
 * Add Estimate delivery settings on wp admin page.
 */
class Admin extends Singleton {
	/**
	 * Metabox class instanse.
	 *
	 * @var Metabox instanse.
	 */
	public $metabox;

	/**
	 * Manager instance.
	 *
	 * @var Manager instanse.
	 */
	public $manager;

	/**
	 * Init.
	 */
	public function init() {
		$this->manager = Manager::get_instance();

		add_action( 'new_to_publish', array( $this, 'clear_transients_on_publish' ) );
		add_action( 'save_post', array( $this, 'clear_transients' ), 10, 2 );
		add_action( 'edit_post', array( $this, 'clear_transients' ), 10, 2 );
		add_action( 'deleted_post', array( $this, 'clear_transients' ), 10, 2 );
		add_action( 'woodmart_change_post_status', array( $this, 'clear_transients_on_ajax' ) );

		add_action( 'init', array( $this, 'add_metaboxes' ) );

		add_action( 'wp_ajax_xts_woo_get_shipping_method', array( $this, 'ajax_get_shipping_method' ) );

		new Status_Button( 'wd_woo_est_del', 2 );

		add_action( 'manage_wd_woo_est_del_posts_columns', array( $this, 'admin_columns_titles' ) );
		add_action( 'manage_wd_woo_est_del_posts_custom_column', array( $this, 'admin_columns_content' ), 10, 2 );

		add_action( 'woocommerce_pre_delete_shipping_zone', array( $this, 'clear_shipping_method_meta_on_delete_zone' ), 10, 3 );
		add_action( 'woocommerce_shipping_zone_method_deleted', array( $this, 'clear_shipping_method_meta_on_delete_method' ), 10, 3 );

		add_filter( 'post_row_actions', array( $this, 'duplicate_action' ), 10, 2 );
	}

	/**
	 * Clear transients on create post.
	 *
	 * @param WP_Post $post Post object.
	 *
	 * @return void
	 */
	public function clear_transients_on_publish( $post ) {
		$this->clear_transients( 0, $post );
	}

	/**
	 * Clear transients.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post Post object.
	 *
	 * @return void
	 */
	public function clear_transients( $post_id, $post ) {
		if ( ! $post || 'wd_woo_est_del' !== $post->post_type ) {
			return;
		}

		delete_transient( $this->manager->transient_est_del_ids );
		delete_transient( $this->manager->transient_est_del_rule . '_' . $post->ID );
	}

	/**
	 * Clear transients on ajax action.
	 *
	 * @return void
	 */
	public function clear_transients_on_ajax() {
		if ( ! wp_doing_ajax() || empty( $_POST['action'] ) || empty( $_POST['id'] ) || 'wd_change_post_status' !== $_POST['action'] ) {
			return;
		}

		$post = get_post( $_POST['id'] );

		if ( ! $post || 'wd_woo_est_del' !== $post->post_type ) {
			return;
		}

		delete_transient( $this->manager->transient_est_del_ids );
		delete_transient( $this->manager->transient_est_del_rule . '_' . $post->ID );
	}

	/**
	 * Add metaboxes for estimate delivery.
	 *
	 * @return void
	 */
	public function add_metaboxes() {
		$metabox = Metaboxes::add_metabox(
			array(
				'id'         => 'wd_woo_est_del_metaboxes',
				'title'      => esc_html__( 'Settings', 'woodmart' ),
				'post_types' => array( 'wd_woo_est_del' ),
			)
		);

		$metabox->add_section(
			array(
				'id'       => 'general',
				'name'     => esc_html__( 'General', 'woodmart' ),
				'icon'     => 'xts-i-footer',
				'priority' => 10,
			)
		);

		$metabox->add_field(
			array(
				'id'           => 'est_del_shipping_method',
				'type'         => 'select',
				'section'      => 'general',
				'name'         => esc_html__( 'Shipping zone and method', 'woodmart' ),
				'description'  => esc_html__( 'Select the shipping zone and method for which these estimated delivery date rules will apply. Leave this field empty if you want the rule to apply to all available shipping zones.', 'woodmart' ),
				'select2'      => true,
				'multiple'     => true,
				'empty_option' => true,
				'autocomplete' => array(
					'type'   => '',
					'value'  => '',
					'search' => 'xts_woo_get_shipping_method', // Ajax action.
					'render' => array( $this, 'show_current_zone' ),
				),
				'priority'     => 10,
			)
		);

		$metabox->add_field(
			array(
				'id'          => 'est_del_day_min',
				'name'        => esc_html__( 'Minimum days', 'woodmart' ),
				'description' => esc_html__( 'Minimum number of days for delivery.', 'woodmart' ),
				'type'        => 'text_input',
				'attributes'  => array(
					'type' => 'number',
					'min'  => '0',
					'step' => '1',
				),
				'section'     => 'general',
				'priority'    => 20,
				'class'       => 'xts-col-6',
			)
		);

		$metabox->add_field(
			array(
				'id'          => 'est_del_day_max',
				'name'        => esc_html__( 'Maximum days', 'woodmart' ),
				'description' => esc_html__( 'Maximum number of days for delivery.', 'woodmart' ),
				'type'        => 'text_input',
				'attributes'  => array(
					'type' => 'number',
					'min'  => '0',
					'step' => '1',
				),
				'section'     => 'general',
				'priority'    => 30,
				'class'       => 'xts-col-6',
			)
		);

		$metabox->add_field(
			array(
				'id'           => 'est_del_skipped_date',
				'type'         => 'select',
				'section'      => 'general',
				'name'         => esc_html__( 'Skipped days of the week', 'woodmart' ),
				'description'  => esc_html__( 'Select the days of the week when delivery will not be made.', 'woodmart' ),
				'group'        => esc_html__( 'Calendar', 'woodmart' ),
				'options'      => array(
					'0' => array(
						'name'  => esc_html__( 'Sunday', 'woodmart' ),
						'value' => '0',
					),
					'1' => array(
						'name'  => esc_html__( 'Monday', 'woodmart' ),
						'value' => '1',
					),
					'2' => array(
						'name'  => esc_html__( 'Tuesday', 'woodmart' ),
						'value' => '2',
					),
					'3' => array(
						'name'  => esc_html__( 'Wednesday', 'woodmart' ),
						'value' => '3',
					),
					'4' => array(
						'name'  => esc_html__( 'Thursday', 'woodmart' ),
						'value' => '4',
					),
					'5' => array(
						'name'  => esc_html__( 'Friday', 'woodmart' ),
						'value' => '5',
					),
					'6' => array(
						'name'  => esc_html__( 'Saturday', 'woodmart' ),
						'value' => '6',
					),
				),
				'select2'      => true,
				'multiple'     => true,
				'empty_option' => true,
				'priority'     => 40,
				'class'        => 'xts-col-6',
			)
		);

		$metabox->add_field(
			array(
				'id'          => 'est_del_daily_deadline',
				'name'        => esc_html__( 'Daily shipping deadline', 'woodmart' ),
				'description' => esc_html__( 'Define a daily deadline for processing orders. Orders placed after this cut-off time will be managed the following business day.', 'woodmart' ),
				'group'       => esc_html__( 'Calendar', 'woodmart' ),
				'type'        => 'text_input',
				'attributes'  => array(
					'type' => 'time',
				),
				'section'     => 'general',
				'priority'    => 50,
				'class'       => 'xts-col-6',
			)
		);

		$metabox->add_field(
			array(
				'id'       => 'est_del_exclusion_dates',
				'name'     => esc_html__( 'Holidays and days off', 'woodmart' ),
				'group'    => esc_html__( 'Calendar', 'woodmart' ),
				'type'     => 'timetable',
				'section'  => 'general',
				'priority' => 60,
			)
		);

		$metabox->add_field(
			array(
				'id'       => 'est_del_condition',
				'group'    => esc_html__( 'Condition', 'woodmart' ),
				'type'     => 'conditions',
				'section'  => 'general',
				'priority' => 70,
			)
		);

		$metabox->add_field(
			array(
				'id'          => 'est_del_priority',
				'name'        => esc_html__( 'Priority', 'woodmart' ),
				'description' => esc_html__( 'Set priority for current discount rules. This will be useful if several rules apply to one shipping method.', 'woodmart' ),
				'group'       => esc_html__( 'Settings', 'woodmart' ),
				'type'        => 'text_input',
				'attributes'  => array(
					'type' => 'number',
					'min'  => '1',
				),
				'default'     => 1,
				'section'     => 'general',
				'class'       => 'xts-col-12',
				'priority'    => 80,
			)
		);

		$metabox->add_field(
			array(
				'id'          => 'est_del_tooltip_content',
				'name'        => esc_html__( 'Tooltip content', 'woodmart' ),
				'description' => esc_html__( 'If this field is filled, a hint with the specified text will appear next to the notice of the current rule.', 'woodmart' ),
				'group'       => esc_html__( 'Settings', 'woodmart' ),
				'type'        => 'textarea',
				'section'     => 'general',
				'wysiwyg'     => true,
				'default'     => '',
				'priority'    => 90,
			)
		);

		$this->manager->set_meta_boxes_fields_keys(
			array(
				'est_del_shipping_method',
				'est_del_day_min',
				'est_del_day_max',
				'est_del_tooltip_content',
				'est_del_skipped_date',
				'est_del_daily_deadline',
				'est_del_exclusion_dates',
				'est_del_condition',
				'est_del_priority',
			)
		);
	}

	/**
	 * Autocomplete by post ids.
	 *
	 * @since 1.0.0
	 *
	 * @param array $ids Posts ids.
	 *
	 * @return array
	 */
	public function show_current_zone( $ids ) {
		$output = array();

		if ( ! $ids ) {
			return $output;
		}

		if ( ! is_array( $ids ) ) {
			$ids = array( $ids );
		}

		foreach ( $ids as $id ) {
			$method = WC_Shipping_Zones::get_shipping_method( $id );

			if ( ! $method ) {
				continue;
			}

			$method_id = $method->get_instance_id();
			$zone      = WC_Shipping_Zones::get_zone_by( 'instance_id', $method_id );

			$method_name = sprintf(
				// translators: Shipping zone and method.
				esc_html__( 'Zone: %1$s. Method: %2$s', 'woodmart' ),
				$zone->get_zone_name(),
				$method->get_title()
			);

			if ( $method ) {
				$output[ $method_id ] = array(
					'name'  => $method_name,
					'value' => $method_id,
				);
			}
		}

		return $output;
	}

	/**
	 * Get shipping method for select2.
	 *
	 * @return void
	 */
	public function ajax_get_shipping_method() {
		check_ajax_referer( 'xts_woo_get_shipping_method_nonce', 'security' );

		$search  = isset( $_POST['params']['term'] ) ? $_POST['params']['term'] : false; // phpcs:ignore
		$methods = array();

		foreach ( WC_Shipping_Zones::get_zones() as $zone ) {
			$zone_id     = $zone['zone_id'];
			$zone_obj    = new WC_Shipping_Zone( $zone_id );
			$all_methods = $zone_obj->get_shipping_methods( true );

			foreach ( $all_methods as $method ) {
				$method_name = sprintf(
					// translators: Shipping zone and method.
					esc_html__( 'Zone: %1$s. Method: %2$s', 'woodmart' ),
					$zone['zone_name'],
					$method->get_title()
				);

				if ( $search && ! str_contains( strtolower( $method_name ), strtolower( $search ) ) ) {
					continue;
				}

				$methods[] = array(
					'id'   => $method->get_instance_id(),
					'text' => $method_name,
				);
			}
		}

		wp_send_json( $methods );
	}

	/**
	 * Columns header.
	 *
	 * @param array $posts_columns Columns.
	 *
	 * @return array
	 */
	public function admin_columns_titles( $posts_columns ) {
		$offset = 3;

		return array_slice( $posts_columns, 0, $offset, true ) + array(
			'shipping_method' => esc_html__( 'Shipping zone and method', 'woodmart' ),
			'min'             => esc_html__( 'Minimum days', 'woodmart' ),
			'max'             => esc_html__( 'Maximum days', 'woodmart' ),
			'priority'        => esc_html__( 'Priority', 'woodmart' ),
		) + array_slice( $posts_columns, $offset, null, true );
	}

	/**
	 * Columns content.
	 *
	 * @param string $column_name Column name.
	 * @param int    $post_id     Post id.
	 *
	 * @return void
	 */
	public function admin_columns_content( $column_name, $post_id ) {
		switch ( $column_name ) {
			case 'priority':
				echo esc_html( get_post_meta( $post_id, 'est_del_priority', true ) );
				break;
			case 'min':
				$min = get_post_meta( $post_id, 'est_del_day_min', true );

				if ( empty( $min ) && '0' !== $min ) {
					echo '<span class="dashicons dashicons-minus"></span>';
					break;
				}

				echo esc_html( $min );
				break;
			case 'max':
				$max = get_post_meta( $post_id, 'est_del_day_max', true );

				if ( empty( $max ) && '0' !== $max ) {
					echo '<span class="dashicons dashicons-minus"></span>';
					break;
				}

				echo esc_html( $max );
				break;
			case 'shipping_method':
				$ids     = get_post_meta( $post_id, 'est_del_shipping_method', true );
				$data    = $this->show_current_zone( $ids );
				$content = array();

				if ( empty( $data ) ) {
					echo '<span class="dashicons dashicons-minus"></span>';
					break;
				}

				foreach ( $data as $shipping_info ) {
					$url = add_query_arg(
						array(
							'page'        => 'wc-settings',
							'tab'         => 'shipping',
							'instance_id' => $shipping_info['value'],
						),
						admin_url( 'admin.php' )
					);

					ob_start();
					?>
					<a href="<?php echo esc_url( $url ); ?>">
						<?php echo esc_html( $shipping_info['name'] ); ?>
					</a>
					<?php

					$content[] = ob_get_clean();
				}

				echo wp_kses( implode( ' | ', $content ), true );
				break;
		}
	}

	/**
	 * Helper for get est_del posts.
	 */
	public function get_est_del_posts() {
		$query = new WP_Query(
			array(
				'post_type'      => 'wd_woo_est_del',
				'meta_query'     => array( // phpcs:ignore.
					array(
						'key'     => 'est_del_shipping_method',
						'value'   => '',
						'compare' => '!=',
					),
				),
				'posts_per_page' => -1,
			)
		);

		return $query->posts;
	}

	/**
	 * This function is responsible for clearing the est_del_shipping_method metadata from wd_woo_est_del post types whenever a shipping zone is deleted.
	 * It ensures that any references to the deleted shipping zone are removed from the associated posts to maintain data integrity.
	 *
	 * @param mixed            $check Whether to go ahead with deletion.
	 * @param WC_Shipping_Zone $zone Shipping zone object.
	 * @param  bool            $force_delete Should the date be deleted permanently.
	 *
	 * @return mixed
	 */
	public function clear_shipping_method_meta_on_delete_zone( $check, $zone, $force_delete ) {
		$shipping_methods = $zone->get_shipping_methods();

		if ( $shipping_methods ) {
			$posts = $this->get_est_del_posts();

			foreach ( $shipping_methods as $method ) {
				$method_id = strval( $method->get_instance_id() );
				$rate_id   = $method->get_rate_id();

				foreach ( $posts as $post ) {
					$post_id    = $post->ID;
					$meta_value = maybe_unserialize( get_post_meta( $post_id, 'est_del_shipping_method', true ) );

					if ( is_array( $meta_value ) && in_array( $method_id, $meta_value, true ) ) {
						$new_meta_value = array_diff( $meta_value, array( $method_id ) );

						update_post_meta( $post_id, 'est_del_shipping_method', $new_meta_value );

						delete_transient( $this->manager->transient_est_del_ids );
						delete_transient( $this->manager->transient_est_del_rule . '_' . $post_id );
					}
				}

				if ( isset( WC()->session ) ) {
					$selected_shipping_method = WC()->session->get( 'chosen_shipping_methods' );

					if ( ! empty( $selected_shipping_method ) && is_array( $selected_shipping_method ) && in_array( $rate_id, $selected_shipping_method, true ) ) {
						WC()->session->set( 'chosen_shipping_methods', false );
					}
				}
			}
		}

		return $check;
	}

	/**
	 * This function handles the removal of est_del_shipping_method metadata from wd_woo_est_del post types when a specific shipping method is deleted.
	 * By doing so, it ensures that any posts referencing the deleted shipping method are properly updated to avoid data inconsistencies.
	 *
	 * @param int|string $method_id Shipping method ID.
	 * @param string     $method_key Shipping method string key, like 'free_shipping'.
	 * @param int        $zone_id Shipping zone ID.
	 */
	public function clear_shipping_method_meta_on_delete_method( $method_id, $method_key, $zone_id ) {
		$posts     = $this->get_est_del_posts();
		$method_id = strval( $method_id );

		foreach ( $posts as $post ) {
			$post_id    = $post->ID;
			$meta_value = maybe_unserialize( get_post_meta( $post_id, 'est_del_shipping_method', true ) );

			if ( is_array( $meta_value ) && in_array( $method_id, $meta_value, true ) ) {
				$new_meta_value = array_diff( $meta_value, array( $method_id ) );

				update_post_meta( $post_id, 'est_del_shipping_method', $new_meta_value );

				delete_transient( $this->manager->transient_est_del_ids );
				delete_transient( $this->manager->transient_est_del_rule . '_' . $post_id );
			}
		}

		if ( isset( WC()->session ) ) {
			$full_method_name         = $method_key . ':' . $method_id;
			$selected_shipping_method = WC()->session->get( 'chosen_shipping_methods' );

			if ( ! empty( $selected_shipping_method ) && is_array( $selected_shipping_method ) && in_array( $full_method_name, $selected_shipping_method, true ) ) {
				WC()->session->set( 'chosen_shipping_methods', false );
			}
		}
	}

	/**
	 * Add duplicate action.
	 *
	 * @param string[] $actions An array of row action links.
	 * @param WP_Post  $post The post object.
	 *
	 * @return string[]
	 */
	public function duplicate_action( $actions, $post ) {
		if ( 'wd_woo_est_del' !== $post->post_type ) {
			return $actions;
		}

		if ( current_user_can( 'edit_posts' ) ) {
			$url = wp_nonce_url(
				add_query_arg(
					array(
						'action' => 'woodmart_duplicate_post_as_draft',
						'post'   => $post->ID,
					),
					'admin.php'
				),
				'woodmart_duplicate_post_as_draft',
				'duplicate_nonce'
			);

			ob_start();
			?>
			<a href="<?php echo esc_url( $url ); ?>">
				<?php esc_html_e( 'Duplicate', 'woodmart' ); ?>
			</a>
			<?php
			$actions['duplicate'] = ob_get_clean();
		}
		return $actions;
	}
}

Admin::get_instance();
