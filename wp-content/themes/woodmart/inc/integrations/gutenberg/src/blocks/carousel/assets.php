<?php

$assets = array(
	'styles'    => array( 'swiper', 'block-carousel' ),
	'scripts'   => array( 'swiper-carousel' ),
	'libraries' => array( 'swiper' ),
);

if ( ! isset( $this->attrs['arrows'] ) || $this->attrs['arrows'] || ! isset( $this->attrs['arrowsTablet'] ) || $this->attrs['arrowsTablet'] || ! isset( $this->attrs['arrowsMobile'] ) || $this->attrs['arrowsMobile'] ) {
	$assets['styles'][] = 'swiper-arrows';
}

if ( ! isset( $this->attrs['paginationControl'] ) || $this->attrs['paginationControl'] || isset( $this->attrs['paginationControlTablet'] ) && $this->attrs['paginationControlTablet'] || isset( $this->attrs['paginationControlMobile'] ) && $this->attrs['paginationControlMobile'] ) {
	$assets['styles'][] = 'swiper-pagin';
}

if ( ! empty( $this->attrs['scrollbar'] ) || ! empty( $this->attrs['scrollbarTablet'] ) || ! empty( $this->attrs['scrollbarMobile'] ) ) {
	$assets['styles'][] = 'swiper-scrollbar';
}

if ( ! empty( $this->attrs['initOnScrollCarousel'] ) ) {
	$assets['libraries'][] = 'waypoints';
}

return $assets;
