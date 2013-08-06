<?php
/**
 * HTML Tag generate class.
 *
 * PHP 5 >= 5.2.0
 *
 * Support doctype: html5, xhtml(xhtml1.0 Transitional), html4(html4.01 Transitional)
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 0.0.0.1
 *
 */
require_once 'Tag/TagNodes.php';

class Tag_Exception extends Exception {}
class Tag_Base {

  /**
   * HTML Document type
   *
   * html5, xhtml, html4
   *
   * @var string $DocType
   */
  public static $DocType = 'html5';

  /**
   * Current DocType instance.
   *
   * @var Tag_DocType
   */
  public $doc;

  /**
   * Cache array.
   *
   * self::$DocTypeInstance['html4']
   * self::$DocTypeInstance['xhtml']
   * self::$DocTypeInstance['html5']
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
    $this->nodes   = new Tag_Nodes();

    foreach ($args as $arg)
    {
      if (is_array($arg))
        $this->updateAttributes($arg);
      else
        $this->append($arg);
    }

    $doc_type_class     = 'Tag_'.ucfirst(self::$DocType);
    $doc_type_file_name = 'Tag'.ucfirst(self::$DocType).'.php';
    require_once dirname(__FILE__).'/'.$doc_type_file_name;
    if (!isset(self::$DocTypeInstance[self::$DocType]))
      self::$DocTypeInstance[self::$DocType] = new $doc_type_class;
    $this->doc      = self::$DocTypeInstance[self::$DocType];
    $this->property = $this->doc->property($this->tagName);
  }

  /**
   * Create caller class instance with array.
   *
   * But, not get class name with static in PHP 5.2
   * Should be defined like 'Tag' of TAG_REFLECTION_CLASS to subclass.
   * Not defined case, Create a Tag_Base instance.
   *
   * @param string $tagName
   * @param array $args
   */
  public static function createInstanceArray($tagName, array $args)
  {
    array_unshift($args, $tagName);
    $_ = new ReflectionClass(self::getClass());
    return $_->newInstanceArgs($args);
  }

  private static function getClass()
  {
    return defined(TAG_REFLECTION_CLASS) ? TAG_REFLECTION_CLASS : __CLASS__;
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
    return self::createInstanceArray($tagName, $args);
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

  //+generate_here
  public static function a() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function abbr() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function acronym() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function address() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function applet() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function area() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function b() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function base() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function basefont() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function bdo() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function big() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function blockquote() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function body() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function br() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function button() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function caption() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function center() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function cite() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function code() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function col() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function colgroup() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function dd() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function del() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function dfn() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function dir() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function div() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function dl() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function dt() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function em() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function fieldset() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function font() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function form() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function frame() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function frameset() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function h1() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function h2() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function h3() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function h4() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function h5() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function h6() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function head() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function hr() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function html() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function i() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function iframe() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function img() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function input() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function ins() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function isindex() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function kbd() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function label() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function legend() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function li() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function link() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function map() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function menu() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function meta() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function noframes() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function noscript() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function object() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function ol() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function optgroup() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function option() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function p() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function param() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function pre() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function q() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function s() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function samp() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function script() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function select() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function small() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function span() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function strike() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function strong() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function style() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function sub() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function sup() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function table() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function tbody() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function td() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function textarea() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function tfoot() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function th() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function thead() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function title() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function tr() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function tt() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function u() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function ul() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function article() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function aside() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function audio() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function bdi() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function canvas() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function command() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function data() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function datagrid() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function datalist() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function details() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function embed() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function eventsource() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function figcaption() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function figure() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function footer() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function header() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function hgroup() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function keygen() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function mark() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function meter() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function nav() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function output() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function progress() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function ruby() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function rp() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function rt() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function section() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function source() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function summary() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function time() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function track() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function video() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  public static function wbr() { $_=func_get_args(); return self::createInstanceArray(__FUNCTION__, $_); }
  //-generate_here
}