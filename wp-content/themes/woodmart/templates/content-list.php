<?php
$blog_style     = woodmart_get_opt( 'blog_style', 'shadow' );
$post_format    = get_post_format();
$thumb_classes  = '';
$gallery_slider = apply_filters( 'woodmart_gallery_slider', true );
$gallery        = array();

$classes = array(
	'wd-post',
	'blog-design-' . woodmart_loop_prop( 'blog_design' ),
	'blog-post-loop',
);

if ( 'shadow' === $blog_style ) {
	$classes[] = 'blog-style-bg';

	if ( woodmart_get_opt( 'blog_with_shadow', true ) ) {
		$classes[] = 'wd-add-shadow';
	}
} else {
	$classes[] = 'blog-style-' . $blog_style;
}

if ( ! get_the_title() ) {
	$classes[] = 'post-no-title';
}

if ( 'quote' === $post_format ) {
	woodmart_enqueue_inline_style( 'blog-loop-format-quote' );
} elseif ( 'gallery' === $post_format && $gallery_slider ) {
	$gallery = get_post_gallery( false, false );

	if ( ! empty( $gallery['ids'] ) ) {
		$thumb_classes .= ' wd-carousel-container wd-post-gallery color-scheme-light';

		$gallery['images_id'] = explode( ',', $gallery['ids'] );
	}
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
	<div class="wd-post-inner">
		<div class="wd-post-thumb<?php echo esc_attr( $thumb_classes ); ?>">
			<?php if ( 'gallery' === $post_format && $gallery_slider && ! empty( $gallery['images_id'] ) ) : ?>
				<?php
				woodmart_enqueue_js_library( 'swiper' );
				woodmart_enqueue_js_script( 'swiper-carousel' );
				woodmart_enqueue_inline_style( 'swiper' );
				?>
				<div class="wd-carousel-inner">
					<div class="wd-carousel wd-grid"<?php echo woodmart_get_carousel_attributes( array( 'autoheight' => 'yes' ) ); ?>>
						<div class="wd-carousel-wrap">
							<?php
							foreach ( $gallery['images_id'] as $image_id ) {
								?>
								<div class="wd-carousel-item">
									<?php echo woodmart_otf_get_image_html( $image_id, apply_filters( 'woodmart_gallery_post_format_size', 'large' ) ); ?>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php woodmart_get_carousel_nav_template( ' wd-post-arrows wd-pos-sep wd-custom-style' ); ?>
				</div>
			<?php else : ?>
				<div class="wd-post-img">
					<?php echo woodmart_get_post_thumbnail( 'large' ); // phpcs:ignore ?>
				</div>
			<?php endif; ?>
			<?php
			woodmart_post_date(
				array(
					'style' => 'wd-style-with-bg',
				)
			);
			?>
			<?php /* translators: %s: Post title */ ?>
			<a class="wd-post-link wd-fill" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" aria-label="<?php echo esc_attr( sprintf( __( 'Link on post %s', 'woodmart' ), esc_attr( get_the_title() ) ) ); ?>"></a>
			<?php if ( woodmart_loop_prop( 'parts_meta' ) && get_the_category_list( ', ' ) ) : ?>
				<div class="wd-post-cat wd-style-with-bg">
					<?php echo get_the_category_list( ', ' ); // phpcs:ignore ?>
				</div>
			<?php endif ?>
		</div>

		<div class="wd-post-content">
			<div class="wd-post-content-inner wd-scroll">
				<?php if ( woodmart_loop_prop( 'parts_meta' ) ) : ?>
					<div class="wd-post-header">
						<?php if ( is_sticky() ) : ?>
							<div class="wd-featured-post">
								<?php esc_html_e( 'Featured', 'woodmart' ); ?>
							</div>
						<?php endif; ?>

						<div class="wd-meta-author">
							<?php woodmart_post_meta_author( true, 'long' ); ?>
						</div>

						<div class="wd-post-actions">
							<?php if ( woodmart_is_social_link_enable( 'share' ) ) : ?>
								<div class="wd-post-share wd-tltp">
									<div class="tooltip top">
										<div class="tooltip-inner">
											<?php
											if ( function_exists( 'woodmart_shortcode_social' ) ) {
												echo woodmart_shortcode_social( // phpcs:ignore
													array(
														'size' => 'small',
														'color' => 'light',
													)
												);}
											?>
										</div>
										<div class="tooltip-arrow"></div>
									</div>
								</div>
							<?php endif ?>

							<?php if ( comments_open() ) : ?>
								<div class="wd-meta-reply">
									<?php woodmart_post_meta_reply(); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( woodmart_loop_prop( 'parts_title' ) ) : ?>
					<h3 class="wd-entities-title title post-title">
						<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
							<?php the_title(); ?>
						</a>
					</h3>
				<?php endif ?>
				<?php if ( woodmart_loop_prop( 'parts_text' ) ) : ?>
					<div class="wd-post-desc wd-scroll-content">
						<?php if ( is_search() ) : ?>
							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div>
						<?php else : ?>
							<?php
							woodmart_get_content( false );

							wp_link_pages(
								array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'woodmart' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								)
							);
							?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			<?php if ( woodmart_loop_prop( 'parts_btn' ) ) : ?>
				<?php woodmart_render_read_more_btn(); ?>
			<?php endif; ?>
		</div>
	</div>
</article>
