<?php
$assets = array(
	'styles'    => array( 'block-fw-section' ),
	'scripts'   => array(),
	'libraries' => array(),
);

if ( ! empty( $this->attrs['shapeDividerTopIcon'] ) || ! empty( $this->attrs['shapeDividerBottomIcon'] ) ) {
	$assets['styles'][] = 'block-shape-divider';
}

return $assets;