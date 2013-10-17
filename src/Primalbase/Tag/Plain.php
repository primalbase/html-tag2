<?php
/**
 * For Escaped HTML append to Tag and TagNods.
 *
 * PHP 5 >= 5.3.0
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 1.0.0
 *
 */


namespace Primalbase\Tag;

class Plain {

  protected $html = '';

  public static function html($html)
  {
    $obj = new static;

    $obj->html = $html;

    return $obj;
  }

  public function __toString()
  {
    return $this->html;
  }
}