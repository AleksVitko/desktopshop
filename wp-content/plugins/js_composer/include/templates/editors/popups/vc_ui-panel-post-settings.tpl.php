<?php
/**
 * UI Panel Post Settings template.
 *
 * @var array $page_settings_data
 * @var Vc_Post_Settings $box
 * @var array $header_tabs_template_variables
 * @var array $controls
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>
<div class="vc_ui-font-open-sans vc_ui-panel-window vc_media-xs vc_ui-panel" data-vc-panel=".vc_ui-panel-header-header" data-vc-ui-element="panel-post-settings" id="vc_ui-panel-post-settings">
	<div class="vc_ui-panel-window-inner">
		<?php
		vc_include_template('editors/popups/vc_ui-header.tpl.php', array(
			'title' => esc_html__( 'Page Settings', 'js_composer' ),
			'controls' => array( 'minimize', 'close' ),
			'header_css_class' => 'vc_ui-post-settings-header-container',
			'header_tabs_template' => 'editors/partials/add_element_tabs.tpl.php',
			'header_tabs_template_variables' => $header_tabs_template_variables,
			'box' => $box,
		));
		?>
		<div class="vc_ui-panel-content-container">
			<div class="vc_ui-panel-content vc_properties-list vc_edit_form_elements" data-vc-ui-element="panel-content">
				<div class="vc_panel-tabs">
					<?php
					foreach ( $header_tabs_template_variables['templates'] as $key => $template_name ) {
						$active_class = 0 === $key ? ' vc_active' : '';
						echo '<div id="vc_page-settings-tab-' . esc_attr( $key ) . '" class="vc_panel-tab vc_row' . esc_attr( $active_class ) . '" data-tab-index="' . esc_attr( $key ) . '">';
						vc_include_template(
							$template_name,
							[
								'page_settings_data' => $page_settings_data,
							]
						);
						echo '</div>';
					}
					?>
				</div>
			</div>
		</div>
		<!-- param window footer-->
		<?php
		// Include the template with the dynamic controls array.
		vc_include_template(
			'editors/popups/vc_ui-footer.tpl.php',
			array(
				'controls' => $controls,
			)
		);
		?>
	</div>
</div>
