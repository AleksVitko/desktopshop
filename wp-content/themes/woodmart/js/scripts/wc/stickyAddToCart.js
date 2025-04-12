/* global woodmart_settings */
(function($) {
	woodmartThemeModule.stickyAddToCart = function() {
		var $trigger = $('form.cart, .out-of-stock');
		var $stickyBtn = $('.wd-sticky-btn');

		if ($stickyBtn.length <= 0 || $trigger.length <= 0 || (woodmartThemeModule.$window.width() <= 768 && !woodmartThemeModule.$body.hasClass('wd-sticky-btn-on-mb'))) {
			return;
		}

		var quantityOverlap = function() {
			if (woodmartThemeModule.$window.width() <= 768 && woodmartThemeModule.$body.hasClass('wd-sticky-btn-on-mb')) {
				$stickyBtn.addClass('wd-quantity-overlap');
			} else {
				$stickyBtn.removeClass('wd-quantity-overlap');
			}
		};

		quantityOverlap();
		woodmartThemeModule.$window.on('resize', quantityOverlap);

		var summaryOffset = $trigger.offset().top + $trigger.outerHeight();
		var $scrollToTop = $('.scrollToTop');

		var stickyAddToCartToggle = function() {
			var windowScroll = woodmartThemeModule.$window.scrollTop();

			if (summaryOffset < windowScroll) {
				$stickyBtn.addClass('wd-sticky-btn-shown');
				$scrollToTop.addClass('wd-sticky-btn-shown');

			} else if (summaryOffset > windowScroll) {
				$stickyBtn.removeClass('wd-sticky-btn-shown');
				$scrollToTop.removeClass('wd-sticky-btn-shown');
			}
		};

		stickyAddToCartToggle();

		woodmartThemeModule.$window.on('scroll', stickyAddToCartToggle);

		$('.wd-sticky-add-to-cart, .wd-sticky-btn-cart > .wd-buy-now-btn').on('click', function(e) {
			e.preventDefault();

			var headerHeight = $('.whb-header .whb-row.whb-sticky-row').length > 0 ? $('.whb-header .whb-main-header').outerHeight() : 0;

			var $stickyHeader = $('.whb-sticky-header');
			var stickyHeaderHeight = $stickyHeader.length ? $stickyHeader.outerHeight() : headerHeight;

			var scrollTo = $('.summary-inner .variations_form, .wd-single-add-cart .variations_form').offset().top - stickyHeaderHeight - woodmart_settings.sticky_add_to_cart_offset;

			$('html, body').animate({
				scrollTop: scrollTo
			}, 800);
		});

		// Wishlist.
		$('.wd-sticky-btn .wd-wishlist-btn a').on('click', function(e) {
			if (!$(this).hasClass('added')) {
				e.preventDefault();
			}

			$('.summary-inner > .wd-wishlist-btn a').trigger('click');
		});

		woodmartThemeModule.$document.on('added_to_wishlist', function() {
			$('.wd-sticky-btn .wd-wishlist-btn a').addClass('added');
		});

		// Compare.
		$('.wd-sticky-btn .wd-compare-btn a').on('click', function(e) {
			if (!$(this).hasClass('added')) {
				e.preventDefault();
			}

			$('.summary-inner > .wd-compare-btn a').trigger('click');
		});

		woodmartThemeModule.$document.on('added_to_compare', function() {
			$('.wd-sticky-btn .wd-compare-btn a').addClass('added');
		});

		// Quantity.
		$('.wd-sticky-btn-cart .qty').on('change', function() {
			$('.summary-inner .qty').val($(this).val());
		});

		$('.summary-inner .qty').on('change', function() {
			$('.wd-sticky-btn-cart .qty').val($(this).val());
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.stickyAddToCart();
	});
})(jQuery);
