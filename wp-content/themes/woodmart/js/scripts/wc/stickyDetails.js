/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdHeaderBuilderInited', function () {
		woodmartThemeModule.stickyDetails();
	});

	woodmartThemeModule.stickyDetails = function() {
		if (!$('.single-product-page').hasClass('wd-sticky-on') || woodmartThemeModule.$window.width() <= 1024) {
			return;
		}

		var details = $('.entry-summary');

		details.each(function() {
			var $column = $(this),
			    offset  = parseInt(woodmart_settings.sticky_product_details_offset),
			    $inner  = $column.find('.summary-inner'),
			    $images = $column.parent().find('.woocommerce-product-gallery');

			$inner.trigger('sticky_kit:detach');
			$images.trigger('sticky_kit:detach');

			$images.imagesLoaded(function() {
				var diff = $inner.outerHeight() - $images.outerHeight();
				var defaultDiff = parseInt(woodmart_settings.sticky_product_details_different);

				if (diff < -defaultDiff) {
					$inner.stick_in_parent({
						offset_top: offset
					});
				} else if (diff > defaultDiff) {
					$images.stick_in_parent({
						offset_top: offset
					});
				}

				woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
					if (woodmartThemeModule.$window.width() <= 1024) {
						$inner.trigger('sticky_kit:detach');
						$images.trigger('sticky_kit:detach');
					} else if ($inner.outerHeight() < $images.outerHeight()) {
						$inner.stick_in_parent({
							offset_top: offset
						});
					} else {
						$images.stick_in_parent({
							offset_top: offset
						});
					}
				}, 300));
			});
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.stickyDetails();
	});
})(jQuery);
