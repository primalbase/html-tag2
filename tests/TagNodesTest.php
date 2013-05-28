<?php
set_include_path(implode(PATH_SEPARATOR, array(
  dirname(__FILE__).'/..',
  get_include_path(),
)));

require_once 'TagNodes.php';
require_once 'Tag.php';

class NodesTest extends PHPUnit_Framework_TestCase
{
  protected $nodes;

  protected function setUp()
  {
    Tag::$codeFormat = false;
    $this->nodes = new TagNodes;
  }

  protected function tearDown()
  {
  }

  public function testConstruct()
  {
    $this->assertEquals((string)TagNodes::create(), '');
    $this->assertEquals((string)TagNodes::create('hoge fuga'), 'hoge fuga');
    $this->assertEquals((string)TagNodes::create(Tag::b()), '<b></b>');
    $this->assertEquals((string)TagNodes::create()->append(Tag::hr()), '<hr>');
    $this->assertEquals((string)TagNodes::create(Tag::li('item1'), Tag::li('item2')), '<li>item1</li><li>item2</li>');
    $this->assertEquals((string)TagNodes::create(1), '1', 'Add a integer.');
    $this->assertEquals((string)TagNodes::create(1.0), '1.0', 'Add a float.');
    $this->assertEquals((string)TagNodes::create(array('a', 'b', 'c')), 'abc', 'Add an array.');
  }

  public function testEmpty()
  {
    $this->assertEquals((string)$this->nodes, '');
  }

  public function testAppendTag()
  {
    $this->assertEquals((string)$this->nodes->append(Tag::strong()), '<strong></strong>');
  }

  public function testException()
  {
    $this->setExpectedException('Tag_NodesException');
    $this->nodes->append(new stdClass);
  }

  public function testAppendTagWithContent()
  {
    $this->nodes->append(Tag::strong('content'));
    $this->assertEquals((string)$this->nodes, '<strong>content</strong>');
    $this->assertEquals((string)$this->nodes->append(array(Tag::br(), 'append text')), '<strong>content</strong><br>append text');
  }

}
?>
