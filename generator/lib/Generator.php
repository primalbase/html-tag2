<?php
class Generator {
  
  public function __construct(array $options=array())
  {
    $this->attributes = $options;
  }
  
  public function __get($name)
  {
    return $this->attributes[$name];
  }
  
  public function output()
  {
    $php_code =<<< __PHP_CODE__
<?php
require_once 'Tag/TagDocType.php';

class {$this->class_name} extends Tag_DocType {

  protected \$docTypeTag = '{$this->doc_type}';


__PHP_CODE__;
    if ($this->open_bracket)
      $php_code .= "  protected \$openBracket    = '{$this->open_bracket}';\n\n";
    if ($this->close_bracket)
      $php_code .= "  protected \$closeBracket   = '{$this->close_bracket}';\n\n";
    if ($this->close_separator)
      $php_code .= "  protected \$closeSeparator = '{$this->close_separator}';\n\n";
    if ($this->use_empty_close_separator)
      $php_code .= "  protected \$useEmptyCloseSeparator = {$this->use_empty_close_separator};\n\n";
    $php_code .=<<< __PHP_CODE__
  protected \$elements = array(

__PHP_CODE__;
  foreach ($this->tags as $tag_name => $value)
  {
    $tag_name = "'".trim($tag_name)."'";
    $php_code .= sprintf("    %s => %d,\n", $tag_name, $value);
  }
  $php_code .=<<< __PHP_CODE__
    );
}
__PHP_CODE__;
    file_put_contents(
      $this->tag_list_path,
      serialize($this->tags)
    );
    file_put_contents(
      $this->doc_type_class_path, $php_code);
    
    return $this;
  }
}

function getElementsByClassName(DOMDocument $DOMDocument, $ClassName)
{
  $Elements = $DOMDocument -> getElementsByTagName("*");
  $Matched = array();

  foreach($Elements as $node)
  {
    if( ! $node -> hasAttributes())
      continue;

    $classAttribute = $node -> attributes -> getNamedItem('class');

    if( ! $classAttribute)
      continue;

    $classes = explode(' ', $classAttribute -> nodeValue);

    if(in_array($ClassName, $classes))
      $Matched[] = $node;
  }

  return $Matched;
}