/* global woodmart_settings */
(function($) {
	$.each([
		'frontend/element_ready/wd_products.default',
		'frontend/element_ready/wd_products_tabs.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.addToCart();
		});
	});

	woodmartThemeModule.addToCart = function() {
		var that = this;
		var timeoutNumber = 0;
		var timeout;

		woodmartThemeModule.$body.on('added_to_cart', function(e, data) {
			if (data && (data.stop_reload || data.e_manually_triggered)) {
				return false;
			}

			if (woodmart_settings.add_to_cart_action === 'popup') {
				var html = [
					'<div class="added-to-cart">',
					'<h3>' + woodmart_settings.added_to_cart + '</h3>',
					'<a href="#" class="btn close-popup">' + woodmart_settings.continue_shopping + '</a>',
					'<a href="' + woodmart_settings.cart_url + '" class="btn view-cart">' + woodmart_settings.view_cart + '</a>',
					'</div>'
				].join('');

				$.magnificPopup.open({
					removalDelay   : 600, //delay removal by X to allow out-animation
					tClose         : woodmart_settings.close,
					tLoading       : woodmart_settings.loading,
					fixedContentPos: true,
					callbacks      : {
						beforeOpen: function() {
							this.wrap.addClass('wd-popup-slide-from-left');
						}
					},
					items          : {
						src : '<div class="wd-popup popup-added_to_cart">' + html + '</div>',
						type: 'inline'
					}
				});

				$('.popup-added_to_cart').on('click', '.close-popup', function(e) {
					e.preventDefault();
					$.magnificPopup.close();
				});

				closeAfterTimeout();
			} else if (woodmart_settings.add_to_cart_action === 'widget') {
				clearTimeout(timeoutNumber);
				var $selector = $('.act-scroll .wd-header-cart .wd-dropdown-cart, .whb-sticked .wd-header-cart .wd-dropdown-cart');

				if ($selector.length > 0) {
					$selector.addClass('wd-opened');
				} else {
					$('.whb-header .wd-header-cart .wd-dropdown-cart').addClass('wd-opened');
				}

				var $cartOpener = $('.cart-widget-opener');
				if ($cartOpener.length > 0) {
					$cartOpener.first().trigger('click');
				}

				timeoutNumber = setTimeout(function() {
					$('.wd-dropdown-cart').removeClass('wd-opened');
				}, 3500);

				closeAfterTimeout();
			}

			woodmartThemeModule.$document.trigger('wdActionAfterAddToCart');
		});

		var closeAfterTimeout = function() {
			if ('yes' !== woodmart_settings.add_to_cart_action_timeout) {
				return false;
			}

			clearTimeout(timeout);

			timeout = setTimeout(function() {
				$('.wd-close-side').trigger('click');
				$.magnificPopup.close();
			}, parseInt(woodmart_settings.add_to_cart_action_timeout_number) * 1000);
		};
	};

	$(document).ready(function() {
		woodmartThemeModule.addToCart();
	});
})(jQuery);
