<?php
/**
 * Yuju config command line File
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
 * @version  SVN: $Id: config.php 120 2013-07-29 08:48:14Z carlosmelga $
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Read config file and return array values
 * 
 * @param string $file config file
 * 
 * @return array
 */
function readconfig($file)
{
    $config=array();
    if (file_exists($file)) {
        $openfile = fopen($file, "r");
        //Output a line of the file until the end is reached
        while (!feof($openfile)) {
            $line=fgets($openfile);
            preg_match('/^define\(\'(.*)\', \'(.*)\'\);/', $line, $result);
            if (count($result)>1) {
                $config[$result[1]]=$result[2];
            }
        }
        fclose($openfile);
    }
    return $config;
}

/**
 * Set config vars
 * 
 * @param string $file config file
 * @param array  $vars array vars
 * 
 * @return void
 */
function setconfig($file, array $vars)
{
    if (!file_exists($file)) {
        echo _("Config file $file not nound")."\n";
        return false;
    }
    $openfile = fopen($file, "r");
    $newfile='';
    //Output a line of the file until the end is reached
    while (!feof($openfile)) {
        $line=fgets($openfile);
        $new=false;
        foreach ($vars as $key => $value) {
            $newline=preg_replace(
                '/^define\(\''.$key.'\', \'(.*)\'\);/',
                'define(\''.$key.'\', \''.$value.'\');',
                $line
            );
            if ($newline!=$line) {
                $newfile.=$newline;
                $new=true;
            }
        }
        if ($new==false) {
            $newfile.=$line;
        }
    }
    fclose($openfile);
    $openfile = fopen($file, 'w');
    fwrite($openfile, $newfile);
    fclose($openfile);
}

?>
