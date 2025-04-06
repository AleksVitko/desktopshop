/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdElementorColumnReady pjax:complete wdShopPageInit', function () {
		woodmartThemeModule.stickyColumn();
	});

	woodmartThemeModule.stickyColumn = function() {
		$('.woodmart-sticky-column').each(function() {
			var $column = $(this),
			    offset  = 150;

			var classes = $column.attr('class').split(' ');

			for (var index = 0; index < classes.length; index++) {
				if (classes[index].indexOf('wd_sticky_offset_') >= 0) {
					var data = classes[index].split('_');
					offset = parseInt(data[3]);
				}
			}

			$column.find(' > .vc_column-inner > .wpb_wrapper').trigger('sticky_kit:detach');
			$column.find(' > .vc_column-inner > .wpb_wrapper').stick_in_parent({
				offset_top: offset
			});
		});

		$('.wd-elementor-sticky-column').each(function() {
			var $column = $(this);
			var offset = 150;
			var classes = $column.attr('class').split(' ');

			for (var index = 0; index < classes.length; index++) {
				if (classes[index].indexOf('wd_sticky_offset_') >= 0) {
					var data = classes[index].split('_');
					offset = parseInt(data[3]);
				}
			}

			var $widgetWrap = $column.find('> .elementor-column-wrap > .elementor-widget-wrap');

			if ($widgetWrap.length <= 0) {
				$widgetWrap = $column.find('> .elementor-widget-wrap');
			}

			$widgetWrap.stick_in_parent({
				offset_top: offset
			});
		});

		$(':is(.wp-block-wd-column, .wp-block-wd-off-sidebar, .wp-block-wd-off-content)[class*="wd-sticky-on-"]').each(function() {
			var $column = $(this);
			var offset  = 150;

			var classes = $column.attr('class').split(' ');

			for (var index = 0; index < classes.length; index++) {
				if (classes[index].indexOf('wd_sticky_offset_') >= 0) {
					var data = classes[index].split('_');
					offset = parseInt(data[3]);
				}
			}

			function initSticky() {
				var windowWidth = woodmartThemeModule.$window.width();

				$column.trigger('sticky_kit:detach');

				if ( ( ! $column.hasClass('wd-sticky-on-lg') && windowWidth > 1024 ) || ( ! $column.hasClass('wd-sticky-on-md-sm') && windowWidth <= 1024 && windowWidth > 768 ) || ( ! $column.hasClass('wd-sticky-on-sm') && windowWidth <= 768 ) ) {
					return;
				}

				$column.stick_in_parent({
					offset_top: offset
				});
			}

			initSticky();

			woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
				initSticky();
			}, 300));
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.stickyColumn();
	});
})(jQuery);
