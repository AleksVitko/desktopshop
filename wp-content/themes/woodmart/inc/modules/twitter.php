<?php
if ( ! function_exists( 'woodmart_get_twitts' ) ) {
	function woodmart_get_twitts( $args = array() ) {
		// Get the tweets from Twitter.
		if ( ! class_exists( 'TwitterOAuth' ) ) {
			return;
		}

		if ( ! isset( $args['name'] ) || ! isset( $args['consumer_key'] ) || ! isset( $args['consumer_secret'] ) || ! isset( $args['access_token'] ) || ! isset( $args['accesstoken_secret'] ) ) {
			echo '<p>You need to enter your Consumer key and secret to display your recent X (Twitter) feed.</p>';
		}

		if ( ! isset( $args['name'] ) ) {
			$args['name'] = 'Twitter';
		}
		if ( ! isset( $args['num_tweets'] ) ) {
			$args['num_tweets'] = 5;
		}
		if ( ! isset( $args['consumer_key'] ) ) {
			$args['consumer_key'] = '';
		}
		if ( ! isset( $args['consumer_secret'] ) ) {
			$args['consumer_secret'] = '';
		}
		if ( ! isset( $args['access_token'] ) ) {
			$args['access_token'] = '';
		}
		if ( ! isset( $args['accesstoken_secret'] ) ) {
			$args['accesstoken_secret'] = '';
		}
		if ( ! isset( $args['exclude_replies'] ) ) {
			$args['exclude_replies'] = '';
		}

		$connection = new TwitterOAuth(
			$args['consumer_key'],          // Consumer key
			$args['consumer_secret'],       // Consumer secret
			$args['access_token'],          // Access token
			$args['accesstoken_secret'] // Access token secret
		);

		$posts_data_transient_name = 'wood-twitter-posts-data-' . sanitize_title_with_dashes( $args['name'] . $args['num_tweets'] . $args['exclude_replies'] );
		$fetchedTweets             = maybe_unserialize( base64_decode( get_transient( $posts_data_transient_name ) ) );

		if ( ! $fetchedTweets ) {
			$fetchedTweets = $connection->get(
				'statuses/user_timeline',
				array(
					'screen_name'     => $args['name'],
					'count'           => $args['num_tweets'],
					'exclude_replies' => ( isset( $args['exclude_replies'] ) ) ? $args['exclude_replies'] : '',
				)
			);

			if ( $connection->http_code != 200 ) {
				echo esc_html__( 'X does not return 200', 'woodmart' );
				return;
			}

			$encode_posts = base64_encode( maybe_serialize( $fetchedTweets ) );
			set_transient( $posts_data_transient_name, $encode_posts, apply_filters( 'wood_twitter_cache_time', HOUR_IN_SECONDS * 2 ) );
		}

		if ( ! $fetchedTweets ) {
			echo esc_html__( 'Twitter does not return any data', 'woodmart' );
		}

		$limitToDisplay = min( $args['num_tweets'], count( $fetchedTweets ) );

		for ( $i = 0; $i < $limitToDisplay; $i++ ) {
			$tweet = $fetchedTweets[ $i ];

			// Core info.
			$name = $tweet->user->name;

			// COMMUNITY REQUEST !!!!!! (2)
			$screen_name = $tweet->user->screen_name;

			$permalink = 'https://x.com/' . $screen_name . '/status/' . $tweet->id_str;
			$tweet_id  = $tweet->id_str;

			// Check for SSL via protocol https then display relevant image - thanks SO - this should do
			if ( is_ssl() ) {
				$image = $tweet->user->profile_image_url_https;
			} else {
				$image = $tweet->user->profile_image_url;
			}

			// Process Tweets - Use Twitter entities for correct URL, hash and mentions
			$text = woodmart_twitter_process_links( $tweet );

			// lets strip 4-byte emojis
			$text = preg_replace( '/[\xF0-\xF7][\x80-\xBF]{3}/', '', $text );

			// Need to get time in Unix format.
			$time  = $tweet->created_at;
			$time  = date_parse( $time );
			$uTime = mktime( $time['hour'], $time['minute'], $time['second'], $time['month'], $time['day'], $time['year'] );

			// Now make the new array.
			$tweets[] = array(
				'text'      => $text,
				'name'      => $name,
				'permalink' => $permalink,
				'image'     => $image,
				'time'      => $uTime,
				'tweet_id'  => $tweet_id,
			);
		}

		// Now display the tweets, if we can.
		if ( isset( $tweets ) ) {
			?>
			<ul <?php echo ( isset( $args['show_avatar'] ) ) ? ' class="twitter-avatar-enabled"' : ''; ?>>
				<?php foreach ( $tweets as $t ) { ?>
					<li class="twitter-post">
						<?php if ( isset( $args['show_avatar'] ) && $args['show_avatar'] ) : ?>
							<div class="twitter-image-wrapper">
								<img <?php echo ( isset( $args['avatar_size'] ) ) ? 'width="' . $args['avatar_size'] . 'px" height="' . $args['avatar_size'] . 'px"' : 'width="48px" height="48px"'; ?> src="<?php echo esc_url( $t['image'] ); ?>" alt="<?php esc_attr_e( 'Tweet Avatar', 'woodmart' ); ?>">
							</div>
						<?php endif ?>
						<div class="twitter-content-wrapper">
							<?php
								echo wp_kses(
									$t['text'],
									array(
										'a' => array(
											'href'   => true,
											'target' => true,
											'rel'    => true,
										),
									)
								);
							?>
							<span class="stt-em">
						<a href="<?php echo esc_url( $t['permalink'] ); ?>" target="_blank">
							<?php
								$timeDisplay = human_time_diff( $t['time'], current_time( 'timestamp' ) );
								$displayAgo  = _x( ' ago', 'leading space is required to keep gap from date', 'woodmart' );
								// Use to make il8n compliant
								printf( esc_html__( '%1$s%2$s', 'woodmart' ), $timeDisplay, $displayAgo );
							?>
						</a>
					</span>
						</div>
					</li>
					<?php
				}
				?>
			</ul>
			<?php
		}
	}
}

if ( ! function_exists( 'woodmart_twitter_process_links' ) ) {
	/**
	 * Twitter process links.
	 *
	 * @param object $tweet Tweet.
	 * @return array|string|string[]|null
	 */
	function woodmart_twitter_process_links( $tweet ) {
		if ( isset( $tweet->retweeted_status ) ) {
			$rt_section = current( explode( ':', $tweet->text ) );
			$text       = $rt_section . ': ';

			$text .= $tweet->retweeted_status->text;
		} else {
			$text = $tweet->text;
		}

		$text = preg_replace( '/((http)+(s)?:\/\/[^<>\s]+)/i', '<a href="$0" target="_blank" rel="nofollow noopener">$0</a>', $text );
		$text = preg_replace( '/[@]+([A-Za-z0-9-_]+)/', '<a href="https://x.com/$1" target="_blank" rel="nofollow noopener">@\\1</a>', $text );
		$text = preg_replace( '/[#]+([A-Za-z0-9-_]+)/', '<a href="https://x.com/search?q=%23$1" target="_blank" rel="nofollow noopener">$0</a>', $text );

		return $text;
	}
}
