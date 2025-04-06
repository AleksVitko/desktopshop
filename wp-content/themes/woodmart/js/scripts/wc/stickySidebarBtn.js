/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit', function () {
		woodmartThemeModule.stickySidebarBtn();
	});

	woodmartThemeModule.stickySidebarBtn = function() {
		var $trigger = $('.wd-show-sidebar-btn,.wd-off-canvas-btn');
		var $stickyBtn = $('.wd-sidebar-opener.wd-show-on-scroll');

		if ($stickyBtn.length <= 0 || $trigger.length <= 0) {
			return;
		}

		var stickySidebarBtnToggle = function() {
			var btnOffset = $trigger.offset().top + $trigger.outerHeight();
			var windowScroll = woodmartThemeModule.$window.scrollTop();

			if (btnOffset < windowScroll) {
				$stickyBtn.addClass('wd-shown');
			} else {
				$stickyBtn.removeClass('wd-shown');
			}
		};

		stickySidebarBtnToggle();

		woodmartThemeModule.$window.on('scroll', stickySidebarBtnToggle);
		woodmartThemeModule.$window.on('resize', stickySidebarBtnToggle);
	};

	$(document).ready(function() {
		woodmartThemeModule.stickySidebarBtn();
	});
})(jQuery);
