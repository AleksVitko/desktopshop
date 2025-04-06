<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package Woodmart
 */

$classes = '';
$style   = '';

get_header();

if ( woodmart_has_sidebar_in_page() ) {
	$classes .= ' wd-grid-col';
	$style   .= ' style="' . woodmart_get_content_inline_style() . '"';
}
?>

<?php
if ( 'sidebar-left' === woodmart_get_page_layout() ) {
	get_sidebar();
}
?>

<div class="wd-content-area site-content<?php echo esc_attr( $classes ); ?>"<?php echo wp_kses( $style, true ); ?>>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content' ); ?>>
					<?php echo woodmart_get_the_content(); //phpcs:ignore ?>

					<?php
					wp_link_pages(
						array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'woodmart' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						)
					);
					?>

					<?php woodmart_entry_meta(); ?>
				</article>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
				if ( woodmart_get_opt( 'page_comments' ) && ( comments_open() || get_comments_number() ) ) :
					comments_template();
					endif;
				?>

		<?php endwhile; ?>

</div>


<?php
if ( 'sidebar-left' !== woodmart_get_page_layout() ) {
	get_sidebar();
}
?>

<?php get_footer(); ?>
