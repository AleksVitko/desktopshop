<?php
/**
 * The template for displaying single project
 *
 */

get_header();

$classes = '';
$style   = '';

if ( woodmart_has_sidebar_in_page() ) {
	$classes .= ' wd-grid-col';
	$style   .= ' style="' . woodmart_get_content_inline_style() . '"';
}

if ( 'sidebar-left' === woodmart_get_page_layout() ) {
	get_sidebar();
}
?>

<div class="wd-content-area site-content<?php echo esc_attr( $classes ); ?>"<?php echo wp_kses( $style, true ); ?>>
		<?php while ( have_posts() ) : the_post(); ?>

				<div class="wd-single-project wd-entry-content">
					<?php the_content( esc_html__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'woodmart' ) ); ?>
				</div>

				<?php
				if ( woodmart_get_opt( 'portfolio_navigation' ) ) {
					woodmart_posts_navigation();
				}

				$args = woodmart_get_related_projects_args( get_the_ID() );

				$query = new WP_Query( $args );

				if ( woodmart_get_opt( 'portfolio_related' ) ) {
					$style = woodmart_get_opt( 'portoflio_style' );

					if ( 'parallax' === $style ) {
						woodmart_enqueue_js_library( 'panr-parallax-bundle' );
						woodmart_enqueue_js_script( 'portfolio-effect' );
					}

					woodmart_enqueue_portfolio_loop_styles( $style );

					woodmart_enqueue_js_library( 'photoswipe-bundle' );
					woodmart_enqueue_inline_style( 'photoswipe' );
					woodmart_enqueue_js_script( 'portfolio-photoswipe' );
					echo woodmart_generate_posts_slider( //phpcs:ignore
						array(
							'title'                   => esc_html__( 'Related projects', 'woodmart' ),
							'slides_per_view'         => 3,
							'hide_pagination_control' => 'yes',
							'custom_sizes'            => apply_filters( 'woodmart_portfolio_related_custom_sizes', false ),
							'spacing'                 => woodmart_get_opt( 'portfolio_spacing' ),
							'spacing_tablet'          => woodmart_get_opt( 'portfolio_spacing_tablet', '' ),
							'spacing_mobile'          => woodmart_get_opt( 'portfolio_spacing_mobile', '' ),
						),
						$query
					);
				}
				?>
		<?php endwhile; ?>

</div>

<?php
if ( 'sidebar-left' !== woodmart_get_page_layout() ) {
	get_sidebar();
}
?>

<?php get_footer(); ?>