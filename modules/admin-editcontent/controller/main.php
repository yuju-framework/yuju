<?php
/**
 * Admin edit content module File
 *
 * @category Module
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
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
    } elseif (file_exists(API.'modules/'.$name_module.'/controller/data-admin.php')) {
        include API.'modules/'.$name_module.'/controller/data-admin.php';
    }

    $page->setModule($name_module, $module, 0, $nameNew[2]);
    $page->Save();
}

$template->assign('__title', _('Edit page: '). $page->getTitle());
$template->assign('page', $page->build('edit'));
