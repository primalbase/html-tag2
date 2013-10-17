<?php
/**
 * Test class for Plain.
 */
use Primalbase\Tag\Tag;
use Primalbase\Tag\Plain;

class PlainTest extends PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    Tag::$codeFormat = false;
  }

  protected function tearDown()
  {
  }

  public function testConstruct()
  {
    $this->assertEquals('<div id="test"></div>', Plain::html('<div id="test"></div>'));
  }
}

