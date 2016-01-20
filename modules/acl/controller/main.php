<?php
/**
 * ACL module  File
 *
 * @category Module
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

if (!isset($params['urlfail'])) {
    $urlfail=DOMAIN;
} else {
    $urlfail=$params['urlfail'];
}

if (!User::isLogin()) {
    header('Location:'.$urlfail);
    exit;
}

if (isset($params['role']) && !$activeuser->isA($params['role'])) {
    header('Location:'.DOMAIN);
    exit;
}
