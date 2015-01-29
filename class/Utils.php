<?php

/**
 * Utils File
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
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: Utils.php 120 2013-07-29 08:48:14Z carlosmelga $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * Utils Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
class Utils
{

    /**
     * Generate pager
     *
     * @param integer $num   number results
     * @param integer $page  number page
     * @param integer $count total results
     * @param string  $url   url destination
     *
     * @return string
     * @since version 1.0
     */
    public static function pager($num, $page, $count, $url)
    {
        $pager = '';
        if ($count > 0) {
            $max_page = ceil($count / $num);

            if ($page > 1) {
                $pager.='<a href="' . $url . '1">' . _('First') . '</a>';
            }

            if ($page - 2 > 0) {
                $pager.=' <a href="' . $url . ($page - 2) . '">' . ($page - 2) . '</a>';
            }

            if ($page - 1 > 0) {
                $pager.=' <a href="' . $url . ($page - 1) . '">' . ($page - 1) . '</a>';
            }

            $pager.=' ' . $page;

            if ($page + 1 <= $max_page) {
                $pager.=' <a href="' . $url . ($page + 1) . '">' . ($page + 1) . '</a>';
            }

            if ($page + 2 <= $max_page) {
                $pager.=' <a href="' . $url . ($page + 2) . '">' . ($page + 2) . '</a>';
            }

            if ($page < $max_page) {
                $pager.=' <a href="' . $url . $max_page . '">' . ('Last') . '</a>';
            }
        }
        return $pager;
    }

    /**
     * Return Server OS
     *
     * @return string
     * @since version 1.0
     */
    public static function getOS()
    {
        switch (php_uname('s')) {
            case 'Linux':
                return 'linux';
                break;
        }
    }

    /**
     * Check valid URI
     *
     * @param string $uri URI
     *
     * @return mixed return filter URI or false
     * @since version 1.0
     */
    public static function validURI($uri)
    {
        return filter_var($uri, FILTER_VALIDATE_URL);
    }

    /**
     * Check if lagnuage is supported
     *
     * @param string $language URI
     *
     * @return boolean return filter URI or false
     * @since version 1.0
     */
    public static function isLanguageSupported($language)
    {
        $file = new File();
        $file->open(dirname(__DIR__) . "/lib/languages.txt");


        //echo "\n\n".dirname(__DIR__)."\n\n";
        while (!$file->eof()) {

            $line = $file->getLine();
            if ($line == $language) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the list of the supported languages
     *
     * @return boolean return filter URI or false
     * @since version 1.0
     */
    public static function getSupportedLanguages()
    {
        $file = new File();
        $file->open(API . "/lib/languages.txt");
        $lang = array();
        while (!$file->eof()) {

            $line = $file->getLine();
            $lang[] = $line;
        }
        return $lang;
    }

}
