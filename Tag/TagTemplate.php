<?php
/**
 * Template for HTML Tag generate class.
 *
 * PHP 5 >= 5.2.0
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 0.0.0.1
 *
 */
class Tag_TemplateException extends Exception {}
class Tag_Template {

  public static $templates = array();
  public $tagName = null;
  public $params  = array();

  /**
   * @param string $name id name.
   */
	public function __construct($tagName)
	{
    $this->tagName = $tagName;
	  $this->params = array_slice(func_get_args(), 1);

	  self::$templates[$this->tagName] = clone $this;
	}

	public static function createInstanceArray($tagName, array $args)
	{
	  array_unshift($args, $tagName);
	  $_ = new ReflectionClass(self::getClass());
	  return $_->newInstanceArgs($args);
	}

	private static function getClass()
	{
	  return defined(TAG_TEMPLATE_REFLECTION_CLASS) ? TAG_TEMPLATE_REFLECTION_CLASS : __CLASS__;
	}

	public static function create($tagName)
	{
    $args = func_get_args();
    array_shift($args);
    return self::createInstanceArray($tagName, $args);
	}

	public function setLabel($label)
	{
    self::$templates[$label] = clone $this;

	  if ($this->tagName != $label)
      unset(self::$templates[$this->tagName]);

    return $this;
	}

	/**
	 * If set an array to merge an attributes.
	 * If set not an array to append a setting value.
	 */
  public function build()
  {
    return Tag::createInstanceArray($this->tagName, $this->params)
      ->updateFromArray(func_get_args());
  }

  public static function get($label)
  {
    if (!array_key_exists($label, self::$templates))
      throw new Tag_TemplateException('Label "'.$label.'" not found.');

    return clone self::$templates[$label];
  }
}

