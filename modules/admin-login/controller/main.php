<?php
/**
 * Admin content module File
 *
 * @category Module
 * @package  YujuFramework
 * @author   Carlos Melgarejo <cmelgarejo@peopletic.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
if (isset($_POST) && count($_POST) >= 0) {
    if (isset($_POST['user']) && $_POST['user'] == "root") {
        if (sha1($_POST['pass']) == ADMINPASS) {
            $_SESSION['adminsession'] = $_POST['user'];
            header("Location: admin");
            exit();
        }
    }
}
