<?php
/**
 * The template for displaying a "No posts found" message
 */
?>

	<article id="post-0" class="post no-results not-found entry-content">
		<h3 class="title"><?php esc_html_e( 'Nothing Found', 'woodmart' ); ?></h3>
		<p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'woodmart' ); ?></p>
		<?php get_search_form(); ?>
	</article>
