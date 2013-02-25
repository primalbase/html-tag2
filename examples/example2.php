<?php
/**
 * Example 2 with Twitter Bootstrap.
 */
define('APP_ROOT', realpath(dirname(__FILE__).'/..'));
set_include_path(implode(PATH_SEPARATOR, array(
APP_ROOT,
get_include_path(),
)));

require_once 'Tag.php';

Tag::$DocType = 'html5';

$html = Tag::html(array('lang' => 'en'));

$html->append(
  Tag::head()
    ->append(Tag::meta(array('charset' => 'UTF-8')))
    ->append(Tag::link(array('type' => 'text/css', 'rel' => 'stylesheet', 'href' => 'asset/bootstrap/css/bootstrap.min.css')))
    ->append(Tag::script(array('type' => 'text/javascript', 'src' => 'asset/bootstrap/js/bootstrap.min.js')))
);

$html->append(
  Tag::body(Tag::h1('content!'))
);

echo $html->doc;
echo $html;