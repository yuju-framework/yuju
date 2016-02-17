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



/**
 * Function that creates an autoloadre for the object system
 *
 * @param string $class_name Class to load
 *
 * @return void
 */
function classAutoLoad($class_name)
{
    $base_dir = substr(__DIR__, 0, strlen(__DIR__)-4);
    if (file_exists($base_dir.'src/class/'.$class_name . '.php')) {
        include_once $base_dir.'src/class/'.$class_name . '.php';
    }
}

require_once('PHP/Token/Stream/Autoload.php');

spl_autoload_register('classAutoLoad');
