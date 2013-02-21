<?php
$tag_base_class_path = dirname(__FILE__).'/../Tag/PbwTagBase.php';

$php_keywords = array('__halt_compiler', 'abstract', 'and', 'array', 'as', 'break', 'callable', 'case', 'catch', 'class', 'clone', 'const', 'continue', 'declare', 'default', 'die', 'do', 'echo', 'else', 'elseif', 'empty', 'enddeclare', 'endfor', 'endforeach', 'endif', 'endswitch', 'endwhile', 'eval', 'exit', 'extends', 'final', 'for', 'foreach', 'function', 'global', 'goto', 'if', 'implements', 'include', 'include_once', 'instanceof', 'insteadof', 'interface', 'isset', 'list', 'namespace', 'new', 'or', 'print', 'private', 'protected', 'public', 'require', 'require_once', 'return', 'static', 'switch', 'throw', 'trait', 'try', 'unset', 'use', 'var', 'while', 'xor');

$tag_list = array();
foreach (glob('tags/*') as $tags)
{
  foreach (unserialize(file_get_contents($tags)) as $values)
  {
    $tag_name = strtolower(trim($values[0]));
    if (in_array($tag_name, $php_keywords))
      continue;
    if (in_array($tag_name, $tag_list))
      continue;
    array_push($tag_list, $tag_name);
  }
}

/**
 * first. make php code.
 */
$php_code = array();
foreach ($tag_list as $tag)
  array_push($php_code, '  public static function '.$tag.'() { return self::__create(__FUNCTION__, func_get_args()); }'."\r\n");

var_dump($php_code);
/**
 * second. remove generated code.
 */
$generate_flg = false;
$contents = array();
$insert_index = 0;
foreach (file($tag_base_class_path) as $index => $line)
{
  if ($generate_flg && (strpos($line, '-generate_here') !== false))
    $generate_flg = false;
  
  if (!$generate_flg)
    array_push($contents, $line);
  
  if (strpos($line, '+generate_here') !== false)
  {
    $generate_flg = true;
    $insert_index = $index;
  }
}
array_splice($contents, $insert_index+1, 0, $php_code);
file_put_contents($tag_base_class_path, implode('', $contents));
