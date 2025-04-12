window.jQuery.each([
	'frontend/element_ready/wd_single_product_tabs.default',
], function(index, value) {
	woodmartThemeModule.wdElementorAddAction(value, function() {
		jQuery.magnificPopup.close();

		woodmartThemeModule.singleProductTabsDescHidden();
	});
});

woodmartThemeModule.singleProductTabsDescHidden = function() {
	var hash       = window.location.hash;
	var url        = window.location.href;	
	var tabsTitles = document.querySelectorAll('.wd-hidden-tab-title');
	var tabReviews = document.querySelector('.tab-title-reviews');

	tabsTitles.forEach(function(tabsTitle) {
		var eventsWasAdded = false;

		jQuery(tabsTitle).magnificPopup({
			type           : 'inline',
			removalDelay   : 600,
			showCloseBtn   : false,
			tLoading       : woodmart_settings.loading,
			fixedContentPos: false,
			callbacks      : {
				open: function() {
					var mfpInstance     = this;
					var contentWrapper  = this.content[0];
					var	closeSideButton = contentWrapper.querySelector('.close-side-hidden');

					if ( ! contentWrapper.classList.contains('wd-opened') ) {
						setTimeout(function () {
							contentWrapper.classList.add('wd-opened');
							tabsTitle.classList.add('wd-active');

							window.dispatchEvent(new Event('wdOpenDescHiddenTab'));
						}, 10);
					}

					if ( ! eventsWasAdded ) {
						eventsWasAdded = true;
	
						if ( closeSideButton ) {
							closeSideButton.addEventListener('click', function(e) {
								e.preventDefault();
								mfpInstance.close();
							});
						}
					}
				},
				beforeClose: function() {
					var activeTab        = document.querySelector('.wd-hidden-tab-title.wd-active');
					var activeTabContent = document.querySelector('.wd-side-hidden.wd-opened');

					if (activeTab) {
						activeTab.classList.remove('wd-active');
					}

					if (activeTabContent) {
						activeTabContent.classList.remove('wd-opened');
					}
				},
			}
		});
	});

	if (tabReviews) {
		if (hash.toLowerCase().indexOf('comment-') >= 0 || hash === '#reviews' || hash === '#tab-reviews' || url.indexOf('comment-page-') > 0 || url.indexOf('cpage=') > 0) {
			tabReviews.click();
		}

		document.querySelectorAll('.woocommerce-review-link').forEach(function(reviewLink) {
			reviewLink.addEventListener('click', function () {
				tabReviews.click();
			});
		});
	}
}

window.addEventListener('load',function() {
	woodmartThemeModule.singleProductTabsDescHidden();
});
