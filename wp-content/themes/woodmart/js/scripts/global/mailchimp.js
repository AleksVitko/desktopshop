
/* global woodmart_settings */
(function($) {
	woodmartThemeModule.fixMailchimpInPopup = function() {
		$('.mc4wp-form').each(function(key, $form) {
			$form = $( $form );
			$response = $form.find('.mc4wp-response');
			$popup = $form.parents('.wd-popup');

			if ( $response.children().length > 0 && $popup.length > 0 ) {
				$.magnificPopup.open({
					items: {
						src: $popup,
					},
					type: 'inline',
					removalDelay: 600,
					tClose: woodmart_settings.close,
					tLoading: woodmart_settings.loading,
					fixedContentPos: true,
					callbacks: {
						beforeOpen: function () {
							this.wrap.addClass('wd-popup-slide-from-left');
						}
					}
				});
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.fixMailchimpInPopup();
	});
})(jQuery);
