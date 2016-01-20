<?php
/**
 * Email File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Email Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Email
{

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
}
