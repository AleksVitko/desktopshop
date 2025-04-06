/* global xts_settings */
(function() {
	woodmartThemeModule.cssAnimations = function() {
	
		var options = {
			root: null,
			rootMargin: '0px',
			threshold: 0
		}
		var elementsToObserve = document.querySelectorAll('.wd-animation');

		var callback = function(entries, observer) {
			entries.forEach(function (entry) {
				// Check if the observed element is intersecting
				if (entry.isIntersecting) {
				  // Perform your desired actions when the element is in view
				  animate(entry.target);
				  observer.unobserve(entry.target);
				}
			});
		};

		var animate = function(target) {
			if ( target.classList.contains('wd-animation-ready')) {
				return;
			}

			var delay = 0;

			target.classList.forEach((classname) => {
				if (classname.includes('wd_delay_')) {
					delay = classname.split('_')[2];
				}
			})

			target.classList.add('wd-animation-ready');

			setTimeout(function() {
				target.classList.add('wd-animated');
			}, delay)
		}

		// Create an IntersectionObserver instance for each element
		elementsToObserve.forEach(function (element) {
			if ( element.closest('.wd-slider') ) {
				return;
			}

			var observer = new IntersectionObserver(callback, options);
			observer.observe(element);
		});

	};
	document.addEventListener('DOMContentLoaded', function() {
		woodmartThemeModule.cssAnimations();
	});
})();
