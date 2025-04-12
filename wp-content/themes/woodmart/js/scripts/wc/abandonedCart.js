/* global woodmart_settings */
woodmartThemeModule.abandonedCart = function() {
	var init = function() {
		recoverGuestCart();
	}

	var recoverGuestCart = function() {
		var inp_email  = document.querySelector('#billing_email');

		if ( ! inp_email ) {
			return;
		}

		var privacyCkeckbox = document.querySelector('#wd-data-consent');

		if (privacyCkeckbox) {
			privacyCkeckbox.addEventListener('change', function (e) {
				e.stopPropagation();

				if (e.currentTarget.checked && inp_email.value.length && isValidEmail(inp_email.value)) {
					var event = new Event('change');

					inp_email.dispatchEvent(event);
				}
			});
		}

		inp_email.addEventListener('change', function (e) {
			var target = e.target;
			var email  = target.value;

			if ( ! checkPrivacy() || ! isValidEmail(email)) {
				return;
			}
		
			var first_name = document.querySelector('#billing_first_name');
			var last_name  = document.querySelector('#billing_last_name');
			var phone      = document.querySelector('#billing_phone');
		
			jQuery.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action: 'woodmart_recover_guest_cart',
					security: woodmart_settings.abandoned_cart_security,
					email,
					phone: phone ? phone.value : '',
					first_name: first_name ? first_name.value : '',
					last_name: last_name ? last_name.value : '',
					currency: woodmart_settings.abandoned_cart_currency,
					language: woodmart_settings.abandoned_cart_language,
				},
				method  : 'POST',
				error   : function() {
					console.log('Ajax error of capturing the abandoned basket of the guest');
				},
			});
		});
	};

	var isValidEmail = function(email) {
		const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
		return emailPattern.test(email);
	}

	var checkPrivacy = function() {
		if ( 'no' === woodmart_settings.abandoned_cart_needs_privacy ) {
			return true;
		}

		var privacyInput = document.querySelector('#wd-data-consent');

		return privacyInput && privacyInput.checked;
	};

	init();
}

woodmartThemeModule.showPrivecyCheckbox = function() {
	var privacyWrapper    = document.querySelector('.wd-data-consent');
	var billingEmailField = document.querySelector('#billing_email_field');

	if ( 'no' === woodmart_settings.abandoned_cart_needs_privacy || ! privacyWrapper || ! billingEmailField) {
		return;
	}

	billingEmailField.appendChild(privacyWrapper);
	privacyWrapper.classList.remove('wd-hide');
}

woodmartThemeModule.showPrivecyCheckbox();

window.addEventListener('load', function() {
	woodmartThemeModule.abandonedCart();
});
