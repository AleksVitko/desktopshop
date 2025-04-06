<?php
/**
 * Status button template.
 *
 * @var string $nonce security nonce.
 * @var string $status status of publication.
 * @var int $post_id publication id.
 * @package Woodmart
 */

$classes = '';

if ( 'publish' === $status ) {
	$classes .= ' xts-active';
}
?>

<div class="xts-switcher-btn<?php echo esc_attr( $classes ); ?>" data-id="<?php echo esc_attr( $post_id ); ?>" data-status="<?php echo esc_attr( $status ); ?>" data-security="<?php echo esc_attr( $nonce ); ?>">
	<div class="xts-switcher-dot-wrap">
		<div class="xts-switcher-dot"></div>
	</div>
	<div class="xts-switcher-labels">
		<span class="xts-switcher-label xts-on">
			<?php echo esc_html__( 'On', 'woodmart' ); ?>
		</span>

		<span class="xts-switcher-label xts-off">
			<?php echo esc_html__( 'Off', 'woodmart' ); ?>
		</span>
	</div>
</div>
