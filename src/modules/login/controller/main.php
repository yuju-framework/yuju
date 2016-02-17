<?php
/**
 * Login module File
 *
 * @category Module
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

if (isset($params['urlvalid'])) {
    $urlvalid=$params['urlvalid'];
} else {
    $urlvalid=DOMAIN;
}
if (isset($_GET['goto']) && !filter_var($_GET['goto'], FILTER_VALIDATE_URL) === false) {
    $urlvalid=$_GET['goto'];
}

if ($activeuser->isLogin() || isset($_POST['user'])) {
    if ($activeuser->isLogin()
        || $activeuser->login($_POST['user'], $_POST['pass'])
    ) {
        if ($urlvalid) {
            header('Location: '.$urlvalid);
            exit;
        }
    } else {
        Error::setError('login', _('User name or password invalid'));
    }
}
if (isset($params['module'])) {
    $module = $params['module'];
} else {
    $module = 'false';
}

$template->assign('module', $module);
