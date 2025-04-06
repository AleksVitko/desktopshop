<?php
/**
 * WOODMART_Layout Class.
 *
 * @package xts
 */

namespace XTS;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Modules\Layouts\Main as Builder;

/**
 * WOODMART_Layout Class set up layout settings
 * for the current page when initializing
 * based on theme options and custom metaboxes
 */
class Layout {

	/**
	 * ID for the current page/post/product/project
	 *
	 * @var integer
	 */
	private $page_id = 0;

	/**
	 * Sidebar name
	 *
	 * @var string
	 */
	private $sidebar_name = 'sidebar-1';

	/**
	 * Inline CSS for the content section
	 *
	 * @var string
	 */
	private $content_inline_style = '';

	/**
	 * Inline CSS for the content section
	 *
	 * @var string
	 */
	private $has_sidebar_in_page = true;


	/**
	 * Extra class for the sidebar section
	 *
	 * @var string
	 */
	private $sidebar_class = '';

	/**
	 * Inline CSS for the sidebar section
	 *
	 * @var string
	 */
	private $sidebar_inline_style = '';

	/**
	 * Offcanvas sidebar classes.
	 *
	 * @var integer
	 */
	private $offcanvas_classes = '';


	/**
	 * Width of the sidebar X/12
	 *
	 * @var integer
	 */
	private $sidebar_col_width = 0;

	/**
	 * Sidebar position
	 *
	 * @var string
	 */
	private $page_layout = '';

	/**
	 * Add WordPress actions
	 */
	public function __construct() {
		if ( is_admin() ) {
			return;
		}

		add_action( 'wp', array( $this, 'set_page_id' ), 1 );

		add_action( 'wp', array( $this, 'init' ), 500 );
	}

	/**
	 * Set page id
	 */
	public function set_page_id() {
		$this->page_id = woodmart_get_the_ID( array( 'singulars' => array( 'product' ) ) );
	}

	/**
	 * Set up all properties
	 */
	public function init() {
		$this->set_sidebar_name();
		$this->set_page_layout();
		$this->set_sidebar_col_width();
	}

	/**
	 * Gets the value of sidebar_name.
	 *
	 * @return mixed
	 */
	public function get_sidebar_name() {
		return apply_filters( 'woodmart_get_sidebar_name', $this->sidebar_name );
	}

	/**
	 * Set the name of sidebar
	 */
	private function set_sidebar_name() {
		$specific = '';
		$page_id  = $this->get_page_id();

		if ( woodmart_woocommerce_installed() && ( is_product_taxonomy() || woodmart_is_shop_archive() || ( is_search() && isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) ) ) { //phpcs:ignore
			$this->sidebar_name = 'sidebar-shop';
		} elseif ( is_singular( 'product' ) ) {
			$this->sidebar_name = 'sidebar-product-single';
		} elseif ( is_singular( 'portfolio' ) || is_post_type_archive( 'portfolio' ) || is_tax( 'project-cat' ) ) {
			$this->sidebar_name = 'portfolio-widgets-area';
		}

		if ( $page_id ) {
			$specific = get_post_meta( $page_id, '_woodmart_custom_sidebar', true );
		}

		if ( $specific && 'none' !== $specific ) {
			$this->sidebar_name = $specific;
		}
	}

	/**
	 * Get CSS class for the content DIV
	 *
	 * @return string
	 */
	public function get_content_inline_style() {
		if ( ! $this->content_inline_style ) {
			$this->set_content_layout();
		}

		return $this->content_inline_style;
	}

	/**
	 * Set CSS class for the content DIV.
	 */
	private function set_content_layout() {
		$size    = 12 - $this->get_sidebar_col_width();
		$size_md = ( 'full-width' === $this->get_page_layout() || 12 === $size || strpos( $this->get_offcanvas_sidebar_classes(), 'wd-sidebar-hidden-md-sm' ) ) ? 12 : 9;

		if ( 12 !== $size && strpos( $this->get_offcanvas_sidebar_classes(), 'wd-sidebar-hidden-lg' ) ) {
			$size = 12;
		}

		if (
			12 === (int) $size && 12 === (int) $size_md
			|| woodmart_woocommerce_installed()
			&& (
				is_cart() && Builder::get_instance()->has_custom_layout( 'cart' )
				|| is_checkout() && Builder::get_instance()->has_custom_layout( 'checkout_form' )
				|| is_singular( 'product' ) && ( Builder::get_instance()->has_custom_layout( 'single_product' ) || ( ! woodmart_get_opt( 'full_height_sidebar' ) && 'full-width' !== woodmart_get_opt( 'single_product_layout', 'full-width' ) ) )
				|| ( woodmart_is_shop_archive() || ( is_search() && isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) ) && Builder::get_instance()->has_custom_layout( 'shop_archive' )
				|| is_404()
			) ) {
				$this->has_sidebar_in_page = false;
		}

		if ( woodmart_is_elementor_installed() && woodmart_is_elementor_full_width( true ) ) {
			$this->has_sidebar_in_page = false;
		}

		$this->content_inline_style  = '--wd-col-lg:' . $size . ';';
		$this->content_inline_style .= '--wd-col-md:' . $size_md . ';';
		$this->content_inline_style .= '--wd-col-sm:12;';
	}

	/**
	 * Check if the page has sidebar.
	 *
	 * @return bool|string
	 */
	public function has_sidebar_in_page() {
		if ( ! $this->content_inline_style ) {
			$this->set_content_layout();
		}

		return $this->has_sidebar_in_page;
	}

	/**
	 * Get extra class for the sidebar DIV
	 *
	 * @return string
	 */
	public function get_sidebar_class() {
		if ( ! $this->sidebar_class && ! $this->sidebar_inline_style ) {
			$this->set_sidebar_layout();
		}

		return $this->sidebar_class;
	}

	/**
	 * Get inline CSS for the sidebar DIV
	 *
	 * @return string
	 */
	public function get_sidebar_inline_style() {
		if ( ! $this->sidebar_class && ! $this->sidebar_inline_style ) {
			$this->set_sidebar_layout();
		}

		return $this->sidebar_inline_style;
	}

	/**
	 * Set CSS class for the sidebar DIV
	 */
	private function set_sidebar_layout() {
		$size    = ( 0 === $this->get_sidebar_col_width() || strpos( $this->get_offcanvas_sidebar_classes(), 'wd-sidebar-hidden-lg' ) ) ? 12 : $this->get_sidebar_col_width();
		$size_md = ( 'full-width' === $this->get_page_layout() || 0 === $this->get_sidebar_col_width() || strpos( $this->get_offcanvas_sidebar_classes(), 'wd-sidebar-hidden-md-sm' ) ) ? 12 : 3;

		$this->sidebar_inline_style  = '--wd-col-lg:' . $size . ';';
		$this->sidebar_inline_style .= '--wd-col-md:' . $size_md . ';';
		$this->sidebar_inline_style .= '--wd-col-sm:12;';

		if ( 0 !== $this->get_sidebar_col_width() ) {
			$this->sidebar_class .= ' ' . $this->get_page_layout();
		}
	}

	/**
	 * Set content column width
	 *
	 * @return integer
	 */
	public function get_sidebar_col_width() {
		return $this->sidebar_col_width;
	}

	/**
	 * Set sidebar column width
	 */
	private function set_sidebar_col_width() {
		$specific = '';

		// Set here page ID. Will be used to get custom value from metabox of specific PAGE | BLOG PAGE | SHOP PAGE.
		$page_id                 = $this->get_page_id();
		$this->sidebar_col_width = woodmart_get_opt( 'sidebar_width' );

		if ( $page_id ) {
			$specific = get_post_meta( $page_id, '_woodmart_sidebar_width', true );
		}

		// Get specific sidebar size for Shop Page.
		if ( woodmart_woocommerce_installed() && ( woodmart_is_shop_archive() || ( is_search() && isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) ) ) { //phpcs:ignore
			$this->sidebar_col_width = woodmart_get_opt( 'shop_sidebar_width' );
		} elseif ( is_singular( 'product' ) ) {
			// Get specific layout for SINGLE PRODUCT PAGE.
			$this->sidebar_col_width = woodmart_get_opt( 'single_sidebar_width' );
		} elseif ( is_home() || is_singular( 'post' ) || is_archive() ) {
			// Get specific sidebar size for Blog Page.
			$this->sidebar_col_width = woodmart_get_opt( 'blog_sidebar_width' );
		} elseif ( is_singular( 'woodmart_layout' ) ) {
			$this->sidebar_col_width = 0;
		}

		if ( $specific && 'default' !== $specific ) {
			// Set specific sidebar size FOR THIS PAGE.
			$this->sidebar_col_width = $specific;
		}
		// Remove theme sidebar for dokan store list page.

		if ( function_exists( 'dokan_is_store_page' ) && dokan_is_store_page() ) {
			$this->sidebar_col_width = 0;
		}

		$layout = $this->get_page_layout();

		// Remove sidebar if it has no widgets.
		$sidebar_name = $this->get_sidebar_name();

		if ( ! is_active_sidebar( $sidebar_name ) && 'sidebar-product-single' !== $sidebar_name ) {
			$this->sidebar_col_width = 0;
		}

		if ( 'full-width' === $layout ) {
			$this->sidebar_col_width = 0;
		}

		if ( empty( $this->sidebar_col_width ) ) {
			$this->sidebar_col_width = 0;
		}
	}

	/**
	 * Get page layout (sidebar position)
	 *
	 * @return string
	 */
	public function get_page_layout() {
		return apply_filters( 'woodmart_get_page_layout', $this->page_layout );
	}

	/**
	 * Set page layout (sidebar position)
	 */
	private function set_page_layout() {
		global $post, $WCMp;

		$specific = '';

		// Set here page ID. Will be used to get custom value from metabox of specific PAGE | BLOG PAGE | SHOP PAGE.
		$page_id = $this->get_page_id();

		$this->page_layout = woodmart_get_opt( 'main_layout' );

		if ( ( is_singular( 'portfolio' ) || is_post_type_archive( 'portfolio' ) || is_tax( 'project-cat' ) ) && ! is_active_sidebar( 'portfolio-widgets-area' ) ) {
			$this->page_layout = 'full-width';
		}

		if ( $page_id ) {
			$specific = get_post_meta( $page_id, '_woodmart_main_layout', true );
		}

		if ( woodmart_woocommerce_installed() && ( woodmart_is_shop_archive() || ( is_search() && isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) ) ) {
			// Get specific layout for Shop Page.
			$this->page_layout = woodmart_get_opt( 'shop_layout' );
		} elseif ( $this->is_account_pages() ) {
			$this->page_layout = 'full-width';
		} elseif ( is_singular( 'product' ) ) {
			// Get specific layout for SINGLE PRODUCT PAGE.
			$this->page_layout = woodmart_get_opt( 'single_product_layout' );
		} elseif ( isset( $WCMp ) && is_tax( $WCMp->taxonomy->taxonomy_name ) ) {
			$this->page_layout = woodmart_get_opt( 'blog_layout' );
		} elseif ( is_singular( 'post' ) || woodmart_is_blog_archive() ) {
			// Get specific layout for Blog Page.
			$this->page_layout = woodmart_get_opt( 'blog_layout' );

			// Disable sidebar if blog design is Masonry Grid.
			if ( 'masonry' === woodmart_get_opt( 'blog_design' ) && ! is_singular( 'post' ) ) {
				$this->page_layout = 'full-width';
			}
		}

		if ( $specific && 'default' !== $specific ) {
			// Set specific layout FOR THIS PAGE.
			$this->page_layout = $specific;
		}
	}

	/**
	 * Check if it is account page
	 *
	 * @return boolean
	 */
	public function is_account_page() {
		if ( function_exists( 'is_account_page' ) ) {
			return is_account_page();
		} else {
			return false;
		}
	}

	/**
	 * Check if it is some account pages
	 *
	 * @return boolean
	 */
	public function is_account_pages() {
		$wishlist_page_id = woodmart_get_opt( 'wishlist_page' );

		if ( function_exists( 'is_account_page' ) ) {
			if ( is_account_page() ) {
				return true;
			}
		}

		if ( (int) $this->get_page_id() === (int) $wishlist_page_id ) {
			return true;
		}

		return false;
	}


	/**
	 * Class for page content container
	 *
	 * @return mixed
	 */
	public function get_main_container_class() {
		$classes = ' container';

		if ( ( (int) woodmart_get_portfolio_page_id() === (int) woodmart_page_ID() ) && woodmart_get_opt( 'portfolio_full_width' ) || ( woodmart_is_elementor_installed() && woodmart_is_elementor_full_width() ) ) {
			$classes = '';
		}

		if ( woodmart_woocommerce_installed() ) {
			// Different class for product page.
			if ( is_singular( 'product' ) && ! get_query_var( 'edit' ) && ( ( function_exists( 'woodmart_elementor_has_location' ) && ! woodmart_elementor_has_location( 'single' ) ) || ! function_exists( 'woodmart_elementor_has_location' ) ) ) {
				$classes = '';

				if ( woodmart_get_opt( 'full_height_sidebar' ) && 'full-width' !== woodmart_get_opt( 'single_product_layout', 'full-width' ) ) {
					if ( woodmart_get_opt( 'single_full_width' ) ) {
						$classes = ' container-fluid';
					} else {
						$classes = ' container';
					}
				}

				if ( Builder::get_instance()->has_custom_layout( 'single_product' ) && 'enabled' === woodmart_get_opt( 'negative_gap' ) ) {
					$classes = ' container';
				}
			}

			if ( woodmart_is_shop_archive() || is_singular( 'product' ) || is_cart() || is_checkout() ) {
				if ( Builder::get_instance()->has_custom_layout( 'single_product' ) || Builder::get_instance()->has_custom_layout( 'shop_archive' ) || Builder::get_instance()->has_custom_layout( 'cart' ) || Builder::get_instance()->has_custom_layout( 'empty_cart' ) || Builder::get_instance()->has_custom_layout( 'checkout_content' ) || Builder::get_instance()->has_custom_layout( 'checkout_form' ) ) {
					$classes .= ' wd-builder-on';
				} else {
					$classes .= ' wd-builder-off';
				}
			}
		}

		if ( $this->has_sidebar_in_page() ) {
			$classes .= ' wd-grid-g';
		}

		$classes .= $this->get_offcanvas_sidebar_classes();

		return apply_filters( 'woodmart_main_content_classes', $classes );
	}

	/**
	 * Get offcanvas wrapper classes.
	 *
	 * @return int|string
	 */
	public function get_offcanvas_sidebar_classes() {
		if ( $this->offcanvas_classes ) {
			return $this->offcanvas_classes;
		}

		if ( 'full-width' === $this->page_layout || ( woodmart_is_elementor_installed() && woodmart_is_elementor_full_width( true ) ) ) {
			return '';
		}

		$is_product_builder = Builder::get_instance()->has_custom_layout( 'single_product' );
		$is_shop_builder    = Builder::get_instance()->has_custom_layout( 'shop_archive' );

		if ( woodmart_is_shop_archive() && ! $is_shop_builder ) {
			if ( woodmart_get_opt( 'shop_hide_sidebar_desktop' ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-lg';
			}
			if ( woodmart_get_opt( 'shop_hide_sidebar_tablet' ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-md-sm';
			}
			if ( woodmart_get_opt( 'shop_hide_sidebar', true ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-sm';
			}
		} elseif ( is_singular( 'product' ) && ! $is_product_builder ) {
			if ( woodmart_get_opt( 'single_product_hide_sidebar' ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-lg';
			}
			if ( woodmart_get_opt( 'single_product_hide_sidebar_tablet', true ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-md-sm';
			}
			if ( woodmart_get_opt( 'single_product_hide_sidebar_mobile', true ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-sm';
			}
		} elseif ( woodmart_is_blog_archive() || is_singular( 'post' ) ) {
			if ( ! is_singular( 'post' ) && 'masonry' === woodmart_get_opt( 'blog_design' ) ) {
				return '';
			}

			if ( woodmart_get_opt( 'blog_hide_sidebar' ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-lg';
			}
			if ( woodmart_get_opt( 'blog_hide_sidebar_tablet', true ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-md-sm';
			}
			if ( woodmart_get_opt( 'blog_hide_sidebar_mobile', true ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-sm';
			}
		} elseif ( ! is_404() ) {
			if ( woodmart_get_opt( 'hide_main_sidebar' ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-lg';
			}
			if ( woodmart_get_opt( 'hide_main_sidebar_tablet', true ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-md-sm';
			}
			if ( woodmart_get_opt( 'hide_main_sidebar_mobile', true ) ) {
				$this->offcanvas_classes .= ' wd-sidebar-hidden-sm';
			}
		}

		return $this->offcanvas_classes;
	}

	/**
	 * Gets the value of page_id.
	 *
	 * @return mixed
	 */
	public function get_page_id() {
		return $this->page_id;
	}
}
