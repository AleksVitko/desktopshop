/* global woodmart_settings */
(function($) {
	$.each([
		'frontend/element_ready/wd_popup.default',
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.contentPopup();
		});
	});

	woodmartThemeModule.$document.on('wdShopPageInit', function() {
		woodmartThemeModule.contentPopup();
	});

	woodmartThemeModule.contentPopup = function() {
		if ('undefined' === typeof $.fn.magnificPopup) {
			return;
		}

		woodmartThemeModule.$document.on('click', '.wd-open-popup, .wp-block-wd-popup > a', function(e) {
			e.preventDefault();

			var $btn = $(this);
			var $content = $btn.parent().siblings('.wd-popup');

			if ($btn.hasClass('wp-block-wd-button')) {
				$content = $btn.siblings('.wd-popup');
			} else if ($btn.attr('href')) {
				$content = $($btn.attr('href'))
			}

			$.magnificPopup.open({
				items          : {
					src : $content,
					type: 'inline',
				},
				removalDelay   : 600, //delay removal by X to allow out-animation
				tClose         : woodmart_settings.close,
				tLoading       : woodmart_settings.loading,
				fixedContentPos: true,
				callbacks      : {
					beforeOpen: function() {
						this.wrap.addClass('wd-popup-slide-from-left');
					},
					open      : function() {
						woodmartThemeModule.$document.trigger('wood-images-loaded');
						woodmartThemeModule.$document.trigger('wdOpenPopup');
					},
				}
			});
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.contentPopup();
	});
})(jQuery);
