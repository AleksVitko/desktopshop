<?php
woodmart_enqueue_inline_style( 'header-elements-base' );

if ( isset( $id ) ) {
	$params['el_class'] = ' whb-' . $id;
}

$params['style'] = ( ! $params['style'] ) ? 'default' : $params['style'];

echo woodmart_shortcode_social( $params );
