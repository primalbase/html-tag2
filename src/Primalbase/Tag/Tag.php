<?php
/**
 * HTML Tag generate class.
 *
 * PHP 5 >= 5.3.0
 *
 * Support doctype: html5, xhtml(xhtml1.0 Transitional), html4(html4.01 Transitional)
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 1.9.1
 *
 */

namespace Primalbase\Tag;

use Primalbase\Tag\TagNodes;

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
   * Tag_Base($tagName, (variadic_options)...)
   *
   * If variadic_options is an array to update attributes.
   *
   * Else if it is a string or a Tag_Base to append nodes.
   *
   * @param string $tagName
   * @param variadic_options $content1, $content2, ...
   */
  public function __construct($tagName)
  {
    $args          = func_get_args();
    $this->tagName = strtolower(array_shift($args));
    $this->nodes   = new TagNodes();
  
    foreach ($args as $arg)
    {
      if (is_array($arg))
        $this->updateAttributes($arg);
      else
        $this->append($arg);
    }

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
  
  /**
   * Generate any $tagName object.
   *
   * @param string $tagName
   * @param array $arguments
   * @return Tag
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
   * @param string $tagName
   * @param variadic_options $content1, $content2, ...
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
        if (is_object($node))
        {
          if (self::$codeFormat && $is_block_tag)
            array_push($parts, self::indent());
          array_push($parts, (string)$node);
        }
        else
        {
          if (self::$codeFormat && $is_block_tag)
          {
            array_push($parts, self::indent());
          }
          array_push($parts, (string)$node);
        }
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
   * Undefined method call is set attribute.
   *
   * If get empty $args return attributes[$name].
   *
   * $attributes[$name] = $args[0]
   *
   * @param $name string
   * @param $args array
   */
  public function __call($name, $args)
  {
    if (empty($args))
    if (array_key_exists($name, $this->attributes))
      return $this->attributes[$name];
    else
      return null;
  
    return $this->attr($name, $args[0]);
  }
  
  public function tagName()
  {
    return $this->tagName;
  }
  
  public function append()
  {
    $args = func_get_args();
    call_user_func_array(array($this->nodes, 'append'), $args);
  
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
   * @param string $value
   * @return Tag_Base
   */
  public function attr($name, $value)
  {
    if (is_null($value))
      unset($this->attributes[$name]);
    else
      $this->attributes[$name] = $value;
  
    return $this;
  }
  
  public function attributes()
  {
    return $this->attributes;
  }
  
  public function updateAttributes(array $attributes=array())
  {
    $this->attributes = array_merge(
      $this->attributes,
      $attributes);
    return $this;
  }
  
  /**
   * Add class.
   *
   * Not append if class exists.
   *
   * @param valiadic_options
   *
   * @return self
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
  
      $defined_class = $this->attributes['class'];
  
      $class_array = preg_split('/\s+/', $defined_class);
      if (!in_array($arg, $class_array))
      {
        array_push($class_array, $arg);
        $this->attributes['class'] = implode(' ', $class_array);
      }
    }
  
    return $this;
  }
  
  /**
   * remove class.
   *
   * @param valiadic_options
   *
   * @return self
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
}