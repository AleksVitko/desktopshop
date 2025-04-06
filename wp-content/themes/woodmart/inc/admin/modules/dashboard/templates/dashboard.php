<div class="xts-welcome-page">

	<?php if ( woodmart_get_opt( 'white_label' ) ) : ?>
		<div class="xts-box xts-white-label-box xts-theme-style">
			<div class="xts-box-content">
				<h3>
					<?php if ( woodmart_get_opt( 'white_label_dashboard_title' ) ) : ?>
						<?php echo esc_html( woodmart_get_opt( 'white_label_dashboard_title' ) ); ?>
					<?php else : ?>
						<?php esc_html_e( 'Welcome to WoodMart', 'woodmart' ); ?>
					<?php endif; ?>
				</h3>
				<div class="xts-about-text">
					<?php if ( woodmart_get_opt( 'white_label_dashboard_text' ) ) : ?>
						<?php echo wp_kses( woodmart_get_opt( 'white_label_dashboard_text' ), true ); ?>
					<?php else : ?>
						<?php esc_html_e( 'Thank you for choosing WoodMart, our premium eCommerce theme! Get started building your stunning online store by easily importing our prebuilt demo sites and customizing the theme options to suit your needs.', 'woodmart' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php else : ?>
		<div class="xts-box xts-welcome-box xts-theme-style xts-color-scheme-light">
			<div class="xts-box-content">
				<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/banner.png' ); ?>" alt="banner">

				<h3>
					<?php esc_html_e( 'Welcome to WoodMart', 'woodmart' ); ?>
				</h3>

				<p>
					<?php esc_html_e( 'Thank you for choosing WoodMart, our premium eCommerce theme! Get started building your stunning online store by easily importing our prebuilt demo sites and customizing the theme options to suit your needs.', 'woodmart' ); ?>
				</p>

				<?php if ( woodmart_get_opt( 'white_label_changelog_tab' ) ) : ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=xts_changelog' ) ); ?>" class="xts-btn">
						<?php esc_html_e( 'What\'s new', 'woodmart' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="xts-row xts-welcome-row xts-sp-20 xts-theme-style">
			<div class="xts-col-12 xts-col-xl-6">
				<div class="xts-box xts-info-boxes">
					<div class="xts-box-content">
						<h4>
							<?php esc_html_e( 'Need assistance?', 'woodmart' ); ?>
						</h4>

						<p>
							<?php esc_html_e( 'Check out these links for more information and support!', 'woodmart' ); ?>
						</p>

						<div class="xts-row">
							<div class="xts-col">
								<div class="xts-info-box-img">
									<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/docs.jpg' ); ?>" alt="documentation banner">
								</div>
								<a href="https://xtemos.com/documentation/woodmart/" class="xts-bordered-btn xts-color-default" target="_blank">
									<?php esc_html_e( 'Documentation', 'woodmart' ); ?>
								</a>
							</div>

							<div class="xts-col">
								<div class="xts-info-box-img">
									<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/video.jpg' ); ?>" alt="video banner">
								</div>
								<a href="https://www.youtube.com/channel/UCu3loFwqqOQ9z-YTcnplK8w/" class="xts-bordered-btn xts-color-default" target="_blank">
									<?php esc_html_e( 'Video tutorials', 'woodmart' ); ?>
								</a>
							</div>

							<div class="xts-col">
								<div class="xts-info-box-img">
									<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/forum.jpg' ); ?>" alt="forum banner">
								</div>
								<a href="https://xtemos.com/forums/forum/woodmart-premium-template/" class="xts-bordered-btn xts-color-default" target="_blank">
									<?php esc_html_e( 'Support forum', 'woodmart' ); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="xts-col-12 xts-col-xl-6">
				<div class="xts-box xts-info-boxes xts-align-center">
					<div class="xts-box-content">
						<h4>
							<?php esc_html_e( 'Enjoying the theme?', 'woodmart' ); ?>
						</h4>

						<p>
							<?php esc_html_e( 'Share your thoughts by leaving a comment on ThemeForest.', 'woodmart' ); ?>
						</p>

						<div class="xts-row">
							<div class="xts-col">
								<div class="xts-info-box-img">
									<img src="<?php echo esc_url( WOODMART_ASSETS_IMAGES . '/dashboard/vote.jpg' ); ?>" alt="vote banner">
								</div>
								<a href="https://themeforest.net/downloads" class="xts-bordered-btn xts-color-default" target="_blank">
									<?php esc_html_e( 'Rate our theme', 'woodmart' ); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

</div>