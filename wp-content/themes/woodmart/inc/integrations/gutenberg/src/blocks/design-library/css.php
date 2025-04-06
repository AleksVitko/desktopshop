<?php
use XTS\Gutenberg\Block_CSS;

$block_css = new Block_CSS( $attrs );

return $block_css->get_css_for_devices();
