woodmartThemeModule.$document.on('wdLoadDropdownsSuccess wdSearchFullScreenContentLoaded wdShopPageInit', function() {
	woodmartThemeModule.elToggle();
});

woodmartThemeModule.elToggle = function() {
	document.querySelectorAll('.wd-toggle').forEach( function (element) {
		if ( element.classList.contains('wd-inited') ) {
			return;
		}

		var content = element.querySelector('.wd-toggle-content');

		element.classList.add('wd-inited');

		element.querySelector('.wd-toggle-head').addEventListener('click', function () {
			if ( element.classList.contains('wd-opening') ) {
				return;
			}

			if (woodmartThemeModule.$window.width() <= 767) {
				if (element.classList.contains('wd-state-static-sm')) {
					return;
				}

				if (element.classList.contains('wd-active-sm')) {
					element.classList.remove('wd-active-sm')
					woodmartThemeModule.slideUp(content);
				} else {
					element.classList.add('wd-active-sm')
					woodmartThemeModule.slideDown(content);
				}
			} else if (woodmartThemeModule.$window.width() <= 1024) {
				if (element.classList.contains('wd-state-static-md-sm')) {
					return;
				}

				if (element.classList.contains('wd-active-md-sm')) {
					element.classList.remove('wd-active-md-sm')
					woodmartThemeModule.slideUp(content);
				} else {
					element.classList.add('wd-active-md-sm')
					woodmartThemeModule.slideDown(content);
				}
			} else {
				if (element.classList.contains('wd-state-static-lg')) {
					return;
				}

				if (element.classList.contains('wd-active-lg')) {
					element.classList.remove('wd-active-lg')
					woodmartThemeModule.slideUp(content);
				} else {
					element.classList.add('wd-active-lg')
					woodmartThemeModule.slideDown(content);
				}
			}

			element.classList.add('wd-opening');

			setTimeout(function() {
				element.classList.remove('wd-opening');
			}, 400);
		});
	});
};

window.addEventListener('load',function() {
	woodmartThemeModule.elToggle();
});
