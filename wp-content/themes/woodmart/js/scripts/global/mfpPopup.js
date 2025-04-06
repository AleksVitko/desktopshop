/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdPortfolioLoadMoreLoaded', function () {
		woodmartThemeModule.mfpPopup();
	});

	woodmartThemeModule.mfpPopup = function() {
		if ('undefined' === typeof $.fn.magnificPopup) {
			return;
		}

		$('.gallery').magnificPopup({
			delegate       : 'a:not([data-elementor-open-lightbox]), a[data-elementor-open-lightbox=no]',
			type           : 'image',
			removalDelay   : 600,
			tClose         : woodmart_settings.close,
			tLoading       : woodmart_settings.loading,
			fixedContentPos: true,
			callbacks      : {
				beforeOpen: function() {
					this.wrap.addClass('wd-popup-slide-from-left');
				}
			},
			image       : {
				verticalFit: true,
				markup: '<div class="wd-popup mfp-figure">'+
					'<div class="mfp-close"></div>'+
					'<figure>'+
					'<div class="mfp-img"></div>'+
					'<figcaption>'+
					'<div class="mfp-bottom-bar">'+
					'<div class="mfp-title"></div>'+
					'<div class="mfp-counter"></div>'+
					'</div>'+
					'</figcaption>'+
					'</figure>'+
					'</div>'
			},
			gallery     : {
				enabled           : true,
				navigateByImgClick: true
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.mfpPopup();
	});
})(jQuery);
