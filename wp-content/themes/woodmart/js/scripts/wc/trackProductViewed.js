/* global woodmart_settings */

woodmartThemeModule.trackProductViewed = function() {
	var singleProduct = document.querySelector('.single-product-page');
	var cookiesName = 'woodmart_recently_viewed_products';

	if ( ! singleProduct || 'undefined' === typeof Cookies ) {
		return;
	}

	var singleProductID = singleProduct.id.replace('product-', '');
	var recentlyProduct = Cookies.get(cookiesName);

	if ( ! recentlyProduct ) {
		recentlyProduct = singleProductID;
	} else {
		recentlyProduct = recentlyProduct.split('|');

		if ( recentlyProduct.indexOf(singleProductID) !== -1 ) {
			return;
		}

		recentlyProduct.unshift(singleProductID);

		recentlyProduct = recentlyProduct.join('|');
	}

	Cookies.set(cookiesName, recentlyProduct, {
		expires: 7,
		path   : woodmart_settings.cookie_path,
		secure : woodmart_settings.cookie_secure_param
	});
};

window.addEventListener('load',function() {
	woodmartThemeModule.trackProductViewed();
});
