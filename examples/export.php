<?php
/**
 * Make the static html from php examples.
 */
foreach (glob('example*.php') as $file)
{
  ob_start();
  require $file;
  file_put_contents(basename($file, '.php').'.html', ob_get_contents());
  ob_end_clean();
}
