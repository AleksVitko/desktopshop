<?php
/**
 * Post settings like custom css for page are displayed here.
 *
 * @since 4.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Class Vc_Post_Settings.
 */
class Vc_Post_Settings {
	/**
	 * Editor type.
	 *
	 * @var mixed
	 */
	protected $editor;

	/**
	 * Post.
	 *
	 * @var WP_Post
	 */
	protected $post;

	/**
	 * Vc_Post_Settings constructor.
	 *
	 * @param mixed $editor
	 * @param WP_Post $post
	 */
	public function __construct( $editor, $post ) {
		$this->editor = $editor;
		$this->post = $post;
	}

	/**
	 * Get editor.
	 *
	 * @return mixed
	 */
	public function editor() {
		return $this->editor;
	}

	/**
	 * Render UI template.
	 */
	public function renderUITemplate() {

		$title_info = vc_get_template( 'editors/partials/param-info.tpl.php', [ 'description' => sprintf( esc_html__( 'Change title of the current %s.', 'js_composer' ), esc_html( get_post_type() ) ) ] );
		$css_info = vc_get_template( 'editors/partials/param-info.tpl.php', [ 'description' => esc_html__( 'Enter custom CSS (Note: it will be outputted only on this particular page).', 'js_composer' ) ] );
		$js_head_info = vc_get_template( 'editors/partials/param-info.tpl.php', [ 'description' => esc_html__( 'Enter custom JS (Note: it will be outputted only on this particular page inside <head> tag).', 'js_composer' ) ] );
		$js_body_info = vc_get_template( 'editors/partials/param-info.tpl.php', [ 'description' => esc_html__( 'Enter custom JS (Note: it will be outputted only on this particular page before closing', 'js_composer' ) ] );

		vc_include_template( 'editors/popups/vc_ui-panel-post-settings.tpl.php',
		array(
			'controls' => $this->getControls(),
			'box' => $this,
			'page_settings_data' => [
				'can_unfiltered_html_cap' =>
					vc_user_access()->part( 'unfiltered_html' )->checkStateAny( true, null )->get(),
				'title_info' => $title_info,
				'css_info' => $css_info,
				'js_head_info' => $js_head_info,
				'js_body_info' => $js_body_info,
			],
			'header_tabs_template_variables' => [
				'categories' => $this->get_categories(),
				'templates' => $this->get_tabs_templates(),
				'is_default_tab' => true,
			],
		) );
	}

	/**
	 * Get modal popup template tabs.
	 *
	 * @param array $categories
	 *
	 * @since 8.1
	 * @return array
	 */
	public function get_tabs( $categories ) {
		$tabs = [];

		foreach ( $categories as $key => $name ) {
			$filter = '.js-category-' . md5( $name );

			$tabs[] = array(
				'name' => $name,
				'filter' => $filter,
				'active' => 0 === $key,
			);
		}

		return $tabs;
	}

	/**
	 * Get tab categories.
	 *
	 * @sinse 8.1
	 * @return array
	 */
	public function get_categories() {
		return [
			esc_html__( 'Settings', 'js_composer' ),
			esc_html__( 'CSS & JS', 'js_composer' ),
		];
	}

	/**
	 * Get tabs templates.
	 *
	 * @since 8.1
	 * @return array
	 */
	public function get_tabs_templates() {
		return [
			'editors/popups/page-settings/page-settings-tab.tpl.php',
			'editors/popups/page-settings/custom-css-js-tab.tpl.php',
		];
	}

	/**
	 * Get controls of the post Settings panel, based on condition.
	 *
	 * @since 8.1
	 * @return array
	 */
	public function getControls() {
		$post = $this->post;
		$post_type = get_post_type_object( $post->post_type );
		$can_publish = current_user_can( $post_type->cap->publish_posts );

		// Initialize controls array.
		$controls = array(
			array(
				'name'  => 'close',
				'label' => esc_html__( 'Close', 'js_composer' ),
			),
		);

		// Add conditional save controls based on post status and user capabilities.
		if ( ! in_array( $post->post_status, array( 'publish', 'future', 'private' ), true ) ) {
			if ( 'draft' === $post->post_status || 'auto-draft' === $post->post_status ) {
				$controls[] = array(
					'name'        => 'save-draft',
					'label'       => esc_html__( 'Save Draft', 'js_composer' ),
					'css_classes' => 'vc_ui-button-fw',
					'style'       => 'action',
				);
			} elseif ( 'pending' === $post->post_status && $can_publish ) {
				$controls[] = array(
					'name'        => 'save-pending',
					'label'       => esc_html__( 'Save as Pending', 'js_composer' ),
					'css_classes' => 'vc_ui-button-fw',
					'style'       => 'action',
				);
			}
			if ( $can_publish ) {
				$controls[] = array(
					'name'               => 'publish',
					'label'              => esc_html__( 'Publish', 'js_composer' ),
					'css_classes'        => 'vc_ui-button-fw',
					'style'              => 'action-secondary',
					'data_change_status' => 'publish',
				);
			} else {
				$controls[] = array(
					'name'               => 'submit-review',
					'label'              => esc_html__( 'Submit for Review', 'js_composer' ),
					'css_classes'        => 'vc_ui-button-fw',
					'style'              => 'action',
					'data_change_status' => 'pending',
				);
			}
		} else {
			$controls[] = array(
				'name'        => 'update',
				'label'       => esc_html__( 'Update', 'js_composer' ),
				'css_classes' => 'vc_ui-button-fw',
				'style'       => 'action',
			);
		}
		return $controls;
	}
}
