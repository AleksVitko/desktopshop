<?php
/**
 * Page builder template.
 *
 * @package woodmart
 */

?>

<div class="xts-wizard-content-inner xts-wizard-page-builder">

	<h3>
		<?php esc_html_e( 'Page builder', 'woodmart' ); ?>
	</h3>

	<p>
		<?php esc_html_e( 'Choose one of the following page builders.', 'woodmart' ); ?>
	</p>

	<div class="xts-wizard-builder-select">
		<div class="xts-wizard-elementor xts-active" data-builder="elementor">
			<div class="xts-page-builder-img">
				<img src="<?php echo esc_url( $this->get_image_url( 'elementor-builder.svg' ) ); ?>" alt="elementor logo">
			</div>

			<div class="xts-page-builder-text">
				<div class="xts-page-builder-title">
					<?php esc_attr_e( 'Elementor', 'woodmart' ); ?>
				</div>

				<p>
					<?php esc_attr_e( 'The World\'s Leading WordPress Website Builder', 'woodmart' ); ?>
				</p>
			</div>
		</div>

		<div class="xts-wizard-gutenberg" data-builder="gutenberg">
			<div class="xts-page-builder-img">
				<img src="<?php echo esc_url( $this->get_image_url( 'gutenberg.svg' ) ); ?>" alt="gutenberg logo">
			</div>

			<div class="xts-page-builder-text">
				<div class="xts-page-builder-title">
					<?php esc_attr_e( 'Gutenberg', 'woodmart' ); ?>
				</div>

				<p>
					<?php esc_attr_e( 'Block based WordPress page content editor', 'woodmart' ); ?>
				</p>
			</div>
		</div>

		<div class="xts-wizard-wpb" data-builder="wpb">
			<div class="xts-page-builder-img">
				<img src="<?php echo esc_url( $this->get_image_url( 'wpb.svg' ) ); ?>" alt="wpb logo">
			</div>

			<div class="xts-page-builder-text">
				<div class="xts-page-builder-title">
					<?php esc_attr_e( 'WPBakery', 'woodmart' ); ?>
				</div>

				<p>
					<?php esc_attr_e( 'WPBakery Page Builder plugin for WordPress', 'woodmart' ); ?>
				</p>
			</div>
		</div>
	</div>

</div>

<div class="xts-wizard-footer">
	<?php $this->get_prev_button( 'child-theme' ); ?>
	<?php $this->get_next_button( 'plugins', 'elementor' ); ?>
	<?php $this->get_next_button( 'plugins', 'gutenberg' ); ?>
	<?php $this->get_next_button( 'plugins', 'wpb' ); ?>
</div>
