<?php
/**
 * Generate a tag list to "tags/xhtmltags" from a websites.
 */

set_include_path(implode(PATH_SEPARATOR, array(
    dirname(__FILE__).'/..',
    get_include_path(),
)));

define('APP_ROOT', dirname(__FILE__).'/..');

require_once dirname(__FILE__).'/lib/Generator.php';

$elements_list_url   = 'http://undine.sakura.ne.jp/uglabo/htmlref/xhtml1-transitional/index.html';
$cache_path          = dirname(__FILE__).'/cache/xhtml_elements.html';

$empty_tags = array('base', 'meta', 'link', 'hr', 'br', 'basefont', 'param', 'img', 'area', 'input', 'isindex', 'col');
/**
 * @see http://www.xml.vc/html/block-inline.html
 */
$inline_contents = array('a', 'abbr', 'acronym', 'applet', 'b', 'basefont', 'bdo', 'big', 'br', 'button', 'cite', 'code', 'dfn', 'em', 'font', 'i', 'iframe', 'img', 'input', 'kbd', 'label', 'map', 'object', 'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'textarea', 'tt', 'u', 'var', 'img', 'input', 'object', 'select', 'textarea', 'option');

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
  if (is_null($a))
    continue;
  $tag_name = $a->nodeValue;
  if (!$tag_name)
    continue;
  
  $tags[$tag_name] = 0;
  
  if (in_array($tag_name, $empty_tags))
    $tags[$tag_name] |= 1;
  if (in_array($tag_name, $inline_contents))
    $tags[$tag_name] |= 2;
}

$generator = new Generator(array(
  'class_name'          => 'Tag_Xhtml',
  'use_empty_close_separator' => 'true',
  'tags'                => $tags,
  'doc_type'            => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
  'doc_type_class_path' => APP_ROOT.'/Tag/TagXhtml.php',
  'tag_list_path'       => dirname(__FILE__).'/tags/xhtmltags',
));

$generator->output();

