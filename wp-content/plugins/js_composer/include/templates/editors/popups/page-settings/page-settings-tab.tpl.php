<?php
/**
 * Page settings tab template.
 *
 * @since 8.1
 * @var array $page_settings_data
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>

<div class="vc_row">
	<div class="vc_col-sm-12 vc_column" id="vc_settings-title-container">
		<div class="wpb_settings-title">
			<div class="wpb_element_label"><?php esc_html_e( 'Page title', 'js_composer' ); ?></div>
			<?php
			if ( is_string( $page_settings_data['title_info'] ) ) {
				echo $page_settings_data['title_info']; // phpcs:ignore: WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
		</div>
		<div class="edit_form_line">
			<?php
			if ( vc_modules_manager()->is_module_on( 'vc-ai' ) ) {
				wpb_add_ai_icon_to_text_field( 'textfield', 'vc_page-title-field' );
			}
			?>
			<input name="page_title" class="wpb-textinput vc_title_name" type="text" value="" id="vc_page-title-field" placeholder="<?php esc_attr_e( 'Please enter page title', 'js_composer' ); ?>">
		</div>
	</div>
	<?php
	if ( vc_modules_manager()->is_module_on( 'vc-post-custom-layout' ) ) {
		?>
		<div class="vc_col-sm-12 vc_column" id="vc_settings-post_custom_layout">
			<div class="wpb_element_label"><?php esc_html_e( 'Layout Option', 'js_composer' ); ?></div>
			<?php
			vc_include_template(
				'editors/partials/vc_post_custom_layout.tpl.php',
				[ 'location' => 'settings' ]
			);
			?>
		</div>
		<?php
	}
	?>
</div>
