<?php
$assets = array(
	'styles'    => array( 'block-image' ),
	'scripts'   => array(),
	'libraries' => array(),
);

if ( ! empty( $this->attrs['expandOnClick'] ) ) {
	$assets['styles'][]    = 'photoswipe';
	$assets['scripts'][]   = 'photoswipe-images';
	$assets['libraries'][] = 'photoswipe-bundle';
}

return $assets;