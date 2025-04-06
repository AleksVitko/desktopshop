/* global woodmart_settings */
(function($) {
	woodmartThemeModule.singleProdReviewsLike = function () {
		let $reviewsTab = $('#reviews');
		
		$reviewsTab.on( 'click', '.wd-review-likes .wd-like, .wd-review-likes .wd-dislike', function(e) {
			e.preventDefault();

			if ( ! $('body').hasClass('logged-in') ) {
				return;
			}

			let vote;
			let $this         = $(this);
			let $voteWrapper  = $this.closest('.wd-review-likes');
			let commentIDAttr = $this.closest('.comment_container').attr('id');
			let commentID     = parseInt(commentIDAttr.substring(commentIDAttr.indexOf('-') + 1));

			if ( $this.hasClass('wd-active') ) {
				return;
			}

			$this.siblings().removeClass( 'wd-active' );
			$this.addClass('wd-active');

			if ( $this.hasClass('wd-like') ) {
				vote = 'like';
			} else if ( $this.hasClass('wd-dislike') ) {
				vote = 'dislike';
			}

			$.ajax({
				url    : woodmart_settings.ajaxurl,
				method : 'POST',
				data   : {
					action: 'woodmart_comments_likes',
					comment_id: commentID,
					vote,
				},
				beforeSend: function() {
					$voteWrapper.addClass('wd-adding');
				},
				complete: function() {
					$voteWrapper.removeClass('wd-adding');
				},
				success: function( response ) {
					let $likesWrap = $this.closest('.wd-review-likes');

					if ( response.hasOwnProperty( 'likes' ) ) {
						$likesWrap.find('.wd-like span').text( response.likes )
					}

					if ( response.hasOwnProperty( 'dislikes' ) ) {
						$likesWrap.find('.wd-dislike span').text( response.dislikes )
					}
				},
				error: function( request ) {
					console.error( request );
				}
			});
		});
	}

	$(document).ready(function() {
		woodmartThemeModule.singleProdReviewsLike();
	});
})(jQuery);
