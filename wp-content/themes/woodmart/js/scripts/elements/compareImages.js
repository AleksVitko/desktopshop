jQuery.each([
	'frontend/element_ready/wd_compare_img.default'
], function(index, value) {
	woodmartThemeModule.wdElementorAddAction(value, function() {
		woodmartThemeModule.compareImages();
	});
});

woodmartThemeModule.compareImages = function() {
	var containers = document.querySelectorAll('.wd-compare-img');

	containers.forEach(function(container) {
		addDraggingEvents(container);
	});

	function addDraggingEvents(container) {
		var isDragging = false;

		// Mouse event handlers.
		container.addEventListener('mousedown', function(e) {
			isDragging = true;
			moveSlider(e, container);
		});

		document.addEventListener('mouseup', function() {
			isDragging = false;
		});

		container.addEventListener('mousemove', function(e) {
			if (!isDragging) {
				return;
			}

			moveSlider(e, container);
		});

		// Event handlers for sensory devices.
		container.addEventListener('touchstart', function(e) {
			isDragging = true;
			moveSlider(e.touches[0], container);
		}, {passive: true});
	
		document.addEventListener('touchend', function() {
			isDragging = false;
		}, {passive: true});
	
		container.addEventListener('touchmove', function(e) {
			if (!isDragging) {
				return;
			}

			moveSlider(e.touches[0], container);
		}, {passive: true});
	}

	// Move the slider to the click position or the drag position.
	function moveSlider(e, container) {
		var containerRect = container.getBoundingClientRect();
		var offsetX       = e.clientX - containerRect.left;

		if (offsetX < 0) {
			offsetX = 0;
		}

		if (offsetX > containerRect.width) {
			offsetX = containerRect.width;
		}

		var widthPercentage = ( (offsetX / containerRect.width) * 100).toFixed(3);

		// Update the CSS variable
		container.style.setProperty('--wd-compare-handle-pos', `${widthPercentage}%`);
	}
}

window.addEventListener('load', function() {
	woodmartThemeModule.compareImages();
});
