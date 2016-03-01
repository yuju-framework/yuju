<?php
/**
 * Yuju autoload File
 *
 * @category common
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

spl_autoload_register(function ($class_name) {
    
    $class_name = str_replace('\\', '/', $class_name);
    if (!defined('ROOT')) {
        $root = substr(__DIR__, 0, strlen(__DIR__)-4).'/';
    } else {
        $root = ROOT;
    }
    if (file_exists($root.'class/'.$class_name . '.php')) {
        require_once $root.'class/'.$class_name . '.php';
    } elseif (defined('API') && file_exists(API.'class/'.$class_name . '.php')) {
        require_once API.'class/'.$class_name . '.php';
    }
});
