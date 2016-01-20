<?php
/**
 * RPC File
 *
 * @category Public
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  GIT:
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
session_start();
require '../conf/site.php';
date_default_timezone_set(TIMEZONE);

if (!isset($_GET['call'])) {
   exit;
}

/**
 * Autoload classes
 *
 * @param string $class_name class name
 *
 * @return void
 */
function classAutoLoad($class_name)
{
    if (file_exists(ROOT.'class/'.$class_name . '.php')) {
        include_once ROOT.'class/'.$class_name . '.php';
    } elseif (file_exists(API.'class/'.$class_name . '.php')) {
        include_once API.'class/'.$class_name . '.php';
    }
}

putenv("LC_ALL=".LANGUAGE);
setlocale(LC_ALL, LANGUAGE);
bindtextdomain("messages", ROOT."locales");
bind_textdomain_codeset("messages","UTF-8");
textdomain("messages");
spl_autoload_register('classAutoLoad');

$call = json_decode($_GET['call'], true);

if (isset($call['module']) && isset($call['params'])) {
    header('Content-type: application/json');
    $rpc_params = $call['params'];
    if (file_exists(ROOT.'modules/rpc-'.$call['module'] . '/controller/main.php')) {
        include_once ROOT.'modules/rpc-'.$call['module'] . '/controller/main.php';
    } elseif (file_exists(API.'modules/rpc-'.$call['module'] . '/controller/main.php')) {
        include_once API.'modules/rpc-'.$call['module'] . '/controller/main.php';
    }
}
