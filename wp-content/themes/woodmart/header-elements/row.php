<?php

$inner_class = 'whb-' . $id . '-inner';

$class .= 'whb-' . $id;
$class .= $params['sticky'] ? ' whb-sticky-row' : ' whb-not-sticky-row';
$class .= $this->has_background( $params ) ? ' whb-with-bg' : ' whb-without-bg';
$class .= $this->has_backdrop_filter( $params ) ? ' whb-with-bdf' : '';

if( $this->has_border($params) ) {
	$class .= ( isset( $params['border']['applyFor'] ) ) ? ' whb-border-' . $params['border']['applyFor'] : ' whb-border-fullwidth';
} else {
	$class .= ' whb-without-border';
}
$class .=  ' whb-color-' . $params['color_scheme'];
$class .= ( $params['hide_desktop'] ) ? ' whb-hidden-desktop' : '';
$class .= ( $params['hide_mobile'] ) ? ' whb-hidden-mobile' : '';
$class .= ( $params['shadow'] ) ? ' whb-with-shadow' : '';

if ( ! empty( $params['row_columns'] ) && '1' === $params['row_columns'] ) {
	$class .= ' whb-col-1';
} else {
	$class .=  ' whb-flex-' . $params['flex_layout'];
}

if ( ! empty( $params['extra_classes'] ) ) {
	$class .= $params['extra_classes'];
}

if ( ! $children && ! woodmart_is_header_frontend_editor() ) {
	return;
}

 ?>

<div class="whb-row <?php echo esc_attr( $class ); ?>">
	<div class="container">
		<div class="whb-flex-row <?php echo esc_attr( $inner_class ); ?>">
			<?php echo apply_filters( 'woodmart_header_builder_row_children', $children ); ?>
		</div>
	</div>
</div>
