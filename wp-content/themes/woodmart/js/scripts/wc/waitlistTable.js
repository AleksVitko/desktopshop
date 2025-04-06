woodmartThemeModule.waitlistTable = function() {
	var waitlistTable = document.querySelector('.wd-wtl-table');

	if ( ! waitlistTable ) {
		return;
	}

	var unsubscribeBtns = waitlistTable.querySelectorAll('.wd-wtl-unsubscribe');

	unsubscribeBtns.forEach(function(unsubscribeBtn) {
		unsubscribeBtn.addEventListener('click', function(e) {
			e.preventDefault();
			
			var actionBtn = this;

			waitlistTable.parentNode.querySelector('.wd-loader-overlay').classList.add('wd-loading');

			jQuery.ajax({
				url     : woodmart_settings.ajaxurl,
				data    : {
					action     : 'woodmart_remove_from_waitlist_in_my_account',
					product_id : actionBtn.dataset.productId,
				},
				method  : 'POST',
				success : function(response) {
					if (!response) {
						return;
					}

					if (response.success) {
						actionBtn.closest('tr').remove();
					}

					if (response.data.content) {
						tempDiv           = document.createElement('div');
						tempDiv.innerHTML = response.data.content;
						var childNodes    = tempDiv.querySelector('.wd-wtl-content').childNodes;

						waitlistTable.parentNode.replaceChildren(...childNodes);
					}
				},
				error   : function() {
					console.error('ajax remove from waitlist error');
				},
				complete: function() {
					waitlistTable.parentNode.querySelector('.wd-loader-overlay').classList.remove('wd-loading');
				}
			});
		});
	});
}

window.addEventListener('load', function() {
	woodmartThemeModule.waitlistTable();
});
