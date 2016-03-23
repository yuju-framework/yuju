<?php
/**
 * Error File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    1.0
 */

namespace YujuFramework;

/**
 * Error Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Error
{
    /**
     * Errors
     *
     * @var    array $errors
     * @access protected
     */
    protected static $errors = array();

    /**
     * Clean errors
     *
     * @access public
     * @return void
     */
    public static function clean()
    {
        Error::$errors=array();
    }

    /**
     * Determine if exists errors
     *
     * @access public
     * @return boolean
     */
    public static function exist()
    {
        if (count(Error::$errors)>0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Setter error
     *
     * @param string $cod error code
     * @param string $txt message error
     *
     * @access public
     * @return void
     */
    public static function setError($cod, $txt)
    {
        Error::$errors[]=array($cod, $txt);
    }

    /**
     * Determine if have errors code
     *
     * @param string $cod code error
     *
     * @access public
     * @return boolean
     */
    public static function haveError($cod)
    {
        if (Error::exist()) {
            foreach (Error::$errors as $error) {
                if ($error[0]==$cod) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Get errors
     *
     * @access public
     * @return array
     */
    public static function getErrors()
    {
        return Error::$errors;
    }

    public static function toString()
    {
        $errors ='';
        foreach (Error::$errors as $error) {
            $errors .= $error[1]."\n";
        }
        return substr($errors, 0, strlen($errors)-1);
    }
    
    public static function toHTML()
    {
        $errors ='';
        foreach (Error::$errors as $error) {
            $errors .= $error[1].'<br>';
        }
        return substr($errors, 0, strlen($errors)-4);
    }
}
