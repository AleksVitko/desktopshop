<?php
/**
 * The sidebar containing the secondary widget area
 *
 * Displays on posts and pages.
 *
 * If no active widgets are in this sidebar, hide it completely.
 */

use XTS\Registry;

$sidebar_col = Registry::getInstance()->layout->get_sidebar_col_width();

if ( 0 === $sidebar_col ) {
	return;
}

$sidebar_class      = Registry::getInstance()->layout->get_sidebar_class();
$sidebar_name       = Registry::getInstance()->layout->get_sidebar_name();
$sidebar_style      = Registry::getInstance()->layout->get_sidebar_inline_style();
$off_canvas_classes = Registry::getInstance()->layout->get_offcanvas_sidebar_classes();

?>
<?php if ( $off_canvas_classes ) : ?>
	<?php woodmart_enqueue_inline_style( 'off-canvas-sidebar' ); ?>
<?php endif; ?>

<aside class="wd-sidebar sidebar-container wd-grid-col<?php echo esc_attr( $sidebar_class ); ?>" style="<?php echo esc_attr( $sidebar_style ); ?>">
	<?php if ( $off_canvas_classes ) : ?>
		<div class="wd-heading">
			<div class="close-side-widget wd-action-btn wd-style-text wd-cross-icon">
				<a href="#" rel="nofollow noopener"><?php esc_html_e( 'Close', 'woodmart' ); ?></a>
			</div>
		</div>
	<?php endif; ?>
	<div class="widget-area">
		<?php do_action( 'woodmart_before_sidebar_area' ); ?>
		<?php dynamic_sidebar( $sidebar_name ); ?>
		<?php do_action( 'woodmart_after_sidebar_area' ); ?>
	</div>
</aside>
