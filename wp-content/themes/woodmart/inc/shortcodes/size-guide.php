<?php

use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Size guide shortcode
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_size_guide_shortcode' ) ) {
	function woodmart_size_guide_shortcode( $element_args ) {
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $element_args );

		$default_args = array(
			'woodmart_css_id' => '',
			'id'              => '',
			'el_class'        => '',
			'css'             => '',
			'title'           => 1,
			'description'     => 1,
		);

		$element_args = wp_parse_args( $element_args, $default_args );
		$attributes   = '';

		$wrapper_classes .= ' ' . $element_args['el_class'];

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $element_args['css'] );
		}

		if ( ! empty( $element_args['el_id'] ) ) {
			$attributes .= ' id="' . esc_attr( $element_args['el_id'] ) . '"';
		}

		if ( ! $element_args['id'] ) {
			return '';
		}

		$id = $element_args['id'];

		if ( 'inherit' === $id ) {
			global $post;

			$sguide_post_id = get_post_meta( $post->ID, 'woodmart_sguide_select' );
			if ( ! empty( $sguide_post_id[0] ) && 'none' !== $sguide_post_id[0] ) {
				$id = $sguide_post_id[0];
			} else {
				$terms = wp_get_post_terms( $post->ID, 'product_cat' );
				if ( $terms ) {
					foreach ( $terms as $term ) {
						if ( get_term_meta( $term->term_id, 'woodmart_chosen_sguide', true ) ) {
							$id = get_term_meta( $term->term_id, 'woodmart_chosen_sguide', true );
						}
					}
				}
			}
		}

		$sguide_post = get_post( $id );

		if ( ! $sguide_post || 'inherit' === $id ) {
			return '';
		}

		$size_tables = get_post_meta( $sguide_post->ID, 'woodmart_sguide', true );

		if ( ! $size_tables ) {
			return '';
		}

		ob_start();

		if ( woodmart_get_opt( 'gutenberg_blocks' ) && $sguide_post->post_content && $element_args['description'] && has_blocks( $sguide_post->post_content ) ) {
			echo Blocks_Assets::get_instance()->get_inline_scripts( $sguide_post->ID );
			echo Post_CSS::get_instance()->get_inline_blocks_css( $sguide_post->ID );
		}

		woodmart_enqueue_inline_style( 'size-guide' );

		?>
		<div class="wd-sizeguide<?php echo esc_attr( $wrapper_classes ); ?>"<?php echo wp_kses( $attributes, true ); ?>>
			<?php if ( $sguide_post->post_title && $element_args['title'] ) : ?>
				<h4 class="wd-sizeguide-title">
					<?php echo esc_html( $sguide_post->post_title ); ?>
				</h4>
			<?php endif; ?>

			<?php if ( $sguide_post->post_content && $element_args['description'] ) : ?>
				<div class="wd-sizeguide-content">
					<?php if ( has_blocks( $sguide_post->post_content ) ) : ?>
						<?php echo do_shortcode( do_blocks( $sguide_post->post_content ) ); ?>
					<?php else : ?>
						<?php echo do_shortcode( $sguide_post->post_content ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="responsive-table">
				<table class="wd-sizeguide-table">
					<?php foreach ( $size_tables as $row ) : ?>
						<tr>
							<?php foreach ( $row as $col ) : ?>
								<td><?php echo esc_html( $col ); ?></td>
							<?php endforeach; ?>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}