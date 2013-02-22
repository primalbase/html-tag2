<?php
set_include_path(implode(PATH_SEPARATOR, array(
    dirname(__FILE__).'/..',
    get_include_path(),
)));

define('APP_ROOT', dirname(__FILE__).'/..');

require_once dirname(__FILE__).'/lib/Generator.php';

$elements_list_url   = 'http://undine.sakura.ne.jp/uglabo/htmlref/xhtml1-transitional/index.html';
$cache_path          = dirname(__FILE__).'/cache/xhtml_elements.html';
$empty_tags = array('base', 'meta', 'link', 'hr', 'br', 'basefont', 'param', 'img', 'area', 'input', 'isindex', 'col');

$tags = array();

$doc = new DOMDocument();

if (!file_exists($cache_path))
  file_put_contents($cache_path, file_get_contents($elements_list_url));
$doc->loadHTMLFile($cache_path);

$h3 = $doc->getElementById('index.alphabetic');
$all_ul = $h3->parentNode->getElementsByTagName('ul');
$element = $h3->nextSibling;
while ($element->nodeType == XML_TEXT_NODE)
  $element = $element->nextSibling;
$ul = $element;
$all_li = $ul->getElementsByTagName('li');
foreach ($all_li as $li)
{
  $a = $li->getElementsByTagName('a');
  $a = $a->item(0);
  $tag_name = $a->nodeValue;
  if (!$tag_name)
    continue;
  
  $values = array(' ');
  if (in_array($tag_name, $empty_tags))
  {
    array_push($values, 'F');
    array_push($values, 'E');
  }
  else
  {
    array_push($values, ' ');
    array_push($values, ' ');
  }
  
  if (strpos($li->nodeValue, '(*)') !== false)
    array_push($values, 'D');
  else
    array_push($values, ' ');

  $tags[$tag_name] = $values;
}

$generator = new Generator(array(
  'class_name'          => 'Tag_Xhtml',
  'use_empty_close_separator' => 'true',
  'tags'                => $tags,
  'doc_type_class_path' => APP_ROOT.'/Tag/TagXhtml.php',
  'tag_list_path'       => dirname(__FILE__).'/tags/xhtmltags',
));

$generator->output();

