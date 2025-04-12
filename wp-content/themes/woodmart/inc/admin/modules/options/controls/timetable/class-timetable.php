<?php
/**
 * Timetable control.
 *
 * @package woodmart
 */

namespace XTS\Admin\Modules\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Admin\Modules\Options\Field;

/**
 * Switcher field control.
 */
class Timetable extends Field {
	/**
	 * Construct the object.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $args Field args array.
	 * @param array  $options Options from the database.
	 * @param string $type Field type.
	 * @param string $object $object Object for post or term.
	 */
	public function __construct( $args, $options, $type = 'options', $object = 'post' ) {
		parent::__construct( $args, $options, $type, $object );

		if ( empty( $this->args['inner_fields'] ) ) {
			$this->set_default_inner_fields();
		}

		add_filter( 'woodmart_admin_localized_string_array', array( $this, 'add_localized_settings' ) );
	}

	/**
	 * Set list of conditions arguments for rendering control.
	 *
	 * @param array $inner_fields List of conditions fields. If this field is empty then the default fields are installed.
	 */
	public function set_default_inner_fields( $inner_fields = array() ) {
		$this->args['inner_fields'] = array(
			'date_type'  => array(
				'name'    => esc_html__( 'Date type', 'woodmart' ),
				'options' => array(
					'single' => esc_html__( 'Single', 'woodmart' ),
					'period' => esc_html__( 'Period', 'woodmart' ),
				),
			),
			'single_day' => array(
				'name'     => esc_html__( 'Day', 'woodmart' ),
				'requires' => array(
					array(
						'key'     => 'date_type',
						'compare' => 'equals',
						'value'   => 'single',
					),
				),
			),
			'first_day'  => array(
				'name'     => esc_html__( 'First day', 'woodmart' ),
				'requires' => array(
					array(
						'key'     => 'date_type',
						'compare' => 'equals',
						'value'   => 'period',
					),
				),
			),
			'last_day'   => array(
				'name'     => esc_html__( 'Last day', 'woodmart' ),
				'requires' => array(
					array(
						'key'     => 'date_type',
						'compare' => 'equals',
						'value'   => 'period',
					),
				),
			),
		);
	}

	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$option_id                = $this->args['id'];
		$conditions               = maybe_unserialize( $this->get_field_value() );
		$selected_condition_query = array();

		if ( empty( $conditions ) ) {
			$conditions = array(
				array(
					'date_type'  => 'single',
					'single_day' => '',
					'first_day'  => '',
					'last_day'   => '',
				),
			);
		}
		?>
		<div class="xts-item-template xts-hidden">
			<div class="xts-table-controls">
				<div class="xts-condition-date-type">
					<select class="xts-condition-date-type" name="<?php echo esc_attr( $option_id . '[{{index}}][date_type]' ); ?>" aria-label="<?php esc_attr_e( 'Date type', 'woodmart' ); ?>" disabled>
						<?php foreach ( $this->args['inner_fields']['date_type']['options'] as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>">
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="xts-condition-day-single">
					<label for="<?php echo esc_attr( $option_id . '[{{index}}][single_day]' ); ?>">
						<?php esc_html_e( 'Day :', 'woodmart' ); ?>
					</label>
					<input type="date" name="<?php echo esc_attr( $option_id . '[{{index}}][single_day]' ); ?>" id="single_day_{{index}}" aria-label="<?php esc_attr_e( 'Day', 'woodmart' ); ?>" disabled>
				</div>
				<div class="xts-condition-empty xts-hidden">
				</div>
				<div class="xts-condition-day-first xts-hidden">
					<label for="<?php echo esc_attr( $option_id . '[{{index}}][first_day]' ); ?>">
						<?php esc_html_e( 'First day :', 'woodmart' ); ?>
					</label>
					<input type="date" name="<?php echo esc_attr( $option_id . '[{{index}}][first_day]' ); ?>" id="first_day_{{index}}" aria-label="<?php esc_attr_e( 'First day', 'woodmart' ); ?>" disabled>
				</div>
				<div class="xts-condition-day-last xts-hidden">
					<label for="<?php echo esc_attr( $option_id . '[{{index}}][last_day]' ); ?>">
						<?php esc_html_e( 'Last day :', 'woodmart' ); ?>
					</label>
					<input type="date" name="<?php echo esc_attr( $option_id . '[{{index}}][last_day]' ); ?>" id="last_day_{{index}}" aria-label="<?php esc_attr_e( 'Last day', 'woodmart' ); ?>" disabled>
				</div>

				<div class="xts-close">
					<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
				</div>
			</div>
		</div>

		<div class="xts-controls-wrapper">
			<div class="xts-table-controls xts-table-heading">
				<div class="xts-condition-date-type">
					<label><?php esc_html_e( 'Date type', 'woodmart' ); ?></label>
				</div>
				<div class="xts-condition-dates">
					<label><?php esc_html_e( 'Dates', 'woodmart' ); ?></label>
				</div>
				<div class="xts-close"></div>
			</div>
			<?php foreach ( $conditions as $id => $condition_args ) : //phpcs:ignore. ?>
				<div class="xts-table-controls">
					<div class="xts-condition-date-type">
						<select class="xts-condition-date-type" name="<?php echo esc_attr( $option_id . '[' . $id . '][date_type]' ); ?>" aria-label="<?php esc_attr_e( 'Date type condition', 'woodmart' ); ?>">
							<?php foreach ( $this->args['inner_fields']['date_type']['options'] as $key => $label ) : ?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $conditions[ $id ]['date_type'] ) ? selected( $conditions[ $id ]['date_type'], $key, false ) : ''; ?>>
									<?php echo esc_html( $label ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="xts-condition-day-single <?php echo isset( $conditions[ $id ] ) && isset( $conditions[ $id ]['date_type'] ) && 'single' === $conditions[ $id ]['date_type'] || ! isset( $conditions[ $id ] ) ? '' : 'xts-hidden'; ?>">
						<label for="<?php echo esc_attr( $option_id . '[' . $id . '][single_day]' ); ?>">
							<?php esc_html_e( 'Day :', 'woodmart' ); ?>
						</label>
						<input type="date" name="<?php echo esc_attr( $option_id . '[' . $id . '][single_day]' ); ?>" name="<?php echo esc_attr( $option_id . '[' . $id . '][single_day]' ); ?>" id="single_day_{{index}}" aria-label="<?php esc_attr_e( 'Day', 'woodmart' ); ?>" value="<?php echo isset( $conditions[ $id ]['single_day'] ) ? esc_attr( $conditions[ $id ]['single_day'] ) : ''; ?>">
					</div>
					<div class="xts-condition-empty <?php echo ( isset( $conditions[ $id ] ) && isset( $conditions[ $id ]['date_type'] ) && 'single' === $conditions[ $id ]['date_type'] || ! isset( $conditions[ $id ] ) ) && in_array( 'period', array_column( $conditions, 'date_type' ), true ) ? '' : 'xts-hidden'; ?>">
					</div>
					<div class="xts-condition-day-first <?php echo isset( $conditions[ $id ] ) && isset( $conditions[ $id ]['date_type'] ) && 'period' === $conditions[ $id ]['date_type'] || ! isset( $conditions[ $id ] ) ? '' : 'xts-hidden'; ?>">
						<label for="<?php echo esc_attr( $option_id . '[' . $id . '][first_day]' ); ?>">
							<?php esc_html_e( 'First day :', 'woodmart' ); ?>
						</label>
						<input type="date" name="<?php echo esc_attr( $option_id . '[' . $id . '][first_day]' ); ?>" name="<?php echo esc_attr( $option_id . '[' . $id . '][first_day]' ); ?>" id="first_day_{{index}}" aria-label="<?php esc_attr_e( 'First day', 'woodmart' ); ?>" value="<?php echo isset( $conditions[ $id ]['first_day'] ) ? esc_attr( $conditions[ $id ]['first_day'] ) : ''; ?>">
					</div>
					<div class="xts-condition-day-last <?php echo isset( $conditions[ $id ] ) && isset( $conditions[ $id ]['date_type'] ) && 'period' === $conditions[ $id ]['date_type'] || ! isset( $conditions[ $id ] ) ? '' : 'xts-hidden'; ?>">
						<label for="<?php echo esc_attr( $option_id . '[' . $id . '][last_day]' ); ?>">
							<?php esc_html_e( 'Last day :', 'woodmart' ); ?>
						</label>
						<input type="date" name="<?php echo esc_attr( $option_id . '[' . $id . '][last_day]' ); ?>" name="<?php echo esc_attr( $option_id . '[' . $id . '][last_day]' ); ?>" id="last_day_{{index}}" aria-label="<?php esc_attr_e( 'Last day', 'woodmart' ); ?>" value="<?php echo isset( $conditions[ $id ]['last_day'] ) ? esc_attr( $conditions[ $id ]['last_day'] ) : ''; ?>">
					</div>

					<div class="xts-close">
						<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<a href="#" class="xts-add-row xts-inline-btn xts-color-primary xts-i-add">
			<?php esc_html_e( 'Add new condition', 'woodmart' ); ?>
		</a>
		<?php
	}

	/**
	 * Enqueue lib.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'wd-cont-table-control', WOODMART_ASSETS . '/css/parts/cont-table-control.min.css', array(), WOODMART_VERSION );

		wp_enqueue_script( 'woodmart-admin-options', WOODMART_ASSETS . '/js/options.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-timetable', WOODMART_ASSETS . '/js/timetable.js', array(), woodmart_get_theme_info( 'Version' ), true );
	}

	/**
	 * Add localized settings.
	 *
	 * @param array $localize_data List of localized dates.
	 *
	 * @return array
	 */
	public function add_localized_settings( $localize_data ) {
		$localize_data['no_rows_msg']            = esc_html__( 'Leave at least one empty line.', 'woodmart' );
		$localize_data['invalid_date_order_msg'] = esc_html__( 'The start date cannot be later than the end date. Please check the order of the entered dates.', 'woodmart' );
		$localize_data['empty_date_field_msg']   = esc_html__( 'Both date fields must be filled. Please enter both dates.', 'woodmart' );

		return $localize_data;
	}
}
