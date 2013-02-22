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
    }
    
    public function testEmpty()
    {
      $this->assertEquals((string)$this->nodes, '');
    }
    
    public function testAppendTag()
    {
      $this->nodes->append(Tag::strong());
      $this->assertEquals((string)$this->nodes, '<strong></strong>');
      $this->assertEquals((string)$this->nodes, '<strong></strong>');
    }
    
    public function testException()
    {
      $this->setExpectedException('Tag_NodesException');
      $this->nodes->append(null);
    }
    
    public function testAppendTagWithContent()
    {
      $this->nodes->append(Tag::strong('content'));
      $this->assertEquals((string)$this->nodes, '<strong>content</strong>');
      $this->assertEquals((string)$this->nodes->append(array(Tag::br(), 'append text')), '<strong>content</strong><br>append text');
    }
    
}
?>
