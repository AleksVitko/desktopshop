<?php
/**
 * Frontend class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Waitlist;

use XTS\Singleton;
use XTS\Modules\Layouts\Main as Layouts;
use WC_Product;
use WC_Product_Variable;

/**
 * Frontend class.
 */
class Frontend extends Singleton {
	/**
	 * Instance of DB_Storage class.
	 *
	 * @var DB_Storage $db_storage - Instance of DB_Storage class.
	 */
	private $db_storage;

	/**
	 * Constructor.
	 */
	public function init() {
		$this->db_storage = DB_Storage::get_instance();

		add_action( 'wp', array( $this, 'add_output_waitlist_subscribe_form' ), 100 );

		add_action( 'wp_ajax_woodmart_update_form_data', array( $this, 'update_form_data' ) );
		add_action( 'wp_ajax_nopriv_woodmart_update_form_data', array( $this, 'update_form_data' ) );

		add_action( 'wp_ajax_woodmart_add_to_waitlist', array( $this, 'add_to_waitlist' ) );
		add_action( 'wp_ajax_nopriv_woodmart_add_to_waitlist', array( $this, 'add_to_waitlist' ) );

		add_action( 'wp_ajax_woodmart_remove_from_waitlist', array( $this, 'remove_from_waitlist_action' ) );
		add_action( 'wp_ajax_nopriv_woodmart_remove_from_waitlist', array( $this, 'remove_from_waitlist_action' ) );

		add_action( 'wp_login', array( $this, 'set_user_id_in_waitlists' ), 10, 2 );

		// Waitlist in my account page.
		if ( is_user_logged_in() ) {
			add_filter( 'woocommerce_account_menu_items', array( $this, 'add_menu_item' ), 10, 1 );
			add_action( 'woocommerce_account_waitlist_endpoint', array( $this, 'account_template' ) );

			add_action( 'wp_ajax_woodmart_remove_from_waitlist_in_my_account', array( $this, 'remove_from_waitlist_in_my_account_action' ) );
		}
	}

	/**
	 * Show the form in Elementor edit mode. This method is used in Elemetor widgets.
	 *
	 * @codeCoverageIgnore
	 */
	public function render_waitlist_subscribe_form_on_elementor_edit_page() {
		global $product;

		$is_elemntor_edit = woodmart_is_elementor_installed() && ( woodmart_elementor_is_edit_mode() || woodmart_elementor_is_preview_page() || woodmart_elementor_is_preview_mode() );

		if ( ! $is_elemntor_edit || ( woodmart_get_opt( 'waitlist_for_loggined' ) && ! is_user_logged_in() ) ) {
			return;
		}

		$form_data = $this->get_simple_form_data( $product );

		if ( empty( $form_data ) ) {
			return;
		}

		$state = 'always_open' === woodmart_get_opt( 'waitlist_form_state', 'current_state' ) ? 'not-signed' : $form_data['state'];

		wc_get_template( 'single-product/wtl-form-' . $state . '.php', array( 'data' => $form_data ) );
	}

	/**
	 * Add render actions if single product build is disable.
	 */
	public function add_output_waitlist_subscribe_form() {
		if ( Layouts::get_instance()->has_custom_layout( 'single_product' ) ) {
			return;
		}

		add_action( 'woocommerce_single_product_summary', array( $this, 'render_waitlist_subscribe_form' ), 30 );
		add_action( 'woodmart_before_wp_footer', array( $this, 'render_template_subscribe_form' ) );
	}

	/**
	 * Enqueue form styles and scripts and render first form state for simple product.
	 *
	 * @codeCoverageIgnore
	 */
	public function render_waitlist_subscribe_form() {
		global $product;

		$is_elemntor_edit = woodmart_is_elementor_installed() && ( woodmart_elementor_is_edit_mode() || woodmart_elementor_is_preview_page() || woodmart_elementor_is_preview_mode() );

		if (
			! woodmart_get_opt( 'waitlist_enabled' ) ||
			( woodmart_get_opt( 'waitlist_for_loggined' ) && ! is_user_logged_in() ) ||
			( ! is_product() && ! $is_elemntor_edit ) ||
			! $product instanceof WC_Product ||
			woodmart_loop_prop( 'is_quick_view' ) ||
			! in_array( $product->get_type(), array( 'simple', 'variable', 'subscription', 'variable-subscription' ), true ) ||
			( $this->is_variable_product( $product ) && empty( $product->get_children() ) )
		) {
			return;
		}

		if ( $this->is_variable_product( $product ) ) {
			$form_data = $this->get_variable_form_data( $product );
		} else {
			$form_data = $this->get_simple_form_data( $product );
		}

		if ( empty( $form_data ) ) {
			return;
		}

		woodmart_enqueue_inline_style( 'woo-opt-wtl' );

		if ( ! $is_elemntor_edit ) {
			woodmart_enqueue_js_script( 'waitlist-subscribe-form' );
			wp_localize_script( 'wd-waitlist-subscribe-form', 'wtl_form_data', $form_data );
		}

		if ( $this->is_simple_product( $product ) ) {
			$state = 'always_open' === woodmart_get_opt( 'waitlist_form_state', 'current_state' ) && ! woodmart_get_opt( 'waitlist_fragments_enable' ) ? 'not-signed' : $form_data['state'];

			wc_get_template( 'single-product/wtl-form-' . $state . '.php', array( 'data' => $form_data ) );
		}
	}

	/**
	 * Render form templates.
	 *
	 * @codeCoverageIgnore
	 */
	public function render_template_subscribe_form() {
		global $product;

		$is_elemntor_edit = woodmart_is_elementor_installed() && ( woodmart_elementor_is_edit_mode() || woodmart_elementor_is_preview_page() || woodmart_elementor_is_preview_mode() );

		if (
			! woodmart_get_opt( 'waitlist_enabled' ) ||
			( woodmart_get_opt( 'waitlist_for_loggined' ) && ! is_user_logged_in() ) ||
			( ! is_product() && ! $is_elemntor_edit ) ||
			! $product instanceof WC_Product ||
			! $this->is_variable_product( $product ) ||
			woodmart_loop_prop( 'is_quick_view' ) ||
			( $this->is_variable_product( $product ) && empty( $product->get_children() ) )
		) {
			return;
		}

		wc_get_template( 'single-product/wtl-form-signed.php' );
		wc_get_template( 'single-product/wtl-form-not-signed.php' );
	}

	/**
	 * Get actual data for render form.
	 */
	public function update_form_data() {
		$product_id        = ! empty( $_GET['product_id'] ) ? absint( $_GET['product_id'] ) : 0;
		$origin_product_id = $product_id;

		if ( defined( 'WCML_VERSION' ) && defined( 'ICL_SITEPRESS_VERSION' ) ) {
			$origin_product_id = apply_filters( 'wpml_object_id', $product_id, 'product', true, wpml_get_default_language() );
		}

		$product = wc_get_product( $product_id );

		if ( empty( $product_id ) || ! $product instanceof WC_Product ) {
			wp_send_json_error(
				array(
					'notice' => esc_html__( 'There is no product.', 'woodmart' ),
				)
			);
			die();
		}

		$signed_ids = array();

		if ( $this->is_variable_product( $product ) && is_user_logged_in() ) {
			$signed_ids = array_values( // Use array_values ​​to reindex the array so that the response data has an array type.
				array_filter(
					$product->get_children(),
					function ( $children_id ) {
						$children = wc_get_product( $children_id );

						if ( ! $children instanceof WC_Product ) {
							return false;
						}

						return ! $children->is_in_stock() && $this->check_is_user_in_waitlist( $children );
					}
				)
			);

			$response = array(
				'global'     => $this->get_global_form_data(),
				'signed_ids' => $signed_ids,
			);

			wp_send_json_success( $response );
		} elseif ( $this->check_is_user_in_waitlist( $product ) ) {
			$form_data = $this->get_simple_form_data( $product );

			ob_start();
			wc_get_template( 'single-product/wtl-form-signed.php', array( 'data' => $form_data ) );
			$response['content'] = ob_get_clean();

			wp_send_json_success( $response );
		}

		if ( empty( $signed_ids ) ) {
			wp_send_json_success();
			die();
		}
	}

	/**
	 * Add to waitlist ajax action.
	 */
	public function add_to_waitlist() {
		$product_id     = ! empty( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		$email_language = '';

		if ( defined( 'WCML_VERSION' ) && defined( 'ICL_SITEPRESS_VERSION' ) ) {
			$product_id     = apply_filters( 'wpml_object_id', $product_id, 'product', true, wpml_get_default_language() );
			$email_language = apply_filters( 'wpml_current_language', null );
		}

		$product    = wc_get_product( $product_id );
		$user_email = ! empty( $_POST['user_email'] ) ? sanitize_email( wp_unslash( $_POST['user_email'] ) ) : '';

		if ( empty( $product_id ) || ! $product instanceof WC_Product ) {
			wp_send_json_error(
				array(
					'notice' => esc_html__( 'There is no product.', 'woodmart' ),
				)
			);
			die();
		}

		if ( empty( $user_email ) || ! is_email( $user_email ) ) {
			wp_send_json_error(
				array(
					'notice' => esc_html__( 'You must provide a valid email address to join the waitlist for this product.', 'woodmart' ),
				)
			);
			die();
		}

		if ( $this->db_storage->check_subscription_exists_by_email( $product, $user_email ) ) {
			wp_send_json_error(
				array(
					'notice' => esc_html__( 'This email is already registered in the waitlist for this product.', 'woodmart' ),
				)
			);
			die();
		}

		if ( is_user_logged_in() && $this->db_storage->check_subscription_exists_by_user_id( $product, get_current_user_id() ) ) {
			wp_send_json_error(
				array(
					'notice' => esc_html__( 'You cannot register more than one email for one product.', 'woodmart' ),
				)
			);
			die();
		}

		if ( $this->db_storage->create_subscription( $user_email, $product, $email_language ) ) {
			if ( ! is_user_logged_in() ) {
				$waitlist                   = $this->db_storage->get_subscription( $product, $user_email );
				$unsubscribe_token          = $waitlist->unsubscribe_token;
				$cookie_data                = woodmart_get_cookie( 'woodmart_waitlist_unsubscribe_tokens' ) ? json_decode( woodmart_get_cookie( 'woodmart_waitlist_unsubscribe_tokens' ), true ) : array();
				$cookie_data[ $product_id ] = $unsubscribe_token;

				woodmart_set_cookie( 'woodmart_waitlist_unsubscribe_tokens', wp_json_encode( $cookie_data ) );
			}

			$response = array(
				'state' => 'signed',
			);

			if ( $this->is_simple_product( $product ) ) {
				$form_data = $this->get_simple_form_data( $product );

				ob_start();
				wc_get_template( 'single-product/wtl-form-signed.php', array( 'data' => $form_data ) );
				$response['content'] = ob_get_clean();
			}

			$mailer                     = WC()->mailer();
			$confirm_subscription_email = $mailer->emails['XTS_Email_Waitlist_Confirm_Subscription'];

			if ( $confirm_subscription_email->is_enabled() && ( 'all' === $confirm_subscription_email->get_option( 'send_to' ) || ! is_user_logged_in() ) ) {
				do_action( 'woodmart_waitlist_send_confirm_subscription_email', $user_email, $product, $email_language );

				$response['notice']        = esc_html__( 'Please, confirm your subscription to the waitlist through the email that we have just sent to you.', 'woodmart' );
				$response['notice_status'] = 'warning';
			} else {
				do_action( 'woodmart_waitlist_send_subscribe_email', $user_email, $product, $email_language );

				$this->db_storage->update_waitlist_data( $product, $user_email, array( 'confirmed' => 1 ) );
			}

			wp_send_json_success( $response );
			die();
		}

		wp_send_json_error(
			array(
				'notice' => esc_html__( 'Could not add product to waitlist.', 'woodmart' ),
			)
		);
		die();
	}

	/**
	 * Remove from waitlist action on single product page.
	 */
	public function remove_from_waitlist_action() {
		$unsubscribe_token = ! empty( $_POST['unsubscribe_token'] ) ? $_POST['unsubscribe_token'] : '';
		$product_id        = ! empty( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;

		if ( defined( 'WCML_VERSION' ) && defined( 'ICL_SITEPRESS_VERSION' ) ) {
			$product_id = apply_filters( 'wpml_object_id', $product_id, 'product', true, wpml_get_default_language() );
		}

		$product = wc_get_product( $product_id );
		$data    = array();

		if ( empty( $product_id ) || ! $product instanceof WC_Product ) {
			wp_send_json_error(
				array(
					'notice' => esc_html__( 'There is no product.', 'woodmart' ),
				)
			);
			die();
		}

		$response = array(
			'state' => 'not-signed',
		);

		if ( $this->is_simple_product( $product ) ) {
			$form_data = $this->get_simple_form_data( $product );

			ob_start();
			wc_get_template( 'single-product/wtl-form-not-signed.php', array( 'data' => $form_data ) );
			$response['content'] = ob_get_clean();
		}

		if ( ( is_user_logged_in() && $this->db_storage->unsubscribe_current_user( $product ) ) || ( ! is_user_logged_in() && $unsubscribe_token && $this->db_storage->unsubscribe_by_token( $unsubscribe_token ) ) ) {
			$cookie_data = woodmart_get_cookie( 'woodmart_waitlist_unsubscribe_tokens' ) ? json_decode( woodmart_get_cookie( 'woodmart_waitlist_unsubscribe_tokens' ), true ) : array();

			if ( ! empty( $cookie_data ) && in_array( $product_id, array_keys( $cookie_data ), true ) ) {
				unset( $cookie_data[ $product_id ] );

				woodmart_set_cookie( 'woodmart_waitlist_unsubscribe_tokens', wp_json_encode( $cookie_data ) );
			}

			wp_send_json_success( $response );
			die();
		}

		wp_send_json_error(
			array(
				'notice' => esc_html__( 'Could not remove product from waitlist.', 'woodmart' ),
			)
		);
		die();
	}

	/**
	 * Set user id in waitlists after the user has successfully logged in.
	 *
	 * @param string  $user_login User login.
	 * @param WP_User $user Instance of WP_User class.
	 *
	 * @return void
	 */
	public function set_user_id_in_waitlists( $user_login, $user ) {
		global $wpdb;

		$cookie_data = woodmart_get_cookie( 'woodmart_waitlist_unsubscribe_tokens' ) ? json_decode( woodmart_get_cookie( 'woodmart_waitlist_unsubscribe_tokens' ), true ) : array();

		if ( empty( $cookie_data ) ) {
			return;
		}

		foreach ( $cookie_data as $product_id => $unsubscribe_token ) {
			$product = wc_get_product( $product_id );

			if ( $this->db_storage->check_subscription_exists_by_user_id( $product, $user->ID ) ) {
				break;
			}

			$wpdb->update( // phpcs:ignore.
				$wpdb->wd_waitlists,
				array( 'user_id' => $user->ID ),
				array( 'unsubscribe_token' => $unsubscribe_token )
			);
		}
	}

	/**
	 * Get list of out of stock variations.
	 *
	 * @param WC_Product_Variable $product Parent variable product.
	 *
	 * @return array
	 */
	public function get_out_of_stock_variations_ids( $product ) {
		$out_of_stock_ids = array();

		$out_of_stock_ids = array_filter(
			$product->get_children(),
			function ( $children_id ) {
				$children = wc_get_product( $children_id );

				if ( ! $children instanceof WC_Product ) {
					return false;
				}

				return ! $children->is_in_stock();
			}
		);

		return $out_of_stock_ids;
	}

	/**
	 * Get global form data. This data will be used for all variations on simple products.
	 *
	 * @return array
	 */
	public function get_global_form_data() {
		return array(
			'email'               => wp_get_current_user()->get( 'user_email' ),
			'fragments_enable'    => 'always_open' === woodmart_get_opt( 'waitlist_form_state', 'current_state' ) && woodmart_get_opt( 'waitlist_fragments_enable' ),
			'policy_check_notice' => esc_html__( 'You must accept our Privacy Policy to join the waitlist.', 'woodmart' ),
			'is_user_logged_in'   => is_user_logged_in(),
		);
	}

	/**
	 * Get variable form data. This data will be used for only variations products.
	 *
	 * @param WC_Product $product Product Object.
	 *
	 * @return array Multidimensional array that includes global forms and all variations products status data.
	 */
	public function get_variable_form_data( $product ) {
		$wtl_form_data    = array();
		$out_of_stock_ids = $this->get_out_of_stock_variations_ids( $product );

		if ( empty( $out_of_stock_ids ) ) {
			return array();
		}

		foreach ( $out_of_stock_ids as $product_id ) {
			$origin_product_id = $product_id;

			if ( defined( 'WCML_VERSION' ) && defined( 'ICL_SITEPRESS_VERSION' ) ) {
				$origin_product_id = apply_filters( 'wpml_object_id', $product_id, 'product', true, wpml_get_default_language() );
			}

			$variation_product   = wc_get_product( $origin_product_id );
			$is_user_in_waitlist = $this->check_is_user_in_waitlist( $variation_product );

			if ( ! wp_doing_ajax() && 'always_open' === woodmart_get_opt( 'waitlist_form_state', 'current_state' ) ) {
				$is_user_in_waitlist = false;
			}

			$wtl_form_data[ $product_id ] = array(
				'product_id' => $product_id,
				'state'      => $is_user_in_waitlist ? 'signed' : 'not-signed',
			);
		}

		return array(
			'global' => $this->get_global_form_data(),
		) + $wtl_form_data;
	}

	/**
	 * Get simple form data. This data will be used for only simple products.
	 *
	 * @param WC_Product $product Product Object.
	 *
	 * @return array One-dimensional array that includes global forms and product status data.
	 */
	public function get_simple_form_data( $product ) {
		if ( ( $this->is_variable_product( $product ) && empty( $this->get_out_of_stock_variations_ids( $product ) ) || ( $this->is_simple_product( $product ) && $product->is_in_stock() ) ) ) {
			return array();
		}

		return $this->get_global_form_data() + array(
			'product_id' => $product->get_id(),
			'state'      => $this->check_is_user_in_waitlist( $product ) ? 'signed' : 'not-signed',
		);
	}

	/**
	 * Check whether the user has a subscription to this product.If this is not a devoured user, then check if his data is in cookie.
	 *
	 * @param WC_Product $product Product Object.
	 *
	 * @return bool
	 */
	public function check_is_user_in_waitlist( $product ) {
		if ( is_user_logged_in() ) {
			return $this->db_storage->check_subscription_exists_by_user_id( $product, get_current_user_id() );
		} else {
			$cookie_data = woodmart_get_cookie( 'woodmart_waitlist_unsubscribe_tokens' ) ? json_decode( woodmart_get_cookie( 'woodmart_waitlist_unsubscribe_tokens' ), true ) : array();

			if ( empty( $cookie_data ) ) {
				return false;
			}

			$product_id = $product->get_id();

			if ( defined( 'WCML_VERSION' ) && defined( 'ICL_SITEPRESS_VERSION' ) ) {
				$product_id = apply_filters( 'wpml_object_id', $product_id, 'product', true, wpml_get_default_language() );
			}

			if ( in_array( $product_id, array_keys( $cookie_data ), true ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Add menu item for standard wc account navigation.
	 *
	 * @param array $items My Account menu items.
	 *
	 * @return array
	 */
	public function add_menu_item( $items ) {
		$new_items = array();

		if ( ! is_array( $items ) ) {
			return $items;
		}

		$items_keys = array_keys( $items );
		$last_key   = end( $items_keys );

		foreach ( $items as $key => $value ) {
			if ( $key === $last_key ) {
				$new_items['waitlist'] = esc_html__( 'Waitlist', 'woodmart' );
			}

			$new_items[ $key ] = $value;
		}

		return $new_items;
	}

	/**
	 * Waitlist template.
	 *
	 * @codeCoverageIgnore
	 */
	public function account_template() {
		$big          = 999999999; // Need an unlikely integer.
		$per_page     = apply_filters( 'woodmart_waitlist_per_page', 12 );
		$current      = max( 1, get_query_var( 'paged' ) );
		$data_count   = $this->db_storage->get_subscription_count_for_current_user();
		$num_of_pages = $data_count > 0 && $per_page > 0 ? ceil( $data_count / $per_page ) : 1;

		$paginate_args = array(
			'base'    => str_replace( $big, '%#%', get_pagenum_link( $big, false ) ),
			'format'  => '?paged=%#%',
			'current' => $current,
			'total'   => $num_of_pages,
		);

		woodmart_set_loop_prop( 'shop_pagination', 'links' );

		woodmart_enqueue_js_library( 'tooltips' );
		woodmart_enqueue_js_script( 'btns-tooltips' );
		woodmart_enqueue_js_script( 'waitlist-table' );

		wc_get_template(
			'myaccount/waitlist.php',
			array(
				'data'          => $this->db_storage->get_subscriptions_user_id( get_current_user_id(), $current ),
				'paginate_args' => $paginate_args,
			)
		);
	}

	/**
	 * Remove from waitlist action on my account page.
	 */
	public function remove_from_waitlist_in_my_account_action() {
		$product_id = ! empty( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;

		if ( defined( 'WCML_VERSION' ) && defined( 'ICL_SITEPRESS_VERSION' ) ) {
			$product_id = apply_filters( 'wpml_object_id', $product_id, 'product', true, wpml_get_default_language() );
		}

		$product = wc_get_product( $product_id );

		if ( empty( $product_id ) || ! $product instanceof WC_Product ) {
			wp_send_json_error(
				array(
					'notice' => esc_html__( 'There is no product.', 'woodmart' ),
				)
			);
		}

		if ( $this->db_storage->unsubscribe_current_user( $product ) ) {
			$content     = '';
			$cookie_data = woodmart_get_cookie( 'woodmart_waitlist_unsubscribe_tokens' ) ? json_decode( woodmart_get_cookie( 'woodmart_waitlist_unsubscribe_tokens' ), true ) : array();

			if ( ! empty( $cookie_data ) && in_array( $product_id, array_keys( $cookie_data ), true ) ) {
				unset( $cookie_data[ $product_id ] );

				woodmart_set_cookie( 'woodmart_waitlist_unsubscribe_tokens', wp_json_encode( $cookie_data ) );
			}

			if ( ! $this->db_storage->get_subscription_count_for_current_user() ) {
				ob_start();

				wc_get_template(
					'myaccount/waitlist.php',
					array(
						'data' => false,
					)
				);

				$content = ob_get_clean();
			}

			wp_send_json_success(
				array(
					'content' => $content,
				)
			);
		}

		wp_send_json_error(
			array(
				'notice' => esc_html__( 'Could not remove product from waitlist.', 'woodmart' ),
			)
		);
	}

	/**
	 * Сheck whether this product can be considered simple.
	 *
	 * @param WC_Product $product Product Object.
	 *
	 * @return bool
	 */
	public function is_simple_product( $product ) {
		return in_array( $product->get_type(), array( 'simple', 'subscription' ), true );
	}

	/**
	 * Сheck whether this product can be considered variable.
	 *
	 * @param WC_Product $product Product Object.
	 *
	 * @return bool
	 */
	public function is_variable_product( $product ) {
		return in_array( $product->get_type(), array( 'variable', 'variable-subscription' ), true );
	}
}

Frontend::get_instance();
