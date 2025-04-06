/* global wtl_form_data */
woodmartThemeModule.waitlistSubscribeForm = function() {
	function init() {
		if ('undefined' === typeof wtl_form_data) { // Disable script on Elementor edit mode.
			return;
		}

		var parentProductId          = getCurrentProductId();
		var addToCartWrapperSelector = '.summary-inner';

		if ( document.querySelector('.wd-content-layout').classList.contains('wd-builder-on') ) {
			addToCartWrapperSelector = '.wd-single-add-cart';
		}

		var variations_form = document.querySelector(`${addToCartWrapperSelector} .variations_form`);

		if (variations_form) {
			var activeVariation     = document.querySelector(`${addToCartWrapperSelector} .wd-active`);
			var variationsUpdated   = false;
			var formInited          = false;
			var selectedVariationId = parseInt(variations_form.querySelector('input.variation_id').value);

			if (selectedVariationId) {
				var variations          = JSON.parse(variations_form.dataset.product_variations);
				var selectedVariation   = variations.find(function(variation) {
					return variation.variation_id === selectedVariationId;
				});

				if (selectedVariation && ! selectedVariation.is_in_stock) {
					showForm(variations_form, selectedVariation.variation_id, wtl_form_data[selectedVariation.variation_id].state);
				}
			}

			jQuery(`${addToCartWrapperSelector} .variations_form`)
				.on('found_variation', function(e, variation) {
					if (variation.is_in_stock) {
						var form = document.querySelector('.wd-wtl-form:not(.wd-wtl-is-template)');

						if (form) {
							form.remove();
						}

						return;
					}

					showForm(this, variation.variation_id, wtl_form_data[variation.variation_id].state);

					if (! variationsUpdated && wtl_form_data.global.fragments_enable && wtl_form_data.global.is_user_logged_in) {
						updateAjaxFormData(parentProductId, 'variation', variation.variation_id);
						variationsUpdated = true;
					}
				})
				.on('click', '.reset_variations', function() {
					var wtlForm = document.querySelector('.wd-wtl-form:not(.wd-wtl-is-template)');

					if (wtlForm) {
						wtlForm.remove();
					}
				});

			if ( ! formInited && document.querySelector('.single-product-page').classList.contains('has-default-attributes') && activeVariation ) {
				jQuery(`${addToCartWrapperSelector} .variations_form`).trigger('reload_product_variations');
				formInited = true;
			}
		} else {
			if (wtl_form_data.hasOwnProperty('fragments_enable') && wtl_form_data.fragments_enable && wtl_form_data.is_user_logged_in) {
				updateAjaxFormData(parentProductId, 'simple');
			}

			var form = document.querySelector('.wd-wtl-form:not(.wd-wtl-is-template)');

			if (form) {
				form.addEventListener('click', formEvents);
			}
		}
	}
	
	function showForm(appendAfter, product_id, state = 'not-signed' ) {
		if (! wtl_form_data.global.is_user_logged_in) {
			var cookiesName  = 'woodmart_waitlist_unsubscribe_tokens';

			var cookieData  = Cookies.get(cookiesName) ? JSON.parse(Cookies.get(cookiesName)) : {};
			
			if (cookieData && cookieData.hasOwnProperty(product_id) ) {
				state = 'signed';
			}
		}

		var templateForm = document.querySelector(`.wd-wtl-form.wd-wtl-is-template[data-state=${state}]`);

		if (! templateForm) {
			return;
		}

		//var stockElement;
		var oldForm      = document.querySelector('.wd-wtl-form:not(.wd-wtl-is-template)');
		var cloneNode    = templateForm.cloneNode(true);

		if ('not-signed' === state) {
			var emailValue = '';

			cloneNode.querySelector('.wd-wtl-subscribe').dataset.productId = product_id;

			if (wtl_form_data.hasOwnProperty('global') && wtl_form_data.global.email) {
				emailValue =  wtl_form_data.global.email;
			} else if (wtl_form_data.hasOwnProperty('email')) {
				emailValue = wtl_form_data.email;
			}

			cloneNode.querySelector('[name="wd-wtl-user-subscribe-email"]').value = emailValue;

			cloneNode.addEventListener('click', subscribe);
		} else {
			cloneNode.querySelector('.wd-wtl-unsubscribe').dataset.productId = product_id;

			cloneNode.addEventListener('click', unsubscribe);
		}

		cloneNode.querySelectorAll('[for$="-tmpl"]').forEach(function(node) {
			node.setAttribute('for', node.getAttribute('for').replace('-tmpl', ''));
		});

		cloneNode.querySelectorAll('[id$="-tmpl"]').forEach(function(node) {
			node.id = node.id.replace('-tmpl', '');
		});

		cloneNode.classList.remove('wd-wtl-is-template');
		cloneNode.classList.remove('wd-hide');

		if (oldForm) {
			oldForm.replaceWith(cloneNode);
			oldForm.classList.remove('wd-hide');
		} else {
			appendAfter.after(cloneNode);
		}

		if (wtl_form_data.hasOwnProperty(product_id)) {
			wtl_form_data[product_id].state = state;
		} else if (wtl_form_data.hasOwnProperty('product_id')) {
			wtl_form_data.product_id = state;
		}

		return cloneNode;
	}

	function updateAjaxFormData(productId, productType, variationId = 0) {
		if (! productId) {
			return;
		}

		var subscribeForm = document.querySelector('.wd-wtl-form:not(.wd-hide)');
		var loaderOverlay = subscribeForm.querySelector('.wd-loader-overlay');
		
		loaderOverlay.classList.add('wd-loading');

		jQuery.ajax({
			url     : woodmart_settings.ajaxurl,
			data    : {
				action     : 'woodmart_update_form_data',
				product_id : productId,
			},
			dataType: 'json',
			method  : 'GET',
			success : function(response) {
				if (response.hasOwnProperty('data')) {
					if (response.data.hasOwnProperty('global')) {
						wtl_form_data.global = response.data.global;
					}

					if (response.data.hasOwnProperty('signed_ids')) {
						response.data.signed_ids.forEach(function(signedProdutId) {
							if (wtl_form_data.hasOwnProperty(signedProdutId)) {
								wtl_form_data[signedProdutId].state = 'signed';
							} else if (wtl_form_data.hasOwnProperty('state')) {
								wtl_form_data.state = 'signed';
							}
						});
					}					

					if ('simple' === productType) {
						updateForm(response.data.content);
					} else if ( 0 !== variationId ) {
						subscribeForm = showForm(document.querySelector('.wd-wtl-form:not(.wd-wtl-is-template)'), variationId, wtl_form_data[variationId].state);
					}
				}
			},
			error   : function() {
				console.error('Something wrong with AJAX response. Probably some PHP conflict');
			},
			complete: function() {
				loaderOverlay = subscribeForm.querySelector('.wd-loader-overlay');

				loaderOverlay.classList.remove('wd-loading');
			}
		});
	}

	function formEvents(e) {
		var subscribeBtn   = e.target.closest('.wd-wtl-subscribe');
		var unsubscribeBtn = e.target.closest('.wd-wtl-unsubscribe');

		if (subscribeBtn) {
			subscribe(e);
		} else if (unsubscribeBtn) {
			unsubscribe(e);
		}
	}

	function subscribe(e) {
		var actionBtn = e.target.closest('.wd-wtl-subscribe');

		if ( ! actionBtn ) {
			return;
		}

		e.preventDefault();

		var subscribeForm    = actionBtn.closest('.wd-wtl-form');
		var policyCheckInput = subscribeForm.querySelector('[name="wd-wtl-policy-check"]');
		var userEmailInput   = subscribeForm.querySelector('[name="wd-wtl-user-subscribe-email"]');
		var userEmail        = userEmailInput ? userEmailInput.value : '';

		data = {
			action     : 'woodmart_add_to_waitlist',
			user_email : userEmail,
			product_id : actionBtn.dataset.productId,
		}

		if (policyCheckInput) {
			if (! policyCheckInput.checked) {
				var noticeValue = '';
				
				if (wtl_form_data.hasOwnProperty('global') && wtl_form_data.global.policy_check_notice) {
					noticeValue =  wtl_form_data.global.policy_check_notice;
				} else if (wtl_form_data.hasOwnProperty('policy_check_notice')) {
					noticeValue = wtl_form_data.policy_check_notice;
				}
				
				if ( ! noticeValue ) {
					return;
				}

				addNotice(subscribeForm, noticeValue, 'warning');
				return;
			}
		}

		sendForm(subscribeForm, data);
	}

	function unsubscribe(e) {
		var actionBtn = e.target.closest('.wd-wtl-unsubscribe');

		if ( ! actionBtn ) {
			return;
		}

		e.preventDefault();

		var cookiesName  = 'woodmart_waitlist_unsubscribe_tokens';
		var subscribeForm = actionBtn.closest('.wd-wtl-form');

		data = {
			action     : 'woodmart_remove_from_waitlist',
			product_id : actionBtn.dataset.productId,
		}

		var productId   = parseInt(data.product_id);
		var cookieData  = Cookies.get(cookiesName) ? JSON.parse(Cookies.get(cookiesName)) : {};
		
		if (cookieData && cookieData.hasOwnProperty(productId) ) {
			data['unsubscribe_token'] = cookieData[productId];
		}

		sendForm(subscribeForm, data);
	}
	
	function sendForm(subscribeForm, data) {
		var loaderOverlay = subscribeForm.querySelector('.wd-loader-overlay');
		
		loaderOverlay.classList.add('wd-loading');

		jQuery.ajax({
			url     : woodmart_settings.ajaxurl,
			data,
			method  : 'POST',
			success : function(response) {
				if (!response) {
					return;
				}

				if (response.success) {
					if (response.data.hasOwnProperty('content') && response.data.hasOwnProperty('state')) {
						updateForm(response.data.content);
					} else {
						subscribeForm = showForm(subscribeForm, data.product_id ,response.data.state);
					}
				}

				if (response.data.hasOwnProperty('notice')) {
					$nocite_type = ! response.success ? 'warning' : 'success';

					if ( response.data.hasOwnProperty('notice_status') ) {
						$nocite_type = response.data.notice_status;
					}

					addNotice(subscribeForm, response.data.notice, $nocite_type);
				}
			},
			error   : function() {
				console.error('ajax adding to waitlist error');
			},
			complete: function() {
				loaderOverlay = subscribeForm.querySelector('.wd-loader-overlay');

				loaderOverlay.classList.remove('wd-loading');
			}
		});
	}

	function updateForm(content) {
		var         forms = document.querySelectorAll('.wd-wtl-form:not(.wd-wtl-is-template)');
		var         form  = Array.from(forms).find(function(form) {
			return ! form.closest('.wd-sticky-spacer');
		});
		var tempDiv       = document.createElement('div');
		tempDiv.innerHTML = content;
		childNodes        = tempDiv.querySelector('.wd-wtl-form').childNodes;

		form.replaceChildren(...childNodes);
	}

	function getCurrentProductId() {
		var product_id = false;

		document.querySelector('body[class*="postid-"]').classList.forEach(function(className) {
			if ( ! className.includes('postid-') ) {
				return;
			}
		
			product_id = className.replace('postid-', '')
		});

		return product_id;
	}

	function addNotice(subscribeForm, message, status) {
		if ( ! subscribeForm ) {
			return;
		}

		var oldNotice = subscribeForm.querySelector('.wd-notice');

		if ( oldNotice ) {
			oldNotice.remove();
		}

		var noticeNode = document.createElement("div");

		noticeNode.classList.add(
			'wd-notice',
			`wd-${status}`
		);

		noticeNode.append(message);
		subscribeForm.append(noticeNode);
	}

	init();
}

window.addEventListener('load', function() {
	woodmartThemeModule.waitlistSubscribeForm();
});
