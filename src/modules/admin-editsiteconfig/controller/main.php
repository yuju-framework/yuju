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

    $yp = new YujuProject();
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
