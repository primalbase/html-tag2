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

$php_code =<<< '__PHP_CODE__'

Tag::$DocType = 'html5';

/**
 * header
 */
$html = Tag::html(
  array('lang' => 'en'),
  Tag::head(
    Tag::meta(array('charset' => 'UTF-8')),
    Tag::title('Example 2'),
    Tag::meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0')),
    Tag::link(array('type' => 'text/css', 'rel' => 'stylesheet', 'href' => 'asset/bootstrap/css/bootstrap.min.css')),
    Tag::link(array('type' => 'text/css', 'rel' => 'stylesheet', 'href' => 'asset/bootstrap/css/bootstrap-responsive.min.css')),
    Tag::link(array('type' => 'text/css', 'rel' => 'stylesheet', 'href' => 'asset/syntaxhighlighter/styles/shCore.css')),
    Tag::link(array('type' => 'text/css', 'rel' => 'stylesheet', 'href' => 'asset/syntaxhighlighter/styles/shThemeDefault.css')),
    Tag::style('
.syntaxhighlighter {
  overflow: auto !important;
  overflow-y: hidden !important;
}
.syntaxhighlighter table {
  margin-bottom: 1em !important;
}
'
    ),
    Tag::script(array('type' => 'text/javascript', 'src' => 'asset/jquery/jquery-1.9.1.min.js')),
    Tag::script(array('type' => 'text/javascript', 'src' => 'asset/bootstrap/js/bootstrap.min.js')),
    Tag::script(array('type' => 'text/javascript', 'src' => 'asset/syntaxhighlighter/scripts/shCore.js')),
    Tag::script(array('type' => 'text/javascript', 'src' => 'asset/syntaxhighlighter/scripts/shBrushPhp.js')),
    Tag::script(array('type' => 'text/javascript'), '
$(function(){
  SyntaxHighlighter.all();
})
'
    )
  )
);
__PHP_CODE__;

eval($php_code);

$body = Tag::body();

$body->append(
  Tag::section(
    Tag::h2('1. Html header'),
    Tag::pre($php_code, array('class' => 'brush: php'))
  )
);

/**
 * navbar
 */
$php_code = <<< '__PHP_CODE__'
$view = Tag::div(
  Tag::div(array('class' => 'navbar navbar-inverse'),
    Tag::div(array('class' => 'navbar-inner'),
      Tag::div(array('class' => 'container-fluid'),
        Tag::button(array('type' => 'button', 'class' => 'btn btn-navbar', 'data-toggle' => 'collapse', 'data-target' => '.nav-collapse'),
          Tag::span(array('class' => 'icon-bar')),
          Tag::span(array('class' => 'icon-bar')),
          Tag::span(array('class' => 'icon-bar'))
        ),
        Tag::a(array('class' => 'brand', 'href' => '#'), 'Project name'),
        Tag::div(array('class' => 'nav-collapse collapse'),
          Tag::p(array('class' => 'navbar-text pull-right'), 'Logged in as ', Tag::a(array('href' => '#', 'class' => 'navbar-link')), 'Username'),
          Tag::ul(array('class' => 'nav'),
            Tag::li(array('class' => 'active'), Tag::a(array('href' => '#'), 'Home')),
            Tag::li(Tag::a(array('href' => '#about'), 'About')),
            Tag::li(Tag::a(array('href' => '#content'), 'Content'))
          )
        )
      )
    )
  )
);
__PHP_CODE__;

eval($php_code);

$body->append(
  Tag::section(
    Tag::h2('2. Navbar'),
    $view,
    Tag::div(
      Tag::pre($php_code, array('class' => 'brush: php'))
    )
  )
);

/**
 * sidebar
 */
$php_code = <<< '__PHP_CODE__'
$view = Tag::div(
  Tag::div(array('class' => 'container-fluid'),
    Tag::div(array('class' => 'row-fluid'),
      Tag::div(array('class' => 'span3'),
        Tag::div(array('class' => 'well sidebar-nav'),
          Tag::ul(array('class' => 'nav nav-list'),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(array('class' => 'nav-header'), 'Sidebar'),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(array('class' => 'nav-header'), 'Sidebar'),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(Tag::a(array('href' => '#'), 'Link')),
            Tag::li(Tag::a(array('href' => '#'), 'Link'))
          )
        )
      )
    )
  )
);
__PHP_CODE__;

eval($php_code);

$body->append(
  Tag::section(
    Tag::h2('3. Sidebar'),
    $view,
    Tag::div(
      Tag::pre($php_code, array('class' => 'brush: php'))
    )
  )
);

/**
 * hero unit
 */
$php_code = <<< '__PHP_CODE__'
$view = Tag::div(
  Tag::div(array('class' => 'container-fluid'),
    Tag::div(array('class' => 'row-fluid'),
      Tag::div(array('class' => 'span9'),
        Tag::div(array('class' => 'hero-unit'),
          Tag::h1('Hello, world!'),
          Tag::p('This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.'),
          Tag::p(Tag::a(array('href' => '#', 'class' => 'btn btn-primary btn-large'), 'Learn more »'))
        )
      )
    )
  )
);
__PHP_CODE__;

eval($php_code);

$body->append(
  Tag::section(
    Tag::h2('4. Hero unit'),
    $view,
    Tag::div(
      Tag::pre($php_code, array('class' => 'brush: php'))
    )
  )
);

/**
 * Headings
 */
$php_code = <<< '__PHP_CODE__'
$view = Tag::div(
  Tag::div(array('class' => 'container-fluid'),
    Tag::div(array('class' => 'row-fluid'),
      Tag::div(array('class' => 'span9'),
        Tag::div(array('class' => 'row-fluid'),
          Tag::div(array('class' => 'span4'),
            Tag::h2('Heading'),
            Tag::p('Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.'),
            Tag::p(Tag::a(array('href' => '#', 'class' => 'btn'), 'View details »'))
          ),
          Tag::div(array('class' => 'span4'),
            Tag::h2('Heading'),
            Tag::p('Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.'),
            Tag::p(Tag::a(array('href' => '#', 'class' => 'btn'), 'View details »'))
          ),
          Tag::div(array('class' => 'span4'),
            Tag::h2('Heading'),
            Tag::p('Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.'),
            Tag::p(Tag::a(array('href' => '#', 'class' => 'btn'), 'View details »'))
          )
        ),
        Tag::div(array('class' => 'row-fluid'),
          Tag::div(array('class' => 'span4'),
            Tag::h2('Heading'),
            Tag::p('Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.'),
            Tag::p(Tag::a(array('href' => '#', 'class' => 'btn'), 'View details »'))
          ),
          Tag::div(array('class' => 'span4'),
            Tag::h2('Heading'),
            Tag::p('Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.'),
            Tag::p(Tag::a(array('href' => '#', 'class' => 'btn'), 'View details »'))
          ),
          Tag::div(array('class' => 'span4'),
            Tag::h2('Heading'),
            Tag::p('Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.'),
            Tag::p(Tag::a(array('href' => '#', 'class' => 'btn'), 'View details »'))
          )
        )
      )
    )
  )
);
__PHP_CODE__;

eval($php_code);

$body->append(
  Tag::section(
    Tag::h2('5. Headings.'),
    $view,
    Tag::div(
      Tag::pre($php_code, array('class' => 'brush: php'))
    )
  )
);

$html->append($body);
echo $html->doc;
echo $html;


