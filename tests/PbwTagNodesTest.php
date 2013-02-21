<?php
set_include_path(implode(PATH_SEPARATOR, array(
  dirname(__FILE__).'/../',
  get_include_path(),
)));

require_once 'Tag/PbwTagNodes.php';
require_once 'Tag.php';

class NodesTest extends PHPUnit_Framework_TestCase
{
  protected $nodes;
  
    protected function setUp()
    {
      $this->nodes = new Pbw_TagNodes;
    }

    protected function tearDown()
    {
    }

    public function testEmpty()
    {
      $this->assertEquals((string)$this->nodes, '');
    }
    
    public function testAppendTag()
    {
      $this->nodes->append(Tag::strong());
      $this->assertEquals((string)$this->nodes, '<strong></strong>');
    }
    
    public function testAppendTagWithContent()
    {
      $this->nodes->append(Tag::strong('content'));
      $this->assertEquals((string)$this->nodes, '<strong>content</strong>');
    }
    
}
?>
