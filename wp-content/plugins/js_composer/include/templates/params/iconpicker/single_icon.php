<?php
/**
 * Template for element param iconpicker single icon.
 *
 * @var string $class_key
 * @var string $selected
 * @var array $icon
 *
 * @since 8.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>

<option value="<?php esc_attr_e( $class_key ); ?>" <?php esc_attr_e( $selected ); ?>><?php esc_html_e( $icon ); ?></option>
