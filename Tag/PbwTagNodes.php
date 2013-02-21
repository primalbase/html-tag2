<?php
/**
 * HTML Tag nodes class.
 *
 * PHP 5 >= 5.1.0
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 0.0.0.1
 *
 */
class Pbw_TagNodes implements Iterator {
  
  protected $nodes = array();
  
  public static function create($nodes=array())
  {
    return new self($nodes);
  }
  
  public function __construct($nodes=array())
  {
    if (is_array($nodes))
      foreach ($nodes as $node)
      $this->append($node);
  }
  
  public function rewind()
  {
    reset($this->nodes);
  }
  
  public function current()
  {
    return current($this->nodes);
  }
  
  public function key()
  {
    return key($this->nodes);
  }
  
  public function next()
  {
    return next($this->nodes);
  }
  
  public function valid()
  {
    $key = key($this->nodes);
    return ($key !== NULL && $key !== FALSE);
  }
  
  public function get($idx)
  {
    return $this->nodes[$idx];
  }
  
  public function append($content)
  {
    if (!self::appendable($content))
      throw new Exception($type.' is not append.');
    
    array_push($this->nodes, $content);
    
    return $this;
  }
  
  public function __toString()
  {
    $escaped = array();
    foreach ($this->nodes as $node)
    {
      if (is_string($node))
        array_push($escaped, htmlspecialchars($node));
      else
        array_push($escaped, (string)$node);
    }
    return implode('', $escaped);
  }
  
  protected static function appendable($content)
  {
    if (gettype($content) == 'string')
      return true;
    
    if (!is_object($content))
      return false;
    
    if (get_class($content) == 'Pbw_Tag')
      return true;
    
    if (is_subclass($content, 'Pbw_Tag'))
      return true;
    
    return false;
  }
}

