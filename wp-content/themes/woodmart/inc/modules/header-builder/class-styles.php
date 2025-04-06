<?php

namespace XTS\Modules\Header_Builder;

class Styles {

	/**
	 * Header elements css.
	 *
	 * @var string
	 */
	private $elements_css;

	/**
	 * Get elements css.
	 *
	 * @return string
	 */
	public function get_elements_css() {
		return $this->elements_css;
	}

	/**
	 * Get all element css.
	 *
	 * @param array $el Element data.
	 * @param array $options Element options.
	 *
	 * @return string
	 */
	public function get_all_css( $el, $options ) {
		$this->set_elements_css( $el );

		return $this->get_header_css( $options ) . $this->get_elements_css();
	}

	/**
	 * Set header elements css.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $el Header structure.
	 */
	public function set_elements_css( $el = false ) {
		if ( ! $el ) {
			$el = woodmart_get_config( 'header-builder-structure' );
		}

		$selector = 'whb-' . $el['id'];

		if ( isset( $el['content'] ) && is_array( $el['content'] ) ) {
			foreach ( $el['content'] as $element ) {
				$this->set_elements_css( $element );
			}
		}

		$css        = '';
		$rules      = '';
		$border_css = '';

		if ( isset( $el['params']['background'] ) && ( 'categories' !== $el['type'] ) ) {
			$rules .= $this->generate_background_css( $el['params']['background']['value'] );

			$backdrop_css = $this->generate_backdrop_filter_css( $el['params']['background']['value'] );

			if ( $backdrop_css ) {
				$css .= '.' . $selector . ':before { ' . $backdrop_css . ' }';
			}
		}

		if ( isset( $el['params']['border'] ) && ( 'categories' !== $el['type'] ) ) {
			$sides      = isset( $el['params']['border']['value']['sides'] ) ? $el['params']['border']['value']['sides'] : array( 'bottom' );
			$border_css = $this->generate_border_css( $el['params']['border']['value'], $sides );
		}

		if ( isset( $el['params']['border'] ) && isset( $el['params']['border']['value']['applyFor'] ) && 'boxed' === $el['params']['border']['value']['applyFor'] ) {
			$css .= '.' . $selector . '-inner { ' . $border_css . ' }';
		} elseif ( $border_css ) {
			$rules .= $border_css;
		}

		if ( 'categories' === $el['type'] ) {
			if ( isset( $el['params']['background'] ) && $el['params']['background']['value'] ) {
				$css .= '.' . $selector . ' .menu-opener { ' . $this->generate_background_css( $el['params']['background']['value'] ) . ' }';
			}

			if ( isset( $el['params']['border'] ) && $el['params']['border']['value'] ) {
				$sides = isset( $el['params']['border']['value']['sides'] ) ? $el['params']['border']['value']['sides'] : array( 'bottom' );
				$css  .= '.' . $selector . ' .menu-opener { ' . $this->generate_border_css( $el['params']['border']['value'], $sides ) . ' }';
			}

			if ( isset( $el['params']['more_cat_button'] ) && $el['params']['more_cat_button']['value'] ) {
				$count = $el['params']['more_cat_button_count']['value'] + 1;
				$css  .= '.' . $selector . '.wd-more-cat:not(.wd-show-cat) .item-level-0:nth-child(n+' . $count . '):not(:last-child) {
				    display: none;
				}.
				wd-more-cat .item-level-0:nth-child(n+' . $count . ') {
				    animation: wd-fadeIn .3s ease both;
				}';
			}
		}
		if ( $rules ) {
			$css .= "\n" . '.' . $selector . ' {' . "\n";
			$css .= "\t" . $rules . "\n";
			$css .= '}' . "\n";
		}

		$css_selectors = array();

		if ( isset( $el['params'] ) && $el['params'] ) {
			foreach ( $el['params'] as $params ) {
				if ( empty( $params['selectors'] ) || ( isset( $params['generate_zero'] ) && '' === $params['value'] ) || ( ! isset( $params['generate_zero'] ) && empty( $params['value'] ) ) || ! $this->check_dependencies( $params['id'], $el ) ) {
					continue;
				}

				foreach ( $params['selectors'] as $selectors => $attributes ) {
					$active_selector = str_replace( '{{WRAPPER}}', $selector, $selectors );

					foreach ( $attributes as $attribute ) {
						$value = $params['value'];

						if ( isset( $params['value']['r'] ) && isset( $params['value']['g'] ) && isset( $params['value']['b'] ) && isset( $params['value']['a'] ) ) {
							$value = 'rgba(' . $params['value']['r'] . ', ' . $params['value']['g'] . ', ' . $params['value']['b'] . ', ' . $params['value']['a'] . ')';
						}

						$css_selectors[ $active_selector ][] = "\t" . str_replace( '{{VALUE}}', $value, $attribute ) . "\n";
					}
				}
			}
		}

		if ( $css_selectors ) {
			foreach ( $css_selectors as $selector => $css_atts ) {
				if ( ! $css_atts ) {
					continue;
				}

				$css .= "\n." . $selector . " {\n";
				$css .= implode( '', $css_atts );
				$css .= '}';
			}
		}

		$this->elements_css .= $css;
	}

	/**
	 * Generate background CSS code.
	 *
	 * @since 1.0.0
	 *
	 * @param array $bg Background data.
	 *
	 * @return string
	 */
	public function generate_background_css( $bg ) {
		$css = '';

		if ( isset( $bg['background-color'] ) ) {
			extract( $bg['background-color'] );
		}

		if ( isset( $r ) && isset( $g ) && isset( $b ) && isset( $a ) ) {
			$css .= 'background-color: rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $a . ');';
		}

		if ( isset( $bg['background-image'] ) ) {
			extract( $bg['background-image'] );
		}

		if ( isset( $url ) ) {
			$css .= 'background-image: url(' . $url . ');';

			if ( isset( $bg['background-size'] ) ) {
				$css .= 'background-size: ' . $bg['background-size'] . ';';
			}

			if ( isset( $bg['background-attachment'] ) ) {
				$css .= 'background-attachment: ' . $bg['background-attachment'] . ';';
			}

			if ( isset( $bg['background-position'] ) ) {
				$css .= 'background-position: ' . $bg['background-position'] . ';';
			}

			if ( isset( $bg['background-repeat'] ) ) {
				$css .= 'background-repeat: ' . $bg['background-repeat'] . ';';
			}
		}

		return $css;
	}

	/**
	 * Generate backdrop filter CSS code.
	 *
	 * @since 1.0.0
	 *
	 * @param array $bg Background data.
	 *
	 * @return string
	 */
	public function generate_backdrop_filter_css( $bg ) {
		$css             = '';
		$backdrop_styles = '';

		if ( ! empty( $bg['background-blur'] ) ) {
			$backdrop_styles .= ' blur(' . $bg['background-blur'] . 'px)';
		}
		if ( isset( $bg['background-brightness'] ) && 1 != $bg['background-brightness'] && ( $bg['background-brightness'] || 0 == $bg['background-brightness'] ) ) { //phpcs:ignore
			$backdrop_styles .= ' brightness(' . $bg['background-brightness'] . ')';
		}
		if ( ! empty( $bg['background-contrast'] ) && 100 !== (int) $bg['background-contrast'] ) { //phpcs:ignore
			$backdrop_styles .= ' contrast(' . $bg['background-contrast'] . '%)';
		}
		if ( ! empty( $bg['background-grayscale'] ) ) {
			$backdrop_styles .= ' grayscale(' . $bg['background-grayscale'] . '%)';
		}
		if ( ! empty( $bg['background-hue-rotate'] ) ) {
			$backdrop_styles .= ' hue-rotate(' . $bg['background-hue-rotate'] . 'deg)';
		}
		if ( ! empty( $bg['background-invert'] ) ) {
			$backdrop_styles .= ' invert(' . $bg['background-invert'] . '%)';
		}
		if ( ! empty( $bg['background-opacity'] ) && 100 !== (int) $bg['background-opacity'] ) { //phpcs:ignore
			$backdrop_styles .= ' opacity(' . $bg['background-opacity'] . '%)';
		}
		if ( ! empty( $bg['background-saturate'] ) && 100 !== (int) $bg['background-saturate'] ) { //phpcs:ignore
			$backdrop_styles .= ' saturate(' . $bg['background-saturate'] . '%)';
		}
		if ( ! empty( $bg['background-sepia'] ) ) {
			$backdrop_styles .= ' sepia(' . $bg['background-sepia'] . '%)';
		}

		if ( $backdrop_styles ) {
			$css .= ' backdrop-filter:' . $backdrop_styles . ';';
			$css .= ' -webkit-backdrop-filter:' . $backdrop_styles . ';';
		}

		return $css;
	}

	/**
	 * Generate border CSS code.
	 *
	 * @since 1.0.0
	 *
	 * @param array $border Border data.
	 * @param array $sides Sides data.
	 *
	 * @return string
	 */
	public function generate_border_css( $border, $sides ) {
		$css = '';

		if ( is_array( $border ) ) {
			extract( $border );
		}
		if ( isset( $color ) ) {
			extract( $color );
		}

		if ( isset( $r ) && isset( $g ) && isset( $b ) && isset( $a ) && isset( $width ) ) {
			$css .= 'border-color: rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . $a . ');';
		}

		foreach ( $sides as $side ) {
			if ( isset( $width ) ) {
				$css .= 'border-' . $side . '-width: ' . $width . 'px;';

				$css .= ( isset( $style ) ) ? 'border-' . $side . '-style: ' . $style . ';' : 'border-' . $side . '-style: solid;';
			}
		}

		return $css;
	}

	/**
	 * Get header elements css.
	 *
	 * @param array $options Header options.
	 *
	 * @return false|string
	 */
	public function get_header_css( $options ) {
		$sticky_clone  = $options['sticky_clone'] && 'slide' === $options['sticky_effect'];

		ob_start();

		?>
:root{
	--wd-top-bar-h: <?php echo esc_attr( ! $options['top-bar']['hide_desktop'] && $options['top-bar']['height'] ? $options['top-bar']['height'] : '.00001' ); ?>px;
	--wd-top-bar-sm-h: <?php echo esc_attr( ! $options['top-bar']['hide_mobile'] && $options['top-bar']['mobile_height'] ? $options['top-bar']['mobile_height'] : '.00001' ); ?>px;
	--wd-top-bar-sticky-h: <?php echo esc_attr( ! $sticky_clone && $options['top-bar']['sticky'] && $options['top-bar']['sticky_height'] ? $options['top-bar']['sticky_height'] : '.00001' ); ?>px;
	--wd-top-bar-brd-w: <?php echo esc_attr( ! $options['top-bar']['hide_desktop'] && ! empty( $options['top-bar']['border']['width'] ) ? $options['top-bar']['border']['width'] : '.00001' ); ?>px;

	--wd-header-general-h: <?php echo esc_attr( ! $options['general-header']['hide_desktop'] && $options['general-header']['height'] ? $options['general-header']['height'] : '.00001' ); ?>px;
	--wd-header-general-sm-h: <?php echo esc_attr( ! $options['general-header']['hide_mobile'] && $options['general-header']['mobile_height'] ? $options['general-header']['mobile_height'] : '.00001' ); ?>px;
	--wd-header-general-sticky-h: <?php echo esc_attr( ! $sticky_clone && $options['general-header']['sticky'] && $options['general-header']['sticky_height'] ? $options['general-header']['sticky_height'] : '.00001' ); ?>px;
	--wd-header-general-brd-w: <?php echo esc_attr( ! $options['general-header']['hide_desktop'] && ! empty( $options['general-header']['border']['width'] ) ? $options['general-header']['border']['width'] : '.00001' ); ?>px;

	--wd-header-bottom-h: <?php echo esc_attr( ! $options['header-bottom']['hide_desktop'] && $options['header-bottom']['height'] ? $options['header-bottom']['height'] : '.00001' ); ?>px;
	--wd-header-bottom-sm-h: <?php echo esc_attr( ! $options['header-bottom']['hide_mobile'] && $options['header-bottom']['mobile_height'] ? $options['header-bottom']['mobile_height'] : '.00001' ); ?>px;
	--wd-header-bottom-sticky-h: <?php echo esc_attr( ! $sticky_clone && $options['header-bottom']['sticky'] && $options['header-bottom']['sticky_height'] ? $options['header-bottom']['sticky_height'] : '.00001' ); ?>px;
	--wd-header-bottom-brd-w: <?php echo esc_attr( ! $options['header-bottom']['hide_desktop'] && ! empty( $options['header-bottom']['border']['width'] ) ? $options['header-bottom']['border']['width'] : '.00001' ); ?>px;

	--wd-header-clone-h: <?php echo esc_attr( $sticky_clone && $options['sticky_height'] ? $options['sticky_height'] : '.00001' ); ?>px;

	--wd-header-brd-w: calc(var(--wd-top-bar-brd-w) + var(--wd-header-general-brd-w) + var(--wd-header-bottom-brd-w));
	--wd-header-h: calc(var(--wd-top-bar-h) + var(--wd-header-general-h) + var(--wd-header-bottom-h) + var(--wd-header-brd-w));
	--wd-header-sticky-h: calc(var(--wd-top-bar-sticky-h) + var(--wd-header-general-sticky-h) + var(--wd-header-bottom-sticky-h) + var(--wd-header-clone-h) + var(--wd-header-brd-w));
	--wd-header-sm-h: calc(var(--wd-top-bar-sm-h) + var(--wd-header-general-sm-h) + var(--wd-header-bottom-sm-h) + var(--wd-header-brd-w));
}

<?php if ( ! $options['top-bar']['hide_desktop'] ) : ?>
<?php // DROPDOWN ALIGN BOTTOM IN TOP BAR. ?>
.whb-top-bar .wd-dropdown {
	margin-top: <?php echo esc_html( $options['top-bar']['height'] / 2 - 20 ); ?>px;
}

.whb-top-bar .wd-dropdown:after {
	height: <?php echo esc_html( $options['top-bar']['height'] / 2 - 10 ); ?>px;
}

<?php if ( ! $sticky_clone && $options['top-bar']['sticky'] ) : ?>
.whb-sticked .whb-top-bar .wd-dropdown:not(.sub-sub-menu) {
	margin-top: <?php echo esc_html( $options['top-bar']['sticky_height'] / 2 - 20 ); ?>px;
}

.whb-sticked .whb-top-bar .wd-dropdown:not(.sub-sub-menu):after {
	height: <?php echo esc_html( $options['top-bar']['sticky_height'] / 2 - 10 ); ?>px;
}
<?php endif; ?>
<?php endif; ?>

<?php if ( ! $options['general-header']['hide_desktop'] && ! $sticky_clone && $options['general-header']['sticky'] ) : ?>
.whb-sticked .whb-general-header .wd-dropdown:not(.sub-sub-menu) {
	margin-top: <?php echo esc_html( $options['general-header']['sticky_height'] / 2 - 20 ); ?>px;
}

.whb-sticked .whb-general-header .wd-dropdown:not(.sub-sub-menu):after {
	height: <?php echo esc_html( $options['general-header']['sticky_height'] / 2 - 10 ); ?>px;
}
<?php endif; ?>

<?php if ( ! empty( $options['top-bar']['border']['width'] ) ) : ?>
:root:has(.whb-top-bar.whb-border-boxed) {
	--wd-top-bar-brd-w: .00001px;
}

@media (max-width: 1024px) {
:root:has(.whb-top-bar.whb-hidden-mobile) {
	--wd-top-bar-brd-w: .00001px;
}
}
<?php endif; ?>

<?php if ( ! empty( $options['general-header']['border']['width'] ) ) : ?>
:root:has(.whb-general-header.whb-border-boxed) {
	--wd-header-general-brd-w: .00001px;
}

@media (max-width: 1024px) {
:root:has(.whb-general-header.whb-hidden-mobile) {
	--wd-header-general-brd-w: .00001px;
}
}
<?php endif; ?>

<?php if ( ! empty( $options['header-bottom']['border']['width'] ) ) : ?>
:root:has(.whb-header-bottom.whb-border-boxed) {
	--wd-header-bottom-brd-w: .00001px;
}

@media (max-width: 1024px) {
:root:has(.whb-header-bottom.whb-hidden-mobile) {
	--wd-header-bottom-brd-w: .00001px;
}
}
<?php endif; ?>

<?php if ( ! $options['header-bottom']['hide_desktop'] ) : ?>
<?php // DROPDOWN ALIGN BOTTOM IN HEADER BOTTOM. ?>
.whb-header-bottom .wd-dropdown {
	margin-top: <?php echo esc_html( $options['header-bottom']['height'] / 2 - 20 ); ?>px;
}

.whb-header-bottom .wd-dropdown:after {
	height: <?php echo esc_html( $options['header-bottom']['height'] / 2 - 10 ); ?>px;
}

<?php if ( ! $sticky_clone && $options['header-bottom']['sticky'] ) : ?>
.whb-sticked .whb-header-bottom .wd-dropdown:not(.sub-sub-menu) {
	margin-top: <?php echo esc_html( $options['header-bottom']['sticky_height'] / 2 - 20 ); ?>px;
}

.whb-sticked .whb-header-bottom .wd-dropdown:not(.sub-sub-menu):after {
	height: <?php echo esc_html( $options['header-bottom']['sticky_height'] / 2 - 10 ); ?>px;
}
<?php endif; ?>
<?php endif; ?>

<?php if ( $sticky_clone ) : ?>
<?php // DROPDOWN ALIGN BOTTOM IN HEADER CLONE. ?>
.whb-clone.whb-sticked .wd-dropdown:not(.sub-sub-menu) {
	margin-top: <?php echo esc_html( $options['sticky_height'] / 2 - 20 ); ?>px;
}

.whb-clone.whb-sticked .wd-dropdown:not(.sub-sub-menu):after {
	height: <?php echo esc_html( $options['sticky_height'] / 2 - 10 ); ?>px;
}
<?php endif; ?>

		<?php

		return ob_get_clean();
	}

	/**
	 * Check whether dependencies for a specific option in the specified element are fulfilled.
	 *
	 * @param  string $option_id - The id of the dependency option to check.
	 * @param  array  $el - List of settings for this item.
	 * @return bool - return true if all dependencies for this option have been met, or the no dependencies option.
	 */
	private function check_dependencies( $option_id, $el ) {
		$res = array();

		if ( ! isset( $el['params'][ $option_id ]['requires'] ) ) {
			return true;
		}

		foreach ( $el['params'][ $option_id ]['requires'] as $require_option => $require_condition ) {
			if ( is_array( $require_condition['value'] ) ) {
				foreach ( $require_condition['value'] as $require_condition_value ) {
					if ( 'equal' === $require_condition['comparison'] ) {
						if ( $el['params'][ $require_option ]['value'] === $require_condition_value ) {
							$res[ $require_option ] = true;
							break;
						} else {
							$res[ $require_option ] = false;
						}
					} else {
						$res[ $require_option ] = $el['params'][ $require_option ]['value'] !== $require_condition_value;
					}
				}
			} else {
				if ( 'equal' === $require_condition['comparison'] ) {
					$res[ $require_option ] = $el['params'][ $require_option ]['value'] === $require_condition['value'];
				} else {
					$res[ $require_option ] = $el['params'][ $require_option ]['value'] !== $require_condition['value'];
				}
			}
		}

		return ! in_array( false, $res );
	}
}
