<?php

namespace XTS\Modules\Header_Builder;

use XTS\Modules\Header_Builder;
use XTS\Singleton;

/**
 * ------------------------------------------------------------------------------------------------
 * Backend class that enqueues main scripts and CSS.
 * ------------------------------------------------------------------------------------------------
 */
class Backend extends Singleton {

	/**
	 * Object main class.
	 *
	 * @var null
	 */
	private $_builder = null;

	/**
	 * Initialize class.
	 *
	 * @return void
	 */
	public function init() {
		$this->_builder = Header_Builder::get_instance();

		if ( isset( $_GET['page'] ) && 'xts_header_builder' === $_GET['page'] ) { //phpcs:ignore
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ), 50 );
			add_filter( 'woodmart_admin_localized_string_array', array( $this, 'add_localized_settings' ) );
		} elseif ( woodmart_is_header_frontend_editor() ) { //phpcs:ignore
			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 100 );
			add_action( 'wp_footer', array( $this, 'output_placeholder' ) );
			add_filter( 'woodmart_localized_string_array', array( $this, 'add_localized_settings' ) );
			add_filter( 'body_class', array( $this, 'add_body_class' ) );

			add_filter( 'woodmart_enqueue_combined_js', '__return_true' );

			remove_action( 'woodmart_before_wp_footer', 'woodmart_search_full_screen', 100 );
			add_action( 'whb_after_header', 'woodmart_search_full_screen' );

			add_action( 'woodmart_before_wp_footer', 'woodmart_mobile_menu', 130 );
			add_action( 'whb_after_header', 'woodmart_mobile_menu', 20 );

			remove_action( 'woodmart_before_wp_footer', 'woodmart_cart_side_widget', 140 );
			add_action( 'whb_after_header', 'woodmart_cart_side_widget', 30 );

			remove_action( 'woodmart_before_wp_footer', 'woodmart_full_screen_main_nav', 120 );
			add_action( 'whb_after_header', 'woodmart_full_screen_main_nav', 50 );
		}
	}

	/**
	 * Output placeholder for header builder.
	 *
	 * @return void
	 */
	public function output_placeholder() {
		include_once get_parent_theme_file_path( WOODMART_FRAMEWORK . '/admin/modules/dashboard/templates/header_builder.php' );
	}

	/**
	 * Add body class for header builder.
	 *
	 * @param array $classes Body classes.
	 *
	 * @return array
	 */
	public function add_body_class( $classes ) {
		$classes[] = 'wd-header-editor';
		return $classes;
	}

	/**
	 * Enqueue scripts in page.
	 *
	 * @return void
	 */
	public function scripts() {
		$dev = apply_filters( 'whb_debug_mode', false );

		$assets_path = ( $dev ) ? WOODMART_HEADER_BUILDER . '/builder/public' : WOODMART_ASSETS;

		wp_enqueue_style( 'wd-admin-base', WOODMART_ASSETS . '/css/parts/base.min.css', array(), WOODMART_VERSION );
		wp_enqueue_style( 'wd-admin-page-header-builder', WOODMART_ASSETS . '/css/parts/page-header-builder.min.css', array(), WOODMART_VERSION );

		if ( woodmart_is_header_frontend_editor() ) {
			woodmart_force_enqueue_style( 'header-base' );
			wp_enqueue_style( 'wd-admin-page-header-builder-frontend', WOODMART_ASSETS . '/css/parts/page-header-builder-frontend.min.css', array(), WOODMART_VERSION );
		}

		wp_register_script( 'woodmart-admin-builder', $assets_path . '/js/builder.js', array( 'wp-element' ), WOODMART_VERSION, array( 'in_footer' => true ) );

		wp_localize_script(
			'woodmart-admin-builder',
			'headerBuilder',
			array(
				'sceleton'        => $this->_builder->factory->get_header( false )->get_structure(),
				'settings'        => $this->_builder->factory->get_header( false )->get_settings(),
				'name'            => WOODMART_HB_DEFAULT_NAME,
				'id'              => WOODMART_HB_DEFAULT_ID,
				'headersList'     => $this->_builder->list->get_all(),
				'headersExamples' => $this->_builder->list->get_examples(),
				'defaultHeader'   => $this->_builder->manager->get_default_header(),
				'texts'           => array(
					'managerTitle'                       => __( 'Headers builder', 'woodmart' ),
					'description'                        => __( 'Here you can manage your header layouts, create new ones, import and export. You can set which header to use for all pages by default.', 'woodmart' ),
					'createNew'                          => __( 'Add new header', 'woodmart' ),
					'import'                             => __( 'Import header', 'woodmart' ),
					'remove'                             => __( 'Delete', 'woodmart' ),
					'edit'                               => __( 'Edit', 'woodmart' ),
					'duplicate'                          => __( 'Duplicate', 'woodmart' ),
					'makeDefault'                        => __( 'Set as default', 'woodmart' ),
					'headerSearchPlaceholder'            => __( 'Search by name', 'woodmart' ),
					'alreadyDefault'                     => __( 'Default header', 'woodmart' ),
					'headerSettings'                     => __( 'Header settings', 'woodmart' ),
					'delete'                             => __( 'Delete', 'woodmart' ),
					'Make it default'                    => __( 'Make it default', 'woodmart' ),
					'on'                                 => __( 'On', 'woodmart' ),
					'off'                                => __( 'Off', 'woodmart' ),
					'Import new header'                  => __( 'Import new header', 'woodmart' ),
					'Import'                             => __( 'Import', 'woodmart' ),
					'JSON code for import is not valid!' => __( 'JSON code for import is not valid!', 'woodmart' ),
					'Paste your JSON header export data here and click "Import"' => __( 'Paste your JSON header export data here and click "Import"', 'woodmart' ),
					'Are you sure you want to remove this header?' => __( 'Are you sure you want to remove this header?', 'woodmart' ),
					'Press OK to make this header default for all pages, Cancel to leave.' => __( 'Press OK to make this header default for all pages, Cancel to leave.', 'woodmart' ),
					'Choose which layout you want to use as a base for your new header.' => __( 'Choose which layout you want to use as a base for your new header.', 'woodmart' ),
					'Examples library'                   => __( 'Examples library', 'woodmart' ),
					'User headers'                       => __( 'User headers', 'woodmart' ),
					'Background image repeat'            => __( 'Background image repeat', 'woodmart' ),
					'Background image'                   => __( 'Background image', 'woodmart' ),
					'Background color'                   => __( 'Background color', 'woodmart' ),
					'Inherit'                            => __( 'Inherit', 'woodmart' ),
					'No repeat'                          => __( 'No repeat', 'woodmart' ),
					'Repeat All'                         => __( 'Repeat All', 'woodmart' ),
					'Repeat horizontally'                => __( 'Repeat horizontally', 'woodmart' ),
					'Repeat vertically'                  => __( 'Repeat vertically', 'woodmart' ),
					'Background image size'              => __( 'Background image size', 'woodmart' ),
					'Cover'                              => __( 'Cover', 'woodmart' ),
					'Contain'                            => __( 'Contain', 'woodmart' ),
					'Background image attachment'        => __( 'Background image attachment', 'woodmart' ),
					'Fixed'                              => __( 'Fixed', 'woodmart' ),
					'Scroll'                             => __( 'Scroll', 'woodmart' ),
					'Background image position'          => __( 'Background image position', 'woodmart' ),
					'Left top'                           => __( 'Left top', 'woodmart' ),
					'Left center'                        => __( 'Left center', 'woodmart' ),
					'Left bottom'                        => __( 'Left bottom', 'woodmart' ),
					'Center top'                         => __( 'Center top', 'woodmart' ),
					'Center center'                      => __( 'Center center', 'woodmart' ),
					'Center bottom'                      => __( 'Center bottom', 'woodmart' ),
					'Right top'                          => __( 'Right top', 'woodmart' ),
					'Right center'                       => __( 'Right center', 'woodmart' ),
					'Right bottom'                       => __( 'Right bottom', 'woodmart' ),
					'Preview'                            => __( 'Preview', 'woodmart' ),
					'Border Width'                       => __( 'Border Width', 'woodmart' ),
					'Style'                              => __( 'Style', 'woodmart' ),
					'Container'                          => __( 'Container', 'woodmart' ),
					'fullwidth'                          => __( 'fullwidth', 'woodmart' ),
					'boxed'                              => __( 'boxed', 'woodmart' ),
					'Upload an image'                    => __( 'Upload an image', 'woodmart' ),
					'Upload'                             => __( 'Upload', 'woodmart' ),
					'Open in new window'                 => __( 'Open in new window', 'woodmart' ),
					'Add element to this section'        => __( 'Add element to this section', 'woodmart' ),
					'Are you sure you want to delete this element?' => __( 'Are you sure you want to delete this element?', 'woodmart' ),
					'Export this header structure'       => __( 'Export this header structure', 'woodmart' ),
					'importDescription'                  => __(
						'Copy the code from the following text area and save it. You will be
					able to import it later with our import function in the headers
					manager.',
						'woodmart'
					),
					'Save header'                        => __( 'Save header', 'woodmart' ),
					'Back to headers list'               => __( 'Back to headers list', 'woodmart' ),
					'Frontend editor'                    => __( 'Frontend editor', 'woodmart' ),
					'Edit'                               => __( 'Edit', 'woodmart' ),
					'Clone'                              => __( 'Clone', 'woodmart' ),
					'Remove'                             => __( 'Remove', 'woodmart' ),
					'Add element'                        => __( 'Add element', 'woodmart' ),
					'Loading, please wait...'            => __( 'Loading, please wait...', 'woodmart' ),
					'Close'                              => __( 'Close', 'woodmart' ),
					'Save'                               => __( 'Save', 'woodmart' ),
					'Header settings'                    => __( 'Header settings', 'woodmart' ),
					'Export header'                      => __( 'Export header', 'woodmart' ),
					'Desktop layout'                     => __( 'Desktop layout', 'woodmart' ),
					'Mobile layout'                      => __( 'Mobile layout', 'woodmart' ),
					'Header is successfully saved.'      => __( 'Header is successfully saved.', 'woodmart' ),
					'Header is successfully deleted.'    => __( 'Header is successfully deleted.', 'woodmart' ),
					'Default header for all pages is changed.' => __( 'Default header for all pages is changed.', 'woodmart' ),
					'Configure'                          => __( 'Configure', 'woodmart' ),
					'settings'                           => __( 'settings', 'woodmart' ),
					'Hidden on desktop'                  => __( 'Hidden on desktop', 'woodmart' ),
					'Hidden on mobile'                   => __( 'Hidden on mobile', 'woodmart' ),
					'Backdrop filter'                    => __( 'Backdrop filter', 'woodmart' ),
					'Edit settings'                      => __( 'Edit settings', 'woodmart' ),
					'backdropDescription'                => __( 'Backdrop effects will be visible only if the row has background with transparency.', 'woodmart' ),
					'Select preview page'                => __( 'Select preview page', 'woodmart' ),
					'Backend editor'                     => __( 'Backend editor', 'woodmart' ),
					'No pages found'                     => __( 'No pages found', 'woodmart' ),
					'Collapse editor'                    => __( 'Collapse editor', 'woodmart' ),
					'Show editor'                        => __( 'Show editor', 'woodmart' ),
					'Close editor'                       => __( 'Close editor', 'woodmart' ),
				),
			)
		);

		wp_enqueue_script( 'woodmart-admin-builder' );

		wp_enqueue_editor();
		wp_enqueue_media();
	}

	public function add_localized_settings( $localize ) {
		if ( ! current_user_can( 'administrator' ) ) {
			return $localize;
		}

		if ( woodmart_is_header_frontend_editor() ) {
			$items = array();
			$posts = get_posts(
				array(
					'post_type'      => array( 'page', 'post', 'portfolio', 'product' ),
					'posts_per_page' => apply_filters( 'woodmart_get_numberposts_by_query_autocomplete', 20 ),
				)
			);

			if ( count( $posts ) > 0 ) {
				foreach ( $posts as $post ) {
					$items[] = array(
						'value' => $post->ID,
						'url'   => get_permalink( $post->ID ),
						'label' => $post->post_title . ' (ID:' . $post->ID . ')',
					);
				}
			}

			$localize['builder_get_search_pages'] = $items;
		}

		return array_merge(
			$localize,
			array(
				'get_builder_elements_nonce'       => wp_create_nonce( 'woodmart-get-builder-elements-nonce' ),
				'get_builder_element_nonce'        => wp_create_nonce( 'woodmart-get-builder-element-nonce' ),
				'builder_load_header_nonce'        => wp_create_nonce( 'woodmart-builder-load-header-nonce' ),
				'builder_save_header_nonce'        => wp_create_nonce( 'woodmart-builder-save-header-nonce' ),
				'builder_remove_header_nonce'      => wp_create_nonce( 'woodmart-builder-remove-header-nonce' ),
				'builder_set_default_header_nonce' => wp_create_nonce( 'woodmart-builder-set-default-header-nonce' ),
				'builder_header_html_nonce'        => wp_create_nonce( 'woodmart-builder-header-html-nonce' ),
				'builder_search_page_nonce'        => wp_create_nonce( 'woodmart-builder-header-search-page-nonce' ),
				'adminUrl'                         => admin_url( 'admin.php' ),
			)
		);
	}
}

$GLOBALS['woodmart_hb_backend'] = Backend::get_instance();
