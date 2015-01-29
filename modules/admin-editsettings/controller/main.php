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

$page=new Yuju_View();
$cssrepo=array();
$jsrepo=array();
$jsfilesnames=array();
$cssfilesnames=array();

if (isset($_GET['page']) && $_GET['page'] != "new-page") {
    $page->Load($_GET['page']);
    $css=json_decode($page->getCssfiles());
    if ($css != "null" && !is_null($css)) {
        foreach ($css as $cssf) {
            $css = str_replace("{\$DOMAIN}css/","",$cssf);
            $cssrepo[]=$css;
        }
    }
    $js=json_decode($page->getJsfiles());
    if ($js != "null" && !is_null($js)) {
        foreach ($js as $jsf) {
            $js = str_replace("{\$DOMAIN}js/","",$jsf);
            $jsrepo[]=$js;
        }
    }
}
$template->assign('loadcssfiles', $cssrepo);
$template->assign('loadjsfiles', $jsrepo);


$jsfiles=Dir::listFiles(ROOT."htdocs/js", true);
foreach ($jsfiles as $jsfile) {
    if (strpos($jsfile->getPlace(),'ckeditor')===false) {
        if ($jsfile->getExtension() == "js") {
            $name = str_replace(ROOT."htdocs/js/","",$jsfile->getPlace());
            $jsfilesnames[]=$name;
        }
    }
}
$cssfiles=Dir::listFiles(ROOT."htdocs/css", true);
foreach ($cssfiles as $cssfile) {
    if (str_replace("/".$cssfile->getName(), "", $cssfile->getPlace()) != ROOT."htdocs/css/ckeditor") {
        if ($cssfile->getExtension() == "css") {
            $name = str_replace(ROOT."htdocs/css/","",$cssfile->getPlace());
            $cssfilesnames[]=$name;
        }
    }
}
$schemas=Dir::listFiles(ROOT."schema");

if (isset($_POST) && count($_POST) > 0) {
    $page->setCssfiles($_POST['text-cssfiles']);
    $page->setDescription($_POST['description']);
    $page->setJsfiles($_POST['text-jsfiles']);
    $page->setKeyword($_POST['keywords']);
    $page->setModules($_POST['modules']);
    $page->setName($_POST['namet']);
    $page->setSchema($_POST['schema']);
    $page->setTitle($_POST['title']);
    $page->setType($_POST['type']);
    $page->setParent($_POST['parent']);
    if(isset($_POST['sitemap'])) {
        $page->setSiteMap($_POST['sitemap']);
    } else {
        $page->setSiteMap(0);
    }
    if ($_GET['page'] != 'new-page') {
        $page->save();
    } else {
        $page->insert();
    }
    header("Location: admin?ra=true");
    exit();
}

$template->assign('page', $page);
$template->assign('jsfiles', $jsfilesnames);
$template->assign('cssfiles', $cssfilesnames);
$template->assign('schemas', $schemas);
?>
