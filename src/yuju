#!/usr/bin/php
<?php
/**
 * Yuju command line File
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

require 'lib/common.php';

/**
 * Autoload classes
 *
 * @param string $class_name class name
 *
 * @return void
 */
function classAutoLoad($class_name)
{
    $root = substr(__FILE__, 0, strlen(__FILE__)-9);
    if (file_exists($root.'/class/'.$class_name . '.php')) {
        include_once $root.'/class/'.$class_name . '.php';
    }
}
spl_autoload_register('classAutoLoad');

if (count($argv)<2) {
    showHelp();
    exit;
}

switch ($argv[1]) {
    case 'create':
        include 'lib/create.php';
        break;
    case 'delete':
        include 'lib/delete.php';
        delete($argv[2]);
        break;
    case 'compile':
        include 'lib/compile.php';
        compile($argv[2], $argv[3]);
        break;
    case 'orm':
        include 'lib/orm.php';
        if (count($argv)<5) {
            showHelp();
            exit;
        }
        if (isset($argv[6])) {
            $name = $argv[6];
        } else {
            $name = null;
        }
        orm($argv[2], $argv[3], $argv[4], $argv[5], $name);
        break;
    default:
        showHelp();
        exit;
        break;
}
