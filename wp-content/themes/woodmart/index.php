<?php
/**
 * The main template file
 */

if ( function_exists( 'woodmart_is_woo_ajax' ) && woodmart_is_woo_ajax() ) {
	do_action( 'woodmart_main_loop' );
	die();
}

get_header();

$content_inline_style = '';
$classes              = '';

if ( woodmart_has_sidebar_in_page() ) {
	$classes              = ' wd-grid-col';
	$content_inline_style = ' style="' . woodmart_get_content_inline_style() . '"';
}

if ( 'sidebar-left' === woodmart_get_page_layout() ) {
	get_sidebar();
}
?>

<div class="wd-content-area site-content<?php echo esc_attr( $classes ); ?>"<?php echo wp_kses( $content_inline_style, true ); ?>>
	<?php do_action( 'woodmart_main_loop' ); ?>
</div>

<?php
if ( 'sidebar-left' !== woodmart_get_page_layout() ) {
	get_sidebar();
}
?>

<?php get_footer(); ?>
