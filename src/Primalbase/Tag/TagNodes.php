<?php
/**
 * HTML Tag nodes class.
 *
 * PHP 5 >= 5.3.0
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 1.9.4
 *
 */

namespace Primalbase\Tag;

class TagNodesException extends \Exception {}
class TagNodes implements \Iterator {

  protected $nodes = array();

  protected $parent = null;

  public static function create($options = null)
  {
    $_ = new \ReflectionClass(__CLASS__);
    return $_->newInstanceArgs(func_get_args());
  }

  public function __construct($options = null)
  {
    $args = func_get_args();
    call_user_func_array(array($this, 'append'), $args);
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

  public function last()
  {
    return end($this->nodes);
  }

  public function first()
  {
    return reset($this->nodes);
  }

  public function append()
  {
    foreach (func_get_args() as $node)
    {
      if (is_null($node))
        continue;

      if (is_array($node))
        foreach ($node as $in_node)
          $this->append($in_node);
      elseif (!self::appendable($node))
        throw new TagNodesException('Don\'t append type [' . gettype($node).']');
      else
      {
        if (method_exists($node, 'setParent'))
          $node->setParent($this->parent);
        array_push($this->nodes, $node);
      }
    }
    return $this;
  }

  public function prepend()
  {
    foreach (func_get_args() as $node)
    {
      if (is_null($node))
        continue;

      if (is_array($node))
        foreach ($node as $in_node)
          $this->prepend($in_node);
      elseif (!self::appendable($node))
        throw new TagNodesException('Don\'t append type [' . gettype($node).']');
      else
        array_unshift($this->nodes, $node);
    }
    return $this;
  }

  public function isEmpty()
  {
    return empty($this->nodes);
  }

  public function __toString()
  {
    $escaped = array();
    foreach ($this->nodes as $node)
      array_push($escaped, static::escapedString($node));

    return implode('', $escaped);
  }

  public static function escapedString($node)
  {
    if (is_object($node))
      return (string)$node;
    else
      return htmlspecialchars((string)$node, ENT_QUOTES);
  }

  public function rawString()
  {
    $raw = array();
    foreach ($this->nodes as $node)
    {
      if (is_string($node))
        array_push($raw, $node);
      else
        array_push($raw, (string)$node);
    }
    return implode('', $raw);
  }

  /**
   * Return posibility content append.
   *
   * Content type is object then allow Tag or TagNodes.
   * Other types always true.
   *
   * @param mixed $content
   * @return boolean
   */
  protected static function appendable($content)
  {
    if (is_object($content))
    {
      if ($content instanceof \Primalbase\Tag\Tag ||
          $content instanceof \Primalbase\Tag\TagNodes ||
          $content instanceof \Primalbase\tag\Plain)
        return true;
      else
        return false;
    }

    return true;
  }
}

