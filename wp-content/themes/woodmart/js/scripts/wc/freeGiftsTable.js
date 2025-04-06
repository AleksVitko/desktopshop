jQuery.each([
	'frontend/element_ready/wd_cart_table.default',
], function(index, value) {
	woodmartThemeModule.wdElementorAddAction(value, function($wrapper) {
		woodmartThemeModule.addGiftProduct();
	});
});

// Update gist table only if turned on layout builder.
if (document.querySelector('.wd-content-layout').classList.contains('wd-builder-on')) {
	jQuery( document.body ).on( 'wc_fragment_refresh updated_wc_div', function(e) {
		var giftsWrapper = document.querySelector('.wd-fg');

		if ( ! giftsWrapper ) {
			return;
		}

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

					childNodes = tempDiv.querySelector('.wd-fg').childNodes;

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
	});
}

woodmartThemeModule.addGiftProduct = function() {
	var isBuilder = document.querySelector('.wd-content-layout').classList.contains('wd-builder-on');
	var listenerArea  = isBuilder ? document.querySelector('.site-content .woocommerce') : document.querySelector('.cart-content-wrapper');

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
				},
				method  : 'POST',
				success : function(response) {
					if (!response) {
						return;
					}

					jQuery(document.body).trigger( 'wc_update_cart' );
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
