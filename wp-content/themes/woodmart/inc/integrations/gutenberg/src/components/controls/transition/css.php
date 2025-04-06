<?php

use XTS\Gutenberg\Block_CSS;

if ( ! function_exists( 'wd_get_block_transition_css' ) ) {
	function wd_get_block_transition_css( $selector, $attributes ) {
		$block_css = new Block_CSS( $attributes );

		$transition = '';

		if ( ! empty( $attributes['transitionBorder'] ) ) {
			$transition .= 'border ' . $attributes['transitionBorder'] . 's, box-shadow ' . $attributes['transitionBorder'] . 's, border-radius ' . $attributes['transitionBorder'] . 's, ';
		}

		if ( ! empty( $attributes['transitionBackground'] ) ) {
			$transition .= 'background ' . $attributes['transitionBackground'] . 's, ';
		}

		if ( ! empty( $attributes['transitionTransform'] ) ) {
			$transition .= 'transform ' . $attributes['transitionTransform'] . 's, ';
		}

		if ( ! empty( $attributes['transitionOpacity'] ) ) {
			$transition .= 'visibility ' . $attributes['transitionOpacity'] . 's, opacity ' . $attributes['transitionOpacity'] . 's, ';
		}

		if ( $transition ) {
			$block_css->add_to_selector(
				$selector,
				'transition: var(--wd-trans-main, all .25s ease), ' . substr( $transition, 0, -2 ) . ', var(--wd-trans-last, last .25s ease);'
			);
		}

		return $block_css->get_css();
	}
}
