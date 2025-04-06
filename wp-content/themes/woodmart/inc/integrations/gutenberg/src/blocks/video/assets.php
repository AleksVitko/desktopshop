<?php
$assets = array(
	'styles'    => array( 'el-video' ),
	'scripts'   => array( 'video-element' ),
	'libraries' => array(),
);

if ( ! empty( $this->attrs['videoOverlayLightbox'] ) || ! empty( $this->attrs['videoActionButton'] ) && in_array( $this->attrs['videoActionButton'], array( 'play', 'button' ), true ) ) {
	$assets['styles'][]    = 'mfp-popup';
	$assets['scripts'][]   = 'video-element-popup';
	$assets['libraries'][] = 'magnific';
}

return $assets;
