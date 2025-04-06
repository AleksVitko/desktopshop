<?php
/**
 * XTS template library file.
 *
 * @package xts
 */

namespace XTS\Elementor;

use Elementor\Plugin;
use Elementor\TemplateLibrary\Source_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * XTS template library.
 *
 * @since 1.0.0
 */
class XTS_Library {
	/**
	 * Object constructor. Init basic things.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->hooks();
		$this->register_templates_source();
	}

	/**
	 * Initialize Hooks
	 *
	 * @since 1.0.0
	 */
	public function hooks() {
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'editor_scripts' ) );
		add_action( 'elementor/editor/footer', array( $this, 'html_templates' ) );

		add_action( 'wp_ajax_xts_get_templates', array( $this, 'get_templates' ) );
	}

	/**
	 * Get templates.
	 *
	 * @return void|\WP_Error
	 */
	public function get_templates() {
		$args = array(
			'source'             => 'xts',
			'edit_mode'          => true,
			'display'            => true,
			'template_id'        => isset( $_POST['template_id'] ) ? $_POST['template_id'] : 0, // phpcs:ignore
			'with_page_settings' => false,
			'editor_post_id'     => isset( $_POST['editor_post_id'] ) ? $_POST['editor_post_id'] : 0, // phpcs:ignore
		);

		if ( ! $args['editor_post_id'] ) {
			return new \WP_Error( 'template_error', 'Editor post ID not found.' );
		}

		if ( ! $args['template_id'] ) {
			return new \WP_Error( 'template_error', 'Template ID not found.' );
		}

		Plugin::$instance->db->switch_to_post( $args['editor_post_id'] );
		Plugin::$instance->editor->set_edit_mode( $args['edit_mode'] );

		$source = $this->get_source( $args['source'] );

		if ( ! $source ) {
			return new \WP_Error( 'template_error', 'Template source not found.' );
		}

		do_action( 'elementor/template-library/before_get_source_data', $args, $source );

		$data = $source->get_data( $args );

		do_action( 'elementor/template-library/after_get_source_data', $args, $source );

		wp_send_json( $data );
	}

	/**
	 * Get source.
	 *
	 * @param int $id Source ID.
	 * @return Source_Base|false
	 */
	public function get_source( $id ) {
		$sources = Plugin::$instance->templates_manager->get_registered_sources();

		if ( ! isset( $sources[ $id ] ) ) {
			return false;
		}

		return $sources[ $id ];
	}

	/**
	 * Register source.
	 *
	 * @since 1.0.0
	 */
	public function register_templates_source() {
		Plugin::instance()->templates_manager->register_source( 'XTS\Elementor\XTS_Library_Source' );
	}

	/**
	 * Load Editor JS
	 *
	 * @since 1.0.0
	 */
	public function editor_scripts() {
		wp_enqueue_style( 'xts-template-library-style', WOODMART_THEME_DIR . '/inc/integrations/elementor/assets/css/template-library.css', array(), woodmart_get_theme_info( 'Version' ) );
		wp_enqueue_script( 'xts-template-library-script', WOODMART_THEME_DIR . '/inc/integrations/elementor/assets/js/template-library.js', array(), woodmart_get_theme_info( 'Version' ), true );

		wp_localize_script(
			'xts-template-library-script',
			'xts_template_library_script',
			array(
				'demoAjaxUrl' => WOODMART_DEMO_URL . 'wp-admin/admin-ajax.php',
				'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			)
		);
	}

	/**
	 * Templates Modal Markup
	 *
	 * @since 1.0.0
	 */
	public function html_templates() {
		?>
		<script type="text/html" id="tmpl-elementor-xts-library-modal-header">
			<div class="elementor-templates-modal__header">
				<div class="elementor-templates-modal__header__logo-area">
					<div class="elementor-templates-modal__header__logo">
						<span class="elementor-templates-modal__header__logo__title">
							XTemos
						</span>
					</div>
				</div>

				<div class="elementor-templates-modal__header__items-area">
					<div class="elementor-templates-modal__header__close elementor-templates-modal__header__close--normal elementor-templates-modal__header__item">
						<i class="eicon-close" aria-hidden="true" title="<?php echo esc_attr__( 'Close', 'woodmart' ); ?>"></i>

						<span class="elementor-screen-only">
							<?php echo esc_html__( 'Close', 'woodmart' ); ?>
						</span>
					</div>
				</div>
			</div>
		</script>
		
		<script type="text/html" id="tmpl-elementor-xts-library-modal-order">
			<div id="elementor-template-library-filter">
				<select id="elementor-template-library-filter-subtype" class="elementor-template-library-filter-select" data-elementor-filter="subtype">
					<option value="all"><?php echo esc_html__( 'All', 'woodmart' ); ?></option>
					<# data.tags.forEach(function(item, i) { #>
					<option value="{{{item.slug}}}">{{{item.title}}}</option>
					<# }); #>
				</select>
			</div>
			
		</script>

		<script type="text/html" id="tmpl-elementor-xts-library-modal">
			<div id="elementor-template-library-templates" data-template-source="remote">
				<div id="elementor-template-library-toolbar">
					<div id="elementor-template-library-filter-toolbar-remote" class="elementor-template-library-filter-toolbar"></div>

					<div id="elementor-template-library-filter-text-wrapper">
						<label for="elementor-template-library-filter-text" class="elementor-screen-only"><?php echo esc_html__( 'Search Templates:', 'woodmart' ); ?></label>
						<input id="elementor-template-library-filter-text" placeholder="<?php echo esc_attr__( 'Search', 'woodmart' ); ?>">
						<i class="eicon-search"></i>
					</div>
				</div>

				<div id="elementor-template-library-templates-container"></div>
			</div>

			<div class="elementor-loader-wrapper" style="display: none">
				<div class="elementor-loader">
					<div class="elementor-loader-boxes">
						<div class="elementor-loader-box"></div>
						<div class="elementor-loader-box"></div>
						<div class="elementor-loader-box"></div>
						<div class="elementor-loader-box"></div>
					</div>
				</div>
				<div class="elementor-loading-title"><?php echo esc_html__( 'Loading', 'woodmart' ); ?></div>
			</div>
		</script>

		<script type="text/html" id="tmpl-elementor-xts-library-modal-item">
			<# data.elements.forEach(function(item, i) { #>
			<div class="elementor-template-library-template elementor-template-library-template-remote elementor-template-library-template-block" data-title="{{{item.image}}}" data-slug="{{{item.slug}}}" data-tag="{{{item.class}}}">
				<div class="elementor-template-library-template-body">
					<img src="{{{item.image}}}" alt="{{{item.title}}}" />

					<a class="elementor-template-library-template-preview" href="{{{item.link}}}" target="_blank">
						<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
					</a>
				</div>

				<div class="elementor-template-library-template-footer">
					<a class="elementor-template-library-template-action elementor-template-library-template-insert elementor-button" data-id="{{{item.id}}}">
						<i class="eicon-file-download" aria-hidden="true"></i>
						<span class="elementor-button-title">Insert</span>
					</a>
					<div class="xts-elementor-template-library-template-name">{{{item.title}}}</div>
				</div>
			</div>
			<# }); #>
		</script>
		<?php
	}
}

new XTS_Library();
