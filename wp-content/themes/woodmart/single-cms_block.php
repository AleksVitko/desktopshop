<?php
/**
 * The template for displaying all html block.
 *
 * @package xts
 */

if ( ! current_user_can( apply_filters( 'woodmart_html_block_access', 'edit_posts' ) ) ) {
	wp_die( 'You do not have access.', '', array( 'back_link' => true ) );
}

get_header();

?>
<?php if ( woodmart_is_elementor_installed() && ( woodmart_elementor_is_edit_mode() || woodmart_elementor_is_preview_page() || woodmart_elementor_is_preview_mode() ) ) : ?>
	<div class="wd-html-block-scheme-switcher">
		<div class="wd-html-block-scheme-dark" data-color="#ffffff">
			<?php esc_html_e( 'Dark', 'woodmart' ); ?>
		</div>

		<div class="wd-html-block-scheme-light" data-color="#212121">
			<?php esc_html_e( 'Light', 'woodmart' ); ?>
		</div>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.wd-html-block-scheme-switcher > div').on('click', function() {
				var color          = jQuery(this).data('color');
				var websiteWrapper = jQuery('.wd-page-wrapper');

				websiteWrapper.css('background-color', color);

				if ( '#212121' === color && ! websiteWrapper.hasClass('color-scheme-light') ) {
					websiteWrapper.addClass('color-scheme-light');
				} else if ( '#ffffff' === color ) {
					websiteWrapper.removeClass('color-scheme-light');
				}
			});
		});
	</script>
<?php endif; ?>

<div class="container">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; ?>
</div>

<?php

get_footer();
