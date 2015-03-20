<?php
/**
 * Login module File
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
 * @version  GIT: 
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
?>
