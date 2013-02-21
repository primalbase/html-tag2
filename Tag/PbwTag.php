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
require_once dirname(__FILE__).'/PbwTagBase.php';
 
class Pbw_Tag extends Pbw_TagBase {
  
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
   * @var Pbw_DocType
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
   * $nodes is Pbw_TagNodes object or a string.
   * Pbw_TagNodes supported __toString().
   *
   * @var mixed Pbw_TagNodes or string
   */
  protected $nodes;
  
  /**
   * Pbw_Tag($tagName, (variadic_options)...)
   *
   * If variadic_options is an array to update attributes.
   *
   * Else if it is a string or a Pbw_Tag to append nodes.
   *
   * @param string $tagNam
   * @param variadic_options
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
    
    $doc_type_class     = 'Pbw_'.ucfirst(self::$DocType);
    $doc_type_file_name = 'Pbw'.ucfirst(self::$DocType).'.php';
    require_once dirname(__FILE__).'/'.$doc_type_file_name;
    if (!isset(self::$DocTypeInstance[self::$DocType]))
      self::$DocTypeInstance[self::$DocType] = new $doc_type_class;
    $this->doc      = self::$DocTypeInstance[self::$DocType];
    $this->property = $this->doc->property($this->tagName);
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
  
  public function append($content)
  {
    if (!$this->nodes)
      $this->nodes = new Pbw_TagNodes();
    $this->nodes->append($content);
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
}

