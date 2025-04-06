/* global woodmart_settings */
(function($) {
	woodmartThemeModule.moreCategoriesButton = function() {
		$('.wd-more-cat').each(function() {
			var $wrapper = $(this);

			$wrapper.find('.wd-more-cat-btn a').on('click', function(e) {
				e.preventDefault();
				$wrapper.toggleClass('wd-show-cat');

				woodmartThemeModule.$document.trigger('wood-images-loaded');
			});
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.moreCategoriesButton();
	});
})(jQuery);
