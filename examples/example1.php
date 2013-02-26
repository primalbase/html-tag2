<?php
define('APP_ROOT', realpath(dirname(__FILE__).'/..'));
set_include_path(implode(PATH_SEPARATOR, array(
  APP_ROOT,
  get_include_path(),
)));

require_once 'Tag.php';

echo Tag::i('PHP ', PHP_VERSION);

echo Tag::h1('Example 1');
echo Tag::h2('1. Construct');

echo Tag::h3("Tag::a()");
echo Tag::create('xmp')->append(Tag::a());
  
echo Tag::h3("Tag::create('hoge', array('class' => 'fuga'), 'munya')");
echo Tag::create('xmp')->append(Tag::create('hoge', array('class' => 'fuga'), 'munya'));

echo Tag::h3("Tag::div(array('class' => 'span12'))");
echo Tag::create('xmp')->append(Tag::div(array('class' => 'span12')));

echo Tag::h3("Tag::div(array('class' => 'span12'), 'test', Tag::span('inner'))");
echo Tag::create('xmp')->append(Tag::div(array('class' => 'span12'), 'test', Tag::span('inner')));

echo Tag::h2('2. Member');

echo Tag::h3("Tag::table()->tagName()");
echo Tag::create('xmp')->append(Tag::table()->tagName());

echo Tag::h3("Tag::table(array('class' => 'horizontal'))->attributes()");
var_dump(Tag::table(array('class' => 'horizontal'))->attributes());

echo Tag::h2('3. Attributes');

echo Tag::h3("Tag::div()->class('control-group')");
echo Tag::create('xmp')->append(Tag::div()->class('control-group'));

echo Tag::h3("Tag::a('here')->href('http://www.google.com')");
echo Tag::create('xmp')->append(Tag::a('here')->href('http://www.google.com'));

echo Tag::h3("Tag::a('another')->attr('href', 'http://www.yahoo.com')");
echo Tag::create('xmp')->append(Tag::a('another')->href('http://www.yahoo.com'));

echo Tag::h2('4. Append');

echo Tag::h3("Tag::div()->append(Tag::span('content'))");
echo Tag::create('xmp')->append(Tag::div()->append(Tag::span('content')));

echo Tag::h2('5. Doctype');

echo Tag::h3("Tag::\$DocType = 'html4'; Tag::br()");
Tag::$DocType = 'html4';
echo Tag::create('xmp')->append(Tag::br());

echo Tag::h3("Tag::\$DocType = 'xhtml'; Tag::br()");
Tag::$DocType = 'xhtml';
echo Tag::create('xmp')->append(Tag::br());

echo Tag::h3("Tag::\$DocType = 'html5'; Tag::br()");
Tag::$DocType = 'html5';
echo Tag::create('xmp')->append(Tag::br());

