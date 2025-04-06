woodmartThemeModule.updateAjaxDeliveryDates = function () {
	var deliveryDates = document.querySelector('.wd-est-del');

	if (! deliveryDates) {
		return;
	}

	jQuery.ajax({
		url     : woodmart_settings.ajaxurl,
		data    : {
			action     : 'woodmart_update_delivery_dates',
			product_id : deliveryDates.dataset.productId,
		},
		dataType: 'json',
		method  : 'GET',
		success : function(response) {
			if ( response.hasOwnProperty('fragments') ) {
				Object.keys(response.fragments).forEach(function(selector) {
					var value = response.fragments[selector];

					document.querySelectorAll(selector).forEach(function(node) {
						node.innerHTML = value;

						if (value) {
							node.parentNode.classList.remove('wd-hide');
						} else {
							node.parentNode.classList.add('wd-hide');
						}
					});
				});
			}
		},
		error   : function() {
			console.error('Something wrong with AJAX response. Probably some PHP conflict.');
		},
		complete: function() {
			deliveryDates.classList.add('wd-loaded');
		}
	});
}

window.addEventListener('load', function() {
	woodmartThemeModule.updateAjaxDeliveryDates();
});
