<?php
/**
 * Generate a tag list to "tags/html5tags" from a websites.
 */
define('APP_ROOT', __DIR__.'/..');
define('DOCTYPE_CLASS_DIR', APP_ROOT.'/src/Primalbase/Tag/DocType');

set_include_path(implode(PATH_SEPARATOR, array(
  __DIR__,
  APP_ROOT,
  get_include_path(),
)));

require_once 'lib/Generator.php';

$elements_list_url   = 'http://www.quackit.com/html_5/tags/';
$cache_path          = 'cache/html5_elements.html';
/**
 * @see http://www.w3.org/TR/html5/syntax.html#void-elements
 */
$empty_tags = array(
  'area',
  'base',
  'br',
  'col',
  'command',
  'embed',
  'hr',
  'img',
  'input',
  'keygen',
  'link',
  'meta',
  'param',
  'source',
  'track',
  'wbr'
);
/**
 * @see http://www.marguerite.jp/Nihongo/WWW/RefHTML5/Appendix/Content-Phrasing.html
 */
$phrasing_contents = array(
  'a',
  'abbr',
  'area',
  'map',
  'audio',
  'b',
  'bdi',
  'bdo',
  'br',
  'button',
  'canvas',
  'cite',
  'code',
  'command',
  'del',
  'dfn',
  'em',
  'embed',
  'i',
  'iframe',
  'img',
  'input',
  'ins',
  'kbd',
  'keygen',
  'label',
  'map',
  'mark',
  'math',
  'meter',
  'noscript',
  'object',
  'output',
  'p',
  'pre',
  'progress',
  'q',
  'ruby',
  's',
  'samp',
  'script',
  'section',
  'select',
  'small',
  'span',
  'strong',
  'sub',
  'sup',
  'svg',
  'textarea',
  'time',
  'u',
  'var',
  'video',
  'wbr',
  'option'
);

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
  if (is_null($td))
    continue;
  $tag_name = trim($td->nodeValue, ' <>');
  if (strpos($tag_name, '!') !== false)
    continue;
  if (!$tag_name)
    continue;
  $tags[$tag_name] = 0;
  if (in_array($tag_name, $empty_tags))
    $tags[$tag_name] |= 1;
  if (in_array($tag_name, $phrasing_contents))
    $tags[$tag_name] |= 2;
}

$generator = new Generator(array(
  'class_name'          => 'Html5',
  'tags'                => $tags,
  'doc_type'            => '<!DOCTYPE html>',
  'doc_type_class_path' => DOCTYPE_CLASS_DIR.'/Html5.php',
  'tag_list_path'       => __DIR__.'/tags/html5tags',
));

$generator->output();

