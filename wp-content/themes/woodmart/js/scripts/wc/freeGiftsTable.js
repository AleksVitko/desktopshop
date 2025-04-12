jQuery.each([
	'frontend/element_ready/wd_cart_table.default',
], function(index, value) {
	woodmartThemeModule.wdElementorAddAction(value, function($wrapper) {
		woodmartThemeModule.addGiftProduct();
	});
});

// Update gifts table only if turned on layout builder.
function updateGiftsTable() {
	var giftsWrapper = document.querySelector('.wd-fg');

	if ( ! giftsWrapper ) {
		return;
	}

	var settings      = giftsWrapper.dataset.hasOwnProperty('settings') ? JSON.parse( giftsWrapper.dataset.settings ) : false;
	var loaderOverlay = giftsWrapper.querySelector('.wd-loader-overlay');

	if ( loaderOverlay ) {
		loaderOverlay.classList.add('wd-loading');
	}

	jQuery.ajax({
		url     : woodmart_settings.ajaxurl,
		data    : {
			action: 'woodmart_update_gifts_table',
		},
		method  : 'POST',
		success : function(response) {
			if (!response) {
				return;
			}

			if (giftsWrapper && response.hasOwnProperty('html')) {
				let tempDiv       = document.createElement('div');
				tempDiv.innerHTML = response.html;

				if ( settings && 'no' === settings.show_title) {
					var titleNode = tempDiv.querySelector('.wd-el-title');

					if (titleNode) {
						titleNode.remove();
					}
				}

				childNodes = tempDiv.childNodes;

				if (0 === childNodes.length) {
					giftsWrapper.classList.add('wd-hide');
				} else {
					giftsWrapper.classList.remove('wd-hide');
				}

				giftsWrapper.replaceChildren(...childNodes);
			}
		},
		error   : function() {
			console.log('ajax update gifts table error');
		},
		complete: function() {
			if ( loaderOverlay ) {
				loaderOverlay.classList.remove('wd-loading');
			}
		}
	});
}

jQuery( document.body ).on( 'updated_cart_totals', updateGiftsTable);
jQuery( document.body ).on( 'updated_checkout', updateGiftsTable);

woodmartThemeModule.addGiftProduct = function() {
	var isCheckout   = !! document.querySelector('.woocommerce-checkout');
	var listenerArea = document.querySelector('.site-content .woocommerce');

	if ( ! listenerArea ) {
		return;
	}

	listenerArea.addEventListener("click", function(e) {
		var addGiftButton = e.target.closest('.wd-add-gift-product');

		if ( addGiftButton ) {
			e.preventDefault();

			var fgTableWrapper = addGiftButton.closest('.wd-fg');
			var loaderOverlay  = fgTableWrapper.querySelector('.wd-loader-overlay');
			var productId      = addGiftButton.dataset.productId;

			if ( addGiftButton.classList.contains('wd-disabled') ) {
				return;
			}

			loaderOverlay.classList.add('wd-loading');

			jQuery.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action: 'woodmart_add_gift_product',
					product_id: productId,
					security: addGiftButton.dataset.security,
					is_checkout: isCheckout ? '1' : '0',
				},
				method  : 'POST',
				success : function(response) {
					if (!response) {
						return;
					}

					triggerEvent = isCheckout ? 'update_checkout' : 'wc_update_cart';

					jQuery(document.body).trigger(triggerEvent);
				},
				error   : function() {
					console.log('ajax adding gift to cart error');
				},
				complete: function() {
					loaderOverlay.classList.remove('wd-loading');
				}
			});
		}
	});
}

window.addEventListener('load',function() {
	woodmartThemeModule.addGiftProduct();
});
