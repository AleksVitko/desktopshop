/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit', function () {
		woodmartThemeModule.productFilters();
	});

	$.each([
		'frontend/element_ready/wd_product_filters.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.productFilters();
		});
	});

	woodmartThemeModule.productFilters = function() {
		// Price slider init.
		woodmartThemeModule.$body.on('filter_price_slider_create filter_price_slider_slide', function(event, min, max, minPrice, maxPrice, $slider) {
			if ('undefined' === typeof accounting) {
				return
			}

			var minHtml = accounting.formatMoney(min, {
				symbol   : woocommerce_price_slider_params.currency_format_symbol,
				decimal  : woocommerce_price_slider_params.currency_format_decimal_sep,
				thousand : woocommerce_price_slider_params.currency_format_thousand_sep,
				precision: woocommerce_price_slider_params.currency_format_num_decimals,
				format   : woocommerce_price_slider_params.currency_format
			});

			var maxHtml = accounting.formatMoney(max, {
				symbol   : woocommerce_price_slider_params.currency_format_symbol,
				decimal  : woocommerce_price_slider_params.currency_format_decimal_sep,
				thousand : woocommerce_price_slider_params.currency_format_thousand_sep,
				precision: woocommerce_price_slider_params.currency_format_num_decimals,
				format   : woocommerce_price_slider_params.currency_format
			});

			$slider.siblings('.filter_price_slider_amount').find('span.from').html(minHtml);
			$slider.siblings('.filter_price_slider_amount').find('span.to').html(maxHtml);

			var $results = $slider.parents('.wd-pf-checkboxes').find('.wd-pf-results');
			var value = $results.find('.selected-value');

			if (min === minPrice && max === maxPrice) {
				value.remove();
			} else {
				if (value.length === 0) {
					$results.prepend('<li class="selected-value" data-title="price-filter" data-min="' + minPrice + '" data-max="' + maxPrice + '">' + minHtml + ' - ' + maxHtml + '</li>');
				} else {
					value.html(minHtml + ' - ' + maxHtml);
				}
			}

			woodmartThemeModule.$body.trigger('price_slider_updated', [
				min,
				max
			]);
		});

		$('.wd-pf-price-range .price_slider_widget').each(function() {
			var $this            = $(this);
			var $minInput        = $this.siblings('.filter_price_slider_amount').find('.min_price');
			var $maxInput        = $this.siblings('.filter_price_slider_amount').find('.max_price');
			var minPrice         = parseInt($minInput.data('min'));
			var maxPrice         = parseInt($maxInput.data('max'));
			var currentUrlParams = new URL(window.location.href);
			var currentMinPrice  = parseInt(currentUrlParams.searchParams.has('min_price') ? currentUrlParams.searchParams.get('min_price') : $minInput.val());
			var currentMaxPrice  = parseInt(currentUrlParams.searchParams.has('max_price') ? currentUrlParams.searchParams.get('max_price') : $maxInput.val());

			$('.price_slider_widget, .price_label').show();

			if (isNaN(currentMinPrice)) {
				currentMinPrice = minPrice;
			}

			if (isNaN(currentMaxPrice)) {
				currentMaxPrice = maxPrice;
			}

			$this.slider({
				range  : true,
				animate: true,
				min    : minPrice,
				max    : maxPrice,
				values : [
					currentMinPrice,
					currentMaxPrice
				],
				create : function() {
					if (currentMinPrice === minPrice && currentMaxPrice === maxPrice) {
						$minInput.val('');
						$maxInput.val('');
					}

					woodmartThemeModule.$body.trigger('filter_price_slider_create', [
						currentMinPrice,
						currentMaxPrice,
						minPrice,
						maxPrice,
						$this
					]);

					$this.closest('.wd-pf-price-range').on('click', '.wd-pf-results li', function(e) {
						var $selectedValueNode = $(this);
						var $filter            = $selectedValueNode.closest('.wd-pf-checkboxes');
						var $activeFilterLink  = $filter.find('.pf-value');

						$filter.find('.min_price').val('');
						$filter.find('.max_price').val('');

						$filter.find('.price_slider_widget').slider('values', [$filter.find('.min_price').data('min'), $filter.find('.max_price').data('max') ]);

						$selectedValueNode.remove();

						if ( 0 === $activeFilterLink.length ) {
							return;
						}

						var url = new URL($activeFilterLink.attr('href'));

						url.searchParams.delete('min_price');
						url.searchParams.delete('max_price');

						$activeFilterLink.attr('href', url.href);

						if ($activeFilterLink) {
							$activeFilterLink.trigger('click');
						}
					});
				},
				slide  : function(event, ui) {
					if (ui.values[0] === minPrice && ui.values[1] === maxPrice) {
						$minInput.val('');
						$maxInput.val('');
					} else {
						$minInput.val(ui.values[0]);
						$maxInput.val(ui.values[1]);
					}

					woodmartThemeModule.$body.trigger('filter_price_slider_slide', [
						ui.values[0],
						ui.values[1],
						minPrice,
						maxPrice,
						$this
					]);
				},
				change : function(event, ui) {
					woodmartThemeModule.$body.trigger('price_slider_change', [
						ui.values[0],
						ui.values[1]
					]);
				}
			});
		});

		var $forms = $('form.wd-product-filters');

		var removeValue = function($mainInput, currentVal) {
			if ($mainInput.length === 0) {
				return;
			}

			var mainInputVal = $mainInput.val();

			if (mainInputVal.indexOf(',') > 0) {
				$mainInput.val(mainInputVal.replace(',' + currentVal, '').replace(currentVal + ',', ''));
			} else {
				$mainInput.val(mainInputVal.replace(currentVal, ''));
			}
		}

		var defaultPjaxArgs = {
			container     : '.wd-page-content',
			timeout       : woodmart_settings.pjax_timeout,
			scrollTo      : false,
			renderCallback: function(context, html, afterRender) {
				woodmartThemeModule.removeDuplicatedStylesFromHTML(html, function(html) {
					context.html(html);
					afterRender();
					woodmartThemeModule.$document.trigger('wdShopPageInit');
					woodmartThemeModule.$document.trigger('wood-images-loaded');
				});
			},
		};

		$forms.each(function(index, $form) {
			$form                 = $($form);
			var $mainSubmitButton = $form.find('.wd-pf-btn button, .wp-block-wd-button');
			var $checkboxes       = $form.find('.wd-pf-checkboxes');

			//Label clear.
			$form.on('click', '.wd-pf-results li', function(e) {
				var $selectedValueNode = $(this);
				var selectedValue      = $selectedValueNode.data('title');
				var $filter            = $selectedValueNode.closest('.wd-pf-checkboxes');
				var $activeFilterLink  = $filter.find(`.pf-value[data-val="${selectedValue}"]`);

				if ( $filter.hasClass('wd-pf-price-range') ) {
					return;
				}

				if ( 0 === $mainSubmitButton.length ) {
					$activeFilterLink.trigger('click');
				} else {
					var $mainInput = $filter.find('.result-input');

					if ( $filter.hasClass('wd-pf-categories') ) {
						$filter.closest('form.wd-product-filters').attr('action', woodmart_settings.shop_url);
					}

					removeValue($mainInput, selectedValue);
					$activeFilterLink.closest('li').removeClass('wd-active');
					$selectedValueNode.remove();
				}
			});

			// Show dropdown on "click".
			$checkboxes.each(function() {
				var $this       = $(this);
				var $btn        = $this.find('.wd-pf-title');
				var multiSelect = $this.hasClass('multi_select');
	
				$btn.on('click', function(e) {
					var target = e.target;
	
					if ($(target).is($btn.find('.selected-value'))) {
						return;
					}
	
					if (!$this.hasClass('wd-opened')) {
						$this.addClass('wd-opened');
						setTimeout(function() {
							woodmartThemeModule.$document.trigger('wdProductFiltersOpened');
						}, 300);
					} else {
						close();
					}
				});
	
				woodmartThemeModule.$document.on('click', function(e) {
					var target = e.target;
	
					if ($this.hasClass('wd-opened') && (multiSelect && !$(target).is($this) && !$(target).parents().is($this)) || (!multiSelect && !$(target).is($btn) && !$(target).parents().is($btn))) {
						close();
					}
				});
	
				var close = function() {
					$this.removeClass('wd-opened');
				};
			});

			if ( 0 === $mainSubmitButton.length ) {
				// Submit form on "Dropdown select".
				$form.on('click', '.wd-pf-checkboxes li > .pf-value, .filter_price_slider_amount .pf-value', function(e) {
					var $priceAmount = $form.find('.filter_price_slider_amount');

					if ( $priceAmount.length > 0 ) {
						var $priceButton = $priceAmount.find('.pf-value');
						var $minInput    = $priceButton.siblings('.min_price');
						var $maxInput    = $priceButton.siblings('.max_price');
						var $link        = $priceButton.attr('href');
						var url          = new URL($link);

						if ($minInput.length && $maxInput.length) {
							if ($minInput.val()) {
								url.searchParams.set($minInput.attr('name'), $minInput.val());
							} else {
								url.searchParams.delete($minInput.attr('name'));
							}

							if ($maxInput.val()) {
								url.searchParams.set($maxInput.attr('name'), $maxInput.val());
							} else {
								url.searchParams.delete($maxInput.attr('name'));
							}

							$priceButton.attr('href', url.href);
						}

						$minInput.val('');
						$maxInput.val('');
					}

					// Send pjax.
					if ( '1' === woodmart_settings.ajax_shop && 'undefined' !== typeof ($.fn.pjax) ) {
						$.pjax.click(e, defaultPjaxArgs);
					}
				});
			} else {
				// Submit form on "Button click".
				$form.on('click', '.wd-pf-checkboxes li > .pf-value', function(e) {
					e.preventDefault();

					var $dataInput = $(this);
					var $thisForm  = $dataInput.closest('form.wd-product-filters');
					var $li        = $dataInput.parent();
					var $widget    = $dataInput.parents('.wd-pf-checkboxes');
					var $mainInput = $widget.find('.result-input');
					var $results   = $widget.find('.wd-pf-results');

					var multiSelect  = $widget.hasClass('multi_select');
					var mainInputVal = $mainInput.val();
					var currentText  = $dataInput.data('title');
					var currentVal   = $dataInput.data('val');

					if (multiSelect) {
						if (!$li.hasClass('wd-active')) {
							if (mainInputVal === '') {
								$mainInput.val(currentVal);
							} else {
								$mainInput.val(mainInputVal + ',' + currentVal);
							}

							$results.prepend('<li class="selected-value" data-title="' + currentVal + '">' + currentText + '</li>');
							$li.addClass('wd-active');
						} else {
							removeValue($mainInput, currentVal);
							$results.find('li[data-title="' + currentVal + '"]').remove();
							$li.removeClass('wd-active');
						}
					} else {
						if (!$li.hasClass('wd-active')) {
							$mainInput.val(currentVal);
							$results.find('.selected-value').remove();
							$results.prepend('<li class="selected-value" data-title="' + currentVal + '">' + currentText + '</li>');
							$li.parents('.wd-scroll-content').find('.wd-active').removeClass('wd-active');
							$li.addClass('wd-active');
						} else {
							$mainInput.val('');
							$results.find('.selected-value').remove();
							$li.removeClass('wd-active');
						}
					}

					if ( $widget.hasClass('wd-pf-categories') ) {
						var url  = new URL($dataInput.attr('href'));
						var link = woodmart_settings.shop_url;

						if ( $li.hasClass('wd-active') ) {
							var link = url.origin + url.pathname;
						}

						$thisForm.attr('action', link);
					}
				});

				// Send pjax.
				if ( '1' === woodmart_settings.ajax_shop  && 'undefined' !== typeof ($.fn.pjax) ) {
					$(document)
						.off('submit', 'form.wd-product-filters')
						.on('submit', 'form.wd-product-filters', function(e) {
							e.preventDefault();
							$form = $(this);

							defaultPjaxArgs.url  = $form.attr('action');
							defaultPjaxArgs.data = $form.find(':input[value!=""]').serialize();
		
							$.pjax(defaultPjaxArgs);
						});
				} else {
					$(document)
						.off('submit', 'form.wd-product-filters')
						.on('submit', 'form.wd-product-filters', function(e) {
							$(':input', this).each(function() {
								this.disabled = !($(this).val());
							});
						});
				}
			}
		});

		woodmartThemeModule.$document.on('click', '.wd-product-filters > a.btn', function(e) {
			e.preventDefault();

			$(this).parent('form').trigger('submit');
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.productFilters();
	});
})(jQuery);