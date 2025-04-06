(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit', function () {
		woodmartThemeModule.buttonShowMore();
	});

	$.each([
		'frontend/element_ready/wd_button.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.buttonShowMore();
		});
	});

	woodmartThemeModule.buttonShowMore = function () {
		$('.wd-collapsible-content, .wp-block-wd-collapsible-content').each(function() {
			var $this = $(this);
			var $button = $this.find('.wd-collapsible-button, > .wp-block-wd-button');

			$button.on('click', function(e) {
				e.preventDefault();

				$this.toggleClass('wd-opened');

				if ($this.data('alt-text')) {
					var $buttonText = $button.find('span');
					var text = $buttonText.text();
					$buttonText.text($this.data('alt-text'));
					$this.data('alt-text', text);
				}
			});
		});
	}

	$(document).ready(function() {
		woodmartThemeModule.buttonShowMore();
	});
})(jQuery);