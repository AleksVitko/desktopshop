<?php
/**
 * HTML dropdown select control.
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
class Discount_Rules extends Field {
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
	}

	/**
	 * Set list of conditions arguments for rendering control.
	 *
	 * @param array $inner_fields List of conditions fields. If this field is empty then the default fields are installed.
	 */
	public function set_default_inner_fields( $inner_fields = array() ) {
		$this->args['inner_fields'] = array(
			'_woodmart_discount_rules_from'       => array(
				'name'    => esc_html__( 'From', 'woodmart' ),
				'options' => array(),
			),
			'_woodmart_discount_rules_to'         => array(
				'name'    => esc_html__( 'To', 'woodmart' ),
				'options' => array(),
			),
			'_woodmart_discount_type'             => array(
				'name'    => esc_html__( 'Type', 'woodmart' ),
				'options' => array(
					'amount'     => esc_html__( 'Fixed discount', 'woodmart' ),
					'percentage' => esc_html__( 'Percentage discount', 'woodmart' ),
				),
			),
			'_woodmart_discount_amount_value'     => array(
				'name'    => esc_html__( 'Value', 'woodmart' ),
				'options' => array(),
			),
			'_woodmart_discount_percentage_value' => array(
				'name'    => esc_html__( 'Value', 'woodmart' ),
				'options' => array(),
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
		$option_id      = $this->args['id'];
		$discount_rules = maybe_unserialize( $this->get_field_value() );

		if ( empty( $discount_rules ) ) {
			$discount_rules = array(
				array(
					'_woodmart_discount_rules_from'       => '',
					'_woodmart_discount_rules_to'         => '',
					'_woodmart_discount_type'             => 'amount',
					'_woodmart_discount_amount_value'     => '',
					'_woodmart_discount_percentage_value' => '',
				),
			);
		}
		?>
		<div class="xts-option-control">
			<div class="xts-item-template xts-hidden">
				<div class="xts-table-controls">
					<div class="xts-discount-from">
						<input type="number" name="<?php echo esc_attr( $option_id . '[{{index}}][_woodmart_discount_rules_from]' ); ?>" name="discount_rules[{{index}}][_woodmart_discount_rules_from]" id="_woodmart_discount_rules_from_{{index}}" class="xts-col-6" min="0" placeholder="<?php esc_attr_e( 'From', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Discount rules from', 'woodmart' ); ?>" disabled>
					</div>
					<div class="xts-discount-to">
						<input type="number" name="<?php echo esc_attr( $option_id . '[{{index}}][_woodmart_discount_rules_to]' ); ?>" id="_woodmart_discount_rules_to_{{index}}" class="xts-col-6" min="0" placeholder="<?php esc_attr_e( 'To', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Discount rules to', 'woodmart' ); ?>" disabled>
					</div>
					<div class="xts-discount-type">
						<select id="_woodmart_discount_type_{{index}}" class="xts-select" name="<?php echo esc_attr( $option_id . '[{{index}}][_woodmart_discount_type]' ); ?>" aria-label="<?php esc_attr_e( 'Discount type', 'woodmart' ); ?>" disabled>
							<?php foreach ( $this->args['inner_fields']['_woodmart_discount_type']['options'] as $key => $label ) : ?>
								<option value="<?php echo esc_attr( $key ); ?>">
									<?php echo esc_html( $label ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="xts-discount-amount-value">
						<div class="xts-option-control">
							<input type="number" name="<?php echo esc_attr( $option_id . '[{{index}}][_woodmart_discount_amount_value]' ); ?>" id="_woodmart_discount_amount_value_{{index}}" class="xts-col-6" min="0" placeholder="0.00" step="0.01" aria-label="<?php esc_attr_e( 'Discount amount value', 'woodmart' ); ?>" disabled>
						</div>
					</div>
					<div class="xts-discount-percentage-value xts-hidden">
						<div class="xts-option-control">
							<input type="number" name="<?php echo esc_attr( $option_id . '[{{index}}][_woodmart_discount_percentage_value]' ); ?>" id="_woodmart_discount_percentage_value_{{index}}" class="xts-col-6" min="0" max="100" placeholder="0.00" step="0.01" aria-label="<?php esc_attr_e( 'Discount percentage value', 'woodmart' ); ?>" disabled>
						</div>
					</div>
					<div class="xts-discount-close">
						<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
					</div>
				</div>
			</div>
			<div class="xts-controls-wrapper">
				<div class="xts-table-controls xts-table-heading">
					<div class="xts-discount-from">
						<label><?php echo esc_html__( 'From', 'woodmart' ); ?></label>
					</div>
					<div class="xts-discount-to">
						<label><?php echo esc_html__( 'To', 'woodmart' ); ?></label>
					</div>
					<div class="xts-discount-type">
						<label><?php echo esc_html__( 'Type', 'woodmart' ); ?></label>
					</div>
					<div class="xts-discount-value">
						<label><?php echo esc_html__( 'Value', 'woodmart' ); ?></label>
					</div>
					<div class="xts-discount-remove"></div>
				</div>
				<?php foreach ( $discount_rules as $id => $rule_args ) : //phpcs:ignore. ?>
					<div class="xts-table-controls">
						<div class="xts-discount-from">
							<input type="number" name="<?php echo esc_attr( $option_id . '[' . $id . '][_woodmart_discount_rules_from]' ); ?>" id="_woodmart_discount_rules_from_<?php echo esc_attr( $id ); ?>" class="xts-col-6" min="0" placeholder="<?php esc_attr_e( 'From', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Discount rules from', 'woodmart' ); ?>" value="<?php echo isset( $discount_rules[ $id ]['_woodmart_discount_rules_from'] ) ? esc_attr( $discount_rules[ $id ]['_woodmart_discount_rules_from'] ) : ''; ?>">
						</div>
						<div class="xts-discount-to">
							<input type="number" name="<?php echo esc_attr( $option_id . '[' . $id . '][_woodmart_discount_rules_to]' ); ?>" id="_woodmart_discount_rules_to_<?php echo esc_attr( $id ); ?>" class="xts-col-6" min="0" placeholder="<?php esc_attr_e( 'To', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Discount rules to', 'woodmart' ); ?>" value="<?php echo isset( $discount_rules[ $id ]['_woodmart_discount_rules_to'] ) ? esc_attr( $discount_rules[ $id ]['_woodmart_discount_rules_to'] ) : ''; ?>">
						</div>
						<div class="xts-discount-type">
							<select id="_woodmart_discount_type_<?php echo esc_attr( $id ); ?>" class="xts-select" name="<?php echo esc_attr( $option_id . '[' . $id . '][_woodmart_discount_type]' ); ?>" aria-label="<?php esc_attr_e( 'Discount type', 'woodmart' ); ?>">
								<?php foreach ( $this->args['inner_fields']['_woodmart_discount_type']['options'] as $key => $label ) : ?>
									<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $discount_rules[ $id ]['_woodmart_discount_type'] ) ? selected( $discount_rules[ $id ]['_woodmart_discount_type'], $key, false ) : ''; ?>>
										<?php echo esc_html( $label ); ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="xts-discount-amount-value <?php echo isset( $discount_rules[ $id ] ) && isset( $discount_rules[ $id ]['_woodmart_discount_type'] ) && 'amount' === $discount_rules[ $id ]['_woodmart_discount_type'] || ! isset( $discount_rules[ $id ] ) ? '' : 'xts-hidden'; ?>">
							<div class="xts-option-control">
								<input type="number" name="<?php echo esc_attr( $option_id . '[' . $id . '][_woodmart_discount_amount_value]' ); ?>" id="_woodmart_discount_amount_value_<?php echo esc_attr( $id ); ?>" class="xts-col-6" min="0" placeholder="0.00" step="0.01" aria-label="<?php esc_attr_e( 'Discount amount value', 'woodmart' ); ?>" value="<?php echo isset( $discount_rules[ $id ]['_woodmart_discount_amount_value'] ) ? esc_attr( $discount_rules[ $id ]['_woodmart_discount_amount_value'] ) : ''; ?>">
							</div>
						</div>
						<div class="xts-discount-percentage-value <?php echo isset( $discount_rules[ $id ] ) && isset( $discount_rules[ $id ]['_woodmart_discount_type'] ) && 'percentage' === $discount_rules[ $id ]['_woodmart_discount_type'] ? '' : 'xts-hidden'; ?>">
							<div class="xts-option-control">
								<input type="number" name="<?php echo esc_attr( $option_id . '[' . $id . '][_woodmart_discount_percentage_value]' ); ?>" id="_woodmart_discount_percentage_value_<?php echo esc_attr( $id ); ?>" class="xts-col-6" min="0" max="100" placeholder="0.00" step="0.01" aria-label="<?php esc_attr_e( 'Discount percentage value', 'woodmart' ); ?>" value="<?php echo isset( $discount_rules[ $id ]['_woodmart_discount_percentage_value'] ) ? esc_attr( $discount_rules[ $id ]['_woodmart_discount_percentage_value'] ) : ''; ?>">
							</div>
						</div>
						<div class="xts-discount-close">
							<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<a href="#" class="xts-add-row xts-inline-btn xts-color-primary xts-i-add">
				<?php esc_html_e( 'Add new rule', 'woodmart' ); ?>
			</a>
		</div>
		<?php
	}

	/**
	 * Enqueue lib.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'woodmart-admin-options', WOODMART_ASSETS . '/js/options.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-discount-rules', WOODMART_ASSETS . '/js/discountRules.js', array( 'jquery' ), WOODMART_VERSION, true );

		wp_localize_script( 'wd-discount-rules', 'wd_discount_rules_notice', $this->add_localized_settings() );
	}

	/**
	 * Add localized settings.
	 *
	 * @return array
	 */
	public function add_localized_settings() {
		return array(
			'quantity_range_start' => esc_html__( 'Quantity range must start with a higher value than previous quantity range.', 'woodmart' ),
			'closing_quantity'     => esc_html__( 'Closing quantity must not be lower than opening quantity.', 'woodmart' ),
			'no_quantity_range'    => esc_html__( 'At least one quantity range is required for this pricing rule.', 'woodmart' ),
			'max_value'            => esc_html__( 'Discount cannot exceed 100%.', 'woodmart' ),
		);
	}
}
