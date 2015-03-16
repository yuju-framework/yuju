<?php
/**
 * Error File
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
 * @version  GIT: 
 * @link     https://github.com/yuju-framework/yuju
 * @since    1.0
 */

/**
 * Error Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
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
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    /**
     * Get errors
     *
     * @access public
     * @return array|boolean
     */
    public static function getErrors()
    {
        if (Error::Exist()) {
            return Error::$errors;
        } else {
            return false;
        }
    }
}
