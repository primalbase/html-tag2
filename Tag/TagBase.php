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
   * Create caller class instance.
   *
   * But, not get class name with static in PHP 5.2
   * Should be defined 'Tag' to TAG_REFLECTION_CLASS.
   * Not defined case, Create a Tag_Base instance.
   *
   * @param string $tagName
   * @param array $args
   */
  protected static function __create_instance($tagName, array $args)
  {
    array_unshift($args, $tagName);
    $class_name = defined(TAG_REFLECTION_CLASS) ? TAG_REFLECTION_CLASS : __CLASS__;
    $_ = new ReflectionClass($class_name);
    return $_->newInstanceArgs($args);
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
    return self::__create_instance($tagName, $args);
  }
  
  public function __toString()
  {
    $parts = array();
    
    array_push($parts, $this->doc->openTag($this->tagName, $this->attributes));
    if (!$this->doc->isEmptyTag($this->tagName))
    {
      array_push($parts, (string)$this->nodes);
      array_push($parts, $this->doc->closeTag($this->tagName));
    }
    
    return implode('', $parts);
  }
  
  /**
   * Set attribute.
   *
   * If empty $args to return attributes[$name].
   *
   * $attributes[$name] = $args[0]
   *
   * @param $name string
   * @param $args array
   */
  public function __call($name, $args)
  {
    if (empty($args))
      return $this->attributes[$name];
    
    $this->attributes[$name] = $args[0];
    
    return $this;
  }
  
  public function tagName()
  {
    return $this->tagName;
  }
  
  public function append()
  {
    if (!$this->nodes)
      $this->nodes = new Tag_Nodes();
    
    $args = func_get_args();
    call_user_func_array(array($this->nodes, 'append'), $args);
    
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
  
  //+generate_here
  public static function a() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function abbr() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function acronym() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function address() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function applet() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function area() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function b() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function base() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function basefont() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function bdo() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function big() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function blockquote() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function body() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function br() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function button() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function caption() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function center() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function cite() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function code() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function col() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function colgroup() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function dd() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function del() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function dfn() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function dir() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function div() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function dl() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function dt() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function em() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function fieldset() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function font() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function form() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function frame() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function frameset() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function h1() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function h2() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function h3() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function h4() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function h5() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function h6() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function head() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function hr() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function html() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function i() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function iframe() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function img() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function input() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function ins() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function isindex() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function kbd() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function label() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function legend() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function li() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function link() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function map() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function menu() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function meta() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function noframes() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function noscript() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function object() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function ol() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function optgroup() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function option() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function p() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function param() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function pre() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function q() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function s() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function samp() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function script() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function select() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function small() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function span() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function strike() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function strong() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function style() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function sub() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function sup() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function table() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function tbody() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function td() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function textarea() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function tfoot() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function th() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function thead() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function title() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function tr() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function tt() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function u() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function ul() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function article() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function aside() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function audio() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function bdi() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function canvas() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function command() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function data() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function datagrid() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function datalist() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function details() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function embed() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function eventsource() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function figcaption() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function figure() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function footer() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function header() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function hgroup() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function keygen() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function mark() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function meter() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function nav() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function output() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function progress() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function ruby() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function rp() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function rt() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function section() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function source() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function summary() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function time() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function track() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function video() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  public static function wbr() { $_=func_get_args(); return self::__create_instance(__FUNCTION__, $_); }
  //-generate_here
}