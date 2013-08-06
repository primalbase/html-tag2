<?php
/**
 * HTML Tag nodes class.
 *
 * PHP 5 >= 5.3.0
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 0.9.0
 *
 */

namespace Primalbase\Tag;

class TagNodesException extends \Exception {}
class TagNodes implements \Iterator {

  protected $nodes = array();

  public static function create()
  {
    $_ = new \ReflectionClass(__CLASS__);
    return $_->newInstanceArgs(func_get_args());
  }

  public function __construct()
  {
    $arg = func_get_args();
    call_user_func_array(array($this, 'append'), $arg);
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

  public function append()
  {
    foreach (func_get_args() as $node)
    {
      if (is_array($node))
        foreach ($node as $in_node)
          $this->append($in_node);
      elseif (!self::appendable($node))
        throw new TagNodesException('Don\'t append type [' . gettype($node).']');
      else
        array_push($this->nodes, $node);
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
    {
      if (is_object($node))
        array_push($escaped, (string)$node);
      else
        array_push($escaped, htmlspecialchars((string)$node));
    }
    return implode('', $escaped);
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
   * Content type is object then allow Tag_Base or Tag_Nodes.
   * Other types always true.
   *
   * @param mixed $content
   * @return boolean
   */
  protected static function appendable($content)
  {
    if (is_object($content))
    {
      if (
        get_class($content) == 'Primalbase\Tag\Tag' ||
        get_class($content) == 'Primalbase\Tag\TagNodes')
        return true;
      else
        return false;
    }

    return true;
  }
}

