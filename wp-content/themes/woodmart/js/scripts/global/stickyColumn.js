/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdElementorColumnReady pjax:complete wdShopPageInit', function () {
		woodmartThemeModule.stickyColumn();
	});

	woodmartThemeModule.$window.on('elementor/frontend/init', function() {
		if (!elementorFrontend.isEditMode()) {
			return;
		}

		elementorFrontend.hooks.addAction('frontend/element_ready/container', function($wrapper) {
			var cid = $wrapper.data('model-cid');

			if (typeof elementorFrontend.config.elements.data[cid] !== 'undefined') {
				if (elementorFrontend.config.elements.data[cid].attributes.container_sticky) {
					$wrapper.addClass('wd-sticky-container-lg');
				} else {
					$wrapper.removeClass('wd-sticky-container-lg');
				}
				if (elementorFrontend.config.elements.data[cid].attributes.container_sticky_tablet) {
					$wrapper.addClass('wd-sticky-container-md-sm');
				} else {
					$wrapper.removeClass('wd-sticky-container-md-sm');
				}
				if (elementorFrontend.config.elements.data[cid].attributes.container_sticky_mobile) {
					$wrapper.addClass('wd-sticky-container-sm');
				} else {
					$wrapper.removeClass('wd-sticky-container-sm');
				}
			}
		});
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

			var $widgetWrap = $column.find(' > .elementor-widget-wrap');

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

		$('[class*="wd-sticky-container-"]').each(function() {
			var $column = $(this);

			function initSticky() {
				var windowWidth = woodmartThemeModule.$window.width();

				$column.trigger('sticky_kit:detach');

				if ( ( ! $column.hasClass('wd-sticky-container-lg') && windowWidth > 1024 ) || ( ! $column.hasClass('wd-sticky-container-md-sm') && windowWidth <= 1024 && windowWidth > 768 ) || ( ! $column.hasClass('wd-sticky-container-sm') && windowWidth <= 768 ) ) {
					return;
				}

				var carouselStyle = window.getComputedStyle($column[0]);
				var offset = parseInt( carouselStyle.getPropertyValue('--wd-sticky-offset'), 10);

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
