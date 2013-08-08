<?php
namespace Primalbase\Tag\DocType;

class Xhtml extends AbstractDocType {

  protected $docTypeTag = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
  protected $useEmptyCloseSeparator = true;

  protected $elements = array(
    'a' => 2,
    'abbr' => 2,
    'acronym' => 2,
    'address' => 0,
    'applet' => 2,
    'area' => 1,
    'b' => 2,
    'base' => 1,
    'basefont' => 3,
    'bdo' => 2,
    'big' => 2,
    'blockquote' => 0,
    'body' => 0,
    'br' => 3,
    'button' => 2,
    'caption' => 0,
    'center' => 0,
    'cite' => 2,
    'code' => 2,
    'col' => 1,
    'colgroup' => 0,
    'dd' => 0,
    'del' => 0,
    'dfn' => 2,
    'dir' => 0,
    'div' => 0,
    'dl' => 0,
    'dt' => 0,
    'em' => 2,
    'fieldset' => 0,
    'font' => 2,
    'form' => 0,
    'h1' => 0,
    'h2' => 0,
    'h3' => 0,
    'h4' => 0,
    'h5' => 0,
    'h6' => 0,
    'head' => 0,
    'hr' => 1,
    'html' => 0,
    'i' => 2,
    'iframe' => 2,
    'img' => 3,
    'input' => 3,
    'ins' => 0,
    'isindex' => 1,
    'kbd' => 2,
    'label' => 2,
    'legend' => 0,
    'li' => 0,
    'link' => 1,
    'map' => 2,
    'menu' => 0,
    'meta' => 1,
    'noframes' => 0,
    'noscript' => 0,
    'object' => 2,
    'ol' => 0,
    'optgroup' => 0,
    'option' => 2,
    'p' => 0,
    'param' => 1,
    'pre' => 0,
    'q' => 2,
    's' => 2,
    'samp' => 2,
    'script' => 0,
    'select' => 2,
    'small' => 2,
    'span' => 2,
    'strike' => 2,
    'strong' => 2,
    'style' => 0,
    'sub' => 2,
    'sup' => 2,
    'table' => 0,
    'tbody' => 0,
    'td' => 0,
    'textarea' => 2,
    'tfoot' => 0,
    'th' => 0,
    'thead' => 0,
    'title' => 0,
    'tr' => 0,
    'tt' => 2,
    'u' => 2,
    'ul' => 0,
    'var' => 2,
    );
}