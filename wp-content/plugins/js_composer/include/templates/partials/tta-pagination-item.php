<?php
/**
 * Template for pagination item of Tabbed-Toggles-Accordions elements.
 *
 * @since 8.3
 * @var string $classes
 * @var int $current
 * @var array $section
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>

<li class="<?php esc_attr_e( $classes ); ?>" data-vc-tab>
	<a aria-label="<?php esc_attr_e( 'Pagination Item', 'js_composer' ); ?> <?php esc_attr_e( $current ); ?>" href="#<?php esc_attr_e( $section['tab_id'] ); ?>" class="vc_pagination-trigger" data-vc-tabs data-vc-container=".vc_tta"></a>
</li>
