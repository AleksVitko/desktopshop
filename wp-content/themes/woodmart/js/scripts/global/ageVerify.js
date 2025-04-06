/* global woodmart_settings */
(function($) {
	woodmartThemeModule.ageVerify = function() {
		if ( typeof Cookies === 'undefined' ) {
			return;
		}

		if (woodmart_settings.age_verify !== 'yes' || Cookies.get('woodmart_age_verify') === 'confirmed') {
			return;
		}

		$.magnificPopup.open({
			items          : {
				src: '.wd-age-verify'
			},
			type           : 'inline',
			closeOnBgClick : false,
			closeBtnInside : false,
			showCloseBtn   : false,
			enableEscapeKey: false,
			removalDelay   : 600,
			tClose         : woodmart_settings.close,
			tLoading       : woodmart_settings.loading,
			fixedContentPos: true,
			callbacks      : {
				beforeOpen: function() {
					this.wrap.addClass('wd-popup-slide-from-left');
				}
			}
		});

		$('.wd-age-verify-allowed').on('click', function(e) {
			e.preventDefault();
			Cookies.set('woodmart_age_verify', 'confirmed', {
				expires: parseInt(woodmart_settings.age_verify_expires),
			 	path   : '/',
				secure : woodmart_settings.cookie_secure_param
			});

			$.magnificPopup.close();
		});

		$('.wd-age-verify-forbidden').on('click', function(e) {
			e.preventDefault();
			$('.wd-age-verify').addClass('wd-forbidden');
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.ageVerify();
	});
})(jQuery);
