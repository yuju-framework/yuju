<?php
/**
 * Yuju ORM command line File
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
 * @version  GIT: 
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * ORM page
 *
 * @param string $directory directory
 * @param string $page      page name
 *
 * @return void
 */
function orm($directory, $command, $type, $table, $name = null)
{
    // TODO: read config, connect to data base and delete database
    include 'lib/config.php';
    if (substr($directory, strlen($directory) - 1) != '/') {
        $directory=$directory.'/';
    }
    include $directory.'conf/site.php';
    //if (class_exists($type, true) && is_a($type, 'AbstractYuju_ORM')) {
        $orm = new Yuju_ORM(new $type);
        switch ($command) {
            case 'object':
                $orm->load($table);
                $file = new File();
                if ($name == null) {
                    $name = ucwords($table);
                }
                $file->setContent($orm->generateObject($name));
                $file->create($directory.'class/'.$name.'.php');
                $file->close();
        }
    //}
    //echo _('Type do not exist')."\n";
}