<?php
/**
 * Cart info metabox template.
 *
 * @package Woodmart
 */

?>
<table class="xts-info-cart" cellspacing="10">
	<tbody>
		<tr>
			<th><?php esc_html_e( 'Cart status:', 'woodmart' ); ?></th>
			<td><span class="<?php echo esc_attr( $status ); ?>"><?php echo esc_html( $status ); ?></span></td>
		</tr>

		<tr>
			<th><?php esc_html_e( 'Cart last views:', 'woodmart' ); ?></th>
			<td><?php echo esc_html( $last_update ); ?></td>
		</tr>

		<tr>
			<th><?php esc_html_e( 'User:', 'woodmart' ); ?></th>
			<td>
			<?php
				$user_name = '';

				if ( ! empty( $user_first_name ) ) {
					$user_name = $user_first_name;
				}

				if ( ! empty( $user_last_name ) ) {
					$user_name .= ' ' . $user_last_name;
				}

				if ( empty( $user_name ) && ! empty( $user_login ) ) {
					$user_name = $user_login;
				}

				if ( empty( $user_name ) ) {
					$user_name = esc_html__( 'guest', 'woodmart' );
				}

				echo esc_html( $user_name );
			?>
			</td>
		</tr>

		<tr>
			<th><?php esc_html_e( 'User email:', 'woodmart' ); ?></th>
			<td><?php echo '<a href="mailto:' . esc_attr( $user_email ) . '">' . esc_html( $user_email ) . '</a>'; ?></td>
		</tr>

		<tr>
			<th><?php esc_html_e( 'Language:', 'woodmart' ); ?></th>
			<td><?php echo esc_html( $language ); ?></td>
		</tr>

		<tr>
			<th><?php esc_html_e( 'Currency:', 'woodmart' ); ?></th>
			<td><?php echo esc_html( $currency ); ?></td>
		</tr>

		<?php if ( ! empty( $history ) ) : ?>
		<tr>
			<th><?php esc_html_e( 'History:', 'woodmart' ); ?></th>
			<td>
				<table class="ywrac-history-table" cellpadding="5">
					<tr>
						<th><?php esc_html_e( 'Sending Date', 'woodmart' ); ?></th>
						<th><?php esc_html_e( 'Email Template', 'woodmart' ); ?></th>
						<th><?php esc_html_e( 'Link Clicked', 'woodmart' ); ?></th>
					</tr>
				<?php foreach ( $history as $h ) : ?>
					<tr>
						<td><?php echo esc_html( $h['data_sent'] ); ?></td>
						<td><?php echo esc_html( $h['email_name'] ); ?></td>
						<td><?php echo esc_html( ( $h['clicked'] == 0 ) ? 'no' : 'yes' ); ?></td>
					</tr>
				<?php endforeach ?>
				</table>

			</td>
		</tr>
	<?php endif ?>
	</tbody>
</table>
