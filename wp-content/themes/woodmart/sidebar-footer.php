<?php
/**
 * The Footer Sidebar
 */

if ( ! is_active_sidebar( 'footer-1' ) && ! is_active_sidebar( 'footer-2' ) && ! is_active_sidebar( 'footer-3' ) && ! is_active_sidebar( 'footer-4' ) && ! is_active_sidebar( 'footer-5' ) && ! is_active_sidebar( 'footer-6' ) && ! is_active_sidebar( 'footer-7' ) ) {
	return;
}

$footer_layout = woodmart_get_opt( 'footer-layout' );

$footer_config = woodmart_get_footer_config( $footer_layout );

if ( count( $footer_config['cols'] ) > 0 ) {
	?>
	<div class="container main-footer">
		<aside class="footer-sidebar widget-area wd-grid-g" style="--wd-col-lg:12;--wd-gap-lg:30px;--wd-gap-sm:20px;">
			<?php foreach ( $footer_config['cols'] as $key => $style ) : ?>
				<?php $index = $key + 1; ?>
				<div class="footer-column footer-column-<?php echo esc_attr( $index ); ?> wd-grid-col" style="<?php echo esc_attr( $style ); ?>">
					<?php dynamic_sidebar( 'footer-' . $index ); ?>
				</div>
			<?php endforeach; ?>
		</aside>
	</div>
	<?php
}

?>

