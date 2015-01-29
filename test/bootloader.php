<?php
/**
 * bootloader File
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
 * @category Test
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: bootloader.php 144 2013-11-19 11:14:08Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
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