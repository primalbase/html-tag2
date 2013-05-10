<?php
/**
 * Template for HTML Tag generate class.
 *
 * PHP 5 >= 5.2.0
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 * @version 0.0.0.1
 *
 */
class Tag_Template {

  public $tagName = null;
  public $params  = array();

  /**
   * @param string $name id name.
   */
	public function __construct($tagName)
	{
    $this->tagName = $tagName;
	  $this->params = array_slice(func_get_args(), 1);
	}

  public function build()
  {
    return Tag::createInstanceArray($this->tagName, $this->params);
  }
}

