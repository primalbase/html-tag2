<?php
/**
 *
 * $elements = (tagName => BitFlg)
 *
 * BitFlg & 1 is empty tag.
 * BitFlg & 2 is phrasing or inline contents.
 *
 * @author Hiroshi Kawai <hkawai@gmail.com>
 */
namespace Primalbase\Tag\DocType;

abstract class AbstractDocType {
  
  protected $docTypeTag = '<!DOCTYPE html>';
  
  protected $openBracket = '<';
  
  protected $closeBracket = '>';
  
  protected $closeSeparator = '/';
  
  protected $useEmptyCloseSeparator = false;
  
  protected $elements = array();

  public function property($tagName)
  {
    if (isset($this->elements[$tagName]))
      return $this->elements[$tagName];
    else
      return 0;
  }
  
  public function openTag($tagName, $attributes)
  {
    $token = array($tagName);
    
    foreach ($attributes as $key => $val)
    {
      if (is_null($val))
        continue;
      elseif ($val === false)
        array_push($token, sprintf('%s', $key));
      else
        array_push($token, sprintf('%s="%s"', $key, htmlspecialchars($val)));
    }

    $parts = array($this->openBracket, implode(' ', $token));
    
    if ($this->isEmptyTag($tagName) && $this->useEmptyCloseSeparator)
      array_push($parts, ' ', $this->closeSeparator);
    array_push($parts, $this->closeBracket);
    
    return implode('', $parts);
  }
  
  public function closeTag($tagName)
  {
    $parts = array(
      $this->openBracket,
      $this->closeSeparator,
      $tagName,
      $this->closeBracket
    );
    
    return implode('', $parts);
  }
  
  public function isEmptyTag($tagName)
  {
    if (!isset($this->elements[$tagName]))
      return 0;
    else
      return ($this->elements[$tagName] & 1);
  }
  
  public function isInlineTag($tagName)
  {
    if (!isset($this->elements[$tagName]))
      return 0;
    else
      return ($this->elements[$tagName] & 2);
  }
  
  public function __toString()
  {
    return $this->docTypeTag;
  }
}