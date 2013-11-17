<?php
/**
 * HTML Tag generate class.
 *
 * append return a self.
 * append{tagName} return a tagName object. (not implemented yet.)
 *
 * PHP 5 >= 5.3.0
 *
 * Support doctype: html5, xhtml(xhtml1.0 Transitional), html4(html4.01 Transitional)
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 1.9.4
 *
 * @todo implement append{tagName}
 */

namespace Primalbase\Tag;

use Primalbase\Tag\TagNodes;
use Primalbase\Tag\Plain;

/**
 * Class Tag
 * @package Primalbase\Tag
 *
 * @method static \Primalbase\Tag\Tag div(array $options = null)
 * @method static \Primalbase\Tag\Tag input(array $options = null)
 * @method \Primalbase\Tag\Tag required(\string $value = null)
 *
 * @todo Define all methods for the auto completion.
 */
class Tag {
	
  /**
   * HTML Document type implements Primalbase\Tag\Doctype
   *
   * Html5, Xhtml, Html4
   *
   * @var string $DocType
   */
  public static $DocType = 'Primalbase\Tag\Doctype\Html5';
  
  /**
   * Current DocType instance.
   *
   * @var DocType
   */
  public $doc;
  
  /**
   * Cache array.
   *
   * self::$DocTypeInstance['Primalbase\Tag\Doctype\Html4']
   * self::$DocTypeInstance['Primalbase\Tag\Doctype\Xhtml']
   * self::$DocTypeInstance['Primalbase\Tag\Doctype\Html5']
   *
   * @var array $DocTypeInstance
   */
  protected static $DocTypeInstance = array();
  
  /**
   * The tag property.
   *
   * Matrix:
   * [O]ptional, [F]orbidden, [E]mpty, [D]eprecated
   * and
   * Start Tag{O}, End Tag{O|F}, Empty{E}, Depr.{D}
   *
   * @var array
  */
  protected $property;
  
  /**
   * lowercase always.
   *
   * <$tagName>
   * <$tagName></$tagName>
   *
   * @var string $tagName
   */
  protected $tagName;
  
  /**
   * <$tagName $attributes[key]="$attributes[value]"...>
   *
   * @var array $attributes
   */
  protected $attributes=array();
  
  /**
   * <$tagName>$nodes</$tagName>
   *
   * $nodes is Tag_Nodes object or a string.
   * Tag_Nodes supported __toString().
   *
   * @var mixed Tag_Nodes or string
  */
  protected $nodes;

  /**
   * @var Tag parent Tag.
   */
  protected $parent;

  /**
   * Code format settings.
   *
   * $codeFormat = false
   *
   * <div><span>codes</span></div>
   *
   * $codeFormat = true
   *
   * <div>
   *   <span>codes</span>
   * </div>
   *
   */
  public static $codeFormat = true;
  
  public static $codeFormatIndent = 0;
  
  public static $codeFormatSpacing = '  ';

  /**
   * Tag($tagName, $options,...)
   *
   * If variadic options is an array to update attributes.
   *
   * Else if it is a string or a Tag to append nodes.
   *
   * @param string|mixed $tagName, $options,...
   */
  public function __construct($tagName)
  {
    $args          = func_get_args();
    $this->tagName = strtolower(array_shift($args));
    $this->nodes   = new TagNodes();
    $this->nodes->setParent($this);

    foreach ($args as $arg)
      $this->append($arg);

    $doctype = static::getDocType();
    $this->doc      = $doctype;
    $this->property = $this->doc->property($this->tagName);
  }
  
  public static function getDocType()
  {
    if (!isset(static::$DocTypeInstance[static::$DocType]))
      static::$DocTypeInstance[static::$DocType] = new static::$DocType;
    
    return static::$DocTypeInstance[static::$DocType];
  }

  public static function docType()
  {
    if (!isset(static::$DocTypeInstance[static::$DocType]))
      static::$DocTypeInstance[static::$DocType] = new static::$DocType;

    if (self::$codeFormat)
      return (string)static::$DocTypeInstance[static::$DocType].PHP_EOL;
    else
      return (string)static::$DocTypeInstance[static::$DocType];
  }
  
  /**
   * Generate any $tagName object.
   *
   * @param string $tagName
   * @param array $args
   * @return static
   */
  public static function __callStatic($tagName, array $args)
  {
    return static::createInstanceArray($tagName, $args);
  }
  
  /**
   * Create caller class instance with array.
   *
   * @param string $tagName
   * @param array $args
   * @return static
   */
  public static function createInstanceArray($tagName, array $args)
  {
    array_unshift($args, $tagName);
    return (new \ReflectionClass(get_called_class()))
      ->newInstanceArgs($args);
  }
  
  /**
   * Create a Tag instance with any tag name.
   *
   * @param string|mixed $tagName, $options,...
   * @return static
   */
  public static function create($tagName)
  {
    $args = func_get_args();
    array_shift($args);
    return static::createInstanceArray($tagName, $args);
  }
  
  static private function indent()
  {
    return str_repeat(self::$codeFormatSpacing, self::$codeFormatIndent);
  }
  
  public function __toString()
  {
    $is_block_tag = !$this->doc->isInlineTag($this->tagName);
    $is_empty_tag = $this->doc->isEmptyTag($this->tagName);
    $open_tag     = $this->doc->openTag($this->tagName, $this->attributes);
    $close_tag    = $this->doc->closeTag($this->tagName);
  
    $parts = array();
  
    array_push($parts, $open_tag);
  
    if ($is_empty_tag)
    {
      if (self::$codeFormat && self::$codeFormatIndent == 0)
        array_push($parts, PHP_EOL);
      return implode('', $parts);
    }

    if (in_array($this->tagName, array('script', 'style')))
    {
      if (self::$codeFormat)
        array_push($parts, PHP_EOL);
      array_push($parts, $this->nodes->rawString());
      if (self::$codeFormat)
        array_push($parts, PHP_EOL);
      if (self::$codeFormat)
        array_push($parts, self::indent());
      array_push($parts, $close_tag);
      if (self::$codeFormatIndent == 0)
        array_push($parts, PHP_EOL);
      return implode('', $parts);
    }

    if (!$this->nodes->isEmpty())
    {
      foreach ($this->nodes as $node)
      {
        self::$codeFormatIndent++;
        if (self::$codeFormat && $is_block_tag)
          array_push($parts, PHP_EOL);

        if (self::$codeFormat && $is_block_tag)
          array_push($parts, self::indent());

        array_push($parts, TagNodes::escapedString($node));

        self::$codeFormatIndent--;
      }
    }
    if (self::$codeFormat && $is_block_tag)
    {
      array_push($parts, PHP_EOL);
      array_push($parts, self::indent());
    }
  
    array_push($parts, $close_tag);
  
    if (self::$codeFormat && self::$codeFormatIndent == 0)
      array_push($parts, PHP_EOL);
  
    return implode('', $parts);
  }
  
  /**
   * Undefined method call to set attribute.
   *
   * $attributes[$name] = $args[0]
   *
   * @param $name string
   * @param $args array
   * @return Tag
   */
  public function __call($name, $args)
  {
    return $this->attr($name, $args[0]);
  }

  public function tagName($tagName='')
  {
    if ($tagName)
      $this->tagName = $tagName;

    return $this;
  }

  public function getTagName()
  {
    return $this->tagName;
  }

  /**
   * Append nodes if argument is not array.
   * Update attribute if argument is array.
   *
   * @return $this
   */
  public function append()
  {
    $args = func_get_args();

    foreach ($args as $arg)
    {
      if (is_array($arg))
        $this->updateAttributes($arg);
      else
        $this->nodes->append($arg);
    }

    return $this;
  }

  /**
   * Prepend nodes if argument is not array.
   * Update attribute if argument is array.
   *
   * @return $this
   */
  public function prepend()
  {
    $args = func_get_args();

    foreach ($args as $arg)
    {
      if (is_array($arg))
        $this->updateAttributes($arg);
      else
        $this->nodes->prepend($arg);
    }

    return $this;
  }

  /**
   * Append to object not apply escape.
   */
  public function appendHtml($html)
  {
    $this->nodes->append(Plain::html($html));
    return $this;
  }

  /**
   * Prepend to object not apply escape.
   */
  public function prependHtml($html)
  {
    $this->nodes->prepend(Plain::html($html));
    return $this;
  }

  public function updateFromArray(array $options=array())
  {
    foreach ($options as $_)
    {
      if (is_array($_))
        $this->updateAttributes($_);
      else
        $this->append($_);
    }
  
    return $this;
  }
  
  public function replace()
  {
    $args = func_get_args();
    call_user_func_array(array($this->nodes, 'replace'), $args);
  
    return $this;
  }
  
  /**
   * Set attribute.
   *
   * @param string $name
   * @param string $value default null
   * @return Tag
   */
  public function attr($name, $value=null)
  {
    if (preg_match('/^[0-9]+$/', $name))
      $this->attributes[$value] = false;
    else
      $this->attributes[$name] = $value;

    return $this;
  }
  
  public function attributes()
  {
    return $this->attributes;
  }

  public function getAttribute($name)
  {
    return $this->attributes[$name];
  }
  
  public function updateAttributes(array $attributes=array())
  {

    foreach ($attributes as $name => $value)
      $this->attr($name, $value);

    return $this;
  }

  /**
   * Has class.
   *
   * @param $class
   *
   * @return bool
   */
  public function hasClass($class)
  {
    if (!isset($this->attributes['class']))
      return false;

    $defined_class = $this->attributes['class'];

    $class_array = preg_split('/\s+/', $defined_class);
    return in_array($class, $class_array);
  }

  /**
   * Add class.
   *
   * Not append if class exists.
   *
   * @param variadic_options
   *
   * @return Tag
   */
  public function addClass()
  {
    foreach (func_get_args() as $arg)
    {
      if (is_array($arg))
      {
        $this->addClass($arg);
        continue;
      }
  
      if (!isset($this->attributes['class']))
      {
        $this->attributes['class'] = $arg;
        continue;
      }

      if (!$this->hasClass($arg))
      {
        if (!$this->attributes['class']) // set false or null
          $class_array = array();
        else
          $class_array = preg_split('/\s+/', $this->attributes['class']);
        array_push($class_array, $arg);
        $this->attributes['class'] = implode(' ', $class_array);
      }
    }
  
    return $this;
  }
  
  /**
   * remove class.
   *
   * @param variadic_options
   *
   * @return Tag
   */
  public function removeClass()
  {
    foreach (func_get_args() as $arg)
    {
      if (!$this->attributes['class'])
        break;
  
      if (is_array($arg))
      {
        foreach ($arg as $_)
          $this->removeClass($_);
        continue;
      }

      if (!$this->hasClass($arg))
        continue;

      $class_array = preg_split('/\s+/', $this->attributes['class']);
      $index = array_search($arg, $class_array);
      if ($index !== false)
        array_splice($class_array, $index, 1);
      if (empty($class_array))
        unset($this->attributes['class']);
      else
        $this->attributes['class'] = implode(' ', $class_array);
    }
  
    return $this;
  }

  public function setParent($parent = null)
  {
    $this->parent = $parent;

    return $this;
  }

  public function getParent()
  {
    return $this->parent;
  }


  public function parent($depth = 1)
  {
    if ($depth == 0) return $this;
    if (is_null($this->parent)) return $this;

    return $this->parent->parent(--$depth);
  }

  public function close()
  {
    return call_user_func_array(array($this, 'parent'), func_get_args());
  }

  /**
   * Close all.
   */
  public function end()
  {
    return $this->parent(-1);
  }
}