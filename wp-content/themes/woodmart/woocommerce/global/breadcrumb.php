<?php
/**
 * Shop breadcrumb
 *
 * @author WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.0
 * @see woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$delimiter = '<span class="wd-delimiter"></span>';

if ( ! empty( $breadcrumb ) ) {
	$count = count( $breadcrumb );
	$i     = 0;

	echo wp_kses_post( $wrap_before );

	foreach ( $breadcrumb as $key => $crumb ) {
		$attr = '';

		$i++;

		if ( $i === $count - 1 ) {
			$attr = ' class="wd-last-link"';
		}

		echo wp_kses_post( $before );

		if ( ! empty( $crumb[1] ) && count( $breadcrumb ) !== $key + 1 ) :
			?>
				<a href="<?php echo esc_url( $crumb[1] ); ?>"<?php echo wp_kses( $attr, true ); ?>>
					<?php echo esc_html( $crumb[0] ); ?>
				</a>
			<?php
		else :
			?>
				<span class="wd-last">
					<?php echo esc_html( $crumb[0] ); ?>
				</span>
			<?php
		endif;

		echo wp_kses_post( $after );

		if ( count( $breadcrumb ) !== $key + 1 ) {
			echo wp_kses_post( $delimiter );
		}
	}

	echo wp_kses_post( $wrap_after );
}
