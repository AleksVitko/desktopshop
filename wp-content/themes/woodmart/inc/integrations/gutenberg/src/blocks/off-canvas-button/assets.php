<?php
$assets = array(
	'styles'    => array( 'el-off-canvas-column-btn' ),
	'scripts'   => array( 'off-canvas-colum-btn' ),
	'libraries' => array(),
);

if ( ! empty( $this->attrs['stickyBtn'] ) ) {
	$assets['styles'][]  = 'mod-sticky-sidebar-opener';
	$assets['scripts'][] = 'sticky-sidebar-btn';
}

return $assets;
