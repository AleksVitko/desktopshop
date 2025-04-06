/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdBackHistory wdShopPageInit', function() {
		woodmartThemeModule.woocommercePriceSlider();
	});

	woodmartThemeModule.woocommercePriceSlider = function() {
		var $amount          = $('.price_slider_amount');
		var $min_price       = $('.price_slider_amount #min_price');
		var $max_price       = $('.price_slider_amount #max_price');
		var $products        = $('.products');
		var currentUrlParams = new URL(window.location.href);

		if (typeof woocommerce_price_slider_params === 'undefined' || $min_price.length < 1 || !$.fn.slider) {
			return false;
		}

		var $slider = $('.price_slider');

		if ($slider.slider('instance') !== undefined) {
			return;
		}

		// Get markup ready for slider
		$('input#min_price, input#max_price').hide();
		$('.price_slider, .price_label').show();

		// Price slider uses $ ui
		var min_price         = parseInt($min_price.data('min'));
		var max_price         = parseInt($max_price.data('max'));
		var step              = $amount.data('step') || 1;
		var current_min_price = parseInt(currentUrlParams.searchParams.has('min_price') ? currentUrlParams.searchParams.get('min_price') : min_price, 10);
		var current_max_price = parseInt(currentUrlParams.searchParams.has('max_price') ? currentUrlParams.searchParams.get('max_price') : max_price, 10);

		if ($products.attr('data-min_price') && $products.attr('data-min_price').length > 0) {
			current_min_price = parseInt($products.attr('data-min_price'), 10);
		}

		if ($products.attr('data-max_price') && $products.attr('data-max_price').length > 0) {
			current_max_price = parseInt($products.attr('data-max_price'), 10);
		}

		$slider.slider({
			range  : true,
			animate: true,
			min    : min_price,
			max    : max_price,
			step   : step,
			values : [
				current_min_price,
				current_max_price
			],
			create : function() {
				$min_price.val(current_min_price);
				$max_price.val(current_max_price);

				woodmartThemeModule.$body.trigger('price_slider_create', [
					current_min_price,
					current_max_price
				]);
			},
			slide  : function(event, ui) {
				$min_price.val(ui.values[0]);
				$max_price.val(ui.values[1]);

				woodmartThemeModule.$body.trigger('price_slider_slide', [
					ui.values[0],
					ui.values[1]
				]);
			},
			change : function(event, ui) {
				woodmartThemeModule.$body.trigger('price_slider_change', [
					ui.values[0],
					ui.values[1]
				]);
			}
		});

		setTimeout(function() {
			woodmartThemeModule.$body.trigger('price_slider_create', [
				current_min_price,
				current_max_price
			]);

			if ($slider.find('.ui-slider-range').length > 1) {
				$slider.find('.ui-slider-range').first().remove();
			}
		}, 10);
	};

	$(document).ready(function() {
		woodmartThemeModule.woocommercePriceSlider();
	});
})(jQuery);
