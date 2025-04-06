<?php
/**
 * Waitlist class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Waitlist;

use XTS\Admin\Modules\Options;
use XTS\Singleton;
use WC_Product;

/**
 * Waitlist class.
 */
class Main extends Singleton {
	/**
	 * DB_Storage instance.
	 *
	 * @var DB_Storage
	 */
	protected $db_storage;

	/**
	 * Init.
	 */
	public function init() {
		if ( ! woodmart_woocommerce_installed() ) {
			return;
		}

		add_action( 'init', array( $this, 'add_options' ) );

		add_filter( 'woocommerce_settings_pages', array( $this, 'add_endpoint_option' ) );
		add_filter( 'woocommerce_get_query_vars', array( $this, 'add_endpoint' ) );

		if ( ! woodmart_get_opt( 'waitlist_enabled' ) ) {
			return;
		}

		$this->define_constants();
		$this->include_files();

		$this->db_storage = DB_Storage::get_instance();

		add_action( 'init', array( $this, 'custom_rewrite_rule' ) );

		add_action( 'before_delete_post', array( $this->db_storage, 'unsubscribe_by_product_id' ) );

		add_action( 'woodmart_remove_not_confirmed_emails', array( $this->db_storage, 'remove_not_confirmed_emails' ) );

		if ( ! wp_next_scheduled( 'woodmart_remove_not_confirmed_emails' ) ) {
			wp_schedule_event( time(), apply_filters( 'woodmart_remove_not_confirmed_emails_time', 'daily' ), 'woodmart_remove_not_confirmed_emails' );
		}
	}

	/**
	 * Add options in theme settings.
	 */
	public function add_options() {
		Options::add_field(
			array(
				'id'          => 'waitlist_enabled',
				'name'        => esc_html__( 'Enable "Waitlist"', 'woodmart' ),
				'hint' => '<video data-src="' . WOODMART_TOOLTIP_URL . 'waitlist_enabled.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Activate this option to allow customers to join a waitlist for out-of-stock products, ensuring they are notified when the items become available again.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'waitlist_section',
				'default'     => '0',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 10,
				'class'       => 'xts-preset-field-disabled',
			)
		);

		Options::add_field(
			array(
				'id'          => 'waitlist_for_loggined',
				'name'        => esc_html__( 'Login to see waitlist', 'woodmart' ),
				'description' => esc_html__( 'Restrict the waitlist feature to logged-in users, ensuring that only registered customers can join the waitlist for out-of-stock products.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'waitlist_section',
				'default'     => '0',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 20,
				'class'       => 'xts-preset-field-disabled',
			)
		);

		Options::add_field(
			array(
				'id'          => 'waitlist_form_state',
				'name'        => esc_html__( 'Initial state', 'woodmart' ),
				'description' => esc_html__( 'Choose the default display for the waitlist feature: either show the form for joining the waitlist or display the current status (joined or not).', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'waitlist_section',
				'options'     => array(
					'always_open'   => array(
						'name'  => esc_html__( 'Always open', 'woodmart' ),
						'value' => 'always_open',
					),
					'current_state' => array(
						'name'  => esc_html__( 'Current state', 'woodmart' ),
						'value' => 'current_state',
					),
				),
				'default'     => 'current_state',
				'priority'    => 30,
			)
		);

		Options::add_field(
			array(
				'id'          => 'waitlist_fragments_enable',
				'name'        => esc_html__( 'Enable fragments updating', 'woodmart' ),
				'description' => esc_html__( 'Activate this setting to ensure that waitlist form is updated correctly when caching is enabled, maintaining accurate waitlist information on the product page.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'waitlist_section',
				'default'     => '0',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 40,
				'class'       => 'xts-preset-field-disabled',
				'requires'    => array(
					array(
						'key'     => 'waitlist_form_state',
						'compare' => 'equals',
						'value'   => 'always_open',
					),
				),
			)
		);

		Options::add_field(
			array(
				'id'          => 'waitlist_wait_interval',
				'name'        => esc_html__( 'Wait interval', 'woodmart' ),
				'description' => esc_html__( 'Sets how often the action repeats to send a batch of emails. You can choose the time gap between each send.', 'woodmart' ),
				'type'        => 'select',
				'section'     => 'waitlist_section',
				'options'     => array(
					strval( MINUTE_IN_SECONDS )      => array(
						'name'  => esc_html__( 'Minute', 'woodmart' ),
						'value' => strval( MINUTE_IN_SECONDS ),
					),
					strval( MINUTE_IN_SECONDS * 10 ) => array(
						'name'  => esc_html__( '10 Minutes', 'woodmart' ),
						'value' => strval( MINUTE_IN_SECONDS * 10 ),
					),
					strval( HOUR_IN_SECONDS )        => array(
						'name'  => esc_html__( 'Hour', 'woodmart' ),
						'value' => strval( HOUR_IN_SECONDS ),
					),
					strval( HOUR_IN_SECONDS * 2 )    => array(
						'name'  => esc_html__( '2 Hours', 'woodmart' ),
						'value' => strval( HOUR_IN_SECONDS * 2 ),
					),
					strval( HOUR_IN_SECONDS * 5 )    => array(
						'name'  => esc_html__( '5 Hours', 'woodmart' ),
						'value' => strval( HOUR_IN_SECONDS * 5 ),
					),
					strval( DAY_IN_SECONDS )         => array(
						'name'  => esc_html__( 'Day', 'woodmart' ),
						'value' => strval( DAY_IN_SECONDS ),
					),
				),
				'default'     => strval( HOUR_IN_SECONDS ),
				'priority'    => 45,
			)
		);

		Options::add_field(
			array(
				'id'          => 'waitlist_enable_privacy_checkbox',
				'name'        => esc_html__( 'Enable privacy policy checkbox', 'woodmart' ),
				'hint' => '<video data-src="' . WOODMART_TOOLTIP_URL . 'waitlist_enable_privacy_checkbox.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Activate this setting to require customers to agree to your privacy policy with a checkbox before they can join the waitlist for out-of-stock products.', 'woodmart' ),
				'type'        => 'switcher',
				'section'     => 'waitlist_section',
				'default'     => '1',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 50,
				'class'       => 'xts-preset-field-disabled',
			)
		);

		Options::add_field(
			array(
				'id'           => 'waitlist_privacy_checkbox_text',
				'name'         => esc_html__( 'Privacy checkbox text', 'woodmart' ),
				'description'  => esc_html__( 'Specify the text that will appear next to the privacy policy checkbox, informing customers about the policy they need to agree to before joining the waitlist. You can use the shortcode [terms] and [privacy_policy]', 'woodmart' ),
				'type'         => 'textarea',
				'wysiwyg'      => false,
				'section'      => 'waitlist_section',
				'empty_option' => true,
				'default'      => wp_kses( __('I have read and accept the <strong>[privacy_policy]</strong>', 'woodmart'), array( 'strong' => array() ) ),
				'priority'     => 60,
				'requires'     => array(
					array(
						'key'     => 'waitlist_enable_privacy_checkbox',
						'compare' => 'equals',
						'value'   => '1',
					),
				),
			)
		);
	}

	/**
	 * Add waiting list account endpoint option.
	 */
	public function add_endpoint_option( $settings ) {
		$offset       = array_search(
			'woocommerce_myaccount_payment_methods_endpoint',
			array_column(
				$settings,
				'id'
			),
			true
		) + 1;
		$first_part   = array_slice( $settings, 0, $offset, true );
		$last_part    = array_slice( $settings, $offset, null, true );
		$first_part[] = array(
			'title'    => esc_html__( 'Waitlist', 'woodmart' ),
			'desc'     => esc_html__( 'Endpoint for the "My account &rarr; Waitlist" page.', 'woodmart' ),
			'id'       => 'woodmart_myaccount_waitlist_endpoint',
			'type'     => 'text',
			'default'  => 'waitlist',
			'desc_tip' => true,
		);
		$settings   = array_merge( $first_part, $last_part );

		return $settings;
	}

	/**
	 * Add waiting list account endpoint
	 */
	public function add_endpoint( $query_vars ) {
		$query_vars['waitlist'] = get_option( 'woodmart_myaccount_waitlist_endpoint', 'waitlist' );

		return $query_vars;
	}

	/**
	 * Define constants.
	 */
	private function define_constants() {
		if ( ! defined( 'XTS_WAITLIST_DIR' ) ) {
			define( 'XTS_WAITLIST_DIR', WOODMART_THEMEROOT . '/inc/integrations/woocommerce/modules/waitlist/' );
		}
	}

	/**
	 * Include files.
	 *
	 * @return void
	 */
	public function include_files() {
		$files = array(
			'class-db-storage',
			'class-emails',
			'class-admin',
			'class-frontend',
		);

		foreach ( $files as $file ) {
			$path = XTS_WAITLIST_DIR . $file . '.php';

			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}
	}

	/**
	 * Add rewrite rules for wishlist.
	 *
	 * @return void
	 */
	public function custom_rewrite_rule() {
		$myaccount_id = (int) get_option( 'woocommerce_myaccount_page_id' );
		$slug         = (string) get_post_field( 'post_name', $myaccount_id );

		if ( empty( $slug ) || ! array_key_exists( 'waitlist', WC()->query->query_vars ) ) {
			return;
		}

		$waitlist_endpoint = WC()->query->query_vars['waitlist'];

		add_rewrite_rule( '^' . $slug . '/' . $waitlist_endpoint . '/page/([^/]*)?', 'index.php?page_id=' . $myaccount_id . '&' . $waitlist_endpoint . '&paged=$matches[1]', 'top' );
	}
}

Main::get_instance();
