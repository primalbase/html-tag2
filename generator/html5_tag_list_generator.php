<?php
/**
 * Generate a tag list to "tags/html5tags" from a websites.
 */

set_include_path(implode(PATH_SEPARATOR, array(
    dirname(__FILE__).'/..',
    get_include_path(),
)));

define('APP_ROOT', dirname(__FILE__).'/..');

require_once dirname(__FILE__).'/lib/Generator.php';

$elements_list_url   = 'http://www.quackit.com/html_5/tags/';
$cache_path          = dirname(__FILE__).'/cache/html5_elements.html';
/**
 * @see http://www.w3.org/TR/html5/syntax.html#void-elements
 */
$empty_tags = array('area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr');

$tags = array();

$doc = new DOMDocument();

if (!file_exists($cache_path))
  file_put_contents($cache_path, file_get_contents($elements_list_url));
@$doc->loadHTMLFile($cache_path);

$table = getElementsByClassName($doc, 'tabular-alt');
$table = $table[0];
$all_tr = $table->getElementsByTagName('tr');
foreach ($all_tr as $tr)
{
  $td = $tr->getElementsByTagName('td');
  $td = $td->item(0);
  $tag_name = trim($td->nodeValue, ' <>');
  if (strpos($tag_name, '!') !== false)
    continue;
  if (!$tag_name)
    continue;
  if (in_array($tag_name, $empty_tags))
    $tags[$tag_name] = array(' ', 'F', 'E', ' ');
  else
    $tags[$tag_name] = array(' ', ' ', ' ', ' ');
}

$generator = new Generator(array(
  'class_name'          => 'Tag_Html5',
  'tags'                => $tags,
  'doc_type'            => '<!DOCTYPE html>',
  'doc_type_class_path' => APP_ROOT.'/Tag/TagHtml5.php',
  'tag_list_path'       => dirname(__FILE__).'/tags/html5tags',
));

$generator->output();

