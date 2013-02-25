<?php
/**
 * Tag_Base and Tag use each anyone.
 *
 * PHP 5.2.0 is dosn't Late Static Bindings.
 * Instead of define to TAG_REFLECTION_CLASS.
 */
require_once 'Tag/TagBase.php';

define('TAG_REFLECTION_CLASS', 'Tag');
class Tag extends Tag_Base {}