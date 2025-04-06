<?php
$assets = array(
	'styles' => array('block-title'),
	'scripts' => array(),
	'libraries' => array(),
);

if ( ! empty( $this->attrs['design'] ) ) {
	$assets['styles'][] = 'block-title-style';
}

return $assets;