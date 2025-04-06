<?php

/* Template name: Portfolio */

$classes      = '';
$style        = '';
$filters_type = woodmart_get_opt( 'portfolio_filters_type', 'masonry' );
$filters      = woodmart_get_opt( 'portoflio_filters' );

if ( 'fragments' === woodmart_is_woo_ajax() ) {
	woodmart_get_portfolio_main_loop( true );
	die();
}

if ( ! woodmart_is_woo_ajax() ) {
	get_header();
} else {
	woodmart_page_top_part();
}

if ( woodmart_has_sidebar_in_page() ) {
	$classes = ' wd-grid-col';
	$style   = ' style="' . woodmart_get_content_inline_style() . '"';
}

if ( 'sidebar-left' === woodmart_get_page_layout() ) {
	get_sidebar();
}

?>
<div class="wd-content-area site-content<?php echo esc_attr( $classes ); ?>"<?php echo wp_kses( $style, true ); ?>>
	<?php if ( have_posts() ) : ?>
		<div class="wd-portfolio-element">
			<?php if ( $filters && ( ( 'links' === $filters_type && is_tax() ) || ! is_tax() ) ) : ?>
				<?php woodmart_portfolio_filters( '', $filters_type ); ?>
			<?php endif ?>

			<?php woodmart_get_portfolio_main_loop(); ?>
		</div>
	<?php else : ?>
		<?php get_template_part( 'content', 'none' ); ?>
	<?php endif; ?>
</div>
<?php

if ( 'sidebar-left' !== woodmart_get_page_layout() ) {
	get_sidebar();
}

if ( ! woodmart_is_woo_ajax() ) {
	get_footer();
} else {
	woodmart_page_bottom_part();
}
