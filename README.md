HTML Tag generator. / HTMLタグジェネレータ
-------------------

PHP 5 >= 5.3.0

Support DocType: HTML5, XHTML(XHTML1.0 Transitional), HTML(HTML4)

_サポートするDocType: HTML5, XHTML(XHTML1.0 Transitional), HTML(HTML4)_

### Tag - HTML Tag generate class. / HTMLタグを動的に生成するクラス ###

@version 1.9.2

### $body_tag = Tag::body() ###
### echo $body_tag ###
or
### echo Tag::body() ###

>  `<body></body>`

### echo Tag::div(array('class' => 'span12')) ###

> `<div class="span12"></div>`

### echo Tag::div(array('class' => 'span6'))->addClass('offset6') ###

> `<div class="span12 offset6"></div>`

### echo Tag::table(Tag::tr(Tag::td('content'))) ###

> `<table><tr><td>content</td></tr></table>`

### echo Tag::div()->append(Tag::span(array('class' => 'label'), 'labeled text')) ###

> `<div><span class="label">labeled text</span></div>`

### echo Tag::create('hoge', array('class' => 'fuga')) ###

> `<hoge class="fuga"></hoge>`

### echo Tag::a('here')->href('http://www.google.com')

> `<a href="http://www.google.com">here</a>`

### Change doctype.

```PHP
Tag::$DocType = 'Primalbase\Tag\DocType\Hhtml5';
echo Tag::br() //=> <br>
```
```PHP
Tag::$DocType = 'Primalbase\Tag\DocType\Xhtml';
echo Tag::br() //=> <br />
```
```PHP
Tag::$DocType = 'Primalbase\Tag\DocType\Html4';
echo Tag::br() //=> <br>
```

TagNodes - HTML Tag list. / 兄弟関係のタグオブジェクトを格納するクラス
----------------------------------------------------------------------

@version 1.9.2

### echo TagNodes::create()->append(Tag::hr())->append(Tag::br())

`<hr><br>`

### echo TagNodes::create('hoge fuga')

`hoge fuga`

Plain - For Escaped HTML append to Tag and TagNods. / HTMLコードをエスケープせずに追加するためのクラス
--------------------------------------------------------------------------------------

@version 1.0.0

Other Examples.
---------------

http://primalbase.github.com/html-tag/examples