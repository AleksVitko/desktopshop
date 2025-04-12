/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdHeaderBuilderInited', function () {
		woodmartThemeModule.stickyColumns();
	});

	$.each([
		'frontend/element_ready/container',
		'frontend/element_ready/wd_sticky_columns.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.stickyColumns();
		});
	});

	woodmartThemeModule.stickyColumns = function() {
		var $elements = $('.wd-sticky-columns[class*="wd-sticky-on-"]');

		$elements.each(function() {
			var $wrapper = $(this);
			var $columnFirst = $wrapper.find('.wd-sticky-columns-inner > .wd-col:first-child > div');
			var $columnSecond = $wrapper.find('.wd-sticky-columns-inner > .wd-col:last-child > div');
			var classes = $wrapper.attr('class').split(' ');
			var offset = 150;

			for (var index = 0; index < classes.length; index++) {
				if (classes[index].indexOf('wd_sticky_offset_') >= 0) {
					var data = classes[index].split('_');
					offset = parseInt(data[3]);
				}
			}

			var diff = $columnFirst.outerHeight() - $columnSecond.outerHeight();

			if (diff < -100) {
				stickyInit($columnFirst, offset);
			} else if (diff > 100) {
				stickyInit($columnSecond, offset);
			}

			woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
				var diff = $columnFirst.outerHeight() - $columnSecond.outerHeight();

				if (diff < -100) {
					stickyInit($columnFirst, offset);
				} else if (diff > 100) {
					stickyInit($columnSecond, offset);
				}
			}, 300));
		});

		function stickyInit($column, offset) {
			var windowWidth = woodmartThemeModule.$window.width();
			var $wrapper = $column.closest('.wd-sticky-columns');

			$column.trigger('sticky_kit:detach');
			$column.siblings().trigger('sticky_kit:detach');

			if ( ( ! $wrapper.hasClass('wd-sticky-on-lg') && windowWidth > 1024 ) || ( ! $wrapper.hasClass('wd-sticky-on-md-sm') && windowWidth <= 1024 && windowWidth > 768 ) || ( ! $wrapper.hasClass('wd-sticky-on-sm') && windowWidth <= 768 ) ) {
				return;
			}

			$column.stick_in_parent({
				offset_top: offset
			});
		}
	};

	$(document).ready(function() {
		woodmartThemeModule.stickyColumns();
	});
})(jQuery);
