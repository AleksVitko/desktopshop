<?php

$assets = array(
	'styles'    => array(),
	'scripts'   => array(),
	'libraries' => array(),
);

if ( ! empty( $this->attrs['labelText'] ) ) {
	$assets['styles'][] = 'mod-nav-menu-label';
}

return $assets;
