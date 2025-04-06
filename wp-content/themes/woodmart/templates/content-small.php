<?php

$classes = array(
	'wd-post',
	'blog-design-' . woodmart_loop_prop( 'blog_design' ),
	'blog-post-loop',
);

if ( ! get_the_title() ) {
	$classes[] = 'post-no-title';
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="wd-post-thumb">
		<?php echo woodmart_get_post_thumbnail( 'large' ); // phpcs:ignore ?>

		<?php /* translators: %s: Post title */ ?>
		<a class="wd-post-link wd-fill" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" aria-label="<?php echo esc_attr( sprintf( __( 'Link on post %s', 'woodmart' ), esc_attr( get_the_title() ) ) ); ?>"></a>
	</div>

	<div class="wd-post-content">
		<?php if ( woodmart_loop_prop( 'parts_title' ) ) : ?>
			<h3 class="wd-entities-title title post-title">
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
					<?php the_title(); ?>
				</a>
			</h3>
		<?php endif; ?>

		<div class="wd-post-entry-meta">
			<?php if ( is_sticky() ) : ?>
				<div class="wd-featured-post">
					<?php esc_html_e( 'Featured', 'woodmart' ); ?>
				</div>
			<?php endif; ?>

			<div class="wd-meta-date">
				<?php echo esc_html( get_the_date( 'd M Y' ) ); ?>
			</div>

			<?php if ( woodmart_loop_prop( 'parts_meta' ) && comments_open() ) : ?>
				<div class="wd-meta-reply-text">
					<?php woodmart_post_meta_reply(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article>
