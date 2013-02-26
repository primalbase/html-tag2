HTML Tag generator.
===================

Tag - HTML Tag generate class.
------------------------------

PHP 5 >= 5.2.0

Support doctype: html5(default), xhtml(xhtml1.0 Transitional), html4

@version 0.0.0.1

### echo Tag::body() ###

`<body></body>`

### echo Tag::div(array('class' => 'span12')) ###

`<div class="span12"></div>`

### echo Tag::table(Tag::tr(Tag::td('content'))) ###

`<table><tr><td>content</td></tr></table>`

### echo Tag::div()->append(Tag::span(array('class' => 'label'), 'labeled text')) ###

`<div><span class="label">labeled text</span></div>`

### echo Tag::create('hoge', array('class' => 'fuga')) ###

`<hoge class="fuga"></hoge>`

### echo Tag::a('here')->href('http://www.google.com')

`<a href="http://www.google.com">here</a>`

### Change doctype.

```PHP
Tag::$DocType = 'xhtml5';
echo Tag::br() //=> <br>
```
```PHP
Tag::$DocType = 'xhtml';
echo Tag::br() //=> <br />
```
```PHP
Tag::$DocType = 'html4';
echo Tag::br() //=> <br>
```

TagNodes - HTML Tag list.
-------------------------

PHP 5 >= 5.2.0

@version 0.0.0.1

### echo TagNodes::create()->append(Tag::hr())->append(Tag::br())

`<hr><br>`

### echo TagNodes::create('hoge fuga')

`hoge fuga`


Other Examples.
---------------

http://primalbase.github.com/html-tag/examples