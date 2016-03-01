<?php
/**
 * bootloader File
 *
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

require_once('PHP/Token/Stream/Autoload.php');

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    $root = substr(__DIR__, 0, strlen(__DIR__)-5).'/src/';
    
    if (file_exists($root.'class/'.$class_name . '.php')) {
        require_once $root.'class/'.$class_name . '.php';
    }
});
