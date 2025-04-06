<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_block_social_buttons_attrs' ) ) {
	function wd_get_block_social_buttons_attrs() {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'title'               => array(
					'type' => 'boolean',
				),
				'type'                => array(
					'type'    => 'string',
					'default' => 'share',
				),
				'layout'              => array(
					'type' => 'string',
				),
				'alignment'           => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'style'               => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'form'                => array(
					'type'    => 'string',
					'default' => 'circle',
				),
				'size'                => array(
					'type'    => 'string',
					'default' => 'default',
				),
				'color'               => array(
					'type' => 'string',
				),
				'social_links_source' => array(
					'type'    => 'string',
					'default' => 'theme_settings',
				),
				'fb_link'             => array(
					'type'    => 'string',
					'default' => '#',
				),
				'twitter_link'        => array(
					'type'    => 'string',
					'default' => '#',
				),
				'isntagram_link'      => array(
					'type'    => 'string',
					'default' => '#',
				),
				'pinterest_link'      => array(
					'type'    => 'string',
					'default' => '#',
				),
				'youtube_link'        => array(
					'type'    => 'string',
					'default' => '#',
				),
				'tumblr_link'         => array(
					'type' => 'string',
				),
				'linkedin_link'       => array(
					'type' => 'string',
				),
				'vimeo_link'          => array(
					'type' => 'string',
				),
				'flickr_link'         => array(
					'type' => 'string',
				),
				'github_link'         => array(
					'type' => 'string',
				),
				'dribbble_link'       => array(
					'type' => 'string',
				),
				'behance_link'        => array(
					'type' => 'string',
				),
				'soundcloud_link'     => array(
					'type' => 'string',
				),
				'spotify_link'        => array(
					'type' => 'string',
				),
				'ok_link'             => array(
					'type' => 'string',
				),
				'vk_link'             => array(
					'type' => 'string',
				),
				'whatsapp_link'       => array(
					'type' => 'string',
				),
				'snapchat_link'       => array(
					'type' => 'string',
				),
				'tg_link'             => array(
					'type' => 'string',
				),
				'viber_link'          => array(
					'type' => 'string',
				),
				'tiktok_link'         => array(
					'type' => 'string',
				),
				'skype_link'          => array(
					'type' => 'string',
				),
				'yelp_link'           => array(
					'type' => 'string',
				),
				'discord_link'        => array(
					'type' => 'string',
				),
			)
		);

		$attr->add_attr( wd_get_advanced_tab_attrs() );

		return $attr->get_attr();
	}
}
