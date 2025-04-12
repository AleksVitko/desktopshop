<?php

$classes  = ' whb-' . $id;
$classes .= ' ' . $params['css_class'];
?>

<div class="whb-space-element<?php echo esc_attr( $classes ); ?>" style="width:<?php echo esc_attr( $params['width'] ); ?>px;"></div>
