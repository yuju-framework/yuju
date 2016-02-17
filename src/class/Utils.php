<?php
/**
 * Utils File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Utils Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
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
                $pager.='<a href="'.$url.'1">'._('First').'</a>';
            }

            if ($page - 2 > 0) {
                $pager.=' <a href="'.$url.($page - 2).'">'.($page - 2).'</a>';
            }

            if ($page - 1 > 0) {
                $pager.=' <a href="'.$url.($page - 1).'">'.($page - 1).'</a>';
            }

            $pager.=' ' . $page;

            if ($page + 1 <= $max_page) {
                $pager.=' <a href="'.$url.($page + 1).'">'.($page + 1).'</a>';
            }

            if ($page + 2 <= $max_page) {
                $pager.=' <a href="'.$url.($page + 2).'">'.($page + 2).'</a>';
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
