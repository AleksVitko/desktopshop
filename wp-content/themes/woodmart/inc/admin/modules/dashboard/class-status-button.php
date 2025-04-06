<?php
/**
 * Class to create a display button and switch the status of publication.
 *
 * @package woodmart
 */

namespace XTS\Admin\Modules\Dashboard;

class Status_Button {
	/**
	 * Post type name to which the button will be added.
	 *
	 * @var string $post_type Post type name.
	 */
	private $post_type = '';

	/**
	 * The column name.
	 *
	 * @var string $column_name The column name.
	 */
	private $column_name = '';

	/**
	 * The position of the column with the button.
	 *
	 * @var int $column_position The position of the column with the button.
	 */
	private $column_position = '';

	/**
	 * Constructor.
	 *
	 * @param string $post_type Post type name.
	 * @param int    $column_position The position of the column with the button.
	 */
	public function __construct( $post_type, $column_position = 2 ) {
		$this->post_type       = $post_type;
		$this->column_name     = $this->post_type . '_status';
		$this->column_position = $column_position;

		// Status switcher column in post type page.
		add_action( 'manage_' . $this->post_type . '_posts_columns', array( $this, 'admin_columns_titles' ) );
		add_action( 'manage_' . $this->post_type . '_posts_custom_column', array( $this, 'admin_columns_content' ), 10, 2 );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'wp_ajax_wd_change_post_status', array( $this, 'change_status_action' ) );
	}

	/**
	 * Columns header.
	 *
	 * @param array $posts_columns Columns.
	 *
	 * @return array
	 */
	public function admin_columns_titles( $posts_columns ) {
		return array_slice( $posts_columns, 0, $this->column_position, true ) + array(
			$this->column_name => esc_html__( 'Active', 'woodmart' ),
		) + array_slice( $posts_columns, $this->column_position, null, true );
	}

	/**
	 * Columns content.
	 *
	 * @param string $column_name Column name.
	 * @param int    $post_id     Post id.
	 */
	public function admin_columns_content( $column_name, $post_id ) {
		if ( $this->column_name === $column_name ) {
			$this->get_template( $post_id );
		}
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		if ( get_post_type() !== $this->post_type ) {
			return;
		}

		wp_enqueue_script( 'wd-status-button', WOODMART_ASSETS . '/js/statusButton.js', array(), WOODMART_VERSION, true );
	}

	/**
	 * Get status button template.
	 *
	 * @param int $post_id Post id.
	 *
	 * @return string|void
	 */
	public function get_template( $post_id ) {
		if ( is_ajax() ) {
			ob_start();
		}

		$status = get_post_status( $post_id );
		$nonce  = wp_create_nonce( 'wd_change_status_' . $post_id );

		include get_parent_theme_file_path( WOODMART_FRAMEWORK . '/admin/modules/dashboard/templates/status-button.php' );

		if ( is_ajax() ) {
			return ob_get_clean();
		}
	}

	/**
	 * Change status action.
	 */
	public function change_status_action() {
		$post_id = woodmart_clean( $_POST['id'] ); // phpcs:ignore
		$status  = woodmart_clean( $_POST['status'] ); // phpcs:ignore

		check_ajax_referer( 'wd_change_status_' . $post_id, 'security' );

		do_action( 'woodmart_change_post_status' );

		wp_update_post(
			array(
				'ID'          => $post_id,
				'post_status' => $status,
			)
		);

		wp_send_json(
			array(
				'new_html' => $this->get_template( $post_id ),
			)
		);
	}
}
