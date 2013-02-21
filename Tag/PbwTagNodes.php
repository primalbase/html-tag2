<?php
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
  
  public function append($content, $escape=true)
  {
    array_push($this->nodes, $content);
    return $this;
  }
  
  public function __toString()
  {
    $nodes = "";
    foreach ($this->nodes as $i => $node)
    {
      if (is_string($node))
      {
        $string = htmlspecialchars($node);
        $nodes .= $string;
      }
      else
        $nodes .= (string)$node;
    }
    return $nodes;
  }
}

