<?php
/**
 * Yuju common command line File
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
 * @version  SVN: $Id: common.php 120 2013-07-29 08:48:14Z carlosmelga $
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Show help
 *
 * @return void
 */
function showHelp()
{
    global $argv;
    echo "Usage: $argv[0] create\n";
    echo "       $argv[0] delete <directory>\n";
    echo "       $argv[0] compile <directory> <modname|'compile-all-web-pages'>\n";
    echo "       $argv[0] orm <directory> <object> <type> <table> [object name]\n";
}
?>
