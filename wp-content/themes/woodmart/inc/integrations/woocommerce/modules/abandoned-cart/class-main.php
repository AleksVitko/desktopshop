<?php
/**
 * Abandoned cart class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Abandoned_Cart;

use XTS\Admin\Modules\Options;
use XTS\Singleton;

/**
 * Abandoned cart class.
 */
class Main extends Singleton {
	/**
	 * Init.
	 */
	public function init() {
		add_action( 'init', array( $this, 'add_options' ) );

		if ( ! woodmart_woocommerce_installed() || ! woodmart_get_opt( 'cart_recovery_enabled' ) ) {
			return;
		}

		$this->include_files();
	}

	/**
	 * Add options in theme settings.
	 *
	 * @return void
	 */
	public function add_options() {
		Options::add_field(
			array(
				'id'          => 'cart_recovery_enabled',
				'name'        => esc_html__( 'Enable cart recovery', 'woodmart' ),
				'description' => esc_html__( 'Reminds customers via email about items left in their cart, boosting sales by recovering potential lost purchases.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'abandoned_cart_section',
				'default'     => false,
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 10,
			)
		);

		Options::add_field(
			array(
				'id'          => 'recover_guest_cart_enabled',
				'name'        => esc_html__( 'Recover guest carts', 'woodmart' ),
				'description' => esc_html__( 'Saves the cart of an unregistered user if they provide their email at checkout.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'abandoned_cart_section',
				'default'     => false,
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 20,
			)
		);

		Options::add_field(
			array(
				'id'          => 'recover_guest_cart_enable_privacy_checkbox',
				'name'        => esc_html__( 'Guest data consent', 'woodmart' ),
				'description' => esc_html__( 'Adds a checkbox for guest users to consent to data storage, enabling abandoned cart email reminders.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'abandoned_cart_section',
				'default'     => false,
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 30,
				'requires'    => array(
					array(
						'key'     => 'recover_guest_cart_enabled',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'       => 'recover_guest_cart_privacy_checkbox_text',
				'type'     => 'textarea',
				'name'     => esc_html__( 'Guest data consent text', 'woodmart' ),
				'wysiwyg'  => false,
				'section'  => 'abandoned_cart_section',
				'default'  => esc_html__( "If you check this box, you are giving us permission to save some of your details into a contact list. You may receive email messages containing information of commercial or promotional nature concerning this store.\nPersonal Data collected: email address, first name and last name.", 'woodmart' ),
				'requires' => array(
					array(
						'key'     => 'recover_guest_cart_enabled',
						'compare' => 'equals',
						'value'   => true,
					),
					array(
						'key'     => 'recover_guest_cart_enable_privacy_checkbox',
						'compare' => 'equals',
						'value'   => true,
					),
				),
				'priority' => 40,
			)
		);

		Options::add_field(
			array(
				'id'           => 'abandoned_cart_timeout',
				'name'         => esc_html__( 'Cart timeout', 'woodmart' ),
				'description'  => esc_html__( 'Sets when an inactive cart is marked as abandoned.', 'woodmart' ),
				'type'         => 'group',
				'section'      => 'abandoned_cart_section',
				'inner_fields' => array(
					array(
						'id'         => 'abandoned_cart_timeframe',
						'type'       => 'text_input',
						'attributes' => array(
							'type' => 'number',
							'min'  => 1,
						),
						'priority'   => 10,
						'default'    => 2,
					),
					array(
						'id'       => 'abandoned_cart_timeframe_period',
						'type'     => 'select',
						'options'  => array(
							strval( MINUTE_IN_SECONDS ) => array(
								'name'  => esc_html__( 'Minutes', 'woodmart' ),
								'value' => strval( MINUTE_IN_SECONDS ),
							),
							strval( HOUR_IN_SECONDS )   => array(
								'name'  => esc_html__( 'Hours', 'woodmart' ),
								'value' => strval( HOUR_IN_SECONDS ),
							),
							strval( DAY_IN_SECONDS )    => array(
								'name'  => esc_html__( 'Days', 'woodmart' ),
								'value' => strval( DAY_IN_SECONDS ),
							),
						),
						'default'  => strval( DAY_IN_SECONDS ),
						'priority' => 20,
					),
				),
				'priority'     => 50,
			)
		);

		Options::add_field(
			array(
				'id'           => 'abandoned_cart_delete_timeout',
				'name'         => esc_html__( 'Cart cleanup', 'woodmart' ),
				'description'  => esc_html__( 'Automatically removes abandoned carts after the specified time.', 'woodmart' ),
				'type'         => 'group',
				'section'      => 'abandoned_cart_section',
				'inner_fields' => array(
					array(
						'id'         => 'abandoned_cart_delete_timeframe',
						'type'       => 'text_input',
						'attributes' => array(
							'type' => 'number',
							'min'  => 1,
						),
						'priority'   => 10,
						'default'    => 30,
					),
					array(
						'id'       => 'abandoned_cart_delete_timeframe_period',
						'type'     => 'select',
						'options'  => array(
							strval( MINUTE_IN_SECONDS ) => array(
								'name'  => esc_html__( 'Minutes', 'woodmart' ),
								'value' => strval( MINUTE_IN_SECONDS ),
							),
							strval( HOUR_IN_SECONDS )   => array(
								'name'  => esc_html__( 'Hours', 'woodmart' ),
								'value' => strval( HOUR_IN_SECONDS ),
							),
							strval( DAY_IN_SECONDS )    => array(
								'name'  => esc_html__( 'Days', 'woodmart' ),
								'value' => strval( DAY_IN_SECONDS ),
							),
						),
						'default'  => strval( DAY_IN_SECONDS ),
						'priority' => 20,
					),
				),
				'priority'     => 60,
			)
		);

		Options::add_field(
			array(
				'id'          => 'abandoned_cart_coupon_enabled',
				'name'        => esc_html__( 'Enable coupon', 'woodmart' ),
				'description' => esc_html__( 'Activate this option to include a discount coupon in the email.', 'woodmart' ),
				'group'       => esc_html__( 'Coupon', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'abandoned_cart_section',
				'default'     => false,
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 70,
			)
		);

		Options::add_field(
			array(
				'id'          => 'abandoned_cart_coupon_prefix',
				'name'        => esc_html__( 'Coupon prefix', 'woodmart' ),
				'description' => esc_html__( 'Specify a prefix to easily identify coupons used for cart recovery emails.', 'woodmart' ),
				'group'       => esc_html__( 'Coupon', 'woodmart' ),
				'type'        => 'text_input',
				'section'     => 'abandoned_cart_section',
				'default'     => 'WD',
				'priority'    => 80,
			)
		);

		Options::add_field(
			array(
				'id'           => 'abandoned_cart_coupon_value',
				'name'         => esc_html__( 'Coupon value', 'woodmart' ),
				'description'  => esc_html__( 'Set the coupon value and select whether it should be a percentage or a fixed amount discount.', 'woodmart' ),
				'group'        => esc_html__( 'Coupon', 'woodmart' ),
				'type'         => 'group',
				'section'      => 'abandoned_cart_section',
				'inner_fields' => array(
					array(
						'id'         => 'abandoned_cart_coupon_amount',
						'type'       => 'text_input',
						'attributes' => array(
							'type' => 'number',
							'min'  => 1,
						),
						'priority'   => 10,
						'default'    => 10,
					),
					array(
						'id'       => 'abandoned_cart_coupon_discount_type',
						'type'     => 'select',
						'section'  => 'abandoned_cart_section',
						'options'  => array(
							'percent'    => array(
								'name'  => esc_html__( 'Percentage', 'woodmart' ),
								'value' => 'percent',
							),
							'fixed_cart' => array(
								'name'  => esc_html__( 'Fixed', 'woodmart' ),
								'value' => 'fixed_cart',
							),
						),
						'default'  => 'percent',
						'priority' => 20,
					),
				),
				'priority'     => 90,
			)
		);

		Options::add_field(
			array(
				'id'          => 'abandoned_cart_delete_used_coupons',
				'name'        => esc_html__( 'Delete used coupons', 'woodmart' ),
				'description' => esc_html__( 'Activate this setting to automatically remove coupons after they\'ve been redeemed.', 'woodmart' ),
				'group'       => esc_html__( 'Coupon', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'abandoned_cart_section',
				'default'     => true,
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 100,
			)
		);

		Options::add_field(
			array(
				'id'          => 'abandoned_cart_delete_expired_coupons',
				'name'        => esc_html__( 'Delete expired coupons', 'woodmart' ),
				'description' => esc_html__( 'Activate this option to remove expired coupons automatically.', 'woodmart' ),
				'group'       => esc_html__( 'Coupon', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'abandoned_cart_section',
				'default'     => true,
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 110,
			)
		);

		Options::add_field(
			array(
				'id'           => 'abandoned_cart_coupon_timeout',
				'name'         => esc_html__( 'Coupon expires after', 'woodmart' ),
				'description'  => esc_html__( 'Set the number of days until the coupon expires.', 'woodmart' ),
				'group'        => esc_html__( 'Coupon', 'woodmart' ),
				'type'         => 'group',
				'section'      => 'abandoned_cart_section',
				'inner_fields' => array(
					array(
						'id'         => 'abandoned_cart_coupon_timeframe',
						'type'       => 'text_input',
						'attributes' => array(
							'type' => 'number',
							'min'  => 1,
						),
						'priority'   => 10,
						'default'    => 1,
					),
					array(
						'id'       => 'abandoned_cart_coupon_timeframe_period',
						'type'     => 'select',
						'options'  => array(
							strval( DAY_IN_SECONDS )   => array(
								'name'  => esc_html__( 'Days', 'woodmart' ),
								'value' => strval( DAY_IN_SECONDS ),
							),
							strval( WEEK_IN_SECONDS )  => array(
								'name'  => esc_html__( 'Weeks', 'woodmart' ),
								'value' => strval( WEEK_IN_SECONDS ),
							),
							strval( MONTH_IN_SECONDS ) => array(
								'name'  => esc_html__( 'Monts', 'woodmart' ),
								'value' => strval( MONTH_IN_SECONDS ),
							),
						),
						'default'  => strval( DAY_IN_SECONDS ),
						'priority' => 20,
					),
				),
				'requires'     => array(
					array(
						'key'     => 'abandoned_cart_delete_expired_coupons',
						'compare' => 'equals',
						'value'   => true,
					),
				),
				'priority'     => 120,
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
			'class-abandoned-cart',
			'class-admin',
			'class-emails',
		);

		foreach ( $files as $file ) {
			$file_path = get_parent_theme_file_path( WOODMART_FRAMEWORK . '/integrations/woocommerce/modules/abandoned-cart/' . $file . '.php' );

			if ( file_exists( $file_path ) ) {
				require_once $file_path;
			}
		}
	}
}

Main::get_instance();
