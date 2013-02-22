<?php
set_include_path(implode(PATH_SEPARATOR, array(
    dirname(__FILE__).'/..',
    get_include_path(),
)));

define('APP_ROOT', dirname(__FILE__).'/..');

require_once dirname(__FILE__).'/lib/Generator.php';

$elements_url = 'http://www.w3.org/TR/html401/index/elements.html';
$cache_path   = dirname(__FILE__).'/cache/html4_elements.html';

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
  
  $tag_name = strtolower(trim($all_td->item(0)->nodeValue));
  if (empty($tag_name))
    continue;
  $tags[$tag_name] = array(
    trim($all_td->item(1)->nodeValue),
    trim($all_td->item(2)->nodeValue),
    trim($all_td->item(3)->nodeValue),
    trim($all_td->item(4)->nodeValue),
  );
}

$generator = new Generator(array(
  'class_name'          => 'Tag_Html4',
  'tags'                => $tags,
  'doc_type_class_path' => APP_ROOT.'/Tag/TagHtml4.php',
  'tag_list_path'       => dirname(__FILE__).'/tags/html4tags',
));

$generator->output();

