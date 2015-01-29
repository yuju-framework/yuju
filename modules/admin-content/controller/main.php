<?php

/**
 * Admin content module File
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
 * @author   Carlos Melgarejo <cmelgarejo@peopletic.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: main.php 123 2013-08-23 11:49:49Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
if (!isset($_SESSION['adminsession'])) {
    header("Location: admin-login");
    exit();
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
        Yuju_View::compileAll();
    } else {
        $page_compiled = new Yuju_View();
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

$pages = Yuju_View::getAll();
$template->assign('pages', $pages);
?>
