/* global woodmart_settings */
woodmartThemeModule.$document.on('wdCloseMobileMenu wdPjaxStart', function() {
	woodmartThemeModule.closeMobileNavigation();
});

woodmartThemeModule.mobileNavigationClickAction      = function(mobileNav) {
	if (! mobileNav) {
		return;
	}

	mobileNav.addEventListener("click", function(e) {
		var currentNav = e.target.closest('.wd-nav');

		if ( ! currentNav ) {
			return;
		}

		var isDropdown       = currentNav.classList.contains('wd-layout-dropdown');
		var isDrilldown      = currentNav.classList.contains('wd-layout-drilldown');
		var isDrilldownSlide = currentNav.classList.contains('wd-drilldown-slide');
		var navTabs          = e.target.closest('.wd-nav-mob-tab li');
		var wdNavOpener      = e.target.closest('.menu-item-has-children > a');
		var wdNavOpenerArrow = e.target.closest('.menu-item-has-children > .wd-nav-opener');
		var currentMobileNav = e.target.closest('.mobile-nav');
		var opener           = 'arrow';
		var parentLi;
		var parentLiChildren;
		var openerBtn;

		if (this.classList.contains('wd-opener-item')) {
			opener = 'item';
		}

		woodmartThemeModule.$document.trigger('wood-images-loaded');

		if (navTabs) {
			e.preventDefault();

			if (navTabs.classList.contains('wd-active')) {
				return;
			}

			var menuName         = navTabs.dataset.menu;
			var activeMobileNav  = null !== currentMobileNav ? currentMobileNav.querySelector('.wd-active') : false;

			if (activeMobileNav) {
				activeMobileNav.classList.remove('wd-active');
			}

			navTabs.classList.add('wd-active');

			if ( null !== currentMobileNav ) {
				currentMobileNav.querySelectorAll('.wd-nav-mobile').forEach(function(wdNavMobile) {
					wdNavMobile.classList.remove('wd-active');
				});

				if ('undefined' !== typeof menuName) {
					currentMobileNav.querySelectorAll(`.mobile-${menuName}-menu`).forEach(function(wdMobileMenu) {
						wdMobileMenu.classList.add('wd-active');
					});
				}
			}
		}

		if (isDropdown) {
			if (('item' === opener && (wdNavOpener || wdNavOpenerArrow)) || ('arrow' === opener && wdNavOpenerArrow)) {
				e.preventDefault();

				if ('item' === opener) {
					openerBtn = wdNavOpener ? wdNavOpener : wdNavOpenerArrow;
				} else {
					openerBtn = wdNavOpenerArrow;
				}

				parentLi             = openerBtn.parentNode;
				parentLiChildren     = Array.from(parentLi.children);
				var parentNavOpener  = parentLiChildren.find(function(el) {
					return el.classList.contains('wd-nav-opener');
				});
				var submenus         = parentLiChildren.filter(function(el) {
					return 'UL' === el.tagName || el.classList.contains('wd-sub-menu');
				});

				if (parentLi.classList.contains('opener-page')) {
					parentLi.classList.remove('opener-page');

					if (0 !== submenus.length) {
						submenus.forEach(function (submenu) {
							woodmartThemeModule.slideUp(submenu, 200);
						});
					}

					[
						'.wd-dropdown-menu .container > ul',
						'.wd-dropdown-menu > ul',
					].forEach(function (selector) {
						var slideUpNodes = parentLi.querySelectorAll(selector);

						if (0 === slideUpNodes.length) {
							return;
						}

						slideUpNodes.forEach(function (slideUpNode) {
							woodmartThemeModule.slideUp(slideUpNode, 200);
						});
					});

					if ('undefined' !== typeof parentNavOpener) {
						parentNavOpener.classList.remove('wd-active');
					}
				} else {
					parentLi.classList.add('opener-page');

					if (0 !== submenus.length) {
						submenus.forEach(function (submenu) {
							woodmartThemeModule.slideDown(submenu, 200);
						});
					}

					[
						'.wd-dropdown-menu .container > ul',
						'.wd-dropdown-menu > ul',
					].forEach(function (selector) {
						var slideDownNodes = parentLi.querySelectorAll(selector);

						if (0 === slideDownNodes.length) {
							return;
						}

						slideDownNodes.forEach(function (slideDownNode) {
							woodmartThemeModule.slideDown( slideDownNode, 200 );
						});
					});

					if ('undefined' !== typeof parentNavOpener) {
						parentNavOpener.classList.add('wd-active');
					}
				}
			}
		} else if (isDrilldown) {
			var wdNavBackLink      = e.target.closest('.menu-item-has-children .wd-drilldown-back a');
			var wdNavBackLinkArrow = e.target.closest('.menu-item-has-children .wd-drilldown-back .wd-nav-opener');
			var parentUl;
			var submenu;

			if (('item' === opener && (wdNavOpener || wdNavOpenerArrow)) || ('arrow' === opener && wdNavOpenerArrow)) {
				if ('item' === opener) {
					openerBtn = wdNavOpener ? wdNavOpener : wdNavOpenerArrow;
				} else {
					openerBtn = wdNavOpenerArrow;
				}

				parentLi         = openerBtn.parentNode;
				parentUl         = parentLi.closest('ul');
				parentLiChildren = Array.from(parentLi.children);
				submenu          = parentLiChildren.find(function(el) {
					return el.classList.contains('wd-sub-menu') || el.classList.contains('sub-sub-menu');
				});

				if ('undefined' !== typeof submenu) {
					e.preventDefault();

					parentLi.setAttribute( 'aria-expanded', true );

					parentUl.classList.add('wd-drilldown-hide');
					parentUl.classList.remove('wd-drilldown-show');

					submenu.classList.add('wd-drilldown-show');
					submenu.setAttribute( 'aria-expanded', false );

					var drilldownBackLink = submenu.querySelector('.wd-drilldown-back a');
					var drilldownBackText = drilldownBackLink.textContent;
					drilldownBackText     = drilldownBackText.replaceAll('\t', '');
					drilldownBackText     = drilldownBackText.replaceAll('\n', '');

					if ( parentLi.classList.contains('item-level-0') ) {
						var currentTab = null;

						if ( null !== currentMobileNav ) {
							currentTab = currentMobileNav.querySelector('.wd-nav-mob-tab li.wd-active .nav-link-text');
						}

						if ( null !== currentTab ) {
							var currentTabText = currentTab.textContent;
							currentTabText     = currentTabText.replaceAll('\t', '');
							currentTabText     = currentTabText.replaceAll('\n', '');

							if (! drilldownBackText.includes(currentTabText) && currentTabText.length > 0) {
								drilldownBackLink.textContent = woodmart_settings.mobile_navigation_drilldown_back_to.replace('%s', currentTabText);
							}
						} else if ( parentLi.classList.contains('cat-item') ) {
							drilldownBackLink.textContent = woodmart_settings.mobile_navigation_drilldown_back_to_categories;
						} else if (! drilldownBackText.includes(woodmart_settings.mobile_navigation_drilldown_back_to_main_menu)) {
							drilldownBackLink.textContent = woodmart_settings.mobile_navigation_drilldown_back_to_main_menu;
						}
					} else {
						var parentMenuText = '';
						var parentMenuLink = parentUl.closest('li').querySelector('.woodmart-nav-link');

						if ( null !== parentMenuLink.querySelector('.nav-link-text') ) {
							parentMenuText = parentMenuLink.querySelector('.nav-link-text').textContent;
						} else if ( null !== parentMenuLink.querySelector('span') ) {
							parentMenuText = parentMenuLink.querySelector('span').textContent;
						} else {
							parentMenuText = parentMenuLink.textContent;
						}

						if (! drilldownBackText.includes( parentMenuText ) && parentMenuText.length > 0) {
							drilldownBackLink.textContent = woodmart_settings.mobile_navigation_drilldown_back_to.replace('%s', parentMenuText);
						}
					}

					if ( isDrilldownSlide ) {
						this.querySelector('ul.wd-active').style.height = `${submenu.offsetHeight}px`;
					}
				}
			}

			if (wdNavBackLink || wdNavBackLinkArrow) {
				e.preventDefault();

				var backBtn      = wdNavBackLink ? wdNavBackLink : wdNavBackLinkArrow;
				parentLi         = backBtn.closest('.menu-item');
				parentUl         = parentLi.closest('ul');
				parentLiChildren = Array.from(parentLi.children);
				submenu          = parentLiChildren.find(function(el) {
					return el.classList.contains('wd-sub-menu') || el.classList.contains('sub-sub-menu');
				});

				parentLi.setAttribute( 'aria-expanded', false );

				if ( ! parentLi.classList.contains('item-level-0') ) {
					parentUl.classList.add('wd-drilldown-show');
				}
				parentUl.classList.remove('wd-drilldown-hide');

				submenu.classList.remove('wd-drilldown-show');
				submenu.setAttribute( 'aria-expanded', true );

				if ( isDrilldownSlide ) {
					if ( parentLi.classList.contains('item-level-0') ) {
						this.querySelector('ul.wd-active').style.height = '';
					} else {
						this.querySelector('ul.wd-active').style.height = `${parentUl.offsetHeight}px`;
					}
				}
			}
		}
	});
}
woodmartThemeModule.mobileNavigationAddOpeners       = function(dropDownCats) {
	dropDownCats.forEach(function(dropDownCat) {
		if ( dropDownCat.querySelector(':scope > .wd-nav-opener') || dropDownCat.closest('.widget_nav_mega_menu') ) {
			return;
		}

		var elementIcon = document.createElement('span');
		elementIcon.classList.add('wd-nav-opener');
		dropDownCat.appendChild(elementIcon);
	});
}
woodmartThemeModule.mobileNavigationCloseSideWidgets = function(closeSideWidgets) {
	if (! closeSideWidgets) {
		return;
	}

	closeSideWidgets.forEach(function(closeSideWidget) {
		closeSideWidget.addEventListener('click', function(e) {
			e.preventDefault();
			woodmartThemeModule.closeMobileNavigation();
		});
	});
}
woodmartThemeModule.openMobileNavigation             = function(mobileNav) {
	var closeSide = document.querySelector('.wd-close-side');

	if ( mobileNav ) {
		mobileNav.classList.add('wd-opened');
	}

	if ( closeSide ) {
		closeSide.classList.add('wd-close-side-opened');
	}

	woodmartThemeModule.$document.trigger('wood-images-loaded');
}
woodmartThemeModule.closeMobileNavigation            = function() {
	var activeHeaderMobileNav = document.querySelector('.wd-header-mobile-nav.wd-opened');
	var activeMobileNav       = document.querySelector('.mobile-nav.wd-opened')
	var activeCloseSide       = document.querySelector('.wd-close-side.wd-close-side-opened');
	var searchFormInput       = document.querySelector('.mobile-nav .searchform input[type=text]');

	if (activeHeaderMobileNav) {
		activeHeaderMobileNav.classList.remove('wd-opened');
	}

	if (activeMobileNav) {
		activeMobileNav.classList.remove('wd-opened');
	}

	if (activeMobileNav && activeCloseSide) {
		activeCloseSide.classList.remove('wd-close-side-opened');
	}

	if (searchFormInput) {
		searchFormInput.blur();
	}
}
woodmartThemeModule.mobileNavigation                 = function() {
	var	dropDownCats     = document.querySelectorAll('.wd-side-hidden-nav .wd-nav-mobile .menu-item-has-children');
	var	mobileNavs       = document.querySelectorAll('.wd-side-hidden-nav');
	var closeSide        = document.querySelector('.wd-close-side');
	var closeSideWidgets = document.querySelectorAll('.mobile-nav .login-side-opener, .mobile-nav .close-side-widget');

	woodmartThemeModule.mobileNavigationAddOpeners(dropDownCats);

	mobileNavs.forEach(function(mobileNav) {
		woodmartThemeModule.mobileNavigationClickAction(mobileNav);
	});

	window.addEventListener('wdEventStarted', function () {
		var openersMobileNav = document.querySelectorAll('.wd-header-mobile-nav > a');

		openersMobileNav.forEach(function(openMobileNav) {
			openMobileNav.addEventListener('click', function(e) {
				e.preventDefault();
				var mobileNavContent = document.querySelector('.wd-side-hidden-nav');

				if (mobileNavContent.classList.contains('wd-opened')) {
					woodmartThemeModule.closeMobileNavigation();
				} else {
					openMobileNav.parentNode.classList.add('wd-opened');
					woodmartThemeModule.openMobileNavigation(mobileNavContent);
				}
			});
		});
	});

	if (closeSide) {
		closeSide.addEventListener('click', function(e) {
			e.preventDefault();
			woodmartThemeModule.closeMobileNavigation();
		});

		closeSide.addEventListener('touchstart', function(e) {
			e.preventDefault();
			woodmartThemeModule.closeMobileNavigation();
		}, {passive: false});
	}

	woodmartThemeModule.mobileNavigationCloseSideWidgets(closeSideWidgets);
}

window.addEventListener('load',function() {
	woodmartThemeModule.mobileNavigation();
});
