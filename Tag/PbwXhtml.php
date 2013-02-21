<?php
require_once dirname(__FILE__).'/PbwDocType.php';

class Pbw_Xhtml extends Pbw_DocType {

  protected $useEmptyCloseSeparator = true;

  protected $elements = array(
    'a' => array('', '', '', ''),
    'abbr' => array('', '', '', ''),
    'acronym' => array('', '', '', ''),
    'address' => array('', '', '', ''),
    'applet' => array('', '', '', 'D'),
    'area' => array('', 'F', 'E', ''),
    'b' => array('', '', '', ''),
    'base' => array('', 'F', 'E', ''),
    'basefont' => array('', 'F', 'E', 'D'),
    'bdo' => array('', '', '', ''),
    'big' => array('', '', '', ''),
    'blockquote' => array('', '', '', ''),
    'body' => array('', '', '', ''),
    'br' => array('', 'F', 'E', ''),
    'button' => array('', '', '', ''),
    'caption' => array('', '', '', ''),
    'center' => array('', '', '', 'D'),
    'cite' => array('', '', '', ''),
    'code' => array('', '', '', ''),
    'col' => array('', 'F', 'E', ''),
    'colgroup' => array('', '', '', ''),
    'dd' => array('', '', '', ''),
    'del' => array('', '', '', ''),
    'dfn' => array('', '', '', ''),
    'dir' => array('', '', '', 'D'),
    'div' => array('', '', '', ''),
    'dl' => array('', '', '', ''),
    'dt' => array('', '', '', ''),
    'em' => array('', '', '', ''),
    'fieldset' => array('', '', '', ''),
    'font' => array('', '', '', 'D'),
    'form' => array('', '', '', ''),
    'h1' => array('', '', '', ''),
    'h2' => array('', '', '', ''),
    'h3' => array('', '', '', ''),
    'h4' => array('', '', '', ''),
    'h5' => array('', '', '', ''),
    'h6' => array('', '', '', ''),
    'head' => array('', '', '', ''),
    'hr' => array('', 'F', 'E', ''),
    'html' => array('', '', '', ''),
    'i' => array('', '', '', ''),
    'iframe' => array('', '', '', ''),
    'img' => array('', 'F', 'E', ''),
    'input' => array('', 'F', 'E', ''),
    'ins' => array('', '', '', ''),
    'isindex' => array('', 'F', 'E', 'D'),
    'kbd' => array('', '', '', ''),
    'label' => array('', '', '', ''),
    'legend' => array('', '', '', ''),
    'li' => array('', '', '', ''),
    'link' => array('', 'F', 'E', ''),
    'map' => array('', '', '', ''),
    'menu' => array('', '', '', 'D'),
    'meta' => array('', 'F', 'E', ''),
    'noframes' => array('', '', '', ''),
    'noscript' => array('', '', '', ''),
    'object' => array('', '', '', ''),
    'ol' => array('', '', '', ''),
    'optgroup' => array('', '', '', ''),
    'option' => array('', '', '', ''),
    'p' => array('', '', '', ''),
    'param' => array('', 'F', 'E', ''),
    'pre' => array('', '', '', ''),
    'q' => array('', '', '', ''),
    's' => array('', '', '', 'D'),
    'samp' => array('', '', '', ''),
    'script' => array('', '', '', ''),
    'select' => array('', '', '', ''),
    'small' => array('', '', '', ''),
    'span' => array('', '', '', ''),
    'strike' => array('', '', '', 'D'),
    'strong' => array('', '', '', ''),
    'style' => array('', '', '', ''),
    'sub' => array('', '', '', ''),
    'sup' => array('', '', '', ''),
    'table' => array('', '', '', ''),
    'tbody' => array('', '', '', ''),
    'td' => array('', '', '', ''),
    'textarea' => array('', '', '', ''),
    'tfoot' => array('', '', '', ''),
    'th' => array('', '', '', ''),
    'thead' => array('', '', '', ''),
    'title' => array('', '', '', ''),
    'tr' => array('', '', '', ''),
    'tt' => array('', '', '', ''),
    'u' => array('', '', '', 'D'),
    'ul' => array('', '', '', ''),
    'var' => array('', '', '', ''),
    );
}