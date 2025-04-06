<?php
/**
 * Estimate delivery class.
 *
 * @package woodmart
 */

namespace XTS\Modules\Estimate_Delivery;

use XTS\Admin\Modules\Options;

/**
 * Estimate delivery class.
 */
class Delivery_Date {
	/**
	 * Manager instance.
	 *
	 * @var Manager instanse.
	 */
	public $manager;

	/**
	 * Instance of WC_Product class.
	 *
	 * @var WC_Product
	 */
	public $product;

	/**
	 * List of product delivery rules.
	 *
	 * @var array
	 */
	public $rule;

	/**
	 * Delivery date format.
	 * Depending on the rules there are 4 types: min, max, day, days or False.
	 *
	 * @var string|false
	 */
	public $format;

	/**
	 * If set, the delivery date will be calculated from this day.
	 *
	 * @var string|false
	 */
	public $start_date;

	/**
	 * Constructor.
	 *
	 * @param WC_Product $product Instance of WC_Product class.
	 * @param int|false  $shipping_method_id Shipping method id for calculate date on admin panel.
	 * @param int|false  $start_date Date of order.
	 *
	 * @return void
	 */
	public function __construct( $product, $shipping_method_id = false, $start_date = false ) {
		$this->manager    = Manager::get_instance();
		$this->product    = $product;
		$this->start_date = $start_date;
		$this->rule       = $this->manager->get_rule_for_product( $product, $shipping_method_id );
		$this->format     = self::get_format( $this->get_rule_meta_box( 'est_del_day_min' ), $this->get_rule_meta_box( 'est_del_day_max' ) );
	}

	/**
	 * Get product date string. Example: 'Oct 2, 2024 - Oct 4, 2024'.
	 *
	 * @return string
	 */
	public function get_date() {
		if ( empty( $this->rule ) ) {
			return '';
		}

		$skipped_date = $this->get_rule_meta_box( 'est_del_skipped_date' );

		if ( ! empty( $skipped_date ) && 7 === count( $skipped_date ) ) {
			return '';
		}

		$delivery_date = '';
		$date_format   = woodmart_get_opt( 'estimate_delivery_date_format', 'M j, Y' );
		$date_format   = 'default' === $date_format ? get_option( 'date_format' ) : $date_format;
		$date_format   = apply_filters( 'woodmart_est_del_date_format', $date_format );
		$min_days      = $this->get_rule_meta_box( 'est_del_day_min' );
		$max_days      = $this->get_rule_meta_box( 'est_del_day_max' );

		switch ( $this->format ) {
			case 'min':
				$min_time       = self::get_date_after( $min_days, $skipped_date, $this->start_date );
				$delivery_date .= wp_date( $date_format, $min_time );
				break;
			case 'max':
				$max_time       = self::get_date_after( $max_days, $skipped_date, $this->start_date );
				$delivery_date .= wp_date( $date_format, $max_time );
				break;
			case 'day':
				if ( empty( $max_days ) ) {
					$max_days = '0';
				}

				$delivery_time = self::get_date_after( $max_days, $skipped_date, $this->start_date );
				$delivery_date = wp_date( $date_format, $delivery_time );
				break;
			case 'days':
				$min_time = self::get_date_after( $min_days, $skipped_date, $this->start_date );
				$max_time = self::get_date_after( $max_days, $skipped_date, $this->start_date );

				$delivery_date .= wp_date( $date_format, $min_time );
				$delivery_date .= apply_filters( 'woodmart_dates_separator', ' - ' );
				$delivery_date .= wp_date( $date_format, $max_time );
				break;
			default:
				$delivery_date = '';
		}

		return $delivery_date;
	}

	/**
	 * Get delivery text string. Example: 'Delivery dates'.
	 *
	 * @return string
	 */
	public function get_label() {
		if ( empty( $this->rule ) ) {
			return '';
		}

		switch ( $this->format ) {
			case 'min':
				return esc_html__( 'Earliest estimated delivery date', 'woodmart' );
			case 'max':
				return esc_html__( 'Latest estimated delivery date', 'woodmart' );
			case 'day':
			case 'days':
				$number = 'day' === $this->format ? 1 : 2;

				return _n( 'Estimated delivery date', 'Estimated delivery dates', $number, 'woodmart' );
			default:
				return '';
		}
	}

	/**
	 * Get a ready delivery date string. Example: 'Estimated delivery dates: Oct 2, 2024 - Oct 4, 2024'.
	 *
	 * @return string
	 */
	public function get_full_date_string() {
		if ( empty( $this->rule ) ) {
			return '';
		}

		$text = $this->get_label();
		$date = $this->get_date();

		$date_string = '';

		if ( ! empty( $text ) ) {
			$date_string = '<strong>' . $text . ':</strong> ';
		}

		if ( ! empty( $date ) ) {
			$date_string .= $date;
		}

		return $date_string;
	}

	/**
	 * Get some rule meta box.
	 *
	 * @param string $key Meta box key.
	 *
	 * @return array
	 */
	public function get_rule_meta_box( $key ) {
		if ( isset( $this->rule[ $key ] ) ) {
			return $this->rule[ $key ];
		}

		return false;
	}

	/**
	 * Get delivery date format.
	 * Depending on the rules there are 4 types: min, max, day, days or False.
	 *
	 * @param string|false $min Minimum delivery days.
	 * @param string|false $max Maximum delivery days.
	 *
	 * @return string|false
	 */
	public static function get_format( $min = false, $max = false ) {
		if ( empty( $max ) && '0' !== $max && ( ! empty( $min ) || '0' === $min ) ) {
			return 'min';
		} elseif ( empty( $min ) && '0' !== $min && ( ! empty( $max ) || '0' === $max ) ) {
			return 'max';
		} elseif ( $min === $max ) {
			return 'day';
		} else {
			return 'days';
		}
	}

	/**
	 * Get date by rules in timestamp format.
	 *
	 * @param string|int $number_of_days The number of days you need to count.
	 * @param array      $skipped_dates List of skipped dates index.
	 * @param int|false  $start_date Start date from which the delivery date will be calculated.
	 *
	 * @return int
	 */
	public static function get_date_after( $number_of_days, $skipped_dates = array(), $start_date = false ) {
		$current_date   = $start_date ? $start_date : current_time( 'm/d/Y' );
		$j              = 1;
		$i              = 1;
		$available      = array();
		$number_of_days = intval( $number_of_days );

		while ( self::is_skip_day( strtotime( $current_date ), $skipped_dates ) && ( $j <= 100 ) ) {
			$current_date = wp_date( 'm/d/Y', strtotime( $current_date . ' + 1 day' ) );
			++$j;
		}

		if ( 0 === $number_of_days ) {
			return strtotime( $current_date );
		}

		while ( ( count( $available ) < $number_of_days ) && ( $i <= 100 ) ) {
			$time = strtotime( $current_date ) + DAY_IN_SECONDS * $i;

			if ( ! self::is_skip_day( $time, $skipped_dates ) ) {
				$available[] = $time;
			}

			++$i;
		}

		return end( $available );
	}

	/**
	 * Return true if current date must be skipped.
	 *
	 * @param int   $timestamp Date which must be verified whether it is necessary to skip it.
	 * @param array $skipped_dates List of skipped dates index.
	 *
	 * @return bool
	 */
	public static function is_skip_day( $timestamp, $skipped_dates = array() ) {
		if ( ! empty( $skipped_dates ) && is_array( $skipped_dates ) ) {
			foreach ( $skipped_dates as $skipped_date ) {
				if ( wp_date( 'w', $timestamp ) === $skipped_date ) {
					return true;
				}
			}
		}

		return false;
	}
}
