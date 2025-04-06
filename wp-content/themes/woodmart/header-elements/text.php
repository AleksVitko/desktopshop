<?php
woodmart_enqueue_inline_style( 'header-elements-base' );
$classes = $params['inline'] ? ' wd-inline' : '';
$classes .= woodmart_get_old_classes( ' whb-text-element' );
?>

<div class="wd-header-text reset-last-child <?php echo esc_attr( $params['css_class'] ); ?><?php echo esc_html( $classes ); ?>"><?php echo do_shortcode($params['content']); ?></div>
