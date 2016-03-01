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
use YujuFramework\YujuView;

if (!isset($_SESSION['adminsession'])) {
    header("Location: admin-login");
    exit;
}

if (isset($_GET['logout'])) {
    unset($_SESSION['adminsession']);
    session_destroy();
    header("Location: admin-login");
}

if (isset($_GET['ra'])) {

    if ($_GET['ra'] == "true") {
        Dir::cleandir(ROOT . "compiled");
        Dir::cleandir(ROOT . "templates");
        YujuView::compileAll();
    } else {
        $page_compiled = new YujuView();
        $page_compiled->makeTemplate($_GET['ra']);
    }
    header("Location: admin");
    exit();
}
if (isset($_GET['dpage']) && $_GET['dpage'] != "") {
    DB::query("delete from page where name = '" . $_GET['dpage'] . "'");
    Dir::cleandir(ROOT . "modules/" . $_GET['dpage']);
    Dir::rmdir(ROOT . "modules/" . $_GET['dpage']);
    header("Location: ?ra=true");
    exit();
}

$pages = YujuView::getAll();
$template->assign('pages', $pages);
