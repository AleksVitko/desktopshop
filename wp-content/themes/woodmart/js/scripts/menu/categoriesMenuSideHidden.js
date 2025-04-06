woodmartThemeModule.$document.on('wdShopPageInit', function() {
	woodmartThemeModule.categoriesMenuSideHidden();
});

jQuery.each([
	'frontend/element_ready/wd_product_categories.default',
	'frontend/element_ready/wd_page_title.default',
], function(index, value) {
	woodmartThemeModule.wdElementorAddAction(value, function() {
		if ( 'function' === typeof woodmartThemeModule.closeMobileNavigation ) {
			woodmartThemeModule.closeMobileNavigation();
		}

		woodmartThemeModule.categoriesMenuSideHidden();
	});
});

woodmartThemeModule.showHideMobileTollBarButton = function() {
	var categoryMenuInStartPosition = document.querySelector('.wd-nav-product-cat-wrap .wd-nav-product-cat, .page-title .wd-nav-product-cat');
	var toolBarCategoriesBatton     = document.querySelector('.wd-toolbar-shop-cat');

	if ( ! toolBarCategoriesBatton ) {
		return;
	}

	battonSettings = 'settings' in toolBarCategoriesBatton.dataset ? JSON.parse( toolBarCategoriesBatton.dataset.settings ) : {};

	if ( ! battonSettings.hasOwnProperty('shop_categories_ancestors') || "0" === battonSettings.shop_categories_ancestors || "no" === battonSettings.shop_categories_ancestors ) {
		return;
	}

	if ( ! categoryMenuInStartPosition ) {
		toolBarCategoriesBatton.classList.add('wd-hide');
	} else if ( toolBarCategoriesBatton.classList.contains('wd-hide') ) {
		toolBarCategoriesBatton.classList.remove('wd-hide');
	}
}

woodmartThemeModule.$document.on('pjax:beforeSend', function() {
	var sideHiddenCat       = document.querySelector('.wd-side-hidden-cat');
	var sideHiddenCatChilds = sideHiddenCat ? sideHiddenCat.childNodes : null;
	var showCatBtn          = document.querySelector('.wd-nav-product-cat-wrap .wd-btn-show-cat, .page-title .wd-btn-show-cat');
	var oldPlaceWrapper     = showCatBtn ? showCatBtn.parentNode : null;

	if ( sideHiddenCatChilds && oldPlaceWrapper ) {
		for (var i = 0; i < sideHiddenCatChilds.length; i++) {
			oldPlaceWrapper.appendChild(sideHiddenCatChilds[i].cloneNode(true));
		}
	}
});

woodmartThemeModule.categoriesMenuSideHidden = function() {
	var openers = document.querySelectorAll('.wd-btn-show-cat, .wd-toolbar-shop-cat');

	woodmartThemeModule.showHideMobileTollBarButton();

	openers.forEach(function(opener) {
		opener.addEventListener('click', function(e) {
			e.preventDefault();

			var sideHiddenCat           = document.querySelector('.wd-side-hidden-cat');
			var categoryMenu            = document.querySelector('.wd-nav-product-cat');
			var shopCategoriesAncestors = false;

			if ( ! categoryMenu || ! ( 'sideCategories' in categoryMenu.dataset ) ) {
				return;
			}

			if  ( sideHiddenCat ) {
				sideHiddenCat.remove();

				sideHiddenCat = document.querySelector('.wd-side-hidden-cat');
			}

			var sideCategories = JSON.parse(categoryMenu.dataset.sideCategories);

			if ( sideCategories.hasOwnProperty('shop_categories_ancestors') && sideCategories.shop_categories_ancestors && "0" !== sideCategories.shop_categories_ancestors && "no" !== sideCategories.shop_categories_ancestors ) {
				shopCategoriesAncestors = true;
			}

			if ( categoryMenu && ! sideHiddenCat ) {
				var newSideHiddenCat = document.createElement("div");

				newSideHiddenCat.classList.add(
					'mobile-nav',
					'wd-side-hidden',
					'wd-side-hidden-cat',
					'wd-' + sideCategories.mobile_categories_position
				);

				if ( 'default' !== sideCategories.mobile_categories_color_scheme ) {
					newSideHiddenCat.classList.add('color-scheme-' + sideCategories.mobile_categories_color_scheme);
				}

				if ( 'only_arrow' === sideCategories.mobile_categories_submenu_opening_action ) {
					newSideHiddenCat.classList.add('wd-opener-arrow');
				} else if ( 'item_and_arrow' === sideCategories.mobile_categories_submenu_opening_action ) {
					newSideHiddenCat.classList.add('wd-opener-item');
				}

				if ('side-hidden' === sideCategories.mobile_categories_layout) {
					if ( categoryMenu.classList.contains('wd-style-underline') ) {
						categoryMenu.classList.remove('wd-style-underline');
					}

					if ( categoryMenu.classList.contains('wd-style-bg') ) {
						categoryMenu.classList.remove('wd-style-bg');
					}

					categoryMenu.querySelectorAll('.wd-dropdown.wd-dropdown-menu').forEach(function(item) {
						item.classList.remove('wd-dropdown', 'wd-dropdown-menu');
					});

					categoryMenu.classList.add(
						'wd-nav-mobile',
						'wd-layout-' + sideCategories.mobile_categories_menu_layout
					);
	
					if ( 'drilldown' === sideCategories.mobile_categories_menu_layout ) {
						categoryMenu.classList.add('wd-drilldown-' + sideCategories.mobile_categories_drilldown_animation)
					}
				}
	
				if ( categoryMenu.previousElementSibling && categoryMenu.previousElementSibling.classList.contains('wd-heading') ) {	
					newSideHiddenCat.appendChild(categoryMenu.previousElementSibling);
				}
	
				newSideHiddenCat.appendChild(categoryMenu);
				document.body.appendChild(newSideHiddenCat);

				sideHiddenCat        = document.querySelector('.wd-side-hidden-cat');
				var	dropDownCats     = sideHiddenCat.querySelectorAll('.wd-nav-mobile .menu-item-has-children');
				var	closeSideWidgets = sideHiddenCat.querySelectorAll('.login-side-opener, .close-side-widget');

				if ('function' === typeof woodmartThemeModule.mobileNavigationAddOpeners && ! shopCategoriesAncestors) {
					woodmartThemeModule.mobileNavigationAddOpeners(dropDownCats);
				}

				if ('function' === typeof woodmartThemeModule.mobileNavigationClickAction  && ! shopCategoriesAncestors) {
					woodmartThemeModule.mobileNavigationClickAction(sideHiddenCat);
				}

				if ('function' === typeof woodmartThemeModule.mobileNavigationCloseSideWidgets) {
					woodmartThemeModule.mobileNavigationCloseSideWidgets( closeSideWidgets );
				}
			}

			if (sideHiddenCat.classList.contains('wd-opened') && 'function' === typeof woodmartThemeModule.closeMobileNavigation ) {
				woodmartThemeModule.closeMobileNavigation();
			} else if ( 'function' === typeof woodmartThemeModule.openMobileNavigation ) {
				setTimeout(function () {
					var sideHiddenCatParrent = sideHiddenCat.parentNode;

					if ( sideHiddenCatParrent ) {
						sideHiddenCatParrent.classList.add('wd-opened');
					}

					woodmartThemeModule.openMobileNavigation(sideHiddenCat);
				}, 10);
			}
		});
	});
};

window.addEventListener('load',function() {
	woodmartThemeModule.categoriesMenuSideHidden();
});
