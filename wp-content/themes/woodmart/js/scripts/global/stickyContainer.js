/* global woodmart_settings */
woodmartThemeModule.wdElementorAddAction('frontend/element_ready/container', function() {
	woodmartThemeModule.stickyContainer();
});

woodmartThemeModule.stickyContainer = function () {
	let windowWidth = woodmartThemeModule.windowWidth;

	function isRtl() {
		return document.querySelector('html').hasAttributes('dir') && 'rtl' === document.querySelector('html').getAttribute('dir');
	}

	function setInlineStyle(el, style) {
		let properties = Object.keys(style);

		if (0 === properties.length) {
			return;
		}

		properties.forEach(function(property) {
			el.style[property] = style[property];
		});
	}

	function getFixedStyles(el, offset) {
		let stickyContainerCloneStyles = window.getComputedStyle(el);
		let styles                     = {
			position: 'fixed',
			width: stickyContainerCloneStyles.width,
			marginTop: stickyContainerCloneStyles.marginTop,
			marginBottom: stickyContainerCloneStyles.marginBottom,
			top: `${offset}px`,
			bottom: '',
			zIndex: 99,
		}

		if ( isRtl() ) {
			styles['insetInlineEnd'] = `${el.getBoundingClientRect().left}px`;
		} else {
			styles['insetInlineStart'] = `${el.getBoundingClientRect().left}px`;
		}

		return styles;
	}

	function getAbsoluteStyles(el) {
		let styles = {
			position: 'absolute',
			top: '',
			bottom: '0px',
		};

		if ( isRtl() ) {
			styles['insetInlineEnd'] = `${el.offsetLeft}px`;
		} else {
			styles['insetInlineStart'] = `${el.offsetLeft}px`;
		}

		return styles;
	}

	function createClone(el, offset, position = 'fixed') {
		let styles = getFixedStyles(el, offset);

		if ( 'absolute' === position ) {
			styles = getAbsoluteStyles(el);
		}

		let clone  = el.cloneNode(true);

		clone.classList.add('wd-sticky-spacer');

		setInlineStyle(clone, {visibility: 'hidden'});

		// Fix duplicate clone id. Only for waitlist privacy policy input.
		var wtlPolicyCheck = clone.querySelector('#wd-wtl-policy-check');

		if ( wtlPolicyCheck ) {
			wtlPolicyCheck.id = wtlPolicyCheck.id + '-clone';
		}

		el.parentNode.insertBefore(clone, el);

		setInlineStyle(el, styles);

		return clone;
	}

	function removeClone(el, clone) {
		el.parentNode.removeChild(clone);

		el.style = '';
	}

	function getSiblings(el) {
		let siblings = [];

		if(! el.parentNode) {
			return siblings;
		}

		let sibling  = el.parentNode.firstChild;

		while (sibling) {
			if (sibling.nodeType === 1 && sibling !== el) {
				siblings.push(sibling);
			}

			sibling = sibling.nextSibling;
		}

		return siblings;
	}

	function makeThisContainerSticky(stickyContainer, responsiveSettings) {
		let elementId = stickyContainer.dataset.id;

		if ('undefined' === typeof elementId) {
			return;
		}

		let stickyContainerClone = document.querySelector(`.elementor-element-${elementId}.wd-sticky-spacer`);

		if ( ( responsiveSettings.is_mobile && ! stickyContainer.classList.contains( 'wd-sticky-container-mobile-yes' ) ) || ( responsiveSettings.is_tablet && ! stickyContainer.classList.contains( 'wd-sticky-container-tablet-yes' ) ) || ( responsiveSettings.is_desktop && ! stickyContainer.classList.contains( 'wd-sticky-container-yes' ) ) ) {
			if ( null !== stickyContainerClone ) {
				removeClone(stickyContainer, stickyContainerClone);
			}

			return;
		}

		let offsetClass                = Array.from(stickyContainer.classList).find(function (element) {
			return element.indexOf('wd-sticky-offset') !== -1;
		});
		let offset                     = 'undefined' !== typeof offsetClass ? parseInt(offsetClass.substring(offsetClass.lastIndexOf('-') + 1)) : 150;
		let scrollTop                  = woodmartThemeModule.$window.scrollTop();
		let stickyHolderHeight         = stickyContainer.offsetHeight;
		let stickyHeightToElementStart = stickyContainer.getBoundingClientRect().top + window.scrollY - offset;
		let isTopContainer             = stickyContainer.parentNode.parentNode.classList.contains('entry-content');
		let heightToElementParentEnd   = stickyContainer.parentNode.getBoundingClientRect().top + window.scrollY - offset + stickyContainer.parentNode.offsetHeight;

		if ( ! isTopContainer && null === stickyContainerClone && scrollTop > stickyHeightToElementStart) {
			let clonePosition = 'fixed';

			if ( scrollTop > heightToElementParentEnd ) {
				clonePosition = 'absolute';
			}

			stickyContainerClone = createClone(stickyContainer, offset, clonePosition);
		}

		if (null === stickyContainerClone) {
			return;
		}

		let heightToElementWrapperStart = stickyContainerClone.parentNode.getBoundingClientRect().top + window.scrollY - offset;
		let heightToElementWrapperEnd   = heightToElementWrapperStart + stickyContainerClone.parentNode.offsetHeight;
		let heightToElementStart        = stickyContainerClone.getBoundingClientRect().top + window.scrollY - offset;

		if (scrollTop < heightToElementStart) {
			removeClone(stickyContainer, stickyContainerClone);
		} else {
			if ('fixed' !== stickyContainer.style.position && scrollTop < (heightToElementWrapperEnd - stickyHolderHeight)) {
				let siblings             = getSiblings(stickyContainer);
				let absoluteColumnExists = siblings.find(function (el) {
					return 'absolute' === el.style.position;
				});

				if ( 'undefined' === typeof absoluteColumnExists ) {
					setInlineStyle(stickyContainer.parentNode, {position: ''});
				}

				setInlineStyle(stickyContainer, getFixedStyles(stickyContainerClone, offset));
			} else if ('absolute' !== stickyContainer.style.position && (stickyHeightToElementStart + stickyHolderHeight) > heightToElementWrapperEnd) {
				setInlineStyle(stickyContainer.parentNode, {position: 'relative'});
				setInlineStyle(stickyContainer, getAbsoluteStyles(stickyContainerClone));
			}
		}
	}

	function wipeSticky() {
		let stickyContainers = document.querySelectorAll(
			'.wd-sticky-container-yes, .wd-sticky-container-tablet-yes, .wd-sticky-container-mobile-yes'
		);
		
		stickyContainers.forEach(function (stickyContainer) {
			let elementId            = stickyContainer.dataset.id;
			let stickyContainerClone = document.querySelector(`.elementor-element-${elementId}.wd-sticky-spacer`);
			
			if ( stickyContainerClone ) {
				stickyContainerClone.remove()
			}
			
			document.querySelector(`.elementor-element-${elementId}`).style = '';
		});
	}

	function makeSticky() {
		window.addEventListener('scroll',function() {
			let stickyContainers = document.querySelectorAll('.wd-sticky-container-yes:not(.wd-sticky-spacer), .wd-sticky-container-tablet-yes:not(.wd-sticky-spacer), .wd-sticky-container-mobile-yes:not(.wd-sticky-spacer)');

			let responsiveSettings = {
				is_desktop: windowWidth > 1024,
				is_tablet : windowWidth > 768 && windowWidth < 1024,
				is_mobile : windowWidth <= 768,
			}

			stickyContainers.forEach(function(stickyContainer) {
				makeThisContainerSticky(stickyContainer, responsiveSettings);
			});
		});
	}

	wipeSticky();
	makeSticky();

	window.addEventListener('resize',function() {
		if ( 'undefined' !== typeof elementor ) {
			windowWidth = !isNaN(parseInt(elementor.$preview.css('--e-editor-preview-width'))) ? parseInt(elementor.$preview.css('--e-editor-preview-width')) : 1025;
		}
	});
}

window.addEventListener('load',function() {
	woodmartThemeModule.stickyContainer();
});
