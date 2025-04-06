jQuery(window).on('elementor:init', function() {
	var buttons = elementor.modules.controls.BaseData.extend({
		onReady: function() {
			var self = this;
			var $set = self.$el.find('.xts-btns-set');

			$set.on('click', '.xts-set-item', function() {
				var $btn       = jQuery(this);
				var allowedUnselect = self.model.attributes.hasOwnProperty('allowed_unselect') ? self.model.attributes.allowed_unselect : '';

				if ($btn.hasClass('xts-active')) {
					if (allowedUnselect) {
						$set
							.find('.xts-active')
							.removeClass('xts-active');

						self.ui.input.val('');
						self.saveValue();
					}

					return;
				}

				var val = $btn.data('value');

				$set
					.find('.xts-active')
					.removeClass('xts-active');

				$btn.addClass('xts-active');

				self.ui.input.val(val);
				self.saveValue();
			});

		},

		saveValue: function() {
			this.setValue(this.ui.input.val());
		},

		onBeforeDestroy: function() {
			this.saveValue();
		},
	});
	elementor.addControlView('wd_buttons', buttons);
});
