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
 * @version  SVN: $Id: main.php 89 2013-05-06 11:11:25Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
if (!isset($_SESSION['adminsession'])) {
    header("Location: admin-login");
    exit();
}

$page['PROJECT_NAME'] = PROJECT_NAME;
$page['MAILADM'] = MAILADM;
$page['DOMAIN'] = DOMAIN;
$page['ROOT'] = ROOT;
$page['DBHOST'] = DBHOST;
$page['DBTYPE'] = DBTYPE;
$page['DBUSER'] = DBUSER;
$page['DBPASS'] = DBPASS;
$page['DBDATA'] = DBDATA;
$page['ADMINPASS'] = ADMINPASS;
$page['LANGUAGE'] = LANGUAGE;

if (isset($_POST['pass'])) {
    echo sha1($_POST['pass']);
    exit();
}

if (isset($_POST) && count($_POST) > 1) {
    
    $yp = new Yuju_Project();
    $yp->setAdminEmail($_POST['MAILADM']);
    $yp->setDBHost($_POST['DBHOST']);
    $yp->getDBName($_POST['DBDATA']);
    $yp->setDBType($_POST['DBTYPE']);
    $yp->setDBUser($_POST['DBUSER']);
    $yp->setDBPass($_POST['DBPASS']);
    $yp->setApi(API);
    $yp->setDBName($_POST['DBDATA']);
    $yp->setDomain($_POST['DOMAIN']);
    $yp->setName($_POST['PROJECT_NAME']);
    $yp->setRoot($_POST['ROOT']);
    $yp->setAdminpass($_POST['ADMINPASS']);
    $yp->setLanguage($_POST['LANGUAGE']);
    switch($yp->setConfig()) {
        case -1:
            Error::setError("config", "Config file \"site.php\" does not exist!");
            break;
        case -2:
            Error::setError("config", "Config file \"site.php\" cannont be opened");
            break;
        case -3:
            Error::setError("config", "The email is invalid");
            break;
        case -4:
            Error::setError("config", "Some error has occured while saving");
            break;
    }
}
$template->assign('page', $page);
?>
