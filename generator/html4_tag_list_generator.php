<?php
/**
 * Generate a tag list to "tags/html4tags" from a websites.
 */

set_include_path(implode(PATH_SEPARATOR, array(
    dirname(__FILE__).'/..',
    get_include_path(),
)));

define('APP_ROOT', dirname(__FILE__).'/..');

require_once dirname(__FILE__).'/lib/Generator.php';

$elements_url = 'http://www.w3.org/TR/html401/index/elements.html';
$cache_path   = dirname(__FILE__).'/cache/html4_elements.html';

/**
 * @see http://www.xml.vc/html/block-inline.html
 */
$inline_contents = array('a', 'abbr', 'acronym', 'applet', 'b', 'basefont', 'bdo', 'big', 'br', 'button', 'cite', 'code', 'dfn', 'em', 'font', 'i', 'iframe', 'img', 'input', 'kbd', 'label', 'map', 'object', 'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'textarea', 'tt', 'u', 'var', 'img', 'input', 'object', 'select', 'textarea');

$tags = array();

$doc = new DOMDocument();

if (!file_exists($cache_path))
  file_put_contents($cache_path, file_get_contents($elements_url));
$doc->loadHTMLFile($cache_path);

$table = $doc->getElementsByTagName('table');
$table  = $table->item(0);
$all_tr = $table->getElementsByTagName('tr');
foreach ($all_tr as $tr)
{
  $all_td = $tr->getElementsByTagName('td');
  
  if (is_null($all_td->item(0)))
    continue;
  $tag_name = strtolower(trim($all_td->item(0)->nodeValue));
  if (empty($tag_name))
    continue;
  $tags[$tag_name] = 0;
  
  if (trim($all_td->item(3)->nodeValue) == 'E')
    $tags[$tag_name] |= 1;
  if (in_array($tag_name, $inline_contents))
    $tags[$tag_name] |= 2;
}

$generator = new Generator(array(
  'class_name'          => 'Tag_Html4',
  'tags'                => $tags,
  'doc_type'            => '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
  'doc_type_class_path' => APP_ROOT.'/Tag/TagHtml4.php',
  'tag_list_path'       => dirname(__FILE__).'/tags/html4tags',
));

$generator->output();

