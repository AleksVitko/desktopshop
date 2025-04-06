/* global woodmart_settings */
(function($) {
	$.each([
		'frontend/element_ready/wd_counter.default'
	], function(index, value) {
		woodmartThemeModule.wdElementorAddAction(value, function() {
			woodmartThemeModule.visibleElements();
		});
	});

	woodmartThemeModule.counterShortcode = function(counter) {
		if (counter.attr('data-state') === 'done' || counter.attr('data-state') === 'process') {
			return;
		}

		counter.prop('Counter', counter.text()).animate({
			Counter: counter.data('final')
		}, {
			duration: parseInt(woodmart_settings.animated_counter_speed),
			easing  : 'swing',
			step    : function(now) {
				if (now >= counter.data('final')) {
					counter.attr('data-state', 'done');
				} else {
					counter.attr('data-state', 'process');
				}

				counter.text(Math.ceil(now));
			}
		});
	};

	woodmartThemeModule.visibleElements = function() {
		$('.woodmart-counter .counter-value, .wp-block-wd-animated-counter span').each(function() {
			var $this = $(this);

			$this.waypoint(function() {
				woodmartThemeModule.counterShortcode($this);
			}, {offset: '100%'});
		});
	};

	$(document).ready(function() {
		woodmartThemeModule.visibleElements();
	});
})(jQuery);
