<?php
/**
 * Faq schema.
 *
 * @package Woodmart
 */

namespace XTS\Modules;

use XTS\Singleton;

/**
 * Faq schema.
 *
 * @package Woodmart
 */
class Faq_Schema extends Singleton {
	/**
	 * Faq entities.
	 *
	 * @var array
	 */
	public array $faq_entities = array();

	/**
	 * Init.
	 *
	 * @return void
	 */
	public function init() {
		add_filter( 'wp_footer', array( $this, 'output_faq_schema' ) );

		// Gutenberg.
		add_filter( 'render_block_wd/accordion', array( $this, 'render_block_accordion_faq_schema' ), 10, 2 );
		add_filter( 'render_block_wd/toggle', array( $this, 'render_block_toggle_faq_schema' ), 10, 2 );

		// WPBakery.
		add_filter( 'woodmart_shortcode_accordion_content', array( $this, 'render_accordion_shortcode_faq_schema' ), 10, 3 );

		// Elementor.
		add_action( 'elementor/frontend/widget/after_render', array( $this, 'render_elementor_accordion_faq_schema' ) );
	}

	/**
	 * Render elementor accordion faq schema.
	 *
	 * @param object $widget Elementor widget.
	 * @return void
	 */
	public function render_elementor_accordion_faq_schema( $widget ) {
		if ( ! $widget || 'wd_accordion' !== $widget->get_name() ) {
			return;
		}

		$settings = $widget->get_settings_for_display();

		if ( empty( $settings['faq_schema'] ) || 'yes' !== $settings['faq_schema'] || empty( $settings['items'] ) ) {
			return;
		}

		foreach ( $settings['items'] as $item ) {
			$question = trim( wp_strip_all_tags( $item['item_title'] ) );

			if ( 'html_block' === $item['content_type'] && $item['html_block_id'] ) {
				$answer = trim(
					strip_tags(
						preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', woodmart_get_html_block( $item['html_block_id'] ) ),
						apply_filters( 'woodmart_allowed_faq_schema_html_tags', '<br>' )
					)
				);
			} else {
				$answer = trim(
					strip_tags(
						preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $item['item_content'] ),
						apply_filters( 'woodmart_allowed_faq_schema_html_tags', '<br>' )
					)
				);
			}

			if ( ! $question || ! $answer ) {
				continue;
			}

			$this->faq_entities[] = '{
				"@type": "Question",
				"name": ' . wp_json_encode( $question, JSON_UNESCAPED_UNICODE ) . ',
				"acceptedAnswer": {
					"@type": "Answer",
					"text": ' . wp_json_encode( $answer, JSON_UNESCAPED_UNICODE ) . '
					}
				}';
		}
	}

	/**
	 * Render accordion shortcode faq schema.
	 *
	 * @param string $content Content.
	 * @param array  $args Arguments.
	 * @param string $raw_content Shortcode content.
	 * @return string
	 */
	public function render_accordion_shortcode_faq_schema( $content, $args, $raw_content ) {
		if ( ! empty( $args['faq_schema'] ) && 'yes' === $args['faq_schema'] ) {
			preg_match_all( '/\[woodmart_accordion_item(.*?)title="(.*?)"(.*?)\](.*?)\[\/woodmart_accordion_item\]/s', $raw_content, $matches, PREG_SET_ORDER );

			foreach ( $matches as $match ) {
				$content_type  = 'text';
				$html_block_id = '';
				$question      = '';
				$answer        = '';

				if ( ! empty( $match[1] ) && preg_match( '/content_type="(.*?)"/', $match[1], $content_type_match ) ) {
					$content_type = $content_type_match[1];
				}

				if ( ! empty( $match[3] ) && preg_match( '/html_block_id="(.*?)"/', $match[3], $html_block_id_match ) ) {
					$html_block_id = intval( $html_block_id_match[1] );
				}

				if ( ! empty( $match[2] ) ) {
					$question = trim( wp_strip_all_tags( $match[2] ) );
				}

				if ( 'html_block' === $content_type && $html_block_id ) {
					$answer = trim(
						strip_tags(
							preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', woodmart_get_html_block( $html_block_id ) ),
							apply_filters( 'woodmart_allowed_faq_schema_html_tags', '<br>' )
						)
					);
				} elseif ( 'text' === $content_type ) {
					$answer = trim(
						strip_tags(
							preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $match[4] ),
							apply_filters( 'woodmart_allowed_faq_schema_html_tags', '<br>' )
						)
					);
				}

				if ( ! $question || ! $answer ) {
					continue;
				}

				$this->faq_entities[] = '{
					"@type": "Question",
					"name": ' . wp_json_encode( $question, JSON_UNESCAPED_UNICODE ) . ',
					"acceptedAnswer": {
						"@type": "Answer",
						"text": ' . wp_json_encode( $answer, JSON_UNESCAPED_UNICODE ) . '
						}
					}';
			}
		}

		return $content;
	}

	/**
	 * Render block accordion faq schema.
	 *
	 * @param string $block_content Block content.
	 * @param array  $block Block.
	 * @return string
	 */
	public function render_block_accordion_faq_schema( $block_content, $block ) {
		if ( ! empty( $block['attrs']['FAQScheme'] ) && ! empty( $block['innerBlocks'] ) ) {
			foreach ( $block['innerBlocks'] as $block ) {
				$answer   = $this->get_faq_answer( $block['innerBlocks'] );
				$question = trim( wp_strip_all_tags( $block['innerHTML'] ) );

				if ( ! $question || ! $answer ) {
					continue;
				}

				$this->faq_entities[] = '{
					"@type": "Question",
					"name": ' . wp_json_encode( $question, JSON_UNESCAPED_UNICODE ) . ',
					"acceptedAnswer": {
						"@type": "Answer",
						"text": ' . wp_json_encode( $answer, JSON_UNESCAPED_UNICODE ) . '
						}
					}';
			}
		}

		return $block_content;
	}

	/**
	 * Render block toggle faq schema.
	 *
	 * @param string $block_content Block content.
	 * @param array  $block Block.
	 * @return string
	 */
	public function render_block_toggle_faq_schema( $block_content, $block ) {
		if ( ! empty( $block['attrs']['FAQScheme'] ) && ! empty( $block['innerBlocks'][0]['innerBlocks'] ) && ! empty( $block['innerBlocks'][1]['innerBlocks'] ) ) {
			$question = $this->get_faq_answer( $block['innerBlocks'][0]['innerBlocks'] );
			$answer   = $this->get_faq_answer( $block['innerBlocks'][1]['innerBlocks'] );

			if ( $question && $answer ) {
				$this->faq_entities[] = '{
					"@type": "Question",
					"name": ' . wp_json_encode( $question, JSON_UNESCAPED_UNICODE ) . ',
					"acceptedAnswer": {
						"@type": "Answer",
						"text": ' . wp_json_encode( $answer, JSON_UNESCAPED_UNICODE ) . '
						}
					}';
			}
		}

		return $block_content;
	}

	/**
	 * Get faq answer.
	 *
	 * @param array  $blocks Blocks settings.
	 * @param string $answer Answer.
	 * @return string
	 */
	public function get_faq_answer( $blocks, $answer = '' ) {
		foreach ( $blocks as $block ) {
			$text = trim(
				strip_tags(
					preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $block['innerHTML'] ),
					apply_filters( 'woodmart_allowed_faq_schema_html_tags', '<br>' )
				)
			);

			$answer .= ' ' . $text;

			if ( ! empty( $block['innerBlocks'] ) ) {
				$answer = $this->get_faq_answer( $block['innerBlocks'], $answer );
			}
		}

		return trim( $answer );
	}

	/**
	 * Output faq schema.
	 *
	 * @return void
	 */
	public function output_faq_schema() {
		if ( $this->faq_entities ) {
			?>
			<script type="application/ld+json">
				{
					"@context": "https://schema.org",
					"@type": "FAQPage",
					"mainEntity": [<?php echo implode( ',', $this->faq_entities ); //phpcs:ignore ?>]
				}
			</script>
			<?php
		}
	}
}

Faq_Schema::get_instance();
