<?php
/**
 * Yuju compile command line File
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
use YujuFramework\YujuView;

/**
 * Compile page
 *
 * @param string $directory directory
 * @param string $page      page name
 *
 * @return void
 */
function compile($directory, $page)
{
    // TODO: read config, connect to data base and delete database
    include 'lib/config.php';
    if (substr($directory, strlen($directory) - 1) != '/') {
        $directory=$directory.'/';
    }
    include $directory.'conf/site.php';
    $view = new YujuView();
    $view->MakeTemplate($page);
}
