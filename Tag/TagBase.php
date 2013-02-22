<?php
/**
 * HTML Tag generate class.
 *
 * PHP 5 >= 5.1.0
 *
 * Support doctype: html5, xhtml(xhtml1.0 Transitional), html4
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 0.0.0.1
 *
 */
require_once 'Tag/TagNodes.php';

class Tag_Exception extends Exception {}
class Tag_Base {
  
  protected static $OpenBracket  = '<';
  protected static $CloseBracket = '>';
  protected static $EmptyCloseBracket = '>';
  
  
  /**
   * HTML Document type
   *
   * html5, xhtml, html4
   *
   * @var string $DocType
   */
  public static $DocType='html5';
  
  /**
   * Cache array.
   *
   * self::$DocTypeInstance['html4']
   * self::$DocTypeInstance['xhtml']
   * self::$DocTypeInstance['html5']
   *
   * @var array $DocTypeInstance
   */
  protected static $DocTypeInstance=array();

  /**
   * Current DocType instance.
   *
   * @var Tag_DocType
   */
  protected $doc;
  
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
  public function __construct()
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
  
  public static function create($tagName)
  {
    $_ = new ReflectionClass('Tag_Base');
    return $_->newInstanceArgs(func_get_args());
  }
  
  public function __toString()
  {
    $parts = array();
    
    array_push($parts, $this->doc->openTag($this->tagName, $this->attributes));
    if (!$this->doc->isEmptyTag($this->tagName))
    {
      array_push($parts, $this->nodes);
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
    
    call_user_func_array(array($this->nodes, 'append'), func_get_args());
    
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
  public static function a() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function abbr() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function acronym() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function address() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function applet() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function area() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function b() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function base() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function basefont() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function bdo() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function big() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function blockquote() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function body() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function br() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function button() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function caption() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function center() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function cite() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function code() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function col() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function colgroup() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function dd() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function del() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function dfn() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function dir() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function div() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function dl() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function dt() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function em() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function fieldset() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function font() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function form() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function frame() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function frameset() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function h1() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function h2() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function h3() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function h4() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function h5() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function h6() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function head() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function hr() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function html() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function i() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function iframe() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function img() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function input() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function ins() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function isindex() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function kbd() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function label() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function legend() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function li() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function link() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function map() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function menu() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function meta() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function noframes() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function noscript() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function object() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function ol() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function optgroup() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function option() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function p() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function param() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function pre() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function q() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function s() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function samp() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function script() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function select() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function small() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function span() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function strike() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function strong() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function style() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function sub() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function sup() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function table() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function tbody() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function td() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function textarea() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function tfoot() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function th() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function thead() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function title() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function tr() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function tt() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function u() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function ul() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function article() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function aside() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function audio() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function bdi() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function canvas() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function command() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function data() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function datagrid() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function datalist() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function details() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function embed() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function eventsource() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function figcaption() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function figure() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function footer() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function header() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function hgroup() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function keygen() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function mark() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function meter() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function nav() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function output() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function progress() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function ruby() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function rp() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function rt() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function section() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function source() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function summary() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function time() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function track() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function video() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  public static function wbr() { $args = func_get_args(); array_unshift($args, __FUNCTION__); return call_user_func_array("self::create", $args); }
  //-generate_here
}