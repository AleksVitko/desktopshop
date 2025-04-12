<?php
/**
 * Breadcrumbs schema.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Seo_Scheme;

use XTS\Singleton;

/**
 * Faq schema.
 *
 * @package Woodmart
 */
class Breadcrumbs extends Singleton {
	/**
	 * Breadcrumb schema.
	 *
	 * @var array
	 */
	public array $schema_items = array();

	/**
	 * Init.
	 *
	 * @return void
	 */
	public function init() {
		add_filter( 'wp_footer', array( $this, 'output_schema' ) );
	}

	/**
	 * Set schema.
	 *
	 * @param array $schema Schema.
	 * @return void
	 */
	public function set_schema_items( $schema ) {
		$this->schema_items = $schema;
	}

	/**
	 * Output faq schema.
	 *
	 * @return void
	 */
	public function output_schema() {
		if ( $this->schema_items ) {
			?>
			<script type="application/ld+json">
				{
					"@context": "https://schema.org",
					"@type": "BreadcrumbList",
					"itemListElement": [<?php echo wp_json_encode( $this->schema_items, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?>]
			}
			</script>
			<?php
		}
	}
}

Breadcrumbs::get_instance();
