/* global woodmart_settings */
(function($) {
	woodmartThemeModule.stickySocialButtons = function() {
		$('.wd-sticky-social').addClass('wd-loaded');
	};

	$(document).ready(function() {
		woodmartThemeModule.stickySocialButtons();
	});
})(jQuery);
