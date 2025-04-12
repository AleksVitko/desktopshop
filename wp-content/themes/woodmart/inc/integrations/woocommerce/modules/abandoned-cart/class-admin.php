<?php
/**
 * Admin class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Abandoned_Cart;

use WP_User_Query;
use XTS\Singleton;
use XTS\Modules\Abandoned_Cart\Abandoned_Cart;
use XTS\Modules\Abandoned_Cart\List_Table\Abandoned_Cart_Table;
use XTS\Modules\Abandoned_Cart\List_Table\Cart_Content_Table;
use WC_Tax;

/**
 * Admin class.
 */
class Admin extends Singleton {
	/**
	 * Post type name
	 *
	 * @var string
	 */
	public $post_type_name;

	/**
	 * Constructor.
	 */
	public function init() {
		$this->include_files();

		$this->post_type_name = Abandoned_Cart::get_instance()->post_type_name;

		add_action( 'init', array( $this, 'delete_abandoned_cart' ) );

		add_action( 'admin_menu', array( $this, 'register_abandoned_cart_page' ) );

		add_filter( 'set-screen-option', array( $this, 'set_screen_option' ), 10, 3 );

		// Single cart post.
		add_action( 'add_meta_boxes_' . $this->post_type_name, array( $this, 'add_metaboxes' ) );

		add_filter( 'screen_layout_columns', array( $this, 'set_screen_columns' ) );

		add_filter( 'get_user_option_screen_layout_' . $this->post_type_name, array( $this, 'return_one' ) ); // Setting the layout to 1 column directly.

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Include files.
	 */
	private function include_files() {
		if ( ! class_exists( 'WP_List_Table' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
		}

		$files = array(
			'class-abandoned-cart-table',
			'class-cart-content-table',
		);

		foreach ( $files as $file ) {
			$file_path = WOODMART_THEMEROOT . '/inc/integrations/woocommerce/modules/abandoned-cart/list-tables/' . $file . '.php';

			if ( file_exists( $file_path ) ) {
				require_once $file_path;
			}
		}
	}

	/**
	 * Register abandoned cart page on admin panel.
	 *
	 * @return void
	 */
	public function register_abandoned_cart_page() {
		global $wd_abandoned_cart_page;

		$wd_abandoned_cart_page = add_submenu_page(
			'edit.php?post_type=product',
			esc_html__( 'Abandoned carts', 'woodmart' ),
			esc_html__( 'Abandoned carts', 'woodmart' ),
			apply_filters( 'woodmart_capability_menu_page', 'edit_products', 'xts-abandoned-cart-page' ),
			'xts-abandoned-cart-page',
			array( $this, 'render_abandoned_cart_page' )
		);

		add_action( 'load-' . $wd_abandoned_cart_page, array( $this, 'abandoned_cart_screen_options' ) );
	}

	/**
	 * Render abandoned cart page on admin panel.
	 *
	 * @codeCoverageIgnore
	 */
	public function render_abandoned_cart_page() {
		$list_table = new Abandoned_Cart_Table();

		$list_table->prepare_items();
		?>
			<div class="wrap xts-wtl-page-wrap">
				<h2 class="wp-heading-inline"><?php echo esc_html__( 'Abandoned carts', 'woodmart' ); ?></h2>

				<form id="xts-abandoned-cart-settings-page-form" method="get" action="">
					<input type="hidden" name="page" value="xts-abandoned-cart-page" />
					<input type="hidden" name="post_type" value="product" />
					<?php
					$list_table->search_box( esc_html__( 'Search', 'woodmart' ), 'xts-search' );
					$list_table->display();
					?>
				</form>
			</div>
		<?php
	}

	/**
	 * Add screen options to abandoned_cart admin page.
	 */
	public function abandoned_cart_screen_options() {
		global $wd_abandoned_cart_page;

		$screen = get_current_screen();

		if ( ! is_object( $screen ) || $screen->id !== $wd_abandoned_cart_page ) {
			return;
		}

		add_screen_option(
			'per_page',
			array(
				'label'   => esc_html__( 'Number of items per page', 'woodmart' ),
				'default' => 20,
				'option'  => 'abandoned_cart_per_page',
			)
		);
	}

	/**
	 * Save screen options.
	 *
	 * @param mixed  $screen_option The value to save instead of the option value.
	 *                              Default false (to skip saving the current option).
	 * @param string $option        The option name.
	 * @param int    $value         The option value.
	 */
	public function set_screen_option( $screen_option, $option, $value ) {
		if ( 'abandoned_cart_per_page' === $option ) {
			return $value;
		}

		return $screen_option;
	}

	/**
	 * Set the number of columns for the custom post type edit screen.
	 *
	 * @param array $columns An array of columns.
	 *
	 * @return array Modified array of columns.
	 */
	public function set_screen_columns( $columns ) {
		$screen = get_current_screen();

		if ( $this->post_type_name === $screen->post_type ) {
			$columns[ $screen->id ] = 1;
		}

		return $columns;
	}

	/**
	 * Return integer 1.
	 *
	 * @return int
	 */
	public function return_one() {
		return 1;
	}

	/**
	 * Add the metaboxes to show the info of the current cart.
	 *
	 * @return void
	 */
	public function add_metaboxes() {
		remove_meta_box( 'submitdiv', $this->post_type_name, 'side' );

		add_meta_box(
			'woodmart-info-cart',
			esc_html__( 'Cart info', 'woodmart' ),
			array( $this, 'show_cart_info_metabox' ),
			$this->post_type_name,
			'normal',
			'default'
		);

		add_meta_box(
			'woodmart-cart',
			esc_html__( 'Cart content', 'woodmart' ),
			array( $this, 'show_cart_metabox' ),
			$this->post_type_name,
			'normal',
			'default'
		);
	}

	/**
	 * Metabox to show the info of the current cart.
	 *
	 * @param WP_Post $post Post.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public function show_cart_info_metabox( $post ) {
		$args = array(
			'cart_id'         => $post->ID,
			'status'          => get_post_meta( $post->ID, '_cart_status', true ),
			'last_update'     => $post->post_modified,
			'user_email'      => sanitize_email( get_post_meta( $post->ID, '_user_email', true ) ),
			'user_first_name' => sanitize_text_field( get_post_meta( $post->ID, '_user_first_name', true ) ),
			'user_last_name'  => sanitize_text_field( get_post_meta( $post->ID, '_user_last_name', true ) ),
			'user_login'      => '',
			'language'        => sanitize_text_field( get_post_meta( $post->ID, '_language', true ) ),
			'history'         => get_post_meta( $post->ID, '_emails_sent', true ),
			'currency'        => get_post_meta( $post->ID, '_user_currency', true ),
		);

		$user_id = sanitize_text_field( get_post_meta( $post->ID, '_user_id', true ) );

		if ( ! empty( $user_id ) ) {
			$user               = get_user_by( 'id', $user_id );
			$args['user_login'] = $user->user_login;
		}

		$this->get_template( 'metabox-cart-info-content', $args );
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( get_post_type() !== $this->post_type_name ) {
			return;
		}

		wp_enqueue_style( 'woocommerce_admin_styles' );
		wp_enqueue_style( 'wd-page-abandoned-cart', WOODMART_ASSETS . '/css/parts/page-abandoned-cart.min.css', array(), WOODMART_VERSION );
	}

	/**
	 * Metabox to show the content of current cart.
	 *
	 * @param WP_Post $post Post.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public function show_cart_metabox( $post ) {
		$cart       = maybe_unserialize( get_post_meta( $post->ID, '_cart', true ) );
		$list_table = new Cart_Content_Table( $cart );

		$list_table->prepare_items();
		$list_table->display();

		$tax_display_mode = get_option( 'woocommerce_tax_display_cart' );
		$currency         = get_woocommerce_currency();
		$tax_total        = 0;
		$total            = 0;

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
			$subtotal_tax     = 0;

			$tax_class = $_product->get_tax_class();
			$tax_rates = WC_Tax::get_rates( $tax_class );

			if ( ! empty( $tax_rates ) ) {
				foreach ( $tax_rates as $rate ) {
					$tax_rate = $rate['rate'] / 100;
					break;
				}

				$subtotal_tax = $_product->get_price() * $quantity * $tax_rate;
				$tax_total   += $subtotal_tax;
			}

			$total += $product_subtotal;
		}

		?>
		<table class="xts-cart-total" cellspacing="10">
			<tbody>
				<?php if ( 'excl' === $tax_display_mode ) : ?>
					<tr>
						<th>
							<?php esc_html_e( 'Cart Subtotal:', 'woodmart' ); ?>
						</th>
						<td>
							<?php echo wc_price( $total, array( 'currency' => $currency ) ); // phpcs:ignore. ?>

							<small class="tax_label">
								<?php echo esc_html( WC()->countries->ex_tax_or_vat() ); ?>
							</small>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( $tax_total && 'excl' === $tax_display_mode ) : ?>
					<tr>
						<th>
							<?php echo esc_html( WC()->countries->tax_or_vat() ); ?>
						</th>
						<td>
							<?php echo wc_price( $tax_total, array( 'currency' => $currency ) ); // phpcs:ignore. ?>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( $total ) : ?>
					<?php $total = 'excl' === $tax_display_mode ? $total + $tax_total : $total; ?>
					<tr>
						<th>
							<?php esc_html_e( 'Cart Total:', 'woodmart' ); ?>
						</th>
						<td>
							<?php echo wc_price( $total, array( 'currency' => $currency ) ); // phpcs:ignore. ?>
						</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Get template.
	 *
	 * @param string $template_name Template name.
	 * @param array  $args          Arguments for template.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public function get_template( $template_name, $args = array() ) {
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args ); // phpcs:ignore
		}

		include WOODMART_THEMEROOT . '/inc/integrations/woocommerce/modules/abandoned-cart/templates/' . $template_name . '.php';
	}

	public function delete_abandoned_cart() {
		if ( ! isset( $_GET['action'] ) || 'woodmart_delete_abandoned_cart' !== $_GET['action'] || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['security'] ) ), 'woodmart_delete_abandoned_cart' ) || empty( $_GET['cart_id'] ) ) {
			return;
		}

		$cart_id = intval( $_GET['cart_id'] ); //phpcs:ignore.

		wp_delete_post( $cart_id, true );

		wp_safe_redirect( admin_url( '/edit.php?post_type=product&page=xts-abandoned-cart-page' ) );
		die();
	}
}

Admin::get_instance();
