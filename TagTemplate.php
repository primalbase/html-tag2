<?php
/**
 * Tag_Template and TagTemplate use each anyone.
 *
 * PHP 5.2.0 dosn't Late Static Bindings.
 * Instead of define to TAG_TEMPLATE_REFLECTION_CLASS.
 */
require_once 'Tag/TagTemplate.php';

define('TAG_TEMPLATE_REFLECTION_CLASS', 'TagTemplate');
class TagTemplate extends Tag_Template {}