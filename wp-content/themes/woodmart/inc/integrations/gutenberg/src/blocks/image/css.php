<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

foreach ( array( '', 'tablet', 'mobile' ) as $device ) {
	if ( isset( $attrs[ 'displayWidth' . ucfirst( $device ) ] ) && 'custom' === $attrs[ 'displayWidth' . ucfirst( $device ) ] ) {
		if ( ! empty( $attrs[ 'customWidth' . ucfirst( $device ) ] ) && '%' === $block_css->get_units_for_attribute( 'customWidth', $device ) ) {
			$block_css->add_to_selector(
				$block_selector,
				'--wd-img-width: 100%;',
				$device ? $device : 'global'
			);
		} else {
			$block_css->add_css_rules(
				$block_selector,
				array(
					array(
						'attr_name' => 'customWidth' . ucfirst( $device ),
						'template'  => '--wd-img-width: {{value}}' . $block_css->get_units_for_attribute( 'customWidth', $device ) . ';',
					),
				),
				$device ? $device : 'global'
			);
		}
	}
}

$block_css->merge_with(
	wd_get_block_advanced_css(
		array(
			'selector'                     => $block_selector,
			'selector_hover'               => $block_selector_hover,

			'selector_border'              => $block_selector . ' img',
			'selector_border_hover'        => $block_selector . ' img:hover',
			'selector_border_parent_hover' => '.wd-hover-parent:hover ' . $block_selector . ' img',

			'selector_shadow'              => $block_selector . ' img',
			'selector_shadow_hover'        => $block_selector . ' img:hover',
			'selector_shadow_parent_hover' => '.wd-hover-parent:hover ' . $block_selector . ' img',

			'selector_transition'          => $block_selector . ',' . $block_selector . ' img',
		),
		$attrs
	)
);

return $block_css->get_css_for_devices();
