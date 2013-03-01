<?php
/**
 * Example 3 Html tag format.
 */
define('APP_ROOT', realpath(dirname(__FILE__).'/..'));
set_include_path(implode(PATH_SEPARATOR, array(
  APP_ROOT,
  get_include_path(),
)));

require_once 'Tag.php';
require_once 'TagNodes.php';

$html4_tags = unserialize(file_get_contents(APP_ROOT.'/generator/tags/html4tags'));

echo Tag::h1('Example 3 Tag format.');

$plain = TagNodes::create();
foreach ($html4_tags as $tag_name => $flg)
  $plain->append(Tag::create($tag_name, 'contents'));

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

$plain = Tag::table(Tag::tr(Tag::td(),Tag::td()), Tag::tr(Tag::td(),Tag::td()));

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

$plain = Tag::ul(Tag::li(), Tag::li());

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

$plain = Tag::ul(Tag::li('aaa'), Tag::li('bbb'));

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

$plain = Tag::div(Tag::div(), Tag::div());

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

$plain = Tag::div(Tag::span(), Tag::span());

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

$plain = Tag::span(Tag::span(), Tag::span());

echo Tag::pre(Tag::code(htmlspecialchars($plain)));


$plain = Tag::span(Tag::span(), Tag::br());

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

$plain = Tag::body(Tag::style('a { color: red; }'));

echo Tag::pre(Tag::code(htmlspecialchars($plain)));
