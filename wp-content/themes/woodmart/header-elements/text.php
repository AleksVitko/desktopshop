<?php

woodmart_enqueue_inline_style( 'header-elements-base' );
$classes  = ' whb-' . $id;
$classes .= $params['inline'] ? ' wd-inline' : '';
$classes .= woodmart_get_old_classes( ' whb-text-element' );
$classes .= $params['css_class'] ? ' ' . $params['css_class'] : '';

?>

<div class="wd-header-text reset-last-child<?php echo esc_html( $classes ); ?>"><?php echo do_shortcode( $params['content'] ); ?></div>
