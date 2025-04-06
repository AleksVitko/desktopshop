<?php
$assets = array(
	'styles'    => array(),
	'scripts'   => array(),
	'libraries' => array(),
);

if ( ! empty( $this->attrs['sticky'] ) || ! empty( $this->attrs['stickyTablet'] ) || ! empty( $this->attrs['stickyMobile'] ) ) {
	$assets['styles'][]    = 'block-opt-sticky';
	$assets['scripts'][]   = 'sticky-column';
	$assets['libraries'][] = 'sticky-kit';
}

return $assets;
