woodmartThemeModule.$document.on('wdShopPageInit', function () {
	woodmartThemeModule.clearSearch();
});

jQuery.each([
	'frontend/element_ready/wd_search.default'
], function(index, value) {
	woodmartThemeModule.wdElementorAddAction(value, function() {
		woodmartThemeModule.clearSearch();
	});
});

woodmartThemeModule.clearSearch = function() {
	var buttons = document.querySelectorAll('form .wd-clear-search');

	buttons.forEach(function(button) {
		var form  = button.closest('form');
		var input = form.querySelector('input');

		if (input) {
			toggleClearButton(input, button);

			input.addEventListener('keyup', function() {
				toggleClearButton(input, button);
			});
		}

		button.addEventListener('click', function(e) {
			e.preventDefault();

			var input   = button.parentNode.querySelector('input');
			input.value = '';

			input.dispatchEvent(new Event('keyup'));
			input.dispatchEvent(new Event('focus'));
		});
	});

	function toggleClearButton(serachInput, clearButton) {
		if (serachInput.value.length) {
			clearButton.classList.remove('wd-hide');
		} else {
			clearButton.classList.add('wd-hide')
			serachInput.classList.remove('wd-search-inited');
		}
	}
}

window.addEventListener('wdEventStarted', function() {
	woodmartThemeModule.clearSearch();
});
