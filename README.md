Tag - Tag generate class.
-------------------------

### echo Tag::body() ###

`<body></body>`

### echo Tag::div(array('class' => 'span12')) ###

`<div class="span12"></div>`

### echo Tag::table(Tag::tr(Tag::td('content'))) ###

`<table><tr><td>content</td></tr></table>`

### echo Tag::div()->append(Tag::span(array('class' => 'label'), 'labbeled text')) ###

`<div><span class="label">labbeled text</span></div>`

TagNodes - Tag list.
--------------------

### $nodes = new TagNodes; echo $nodes->append(Tag::hr())->append(Tag::br())

`<hr><br>`

### $nodes = new TagNodes; echo $nodes->append('hoge fuga')

`hoge fuga`
