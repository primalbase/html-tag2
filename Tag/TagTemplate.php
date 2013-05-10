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

	/**
	 * If set an array to merge an attributes.
	 * If set not an array to append a setting value.
	 */
  public function build()
  {
    $tag = Tag::createInstanceArray($this->tagName, $this->params);

    foreach (func_get_args() as $_)
    {
      if (is_array($_))
        $tag->updateAttributes($_);
      else
        $tag->append($_);
    }

    return $tag;
  }
}

