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

namespace YujuFramework;

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
     * Check valid URI
     *
     * @param string $uri URI
     *
     * @return boolean
     * @since version 1.0
     */
    public static function validURI($uri)
    {
        if (filter_var($uri, FILTER_VALIDATE_URL)=== false) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Determine if email valide
     *
     * @param string $mail email
     *
     * @return boolean
     */
    public static function validEmail($mail)
    {
        $match = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@";
        $match .= "+([_a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]{2,200}\.[a-zA-Z]{2,6}$/";
        if (preg_match($match, $mail)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Returns a random string
     *
     * @param int $num The length for the generated string
     *
     * @return string
     */
    public static function getAleatoryText($num)
    {
        $text = '';
        for ($c = 0; $c < $num; $c++) {
            $tipo = rand(1, 3);
            switch ($tipo) {
                case 1:
                    $text .= chr(rand(48, 57));
                    break;
                case 2:
                    $text .= chr(rand(65, 90));
                    break;
                case 3:
                    $text .= chr(rand(97, 122));
                    break;
            }
        }
        return $text;
    }
}
