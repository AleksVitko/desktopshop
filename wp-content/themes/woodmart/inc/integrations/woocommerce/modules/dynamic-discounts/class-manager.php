<?php
/**
 * Manager class file.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Dynamic_Discounts;

use WC_Product;
use WP_Post;
use XTS\Singleton;

/**
 * Manager class.
 */
class Manager extends Singleton {
	/**
	 * Default ist of meta box arguments for rendering template.
	 *
	 * @var array $meta_boxes_fields List of meta box arguments for rendering template.
	 */
	private $meta_boxes_fields_keys = array();

	/**
	 * Transient name for 'All discounts post ids'.
	 *
	 * @var string $wd_transient_discounts_ids .
	 */
	public $wd_transient_discounts_ids = 'wd_all_discounts_post_ids';

	/**
	 * Transient name for 'Single discounts reles'. Has a dynamic part at the end of the name '_${discount_post_id}'.
	 *
	 * @var string $wd_transient_discounts_rule .
	 */
	public $wd_transient_discounts_rule = 'wd_transient_discounts_rule';

	/**
	 * Constructor.
	 */
	public function init() {}

	/**
	 * Get current discount rules for needed product.
	 *
	 * @param WC_Product $product The product object for which you need to get discount rules.
	 *
	 * @return array
	 */
	public function get_discount_rules( $product ) {
		$all_discount_rules = $this->get_all_rules();

		uasort( $all_discount_rules, array( $this, 'sort_by_priority' ) );

		foreach ( $all_discount_rules as $discounts_id => $discount_rules ) {
			if ( ! $this->check_discount_condition( $discount_rules, $product ) ) {
				continue;
			}

			$discount_rules['post_id'] = get_post( $discounts_id )->ID;
			$discount_rules['title']   = get_post( $discounts_id )->post_title;

			return $discount_rules;
		}

		return array();
	}

	/**
	 * Check if there are discount rules for this product.
	 *
	 * @param WC_Product $product The product object for which you want to check for discounts.
	 *
	 * @return bool
	 */
	public function check_discount_exist( $product ) {
		return count( $this->get_discount_rules( $product ) ) > 0;
	}

	/**
	 * Set default list of meta box arguments for rendering template.
	 *
	 * @param array $meta_boxes_fields_keys List of default meta boxes fields.
	 */
	public function set_meta_boxes_fields_keys( $meta_boxes_fields_keys ) {
		$this->meta_boxes_fields_keys = $meta_boxes_fields_keys;
	}

	/**
	 * Get default list of meta box arguments for rendering template.
	 *
	 * @return array List of meta box arguments for rendering template.
	 */
	public function get_meta_boxes_fields_keys() {
		return $this->meta_boxes_fields_keys;
	}

	/**
	 * Get list of meta box arguments for single discounts post from database.
	 *
	 * @param int|string $id Discounts post id.
	 *
	 * @return array List of meta box arguments.
	 */
	public function get_single_post_rules( $id = '' ) {
		if ( ! $id ) {
			$id = get_the_ID();
		}

		$cache = get_transient( $this->wd_transient_discounts_rule . '_' . $id );

		if ( $cache ) {
			return $cache;
		}

		$default_meta_boxes = $this->get_meta_boxes_fields_keys();
		$current_meta_boxes = array();

		foreach ( $default_meta_boxes as $meta_box_id ) {
			$current_meta_boxes[ $meta_box_id ] = maybe_unserialize( get_post_meta( $id, $meta_box_id, true ) );
		}

		set_transient( $this->wd_transient_discounts_rule . '_' . $id, $current_meta_boxes );

		return $current_meta_boxes;
	}

	/**
	 * Get list of discounts post ids.
	 *
	 * @return int[]
	 */
	public function get_all_rule_posts_ids() {
		$cache = get_transient( $this->wd_transient_discounts_ids );

		if ( $cache ) {
			return $cache;
		}

		$all_discounts_post_ids = get_posts(
			array(
				'fields'         => 'ids',
				'posts_per_page' => -1,
				'post_type'      => 'wd_woo_discounts',
			)
		);

		set_transient( $this->wd_transient_discounts_ids, $all_discounts_post_ids );

		return $all_discounts_post_ids;
	}

	/**
	 * Get list of meta box arguments for all discounts posts from database.
	 *
	 * @return array List of meta box arguments.
	 */
	public function get_all_rules() {
		$ids = $this->get_all_rule_posts_ids();

		if ( empty( $ids ) ) {
			return array();
		}

		$meta_boxes = array();

		foreach ( $ids as $id ) {
			$meta_boxes[ $id ] = $this->get_single_post_rules( $id );
		}

		return $meta_boxes;
	}

	/**
	 * Check condition before apply discount.
	 *
	 * @param array      $discount_rules List of meta box arguments.
	 * @param WC_Product $product The product object for which you need to check discount rules.
	 *
	 * @return bool
	 */
	public function check_discount_condition( $discount_rules, $product ) {
		$conditions = $discount_rules['discount_condition'];
		$is_active  = false;
		$is_exclude = false;

		// @codeCoverageIgnoreStart
		if ( 'variation' === $product->get_type() ) {
			$product = wc_get_product( $product->get_parent_id() );
		}
		// @codeCoverageIgnoreEnd

		foreach ( $conditions as $discount_id => $condition ) {
			$conditions[ $discount_id ]['woodmart_discount_priority'] = $this->get_condition_priority( $condition['type'] );
		}

		uasort( $conditions, array( $this, 'sort_by_priority' ) );

		foreach ( $conditions as $condition ) {
			if ( isset( $condition['query'] ) ) {
				$condition['query'] = apply_filters( 'wpml_object_id', $condition['query'], $condition['type'], true, apply_filters( 'wpml_current_language', null ) );
			}

			switch ( $condition['type'] ) {
				case 'all':
					$is_active = 'include' === $condition['comparison'];

					if ( 'exclude' === $condition['comparison'] ) {
						$is_exclude = true;
					}
					break;
				case 'product':
					$is_needed_product = (int) $product->get_id() === (int) $condition['query'];

					if ( $is_needed_product ) {
						if ( 'exclude' === $condition['comparison'] ) {
							$is_active  = false;
							$is_exclude = true;
						} else {
							$is_active = true;
						}
					}

					break;
				case 'product_type':
					$is_needed_type = $product->get_type() === $condition['product-type-query'];

					if ( $is_needed_type ) {
						if ( 'exclude' === $condition['comparison'] ) {
							$is_active  = false;
							$is_exclude = true;
						} else {
							$is_active = true;
						}
					}
					break;
				case 'product_cat':
				case 'product_tag':
				case 'product_brand':
				case 'product_attr_term':
					$terms = wp_get_post_terms( $product->get_id(), get_taxonomies(), array( 'fields' => 'ids' ) );

					if ( $terms ) {
						$is_needed_term = in_array( (int) $condition['query'], $terms, true );

						if ( $is_needed_term ) {
							if ( 'exclude' === $condition['comparison'] ) {
								$is_active  = false;
								$is_exclude = true;
							} else {
								$is_active = true;
							}
						}
					}
					break;
				case 'product_cat_children':
					$terms         = wp_get_post_terms( $product->get_id(), get_taxonomies(), array( 'fields' => 'ids' ) );
					$term_children = get_term_children( $condition['query'], 'product_cat' );

					if ( $terms ) {
						$is_needed_cat_children = count( array_diff( $terms, $term_children ) ) !== count( $terms );

						if ( $is_needed_cat_children ) {
							if ( 'exclude' === $condition['comparison'] ) {
								$is_active  = false;
								$is_exclude = true;
							} else {
								$is_active = true;
							}
						}
					}
					break;
			}

			if ( $is_exclude || $is_active ) {
				break;
			}
		}

		return $is_active;
	}

	/**
	 * Get condition priority;
	 *
	 * @param string $type Condition type.
	 *
	 * @return int
	 */
	public function get_condition_priority( $type ) {
		$priority = 50;

		switch ( $type ) {
			case 'all':
				$priority = 10;
				break;
			case 'product_cat_children':
				$priority = 20;
				break;
			case 'product_type':
			case 'product_cat':
			case 'product_tag':
			case 'product_brand':
			case 'product_attr_term':
				$priority = 30;
				break;
			case 'product':
				$priority = 40;
				break;
		}

		return apply_filters( 'woodmart_dynamic_price_condition_priority', $priority, $type );
	}

	/**
	 * Sort the discounts rule by priority DESC.
	 *
	 * @param array $a The first array to compare.
	 * @param array $b The first array to compare.
	 *
	 * @return int
	 */
	public function sort_by_priority( $a, $b ) {
		return $b['woodmart_discount_priority'] <=> $a['woodmart_discount_priority'];
	}
}

Manager::get_instance();
