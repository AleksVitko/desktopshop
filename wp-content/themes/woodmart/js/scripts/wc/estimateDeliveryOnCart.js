jQuery(document).on('updated_shipping_method', function() {
	jQuery(document.body).trigger('wc_update_cart');
});

jQuery(document).on(
	'submit',
	'form.woocommerce-shipping-calculator',
	function() {
		jQuery(document.body).trigger('wc_update_cart');
	}
);
