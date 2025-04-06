<?php 

/* Template name: Maintenance */

$GLOBALS['wd_maintenance'] = true;

get_header(); ?>
<div class="maintenance-content container">

	<?php /* The loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-content' ); ?>>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>

</div>

<?php get_footer(); ?>