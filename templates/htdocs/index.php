<?php
/**
 * Index File
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
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: index.php 120 2013-07-29 08:48:14Z carlosmelga $
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
session_start();
require '../conf/site.php';
date_default_timezone_set(TIMEZONE);
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

// Load WebPage
if (defined('API')) {
    include API.'class/Yuju_View.php';
} else {
    include ROOT.'class/Yuju_View.php';
}
$view=new Yuju_View();
spl_autoload_register('classAutoLoad');
if (isset($_SESSION['user'])) {
    $activeuser=unserialize($_SESSION['user']);
} else {
    // Load Object User
    $activeuser=new User();
}
// If slash, location 301 without slash
if (substr($_GET['p'], -1)=='/') {
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: '.DOMAIN.substr($_GET['p'], 0, strlen($_GET['p'])-1));
    exit;
}

$view->display($view->getPage($_GET['p']).'.tpl', $_SERVER['REQUEST_URI']);
?>