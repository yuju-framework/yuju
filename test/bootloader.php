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
    if (file_exists(__DIR__.'/../class/'.$class_name . '.php')) {
        include_once __DIR__.'/../class/'.$class_name . '.php';
    } elseif (defined('API') && file_exists(API . 'class/'.$class_name . '.php')) {
        include_once API . 'class/'.$class_name . '.php';
    }
}
spl_autoload_register('classAutoLoad');
