<?php
/**
 * Example 3 Html tag format.
 */
!defined('APP_ROOT') && define('APP_ROOT', realpath(dirname(__FILE__).'/..'));
set_include_path(implode(PATH_SEPARATOR, array(
  APP_ROOT,
  get_include_path(),
)));

require_once 'Tag.php';
require_once 'TagNodes.php';

$html4_tags = unserialize(file_get_contents(APP_ROOT.'/generator/tags/html4tags'));

echo Tag::h1('Example 3 Tag format.');

echo Tag::pre(Tag::code('Tag::$codeFormat = true; // default'));

echo Tag::h2('1. Html4 tags.');

$plain = TagNodes::create();
foreach ($html4_tags as $tag_name => $flg)
  $plain->append(Tag::create($tag_name, 'contents'));

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

echo Tag::h2('2. Table.');

$plain = Tag::table(Tag::tr(Tag::td(),Tag::td()), Tag::tr(Tag::td(),Tag::td()));

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

echo Tag::h2('3. List.');

$plain = Tag::ul(Tag::li(), Tag::li());

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

$plain = Tag::ul(Tag::li('aaa'), Tag::li('bbb'));

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

echo Tag::h2('4. Block and inline.');

$plain = Tag::div(Tag::div(), Tag::div());

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

$plain = Tag::div(Tag::span(), Tag::span());

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

$plain = Tag::span(Tag::span(), Tag::span());

echo Tag::pre(Tag::code(htmlspecialchars($plain)));


$plain = Tag::span(Tag::span(), Tag::br());

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

echo Tag::h2('5. Style and script.');

$plain = Tag::head(Tag::style('a { color: red; }'), Tag::script('function(){
    alert("warning!");
}'));

echo Tag::pre(Tag::code(htmlspecialchars($plain)));

