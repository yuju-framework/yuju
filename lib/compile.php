<?php
/**
 * Yuju compile command line File
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
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: compile.php 85 2013-05-05 18:53:32Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * Compile page
 *
 * @param string $directory directory
 * @param string $page      page name
 *
 * @return void
 */
function compile($directory, $page)
{
    // TODO: read config, connect to data base and delete database
    include 'lib/config.php';
    if (substr($directory, strlen($directory) - 1) != '/') {
        $directory=$directory.'/';
    }
    include $directory.'conf/site.php';
    
    $view = new Yuju_View();
    $view->MakeTemplate($page);
}
?>
