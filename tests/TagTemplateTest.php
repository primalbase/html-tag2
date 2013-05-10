<?php
set_include_path(implode(PATH_SEPARATOR, array(
  dirname(__FILE__).'/..',
  get_include_path(),
)));
require_once 'Tag.php';
require_once 'TagTemplate.php';

class NodesTest extends PHPUnit_Framework_TestCase
{
  protected $nodes;

  protected function setUp()
  {
    Tag::$codeFormat = false;
  }

  protected function tearDown()
  {
  }

  public function testConstruct()
  {
    $template = new TagTemplate('div');
    $this->assertEquals($template->tagName, 'div');
    $this->assertEquals($template->params, array());
    $this->assertEquals((string)$template->build(), '<div></div>');

    $template = new TagTemplate('div', array('class' => 'test'));
    $this->assertEquals($template->tagName, 'div');
    $this->assertEquals($template->params, array(array('class' => 'test')));
    $this->assertEquals((string)$template->build(), '<div class="test"></div>');

    $template = new TagTemplate('div', array('class' => 'test'), 'content');
    $this->assertEquals($template->tagName, 'div');
    $this->assertEquals($template->params, array(array('class' => 'test'), 'content'));
    $this->assertEquals((string)$template->build(), '<div class="test">content</div>');

    $template = new TagTemplate('div', Tag::div('inner div'), array('class' => 'test'));
    $this->assertEquals($template->tagName, 'div');
    $this->assertEquals((string)$template->params[0], '<div>inner div</div>');
    $this->assertEquals($template->params[1], array('class' => 'test'));
    $this->assertEquals((string)$template->build(), '<div class="test"><div>inner div</div></div>');
  }
}
?>
