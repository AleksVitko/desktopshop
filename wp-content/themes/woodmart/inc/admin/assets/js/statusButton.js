/* global wd_status_btn_data */
(function($) {
	$(document)
		.on('click', `.wp-list-table .xts-switcher-btn`, function() {
			var $switcher = $(this);

			$switcher.addClass('xts-loading');

			$.ajax({
				url     : woodmartConfig.ajaxUrl,
				method  : 'POST',
				data    : {
					action  : 'wd_change_post_status',
					id      : $switcher.data('id'),
					status  : 'publish' === $switcher.data('status') ? 'draft' : 'publish',
					security: $switcher.data('security'),
				},
				dataType: 'json',
				success : function(response) {
					$switcher.replaceWith(response.new_html);
				},
				error   : function(error) {
					console.error(error);
				}
			});
		});
})(jQuery);
