<?php
/**
 * Yuju delete command line File
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
 * @version  SVN: $Id: delete.php 120 2013-07-29 08:48:14Z carlosmelga $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * Delete project
 *
 * @param string $directory directory
 * 
 * @return boolean
 */
function delete($directory)
{
    // TODO: read config, connect to data base and delete database
    include 'lib/config.php';
    $config=readconfig($directory.'conf/site.php');
    $conection=new mysqli($config['DBHOST'], $config['DBUSER'], $config['DBPASS']);
    
    if ($conection->connect_error) {
        echo _("Error connecting to host")."\n";
        return false;
    }
    if (!$conection->query('DROP DATABASE '.$config['DBDATA'].';')) {
        echo _("Error droping database ").$config['DBDATA']." \n";
        return false;
    }
    
    shell_exec('rm -rf '.$directory.' 2>&1');
    return true;
}
?>
