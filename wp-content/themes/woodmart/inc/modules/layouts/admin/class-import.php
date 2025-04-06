<?php
/**
 * Import class file.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Plugin;
use WP_Query;
use XTS\Vctemplates;
use XTS\Elementor\Elementor;
use XTS\Elementor\XTS_Library_Source;

/**
 * Import class.
 */
class Import {
	/**
	 * Post ID.
	 */
	private $post_id;
	/**
	 * Layout type.
	 */
	private $layout_type;
	/**
	 * Predefined name.
	 */
	private $predefined_name;
	/**
	 * Current page builder.
	 */
	private $current_builder;

	/**
	 * Construct.
	 */
	public function __construct( $post_id, $layout_type, $predefined_name ) {
		$this->post_id         = $post_id;
		$this->layout_type     = $layout_type;
		$this->predefined_name = $predefined_name;
		$this->current_builder = 'native' === woodmart_get_opt( 'current_builder' ) ? 'gutenberg' : woodmart_get_current_page_builder();

		if ( 'gutenberg' === $this->current_builder ) {
			$this->run_gutenberg();
		} elseif ( 'wpb' === $this->current_builder ) {
			$this->run_wpb();
		} elseif ( 'elementor' === $this->current_builder ) {
			$this->run_elementor();
		}
	}

	/**
	 * Run Elementor import.
	 */
	private function run_elementor() {
		Elementor::get_instance()->files_include();

		$elementor_library = new XTS_Library_Source();

		add_filter( 'elementor/files/allow_unfiltered_upload', '__return_true' );

		$data = json_decode( $this->get_data(), true );

		$data = $elementor_library->replace_elements_ids_public( $data );
		$data = $elementor_library->process_export_import_content_public( $data, 'on_import' );

		$document = Plugin::$instance->documents->get( $this->post_id );

		if ( $document ) {
			$data = $document->get_elements_raw_data( $data, true );
		}

		update_post_meta( $this->post_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
		update_post_meta( $this->post_id, '_elementor_edit_mode', 'builder' );
		update_post_meta( $this->post_id, '_elementor_template_layout_type', 'wp-post' );
		update_post_meta( $this->post_id, '_elementor_version', '3.5.5' );
	}

	/**
	 * Run WPB import.
	 */
	private function run_wpb() {
		$vc_templates = new Vctemplates();
		$data         = json_decode( $this->get_data(), true );
		$config       = json_decode( $this->get_config(), true );

		$new_data = $vc_templates->get_content( $data[0], $config );

		wp_update_post(
			array(
				'ID'           => $this->post_id,
				'post_content' => $new_data,
			)
		);
	}

	/**
	 * Run Gutenberg import.
	 */
	private function run_gutenberg() {
		$data = json_decode( $this->get_data(), true );

		$content        = $data[0];
		$images_matches = array();
		preg_match_all( '/\"(image|bgImage)\":\s*\{[^}]*\"id\":\s*(\d+),\s*\"url\":\s*\"([^\"]+)\"\s*\}/', $content, $images_matches );

		if ( ! empty( $images_matches[2] ) ) {
			$images_matches[2] = array_unique( $images_matches[2] );
			$images_matches[3] = array_unique( $images_matches[3] );

			foreach ( $images_matches[3] as $key => $url ) {
				$id = $this->get_gutenberg_image( $url );

				if ( ! $id || is_wp_error( $id ) ) {
					continue;
				}

				$attachment_url = wp_get_attachment_url( $id );

				if ( $attachment_url ) {
					$content = str_replace( $url, $attachment_url, $content );
					$content = str_replace( '"id":' . $images_matches[2][ $key ], '"id":' . $id, $content );
					$content = str_replace( 'wp-image-' . $images_matches[2][ $key ], 'wp-image-' . $id, $content );
				}
			}
		}

		wp_update_post(
			array(
				'ID'           => $this->post_id,
				'post_content' => wp_slash( $content ),
			)
		);
	}

	/**
	 * Get images config.
	 */
	public function get_config() {
		ob_start();

		$path = WOODMART_THEMEROOT . '/inc/modules/layouts/admin/predefined/' . $this->layout_type . '/' . $this->predefined_name . '/' . $this->current_builder . '/config.json';

		if ( file_exists( $path ) ) {
			include_once $path;
		}

		return ob_get_clean();
	}

	/**
	 * Get layout data.
	 */
	public function get_data() {
		ob_start();

		include_once WOODMART_THEMEROOT . '/inc/modules/layouts/admin/predefined/' . $this->layout_type . '/' . $this->predefined_name . '/' . $this->current_builder . '/data.json';

		return ob_get_clean();
	}

	/**
	 * Get image with Gutenberg.
	 *
	 * @param string $url Image url.
	 * @return int|\WP_Error
	 */
	private function get_gutenberg_image( $url ) {
		$get_attachment = new WP_Query(
			array(
				'posts_per_page' => 1,
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'meta_query'     => array(
					array(
						'key'     => '_wp_attached_file',
						'value'   => pathinfo( wp_basename( $url ), PATHINFO_FILENAME ),
						'compare' => 'LIKE',
					),
				),
			)
		);

		if ( isset( $get_attachment->posts, $get_attachment->posts[0] ) ) {
			$id = $get_attachment->posts[0]->ID;
		} else {
			add_filter( 'image_sideload_extensions', array( $this, 'allowed_image_sideload_extensions' ) );

			$id = media_sideload_image( $url, 0, '', 'id' );

			if ( ! is_wp_error( $id ) ) {
				$metadata = wp_get_attachment_metadata( $id );

				if ( empty( $metadata ) ) {
					require_once ABSPATH . 'wp-admin/includes/image.php';

					$metadata = wp_generate_attachment_metadata( $id, get_attached_file( $id ) );

					if ( ! empty( $metadata ) ) {
						wp_update_attachment_metadata( $id, $metadata );
					}
				}
			}

			remove_filter( 'image_sideload_extensions', array( $this, 'allowed_image_sideload_extensions' ) );
		}

		return $id;
	}

	/**
	 * Allow image sideload extensions.
	 *
	 * @param array $allowed_extensions Allowed extensions.
	 * @return array
	 */
	public function allowed_image_sideload_extensions( $allowed_extensions ) {
		$allowed_extensions[] = 'svg';

		return $allowed_extensions;
	}
}
