/* global woodmart_settings */
(function($) {
	woodmartThemeModule.addToCartAllTypes = function() {
		if (woodmart_settings.ajax_add_to_cart == false) {
			return;
		}

		woodmartThemeModule.$body.on('submit', 'form.cart', function(e) {
			var $form = $(this);
			var $productWrapper = $form.parents('.single-product-page');

			if ($productWrapper.length === 0) {
				$productWrapper = $form.parents('.product-quick-view');
			}

			if ($productWrapper.hasClass('product-type-external') || $productWrapper.hasClass('product-type-zakeke') || $productWrapper.hasClass('product-type-gift-card') || 'undefined' !== typeof e.originalEvent && $(e.originalEvent.submitter).hasClass('wd-buy-now-btn')) {
				return;
			}

			if ($form.parents('.wd-sticky-btn-cart').length > 0) {
				var $stickyBtnWrap = $form.parents('.wd-sticky-btn-cart');

				if ($stickyBtnWrap.hasClass('wd-product-type-external')) {
					return;
				}
			}

			e.preventDefault();

			var $thisbutton = $form.find('.single_add_to_cart_button'),
			    data        = $form.serialize();

			data += '&action=woodmart_ajax_add_to_cart';

			if ($thisbutton.val()) {
				data += '&add-to-cart=' + $thisbutton.val();
			}

			$thisbutton.removeClass('added not-added');
			$thisbutton.addClass('loading');

			// Trigger event
			woodmartThemeModule.$body.trigger('adding_to_cart', [
				$thisbutton,
				data
			]);

			$.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : data,
				method  : 'POST',
				success : function(response) {
					if (!response) {
						return;
					}

					var this_page = window.location.toString();

					this_page.replace('add-to-cart', 'added-to-cart');

					if (response.error && response.product_url) {
						window.location = response.product_url;
						return;
					}

					// Redirect to cart option
					if (woodmart_settings.cart_redirect_after_add === 'yes') {
						window.location = woodmart_settings.cart_url;
					} else {

						$thisbutton.removeClass('loading');

						var fragments = response.fragments || {};
						var cart_hash = response.cart_hash;

						// Block fragments class
						if (fragments) {
							$.each(fragments, function(key) {
								$(key).addClass('updating');
							});

							// Replace fragments
							$.each(fragments, function(key, value) {
								$(key).replaceWith(value);
							});
						}

						// Show notices
						var $noticeWrapper = $('.woocommerce-notices-wrapper');
						$noticeWrapper.empty();
						if (response.notices && response.notices.indexOf('error') > 0) {
							$noticeWrapper.append(response.notices);
							$thisbutton.addClass('not-added');

							woodmartThemeModule.$body.trigger('not_added_to_cart', [
								fragments,
								cart_hash,
								$thisbutton
							]);
						} else {
							if ('undefined' !== typeof $.fn.magnificPopup && woodmart_settings.add_to_cart_action === 'widget') {
								$.magnificPopup.close();
							}

							// Changes button classes
							$thisbutton.addClass('added');
							// Trigger event so themes can refresh other areas
							woodmartThemeModule.$body.trigger('added_to_cart', [
								fragments,
								cart_hash,
								$thisbutton
							]);
						}
					}
				},
				error   : function() {
					console.log('ajax adding to cart error');
				},
				complete: function() { }
			});
		});

		woodmartThemeModule.$body.on('click', '.variations_form .wd-buy-now-btn', function(e) {
			var $this = $(this);
			var $addToCartBtn = $this.siblings('.single_add_to_cart_button');

			if ( 'undefined' !== typeof wc_add_to_cart_variation_params && $addToCartBtn.hasClass('disabled') ) {
				e.preventDefault();

				if ($addToCartBtn.hasClass('wc-variation-is-unavailable') ) {
					alert( wc_add_to_cart_variation_params.i18n_unavailable_text );
				} else if ( $addToCartBtn.hasClass('wc-variation-selection-needed') ) {
					alert( wc_add_to_cart_variation_params.i18n_make_a_selection_text );
				}
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.addToCartAllTypes();
	});
})(jQuery);
