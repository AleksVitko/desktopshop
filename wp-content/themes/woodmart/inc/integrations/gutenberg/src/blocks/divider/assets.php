<?php
$assets = array(
	'styles' => array('block-divider'),
	'scripts' => array(),
	'libraries' => array(),
);

if ( isset( $this->attrs['innerBlock'] ) && in_array( $this->attrs['innerBlock'], array( 'title', 'icon' ) ) ) {
	$assets['styles'][] = 'block-divider-inner';
}

return $assets;