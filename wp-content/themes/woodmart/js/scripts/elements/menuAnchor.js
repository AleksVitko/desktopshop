jQuery(window).on('elementor/frontend/init', function(){
	if (window.elementorFrontend) {
		elementorFrontend.hooks.addFilter( 'frontend/handlers/menu_anchor/scroll_top_distance', function(scrollTop) {
			var stickyElementsHeight = 0;
			var stickyRows           = jQuery('.whb-sticky-row');
			
			if (0 === stickyRows.length) {
				return scrollTop;
			}

			stickyRows.each(function() {
				stickyElementsHeight += jQuery(this).height();
			});

			return scrollTop - stickyElementsHeight;
		});
	}
});