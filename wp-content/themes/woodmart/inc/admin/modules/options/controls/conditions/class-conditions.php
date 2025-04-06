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
class Conditions extends Field {
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

		// Select2 values for Discount Condition options.
		add_action( 'wp_ajax_wd_conditions_query', array( $this, 'conditions_query' ) );
	}

	/**
	 * Set list of conditions arguments for rendering control.
	 *
	 * @param array $inner_fields List of conditions fields. If this field is empty then the default fields are installed.
	 */
	public function set_default_inner_fields( $inner_fields = array() ) {
		$this->args['inner_fields'] = array(
			'comparison'         => array(
				'name'    => esc_html__( 'Comparison condition', 'woodmart' ),
				'options' => array(
					'include' => esc_html__( 'Include', 'woodmart' ),
					'exclude' => esc_html__( 'Exclude', 'woodmart' ),
				),
			),
			'type'               => array(
				'name'    => esc_html__( 'Condition type', 'woodmart' ),
				'options' => array(
					'all'                  => esc_html__( 'All products', 'woodmart' ),
					'product'              => esc_html__( 'Single product id', 'woodmart' ),
					'product_cat'          => esc_html__( 'Product category', 'woodmart' ),
					'product_cat_children' => esc_html__( 'Child product categories', 'woodmart' ),
					'product_tag'          => esc_html__( 'Product tag', 'woodmart' ),
					'product_attr_term'    => esc_html__( 'Product attribute', 'woodmart' ),
					'product_type'         => esc_html__( 'Product type', 'woodmart' ),
				),
			),
			'query'              => array(
				'name'     => esc_html__( 'Condition query', 'woodmart' ),
				'options'  => array(),
				'requires' => array(
					array(
						'key'     => '_woodmart_show_checkbox',
						'compare' => 'equals',
						'value'   => true,
					),
				),
			),
			'product-type-query' => array(
				'name'    => esc_html__( 'Condition query', 'woodmart' ),
				'options' => array(
					'simple'   => esc_html__( 'Simple product', 'woodmart' ),
					'variable' => esc_html__( 'Variable product', 'woodmart' ),
				),
			),
		);
	}

	/**
	 * Get data from db for render select2 options for Discount Condition options in admin page.
	 */
	public function conditions_query() {
		check_ajax_referer( 'wd-new-template-nonce', 'security' );

		$query_type = woodmart_clean( $_POST['query_type'] ); // phpcs:ignore
		$search     = isset( $_POST['search'] ) ? woodmart_clean( $_POST['search'] ) : false; // phpcs:ignore

		$items = array();

		switch ( $query_type ) {
			case 'product_cat':
			case 'product_cat_children':
			case 'product_tag':
			case 'product_attr_term':
				$taxonomy = array();

				if ( 'product_cat' === $query_type || 'product_cat_children' === $query_type ) {
					$taxonomy[] = 'product_cat';
				}
				if ( 'product_tag' === $query_type ) {
					$taxonomy[] = 'product_tag';
				}
				if ( 'product_attr_term' === $query_type ) {
					foreach ( wc_get_attribute_taxonomies() as $attribute ) {
						$taxonomy[] = 'pa_' . $attribute->attribute_name;
					}
				}

				$terms = get_terms(
					array(
						'hide_empty' => false,
						'fields'     => 'all',
						'taxonomy'   => $taxonomy,
						'search'     => $search,
					)
				);

				if ( count( $terms ) > 0 ) {
					foreach ( $terms as $term ) {
						$items[] = array(
							'id'   => $term->term_id,
							'text' => $term->name . ' (ID: ' . $term->term_id . ') (Tax: ' . $term->taxonomy . ')',
						);
					}
				}
				break;
			case 'product_type':
				$product_types = wc_get_product_types();

				unset( $product_types['grouped'], $product_types['external'] );

				foreach ( $product_types as $type => $title ) {
					$items[] = array(
						'id'   => $type,
						'text' => $title,
					);
				}
				break;
			case 'product':
				$posts = get_posts(
					array(
						's'                => $search,
						'post_type'        => 'product',
						'posts_per_page'   => 100,
						'suppress_filters' => false,
					)
				);

				if ( count( $posts ) > 0 ) {
					foreach ( $posts as $post ) {
						$items[] = array(
							'id'   => $post->ID,
							'text' => $post->post_title . ' (ID: ' . $post->ID . ')',
						);
					}
				}
				break;
		}

		wp_send_json(
			array(
				'results' => $items,
			)
		);
	}

	/**
	 * Get saved data from db for render selected select2 option for Discount Condition options in admin page.
	 *
	 * @param string|int $id Search for this term value.
	 * @param string     $query_type Query type.
	 *
	 * @return array
	 */
	public function get_saved_conditions_query( $id, $query_type ) {
		$item = array();

		switch ( $query_type ) {
			case 'product_cat':
			case 'product_cat_children':
			case 'product_tag':
			case 'product_attr_term':
				$taxonomy = '';

				if ( 'product_cat' === $query_type || 'product_cat_children' === $query_type ) {
					$taxonomy = 'product_cat';
				}

				if ( 'product_tag' === $query_type ) {
					$taxonomy = 'product_tag';
				}

				if ( 'product_attr_term' === $query_type ) {
					foreach ( wc_get_attribute_taxonomies() as $attribute ) {
						$term = get_term_by(
							'id',
							$id,
							'pa_' . $attribute->attribute_name
						);

						if ( ! $term || $term instanceof WP_Error ) {
							continue;
						} else {
							break;
						}
					}
				} else {
					$term = get_term_by(
						'id',
						$id,
						$taxonomy
					);
				}

				if ( ! isset( $term ) || empty( $term ) ) {
					break;
				}

				$item['id']   = $term->term_id;
				$item['text'] = $term->name . ' (ID: ' . $term->term_id . ') (Tax: ' . $term->taxonomy . ')';
				break;
			case 'product':
				$post = get_post( $id );

				$item['id']   = $post->ID;
				$item['text'] = $post->post_title . ' (ID: ' . $post->ID . ')';
				break;
		}

		return $item;
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
					'comparison' => 'include',
					'type'       => 'all',
				),
			);
		}
		?>
		<div class="xts-item-template xts-hidden">
			<div class="xts-table-controls">
				<div class="xts-comparison-condition">
					<select class="xts-comparison-condition" name="<?php echo esc_attr( $option_id . '[{{index}}][comparison]' ); ?>" aria-label="<?php esc_attr_e( 'Comparison condition', 'woodmart' ); ?>" disabled>
						<?php foreach ( $this->args['inner_fields']['comparison']['options'] as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>">
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="xts-condition-type">
					<select class="xts-condition-type" name="<?php echo esc_attr( $option_id . '[{{index}}][type]' ); ?>" aria-label="<?php esc_attr_e( 'Condition type', 'woodmart' ); ?>" disabled>
						<?php foreach ( $this->args['inner_fields']['type']['options'] as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>">
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="xts-condition-query xts-hidden">
					<select class="xts-condition-query" name="<?php echo esc_attr( $option_id . '[{{index}}][query]' ); ?>" placeholder="<?php esc_attr_e( 'Start typing...', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Condition query', 'woodmart' ); ?>" disabled></select>
				</div>
				<div class="xts-product-type-condition-query xts-hidden">
					<select class="xts-product-type-condition-query" name="<?php echo esc_attr( $option_id . '[{{index}}][product-type-query]' ); ?>" aria-label="<?php esc_attr_e( 'Product type condition query', 'woodmart' ); ?>" disabled>
						<?php foreach ( $this->args['inner_fields']['product-type-query']['options'] as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>">
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="xts-condition-close">
					<a href="#" class="xts-remove-item xts-bordered-btn xts-color-warning xts-style-icon xts-i-close"></a>
				</div>
			</div>
		</div>

		<div class="xts-controls-wrapper">
			<div class="xts-table-controls xts-table-heading">
				<div class="xts-comparison-condition">
					<label><?php esc_html_e( 'Comparison condition', 'woodmart' ); ?></label>
				</div>
				<div class="xts-condition-type">
					<label><?php esc_html_e( 'Condition type', 'woodmart' ); ?></label>
				</div>
				<div class="xts-condition-query <?php echo empty( $selected_condition_query ) ? 'xts-hidden' : ''; ?>">
					<label><?php esc_html_e( 'Condition query', 'woodmart' ); ?></label>
				</div>
				<div class="xts-condition-remove"></div>
			</div>
			<?php foreach ( $conditions as $id => $condition_args ) : //phpcs:ignore. ?>
				<?php
				if ( ! empty( $condition_args['query'] ) && ! empty( $condition_args['type'] ) ) {
					$selected_condition_query = $this->get_saved_conditions_query( $condition_args['query'], $condition_args['type'] );
				}
				?>
				<div class="xts-table-controls">
					<div class="xts-comparison-condition">
						<select class="xts-comparison-condition" name="<?php echo esc_attr( $option_id . '[' . $id . '][comparison]' ); ?>" aria-label="<?php esc_attr_e( 'Comparison condition', 'woodmart' ); ?>">
							<?php foreach ( $this->args['inner_fields']['comparison']['options'] as $key => $label ) : ?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $conditions[ $id ]['comparison'] ) ? selected( $conditions[ $id ]['comparison'], $key, false ) : ''; ?>>
									<?php echo esc_html( $label ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="xts-condition-type">
						<select class="xts-condition-type" name="<?php echo esc_attr( $option_id . '[' . $id . '][type]' ); ?>" aria-label="<?php esc_attr_e( 'Condition type', 'woodmart' ); ?>">
							<?php foreach ( $this->args['inner_fields']['type']['options'] as $key => $label ) : ?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $conditions[ $id ]['type'] ) ? selected( $conditions[ $id ]['type'], $key, false ) : ''; ?>>
									<?php echo esc_html( $label ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="xts-condition-query <?php echo empty( $selected_condition_query ) ? 'xts-hidden' : ''; ?>">
						<select class="xts-condition-query" name="<?php echo esc_attr( $option_id . '[' . $id . '][query]' ); ?>" placeholder="<?php echo esc_attr__( 'Start typing...', 'woodmart' ); ?>" aria-label="<?php esc_attr_e( 'Condition query', 'woodmart' ); ?>">
							<?php if ( ! empty( $selected_condition_query ) ) : ?>
								<option value="<?php echo esc_attr( $selected_condition_query['id'] ); ?>" selected>
									<?php echo esc_html( $selected_condition_query['text'] ); ?>
								</option>
							<?php endif; ?>
						</select>
					</div>
					<div class="xts-product-type-condition-query <?php echo isset( $conditions[ $id ] ) && ( 'product_type' !== $conditions[ $id ]['type'] || ! isset( $conditions[ $id ]['product-type-query'] ) ) || ! isset( $conditions[ $id ] ) ? 'xts-hidden' : ''; ?>">
						<select class="xts-product-type-condition-query" name="<?php echo esc_attr( $option_id . '[' . $id . '][product-type-query]' ); ?>" aria-label="<?php esc_attr_e( 'Product type condition query', 'woodmart' ); ?>">
							<?php foreach ( $this->args['inner_fields']['product-type-query']['options'] as $key => $label ) : ?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php echo isset( $conditions[ $id ]['product-type-query'] ) ? selected( $conditions[ $id ]['product-type-query'], $key, false ) : ''; ?>>
									<?php echo esc_html( $label ); ?>
								</option>
							<?php endforeach; ?>
						</select>
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

		wp_enqueue_script( 'select2', WOODMART_ASSETS . '/js/libs/select2.full.min.js', array(), woodmart_get_theme_info( 'Version' ), true );
		wp_enqueue_script( 'woodmart-admin-options', WOODMART_ASSETS . '/js/options.js', array(), WOODMART_VERSION, true );
		wp_enqueue_script( 'wd-conditions', WOODMART_ASSETS . '/js/conditions.js', array(), woodmart_get_theme_info( 'Version' ), true );

		wp_localize_script( 'wd-conditions', 'wd_conditions_notice', $this->add_localized_settings() );
	}

	/**
	 * Add localized settings.
	 *
	 * @return array
	 */
	public function add_localized_settings() {
		return array(
			'no_discount_condition' => esc_html__( 'At least one condition is required.', 'woodmart' ),
		);
	}
}
