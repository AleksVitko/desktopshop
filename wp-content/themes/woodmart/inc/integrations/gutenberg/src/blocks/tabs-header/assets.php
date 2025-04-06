<?php
$assets = array(
	'styles' => array('block-title'),
	'scripts' => array(),
	'libraries' => array(),
);

if ( isset( $this->attrs['parallaxScroll'] ) ) {
	$assets['libraries'][] = 'parallax-scroll-bundle';
}

return $assets;