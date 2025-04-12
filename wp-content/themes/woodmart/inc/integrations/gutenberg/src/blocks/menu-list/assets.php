<?php

$assets = array(
	'styles'    => array( 'block-menu-list' ),
	'scripts'   => array(),
	'libraries' => array(),
);

if ( ! empty( $this->attrs['labelText'] ) ) {
	$assets['styles'][] = 'mod-nav-menu-label';
}

return $assets;
