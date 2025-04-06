/* global woodmart_settings */
(function($) {
	woodmartThemeModule.$document.on('wdBackHistory wdShopPageInit', function () {
		woodmartThemeModule.categoriesAccordion();
	});

	woodmartThemeModule.categoriesAccordion = function() {

		if (woodmart_settings.categories_toggle === 'no') {
			return;
		}

		var $widget = $('.widget_product_categories'),
		    $list   = $widget.find('.product-categories'),
		    time    = 300;

		$list.find('.cat-parent').each(function() {
			var $this = $(this);

			if ($this.find(' > .wd-cats-toggle').length > 0) {
				return;
			}
			if ($this.find(' > .children').length === 0 || $this.find(' > .children > *').length === 0) {
				return;
			}

			if ($this.hasClass('current-cat') || $this.hasClass('current-cat-parent')) {
				$this.append('<div class="wd-cats-toggle toggle-active"></div>');

				$this.find('> .children').addClass('list-shown');
			} else {
				$this.append('<div class="wd-cats-toggle"></div>');
			}
		});

		$list.on('click', '.wd-cats-toggle', function() {
			var $btn     = $(this),
			    $subList = $btn.prev();

			if ($subList.hasClass('list-shown')) {
				$btn.removeClass('toggle-active');
				$subList.stop().slideUp(time).removeClass('list-shown');
			} else {
				$subList.parent().parent().find('> li > .list-shown').slideUp().removeClass('list-shown');
				$subList.parent().parent().find('> li > .toggle-active').removeClass('toggle-active');
				$btn.addClass('toggle-active');
				$subList.stop().slideDown(time).addClass('list-shown');
			}
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.categoriesAccordion();
	});
})(jQuery);
