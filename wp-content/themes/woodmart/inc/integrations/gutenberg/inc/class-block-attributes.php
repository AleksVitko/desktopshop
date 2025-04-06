<?php

namespace XTS\Gutenberg;

/**
 * Gutenberg merge element attributes.
 *
 * @package Woodmart
 */
class Block_Attributes {
	/**
	 * Element attributes variable.
	 *
	 * @var array|array[]
	 */
	private array $attributes = array(
		'blockId' => array(
			'type' => 'string',
		),
	);

	/**
	 * Constructor method.
	 */
	public function __construct() {}

	/**
	 * Add new attribute for element.
	 *
	 * @param array  $attributes New attributes.
	 * @param string $attrs_prefix Attribute prefix.
	 * @return void
	 */
	public function add_attr( $attributes, $attrs_prefix = '' ) {
		if ( $attributes ) {
			foreach ( $attributes as $key => $attribute ) {
				if ( ! empty( $attribute['units'] ) ) {
					$units_attr = array(
						'type'    => 'string',
						'default' => $attribute['units'],
					);

					if ( ! empty( $attribute['responsive'] ) ) {
						foreach ( array( 'tablet', 'mobile' ) as $device ) {
							$this->attributes[ $this->get_attr_key( $key, $attrs_prefix ) . 'Units' . ucfirst( $device ) ] = $units_attr;
						}
					}

					$this->attributes[ $this->get_attr_key( $key, $attrs_prefix ) . 'Units' ] = $units_attr;

					unset( $attribute['units'] );
				}

				if ( ! empty( $attribute['responsive'] ) ) {
					unset( $attribute['responsive'] );

					$responsive_attr = $attribute;

					if ( isset( $responsive_attr['default'] ) ) {
						unset( $responsive_attr['default'] );
					}

					foreach ( array( 'tablet', 'mobile' ) as $device ) {
						$this->attributes[ $this->get_attr_key( $key, $attrs_prefix ) . ucfirst( $device ) ] = $responsive_attr;
					}
				}

				$this->attributes[ $this->get_attr_key( $key, $attrs_prefix ) ] = $attribute;
			}
		}
	}

	/**
	 * Get element attributes.
	 *
	 * @return array[]
	 */
	public function get_attr() {
		return $this->attributes;
	}

	/**
	 * Get attribute key with prefix.
	 *
	 * @param string $key Attribute key.
	 * @param string $attrs_prefix Attribute prefix.
	 * @return string
	 */
	private function get_attr_key( $key, $attrs_prefix ) {
		if ( $attrs_prefix ) {
			$key = ucfirst( $key );
		}

		return $attrs_prefix . $key;
	}
}
