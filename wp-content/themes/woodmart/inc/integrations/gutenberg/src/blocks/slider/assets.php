<?php
$assets = array(
	'styles'    => array( 'swiper', 'block-slider' ),
	'scripts'   => array( 'swiper-carousel', 'slider-element' ),
	'libraries' => array( 'swiper' ),
);

if ( ! empty( $this->attrs['effect'] ) && 'distortion' === $this->attrs['effect'] ) {
	$assets['styles'][]  = 'slider-anim-distortion';
	$assets['scripts'][] = 'slider-distortion';
}

if ( ! isset( $this->attrs['arrows'] ) || $this->attrs['arrows'] || ! isset( $this->attrs['arrowsTablet'] ) || $this->attrs['arrowsTablet'] || ! isset( $this->attrs['arrowsMobile'] ) || $this->attrs['arrowsMobile'] ) {
	$assets['styles'][] = 'swiper-arrows';

	if ( isset( $this->attrs['arrowsStyle'] ) && in_array( $this->attrs['arrowsStyle'], array( '2', '3' ), true ) ) {
		$assets['styles'][] = 'slider-arrows';
	}
}

if ( ! isset( $this->attrs['pagination'] ) || $this->attrs['pagination'] || ! isset( $this->attrs['paginationTablet'] ) || $this->attrs['paginationTablet'] || ! isset( $this->attrs['paginationMobile'] ) || $this->attrs['paginationMobile'] ) {
	$assets['styles'][] = 'swiper-pagin';

	if ( ! empty( $this->attrs['paginationStyle'] ) ) {
		if ( '2' === $this->attrs['paginationStyle'] ) {
			$assets['styles'][] = 'slider-dots-style-2';
		} elseif ( '3' === $this->attrs['paginationStyle'] ) {
			$assets['styles'][] = 'slider-dots-style-3';
		}
	}
}

if ( ! empty( $this->attrs['shapeDividerTopIcon'] ) || ! empty( $this->attrs['shapeDividerBottomIcon'] ) ) {
	$assets['styles'][] = 'block-shape-divider';
}

return $assets;
