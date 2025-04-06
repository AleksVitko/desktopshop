/* global xts_settings */
(function($) {
	woodmartThemeModule.$document.on('wdLoadDropdownsSuccess', function() {
		woodmartThemeModule.videoElementPopup();
	});

	woodmartThemeModule.wdElementorAddAction('frontend/element_ready/wd_video.default', function() {
		woodmartThemeModule.videoElementPopup();
	});

	woodmartThemeModule.videoElementPopup = function() {
		if ('undefined' === typeof ($.fn.magnificPopup)) {
			return;
		}

		$('.wd-el-video-btn:not(.wd-el-video-hosted), .wd-el-video-btn-overlay.wd-el-video-lightbox:not(.wd-el-video-hosted), .wd-el-video.wd-action-button:not(.wd-video-hosted) a:not(.wp-block-wd-button), .wd-el-video.wd-action-action_button:not(.wd-video-hosted) a:not(.wp-block-wd-button)').magnificPopup({
			tClose         : woodmart_settings.close,
			tLoading       : woodmart_settings.loading,
			removalDelay   : 600,
			type           : 'iframe',
			preloader      : false,
			fixedContentPos: true,
			iframe         : {
				markup  : '<div class="wd-popup wd-with-video wd-video-popup"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" allowfullscreen frameborder="0"></iframe></div>',
				patterns: {
					youtube: {
						index: 'youtube.com/',
						id   : 'v=',
						src  : '//www.youtube.com/embed/%id%?rel=0&autoplay=1&mute=1'
					},
					vimeo  : {
						index: 'vimeo.com/',
						id   : '/',
						src  : '//player.vimeo.com/video/%id%?transparent=0&autoplay=1&muted=1'
					}
				}
			},
			callbacks      : {
				beforeOpen: function() {
					this.wrap.addClass('wd-popup-slide-from-left');
				}
			}
		});

		$('.wd-el-video-btn-overlay.wd-el-video-lightbox.wd-el-video-hosted,.wd-el-video-btn.wd-el-video-hosted, .wd-el-video.wd-action-button.wd-video-hosted a:not(.wp-block-wd-button), .wd-el-video.wd-action-action_button.wd-video-hosted a:not(.wp-block-wd-button)').magnificPopup({
			type        : 'inline',
			tClose      : woodmart_settings.close,
			tLoading    : woodmart_settings.loading,
			removalDelay: 600,
			preloader   : false,
			fixedContentPos: true,
			callbacks   : {
				beforeOpen  : function() {
					this.wrap.addClass('wd-popup-slide-from-left');
				},
				elementParse: function(item) {
					var $video = $(item.src).find('video');

					if ( ! $video.attr('src') ) {
						$video.attr('src', $video.data('lazy-load'));
					}

					$video[0].play();
				},
				open        : function() {
					woodmartThemeModule.$document.trigger('wood-images-loaded');
					woodmartThemeModule.$window.resize();
				},
				close       : function(e) {
					var magnificPopup = $.magnificPopup.instance;
					var $video = $(magnificPopup.st.el[0]).parents('.wd-el-video').find('video');
					$video[0].pause();
				}
			}
		});

		$('.wd-el-video.wd-action-button .wp-block-wd-button').off('click').on('click', function (e) {
			e.preventDefault();

			var $wrapper = $(this).parent();
			var items = '';

				$.magnificPopup.close()

			if ($wrapper.hasClass('wd-video-hosted')) {
				items = $wrapper.find('.wd-popup.wd-video-popup')
			} else {
				items = $('<div class="wd-popup mfp-with-anim wd-video-popup"><iframe class="mfp-iframe" src="' + $wrapper.data('src') + '" allowfullscreen allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" width="100%" height="100%"></iframe></div>')
			}

			$.magnificPopup.open({
				items       : {
					src : items,
					type: 'inline'
				},
				tClose: woodmart_settings.close,
				tLoading: woodmart_settings.loading,
				removalDelay: 500,
				preloader: false,
				callbacks: {
					beforeOpen: function () {
						this.st.mainClass = 'mfp-move-horizontal';
					},
					elementParse: function (item) {
						var $video = $(item.src).find('video');

						if ( $video.length ) {
							if ( ! $video.attr('src') ) {
								$video.attr('src', $video.data('lazy-load'));
							}

							$video[0].play();
						}
					},
					open: function () {
						woodmartThemeModule.$document.trigger('wood-images-loaded');
						woodmartThemeModule.$window.resize();
					},
					close: function (e) {
						var magnificPopup = $.magnificPopup.instance;

						if ('undefined' !== typeof magnificPopup.st.el) {
							var $video = $(magnificPopup.st.el[0]).parents('.wd-el-video').find('video');

							if ( $video.length ) {
								$video[0].pause();
							}
						}
					}
				}
			})
		})
	};

	$(document).ready(function() {
		woodmartThemeModule.videoElementPopup();
	});
})(jQuery);