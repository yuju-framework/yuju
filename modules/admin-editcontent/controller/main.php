<?php
/**
 * Admin edit content module File
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
 * @category Module
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: main.php 164 2014-01-09 16:57:37Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
if (!isset($_SESSION['adminsession'])) {
    header("Location: admin-login");
    exit();
}

$page=new Yuju_View();
$page->Load($_GET['page']);

if (isset($_POST) && count($_POST)>0) {
    
    $module=array();
    foreach ($_POST as $name => $value) {
        if (substr($name, 0, 4)=='sb--') {
            $nameNew=explode('--', $name);
            $name_module=$nameNew[1];
        } else {
            $module[$name]=$value;
        }
    }
    
    if (file_exists(ROOT.'modules/'.$name_module.'/controller/data-admin.php')) {
        include ROOT.'modules/'.$name_module.'/controller/data-admin.php';
    } elseif(file_exists(API.'modules/'.$name_module.'/controller/data-admin.php')) {
        include API.'modules/'.$name_module.'/controller/data-admin.php';
    }
    
    $page->setModule($name_module, $module, 0, $nameNew[2]);
    $page->Save();
}

$template->assign('__title', _('Edit page: '). $page->getTitle());
$template->assign('page', $page->build('edit'));
?>
