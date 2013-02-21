<?php
/**
 * HTML Tag generated class.
 *
 * PHP 5 >= 5.1.0
 *
 * Support doctype: html5, xhtml(xhtml1.0 Transitional), html4
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 *
 */

!defined('PBW_TAG_CLASS') && define('PBW_TAG_CLASS', 'Pbw_Tag');

require_once 'Tag/PbwTagBase.php';
 
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
  
  public function __construct()
  {
    $args = func_get_args();
    $this->tagName      = strtolower(array_shift($args));
    $doc_type_class     = 'Pbw_'.ucfirst(self::$DocType);
    $doc_type_file_name = 'Pbw'.ucfirst(self::$DocType).'.php';
    require_once dirname(__FILE__).'/Tag/'.$doc_type_file_name;
    if (!isset(self::$DocTypeInstance[self::$DocType]))
      self::$DocTypeInstance[self::$DocType] = new $doc_type_class;
    $this->doc      = self::$DocTypeInstance[self::$DocType];
    $this->property = $this->doc->property($this->tagName);
  }
  
  public function __toString()
  {
    $parts = array();
    
    array_push($parts, $this->doc->openTag($this->tagName, $this->attributes));
    if (!$this->doc->isEmpty($this->tagName))
    {
      array_push($parts, $this->nodes);
      array_push($parts, $this->doc->closeTag($this->tagName));
    }
    
    return implode('', $parts);
  }
  
  public function tagName()
  {
    return $this->tagName;
  }
  
  public function attributes()
  {
    return $this->attributes;
  }
}

