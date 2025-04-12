<?php
/**
 * HTML block element
 */

woodmart_enqueue_inline_style( 'header-elements-base' );

$classes = ' whb-' . $id;
$classes .= woodmart_get_old_classes( ' whb-html-block-element' );
?>
<div class="wd-header-html wd-entry-content<?php echo esc_attr( $classes ); ?>">
	<?php echo woodmart_get_html_block( $params['block_id'] ); ?>
</div>
