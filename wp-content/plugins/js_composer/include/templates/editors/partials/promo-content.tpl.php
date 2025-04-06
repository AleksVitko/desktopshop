<?php
/**
 * Promo content template.
 *
 * @var bool $is_about_page
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>
<img class="vc-featured-img" src="<?php echo esc_url( vc_asset_url( 'vc/wpb-8-0-about.png' ) ); ?>"/>

<div class="vc-feature-text">
	<h3><?php esc_html_e( 'Introducing New Features in 8.1 Release', 'js_composer' ); ?></h3>

	<p><?php esc_html_e( "The final update of 2024 is designed to deliver a smoother, more reliable building experience, for a more streamlined workflow. We've fine-tuned the page builder to ensure it continues to meet your expectations, empowering you to create stunning websites with ease. Thank you for being part of our journey this year. As we look ahead, we're committed to bringing you even more innovation and functionality in the coming updates. Here's to an incredible year of creativity and growth together!", 'js_composer' ); ?></p>
	<?php
	$tabs = vc_settings()->getTabs();
	$is_license_tab_access = isset( $tabs['vc-updater'] ) && vc_user_access()->part( 'settings' )->can( 'vc-updater-tab' )->get();
	if ( $is_about_page && ! vc_license()->isActivated() && $is_license_tab_access ) :
		?>
		<div class="vc-feature-activation-section">
			<?php $url = 'admin.php?page=vc-updater'; ?>
			<a href="<?php echo esc_attr( is_network_admin() ? network_admin_url( $url ) : admin_url( $url ) ); ?>" class="vc-feature-btn" id="vc_settings-updater-button" data-vc-action="activation"><?php esc_html_e( 'Activate License', 'js_composer' ); ?></a>
			<p class="vc-feature-info-text">
				<?php esc_html_e( 'Direct plugin activation only.', 'js_composer' ); ?>
				<a href="https://wpbakery.com/wpbakery-page-builder-license/?utm_source=wpdashboard&utm_medium=wpb-settings-about-whats-new&utm_content=text" target="_blank" rel="noreferrer noopener"><?php esc_html_e( 'Don\'t have a license?', 'js_composer' ); ?></a>
			</p>
		</div>
	<?php endif; ?>
</div>
