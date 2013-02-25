<?php
abstract class Tag_DocType {
  
  protected $docTypeTag = '<!DOCTYPE html>';
  
  protected $openBracket = '<';
  
  protected $closeBracket = '>';
  
  protected $closeSeparator = '/';
  
  protected $useEmptyCloseSeparator = false;
  
  protected $elements = array();
  
  public function property($tagName)
  {
    return $this->elements[$tagName];
  }
  
  public function openTag($tagName, $attributes)
  {
    $token = array($tagName);
    
    foreach ($attributes as $key => $val)
      array_push($token, sprintf('%s="%s"', $key, htmlspecialchars($val)));
    
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
    return ($this->elements[$tagName][2] == 'E');
  }
  
  public function __toString()
  {
    return $this->docTypeTag;
  }
}