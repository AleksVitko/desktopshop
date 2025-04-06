(function($) {
	woodmartThemeModule.$document.on('wdShopPageInit', function () {
		woodmartThemeModule.offCanvasColumnBtn();
	});

	$.each([
		'frontend/element_ready/column',
		'frontend/element_ready/container',
		'frontend/element_ready/wd_builder_off_canvas_column_btn.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.offCanvasColumnBtn();
		});
	});

	woodmartThemeModule.offCanvasColumnBtn = function() {
		var $closeSide = $('.wd-close-side');
		var $colOffCanvas = $('[class*="wd-col-offcanvas"], .wp-block-wd-off-sidebar');
		var alignment = $colOffCanvas.hasClass('wd-alignment-left') || $colOffCanvas.hasClass('wd-left') ? 'left' : 'right';
		var $openButton = $('.wd-off-canvas-btn, .wd-off-canvas-btn ~ .wd-sidebar-opener, .wd-toolbar-sidebar');
		var innerWidth = woodmartThemeModule.$window.width();

		var offCanvassInit = function() {
			if (! $colOffCanvas.hasClass( 'wp-block-wd-off-sidebar' )) {
				$colOffCanvas.removeClass('wd-left wd-right').addClass('wd-' + alignment);
			}

			$colOffCanvas.addClass('wd-side-hidden wd-inited');

			if (0 === $colOffCanvas.find('.wd-heading').length) {
				$colOffCanvas.prepend(
					'<div class="wd-heading"><div class="close-side-widget wd-action-btn wd-style-text wd-cross-icon"><a href="#" rel="nofollow">' + woodmart_settings.off_canvas_column_close_btn_text + '</a></div></div>'
				);
			}

			$openButton.on('click', function(e) {
				e.preventDefault();

				if (! $colOffCanvas.length) {
					return;
				}

				$colOffCanvas.addClass('wd-scroll wd-opened');
				$closeSide.addClass('wd-close-side-opened');
				$openButton.addClass('wd-opened');

				$colOffCanvas.find(' .elementor-widget-wrap').first().addClass('wd-scroll-content');

				if ($colOffCanvas.hasClass( 'wp-block-wd-off-sidebar' )) {
					$colOffCanvas.find('> .widget-area').addClass('wd-scroll-content');
				}
			});
		};

		if ($colOffCanvas.hasClass('wp-block-wd-off-sidebar') && (($colOffCanvas.hasClass('wd-hide-lg') && innerWidth >= 1024) || ($colOffCanvas.hasClass('wd-hide-md-sm') && 768 <= innerWidth && innerWidth <= 1024) || ($colOffCanvas.hasClass('wd-hide-sm') && innerWidth <= 767))) {
			offCanvassInit();
		} else if ('elementor' === woodmart_settings.current_page_builder && (($colOffCanvas.hasClass('wd-col-offcanvas-lg') && innerWidth >= 1024) || ($colOffCanvas.hasClass('wd-col-offcanvas-md-sm') && 768 <= innerWidth && innerWidth <= 1024) || ($colOffCanvas.hasClass('wd-col-offcanvas-sm') && innerWidth <= 767))) {
			offCanvassInit();
		} else if ('wpb' === woodmart_settings.current_page_builder && (($colOffCanvas.hasClass('wd-col-offcanvas-lg') && innerWidth >= 1200) || ($colOffCanvas.hasClass('wd-col-offcanvas-md-sm') && 769 <= innerWidth && innerWidth <= 1199) || ($colOffCanvas.hasClass('wd-col-offcanvas-sm') && innerWidth <= 768))) {
			offCanvassInit();
		} else if ( $colOffCanvas.hasClass( 'wd-side-hidden' ) ) {
			$openButton.off('click');
			$('.wp-block-wd-off-sidebar').removeClass('wd-side-hidden wd-inited wd-scroll wd-opened');
			$('.elementor-column, .e-con').removeClass('wd-side-hidden wd-inited wd-scroll wd-opened wd-left wd-right');
			$('.wpb_column').removeClass('wd-side-hidden wd-inited wd-scroll wd-opened wd-left wd-right');
			$closeSide.removeClass('wd-close-side-opened');
			$openButton.removeClass('wd-opened');
			$colOffCanvas.find(' .elementor-widget-wrap').first().removeClass('wd-scroll-content');
			$colOffCanvas.find('.wd-heading').remove();
		}

		$openButton.on('click', function(e) {
			e.preventDefault();
		});

		woodmartThemeModule.$body.on('pjax:beforeSend', function() {
			$('.wd-close-side, .close-side-widget').trigger('click');
		});

		woodmartThemeModule.$body.on('click touchstart', '.wd-close-side', function(e) {
			e.preventDefault();

			closeOffCanvas();
		});

		woodmartThemeModule.$body.on('click', '.close-side-widget', function(e) {
			e.preventDefault();

			closeOffCanvas();
		});

		function closeOffCanvas() {
			$colOffCanvas.removeClass('wd-opened');
			$closeSide.removeClass('wd-close-side-opened');
			$openButton.removeClass('wd-opened');
		}
	};

	woodmartThemeModule.$window.on('resize', woodmartThemeModule.debounce(function() {
		woodmartThemeModule.offCanvasColumnBtn();
	}, 300));

	$(document).ready(function() {
		woodmartThemeModule.offCanvasColumnBtn();
	});
})(jQuery);