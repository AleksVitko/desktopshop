<?php
/**
 * Woodmart email styles.
 *
 * @package XTS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load colors.
$base           = get_option( 'woocommerce_email_base_color' );
$btn_text_color = wc_light_or_dark( $base, '#333', '#ffffff' );

?>
.xts-align-start {
	text-align: start;
}

.xts-align-end {
	text-align: end;
}

.xts-prod-table {
	font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
	width: 100%;
	margin: 0 0 16px;
}

.xts-tbody-td {
	vertical-align: middle;
	font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
}

.xts-thumb-link {
	display: flex;
	align-items: center;
	border-bottom: none;
	text-decoration: none;
}

.xts-img-col {
	width: 32px;
}

.xts-unit-slash {
	margin-inline: 4px;
}

.xts-thumb {
	margin-inline-end: 15px;
	max-width:70px;
}

.xts-add-to-cart {
	display: inline-block;
	background-color: <?php echo esc_attr( $base ); ?>;
	color: <?php echo esc_attr( $btn_text_color ); ?>;
	white-space: nowrap;
	padding: .618em 1em; 
	border-radius: 3px;
	text-decoration: none;
}
<?php
