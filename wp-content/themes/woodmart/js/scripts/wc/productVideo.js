/* global woodmart_settings */
(function($) {
	woodmartThemeModule.productVideo = function() {
		if ('undefined' === typeof $.fn.magnificPopup) {
			return;
		}

		$('.product-video-button a').magnificPopup({
			tClose         : woodmart_settings.close,
			tLoading       : woodmart_settings.loading,
			type           : 'iframe',
			removalDelay   : 600,
			iframe         : {
				markup  : '<div class="wd-popup wd-with-video">' +
					'<div class="mfp-close"></div>' +
					'<iframe class="mfp-iframe" src="//about:blank" allowfullscreen></iframe>' +
					'</div>',
				patterns: {
					youtube: {
						index: 'youtube.com/',
						id   : 'v=',
						src  : '//www.youtube.com/embed/%id%?rel=0&autoplay=1'
					}
				}
			},
			preloader      : false,
			fixedContentPos: true,
			callbacks      : {
				beforeOpen: function() {
					this.wrap.addClass('wd-popup-slide-from-left');
				}
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.productVideo();
	});
})(jQuery);
