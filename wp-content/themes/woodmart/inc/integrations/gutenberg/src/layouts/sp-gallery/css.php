<?php
use XTS\Gutenberg\Block_CSS;

$block_css        = new Block_CSS( $attrs );
$gallery_selector = $block_selector . ' .woocommerce-product-gallery';

$block_css->add_css_rules(
	$gallery_selector,
	array(
		array(
			'attr_name' => 'gridColumnsGap',
			'template'  => '--wd-gallery-gap: {{value}}px;',
		),
	)
);

$block_css->add_css_rules(
	$gallery_selector,
	array(
		array(
			'attr_name' => 'gridColumnsGapTablet',
			'template'  => '--wd-gallery-gap: {{value}}px;',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$gallery_selector,
	array(
		array(
			'attr_name' => 'gridColumnsGapMobile',
			'template'  => '--wd-gallery-gap: {{value}}px;',
		),
	),
	'mobile'
);

$block_css->add_css_rules(
	$gallery_selector . '.thumbs-position-left',
	array(
		array(
			'attr_name' => 'thumbnailsLeftGalleryWidth',
			'template'  => '--wd-thumbs-width: {{value}}' . $block_css->get_units_for_attribute( 'thumbnailsLeftGalleryWidth' ) . ';',
		),
		array(
			'attr_name' => 'thumbnailsLeftGalleryHeight',
			'template'  => '--wd-thumbs-height: {{value}}' . $block_css->get_units_for_attribute( 'thumbnailsLeftGalleryHeight' ) . ';',
		),
	),
);

$block_css->add_css_rules(
	$gallery_selector . '.thumbs-position-left',
	array(
		array(
			'attr_name' => 'thumbnailsLeftGalleryWidthTablet',
			'template'  => '--wd-thumbs-width: {{value}}' . $block_css->get_units_for_attribute( 'thumbnailsLeftGalleryWidth', 'tablet' ) . ';',
		),
		array(
			'attr_name' => 'thumbnailsLeftGalleryHeightTablet',
			'template'  => '--wd-thumbs-height: {{value}}' . $block_css->get_units_for_attribute( 'thumbnailsLeftGalleryHeight', 'tablet' ) . ';',
		),
	),
	'tablet'
);

$block_css->add_css_rules(
	$gallery_selector . '.thumbs-position-left',
	array(
		array(
			'attr_name' => 'thumbnailsLeftGalleryWidthMobile',
			'template'  => '--wd-thumbs-width: {{value}}' . $block_css->get_units_for_attribute( 'thumbnailsLeftGalleryWidth', 'mobile' ) . ';',
		),
		array(
			'attr_name' => 'thumbnailsLeftGalleryHeightMobile',
			'template'  => '--wd-thumbs-height: {{value}}' . $block_css->get_units_for_attribute( 'thumbnailsLeftGalleryHeight', 'mobile' ) . ';',
		),
	),
	'mobile'
);

$block_css->merge_with(
	wd_get_block_advanced_css(
		array(
			'selector'       => $block_selector,
			'selector_hover' => $block_selector_hover,
		),
		$attrs
	)
);

return $block_css->get_css_for_devices();
