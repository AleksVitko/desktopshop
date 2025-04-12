<?php
/**
 * Free gifts class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Free_Gifts;

use WC_Cart;
use WC_Product;
use XTS\Admin\Modules\Options;
use XTS\Singleton;
use XTS\Modules\Layouts\Main as Layouts;

/**
 * Free gifts class.
 */
class Main extends Singleton {
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
		add_action( 'init', array( $this, 'add_options' ) );

		if ( ! woodmart_woocommerce_installed() || ! woodmart_get_opt( 'free_gifts_enabled', 0 ) || woodmart_get_opt( 'free_gifts_limit', 5 ) < 1 ) {
			add_action( 'woocommerce_after_calculate_totals', array( $this, 'remove_gifts_from_cart' ) );

			return;
		}

		$this->include_files();

		$this->manager = Manager::get_instance();

		add_action( 'wp_ajax_woodmart_add_gift_product', array( $this, 'add_manual_gift_product' ) );
		add_action( 'wp_ajax_nopriv_woodmart_add_gift_product', array( $this, 'add_manual_gift_product' ) );

		add_action( 'woocommerce_before_calculate_totals', array( $this, 'change_price' ) );

		add_action( 'woocommerce_after_calculate_totals', array( $this, 'update_gifts_in_cart' ) );

		add_filter( 'woocommerce_before_mini_cart_contents', array( $this, 'cart_item_price_on_ajax' ) );

		add_filter( 'woocommerce_get_cart_contents', array( $this, 'sorting_cart_contents' ) );
	}

	/**
	 * Add options in theme settings.
	 *
	 * @return void
	 */
	public function add_options() {
		Options::add_field(
			array(
				'id'          => 'free_gifts_enabled',
				'name'        => esc_html__( 'Enable "Free gifts"', 'woodmart' ),
				'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'free_gifts_enabled.jpg" alt="">', true ),
				'description' => esc_html__( 'Turn on this option to allow customers to receive free gifts with their purchases.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'free_gifts_section',
				'default'     => '0',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 10,
				'class'       => 'xts-preset-field-disabled',
			)
		);

		Options::add_field(
			array(
				'id'       => 'free_gifts_limit',
				'name'     => esc_html__( 'Maximum Gifts in an Order', 'woodmart' ),
				'type'     => 'text_input',
				'section'  => 'free_gifts_section',
				'default'  => '5',
				'priority' => 20,
				'class'    => 'xts-preset-field-disabled',
			)
		);

		Options::add_field(
			array(
				'id'          => 'free_gifts_allow_multiple_identical_gifts',
				'name'        => esc_html__( 'Allow adding multiple identical gifts', 'woodmart' ),
				'description' => esc_html__( 'If enabled, the user can add the same product to the cart multiple times. It works if the "Manual Gifts" rule is selected for the gift.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'free_gifts_section',
				'default'     => '0',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 25,
				'class'       => 'xts-preset-field-disabled',
			)
		);

		Options::add_field(
			array(
				'id'          => 'free_gifts_price_format',
				'name'        => esc_html__( 'Gift products price display', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'free_gifts_price_format.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Choose how to display the price of gift products, either as "Free" or "$0.00".', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'free_gifts_section',
				'options'     => array(
					'text'     => array(
						'name'  => esc_html__( '"Free" text', 'woodmart' ),
						'value' => 'text',
					),
					'discount' => array(
						'name'  => esc_html__( 'Discount to zero', 'woodmart' ),
						'value' => 'discount',
					),
				),
				'default'     => 'text',
				'priority'    => 30,
			)
		);

		Options::add_field(
			array(
				'id'       => 'free_gift_on_cart',
				'name'     => esc_html__( 'Cart', 'woodmart' ),
				'group'    => esc_html__( 'Locations', 'woodmart' ),
				'type'     => 'switcher',
				'section'  => 'free_gifts_section',
				'default'  => true,
				'on-text'  => esc_html__( 'On', 'woodmart' ),
				'off-text' => esc_html__( 'Off', 'woodmart' ),
				'priority' => 40,
				'class'    => 'xts-col-12',
			)
		);

		Options::add_field(
			array(
				'id'          => 'free_gifts_table_location',
				'name'        => esc_html__( 'Cart free gifts table position', 'woodmart' ),
				'description' => esc_html__( 'Select the placement of the free gifts table on the cart page, either before or after the listed products.', 'woodmart' ),
				'type'        => 'buttons',
				'group'       => esc_html__( 'Locations', 'woodmart' ),
				'section'     => 'free_gifts_section',
				'options'     => array(
					'woocommerce_before_cart_table' => array(
						'name'  => esc_html__( 'Before cart table', 'woodmart' ),
						'value' => 'woocommerce_before_cart_table',
					),
					'woocommerce_after_cart_table'  => array(
						'name'  => esc_html__( 'After cart table', 'woodmart' ),
						'value' => 'woocommerce_after_cart_table',
					),
				),
				'default'     => 'woocommerce_after_cart_table',
				'priority'    => 50,
				'class'       => 'xts-col-12',
				'requires'    => array(
					array(
						'key'     => 'free_gift_on_cart',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'       => 'free_gift_on_checkout',
				'name'     => esc_html__( 'Checkout', 'woodmart' ),
				'group'    => esc_html__( 'Locations', 'woodmart' ),
				'type'     => 'switcher',
				'section'  => 'free_gifts_section',
				'default'  => false,
				'on-text'  => esc_html__( 'On', 'woodmart' ),
				'off-text' => esc_html__( 'Off', 'woodmart' ),
				'priority' => 60,
				'class'    => 'xts-col-12',
			)
		);
	}

	/**
	 * Include files.
	 *
	 * @return void
	 */
	public function include_files() {
		$files = array(
			'class-manager',
			'class-admin',
			'class-frontend',
		);

		foreach ( $files as $file ) {
			require_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/woocommerce/modules/free-gifts/' . $file . '.php' );
		}
	}

	/**
	 * Add manual gift product.
	 *
	 * @return void
	 */
	public function add_manual_gift_product() {
		$product_id  = ! empty( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
		$is_checkout = ! empty( $_POST['is_checkout'] ) ? boolval( $_POST['is_checkout'] ) : false;

		check_ajax_referer( 'wd_free_gift_' . $product_id, 'security' );

		if ( empty( $product_id ) ) {
			wp_send_json_error(
				array(
					'error' => esc_html__( 'Cannot process action', 'woodmart' ),
				)
			);
		}

		if ( $this->manager->get_gifts_in_cart_count() >= woodmart_get_opt( 'free_gifts_limit', 5 ) ) {
			if ( ! wc_has_notice( $this->manager->get_notices( 'free_gifts_limit' ), 'error' ) ) {
				wc_add_notice( $this->manager->get_notices( 'free_gifts_limit' ), 'error' );
			}

			wp_send_json_error();
		}

		$variation_id = ! empty( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : 0;

		if ( ! empty( $variation_id ) ) {
			$product_id = $variation_id;
		}

		if ( ! woodmart_get_opt( 'free_gifts_allow_multiple_identical_gifts' ) && $this->manager->check_is_gift_in_cart( $product_id ) ) {
			if ( ! wc_has_notice( $this->manager->get_notices( 'already_added' ), 'error' ) ) {
				wc_add_notice( $this->manager->get_notices( 'already_added' ), 'error' );
			}

			wp_send_json_error();
		}

		if ( ! $is_checkout && ! wc_has_notice( $this->manager->get_notices( 'added_successfully' ) ) && wc_get_product( $product_id )->is_in_stock() ) {
			wc_add_notice( $this->manager->get_notices( 'added_successfully' ) );
		}

		WC()->cart->add_to_cart(
			$product_id,
			1,
			0,
			array(),
			array(
				'wd_is_free_gift' => true,
			)
		);

		wp_send_json_success();
	}

	/**
	 * Change price.
	 *
	 * @param WC_Cart $cart_object WC_Cart instance.
	 *
	 * @return void
	 */
	public function change_price( $cart_object ) {
		if ( 0 === $this->manager->get_gifts_in_cart_count() ) {
			return;
		}

		foreach ( $cart_object->get_cart() as $cart_item_key => $cart_item ) {
			if ( ! isset( $cart_item['wd_is_free_gift'] ) ) {
				continue;
			}

			if ( $cart_item['quantity'] > 1 && ! woodmart_get_opt( 'free_gifts_allow_multiple_identical_gifts' ) ) {
				$cart_object->set_quantity( $cart_item_key, 1 );
			}

			$free_gift_product = $cart_item['data'];
			$price             = apply_filters( 'woodmart_free_gift_set_product_cart_price', 0, $cart_item );

			$free_gift_product->set_price( $price );
		}
	}

	/**
	 * When option is disabled we need remove all gifts from cart.
	 * 
	 * @param WC_Cart $cart_object WC_Cart instance.
	 */
	public function remove_gifts_from_cart( $cart_object ) {
		if ( woodmart_get_opt( 'free_gifts_enabled', 0 ) || did_action( 'woocommerce_after_calculate_totals' ) > 1 ) {
			return;
		}

		foreach ( $cart_object->get_cart() as $cart_item_key => $cart_item ) {
			if ( ! isset( $cart_item['wd_is_free_gift'] ) ) {
				continue;
			}

			unset( $cart_object->cart_contents[ $cart_item_key ] );
		}
	}

	/**
	 * Update gifts in cart. Remove gifts that are no longer eligible to be in the cart. Add automatic gifts.
	 *
	 * @return void
	 */
	public function update_gifts_in_cart() {
		if ( did_action( 'woocommerce_after_calculate_totals' ) > 1 ) {
			return;
		}

		$cart_object     = WC()->cart;
		$totals          = $cart_object->get_totals();
		$gifts_rules     = $this->manager->get_rules();
		$checked_gifts   = array();
		$automatic_gifts = array();

		if ( empty( $totals['total'] ) || empty( $gifts_rules ) || ! woodmart_get_opt( 'free_gifts_enabled', 0 ) ) {
			foreach ( $cart_object->get_cart() as $cart_item_key => $cart_item ) {
				if ( ! isset( $cart_item['wd_is_free_gift'] ) ) {
					continue;
				}

				unset( $cart_object->cart_contents[ $cart_item_key ] );
			}

			return;
		}

		if ( defined( 'WCML_VERSION' ) ) {
			foreach ( $gifts_rules as $post_id => $rule ) {
				if ( empty( $rule['free_gifts'] ) ) {
					continue;
				}

				foreach ( $rule['free_gifts'] as $key => $free_gift_id ) {
					$gifts_rules[ $post_id ]['free_gifts'][ $key ] = apply_filters( 'wpml_object_id', $free_gift_id, 'product', true, apply_filters( 'wpml_current_language', null ) );
				}
			}
		}

		$gifts_rules = array_filter(
			$gifts_rules,
			function ( $rule ) use ( $totals ) {
				$cart_price = $totals['subtotal'];

				if ( isset( $rule['free_gifts_cart_price_type'] ) && in_array( $rule['free_gifts_cart_price_type'], array( 'subtotal', 'total' ), true ) ) {
					$cart_price = $totals[ $rule['free_gifts_cart_price_type'] ];
				}

				return ! empty( $rule['free_gifts'] ) && $this->manager->check_free_gifts_totals( $rule, $cart_price );
			}
		);

		$gifts_rules = array_map(
			function ( $rule ) {
				foreach ( $rule['free_gifts'] as $key => $gifts_id ) {
					$rule['free_gifts'][ $key ] = intval( $gifts_id );

					if ( ! ( wc_get_product( $gifts_id ) )->is_in_stock() ) {
						unset( $rule['free_gifts'][ array_search( $gifts_id, $rule['free_gifts'], true ) ] );
					}
				}

				return $rule;
			},
			$gifts_rules
		);

		$gift_count = 0;

		foreach ( $cart_object->get_cart() as $cart_item_key => $cart_item ) {
			if ( $gift_count > woodmart_get_opt( 'free_gifts_limit', 5 ) ) {
				break;
			} else {
				if ( ! isset( $cart_item['wd_is_free_gift'] ) ) {
					$product = $cart_item['data'];

					foreach ( $gifts_rules as $gift_rule ) {
						if ( ! $this->manager->check_free_gifts_condition( $gift_rule, $product ) ) {
							continue;
						}

						if ( 'automatic' === $gift_rule['free_gifts_rule_type'] ) {
							$automatic_gifts = array_merge( $automatic_gifts, $gift_rule['free_gifts'] );
						}

						$checked_gifts = array_merge( $checked_gifts, $gift_rule['free_gifts'] );
					}
				} else {
					++$gift_count;
				}
			}
		}

		$gift_count = 0;

		foreach ( $cart_object->get_cart() as $cart_item_key => $cart_item ) {
			if ( ! isset( $cart_item['wd_is_free_gift'] ) ) {
				continue;
			}

			++$gift_count;

			$gift_product    = $cart_item['data'];
			$gift_product_id = $gift_product->get_id();

			$unique_gift_ids = array_unique( array_merge( ...array_column( $gifts_rules, 'free_gifts' ) ) );

			if ( $gift_count > woodmart_get_opt( 'free_gifts_limit', 5 ) || ! $gift_product->is_in_stock() || empty( $gifts_rules ) || ! in_array( $gift_product_id, $unique_gift_ids, true ) ) {
				unset( $cart_object->cart_contents[ $cart_item_key ] );
				continue;
			}

			if ( ! in_array( $gift_product_id, $checked_gifts, true ) ) {
				unset( $cart_object->cart_contents[ $cart_item_key ] );
			} elseif ( in_array( $gift_product_id, $automatic_gifts, true ) ) {
				unset( $automatic_gifts[ array_search( $gift_product_id, $automatic_gifts, true ) ] );
			}
		}

		if ( $gift_count < woodmart_get_opt( 'free_gifts_limit', 5 ) && ! empty( $automatic_gifts ) ) {
			$gift_count = 0;

			foreach ( $automatic_gifts as $gift_id ) {
				++$gift_count;

				if ( $gift_count > woodmart_get_opt( 'free_gifts_limit', 5 ) ) {
					break;
				}

				$cart_object->add_to_cart(
					$gift_id,
					1,
					0,
					array(),
					array(
						'wd_is_free_gift'           => true,
						'wd_is_free_gift_automatic' => true,
					)
				);
			}
		}
	}

	/**
	 * Gets sorted cart contents.
	 *
	 * @param array $cart_contents List of cart items.
	 *
	 * @return array
	 */
	public function sorting_cart_contents( $cart_contents ) {
		uasort( $cart_contents, array( $this, 'sort_data' ) );

		return $cart_contents;
	}

	/**
	 * Sort the products so that gifts are at the end of the list.
	 *
	 * @param array $a First array.
	 * @param array $b Next array.
	 *
	 * @return int
	 */
	private function sort_data( $a, $b ) {
		$a_is_gift = isset( $a['wd_is_free_gift'] );
		$b_is_gift = isset( $b['wd_is_free_gift'] );

		if ( $a_is_gift && $b_is_gift ) {
			return 0;
		}

		return ! $a_is_gift ? -1 : 1;
	}

	/**
	 * Update price in mini cart on get_refreshed_fragments action.
	 *
	 * @codeCoverageIgnore
	 * @return void
	 */
	public function cart_item_price_on_ajax() {
		if ( apply_filters( 'woodmart_do_not_recalulate_total_on_get_refreshed_fragments', false ) ) {
			return;
		}

		if ( wp_doing_ajax() && ! empty( $_GET['wc-ajax'] ) && 'get_refreshed_fragments' === $_GET['wc-ajax'] ) { // phpcs:ignore.
			WC()->cart->calculate_totals();
			WC()->cart->set_session();
			WC()->cart->maybe_set_cart_cookies();
		}
	}
}

Main::get_instance();
