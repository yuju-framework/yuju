#!/usr/bin/php
<?php
/**
 * Yuju command line File
 *
 * PHP version 5
 *
 * Copyright individual contributors as indicated by the @authors tag.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: yuju.php 92 2013-05-06 11:24:12Z danifdez $
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
    if (isset($arv[6])) {
        $name = $arv[6];
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
?>
