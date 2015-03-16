<?php
/**
 * ACL File
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
 * @since    version 1.0
 */

/**
 * Class ACL
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class ACL
{
    /**
     * Permision
     *
     * @var array
     * @access private
     */
    private $_acl;

    /**
     * Constructor
     * 
     */
    public function __construct()
    {
        $this->_acl=array();
    }
    
    /**
     * Reset permisssions
     * 
     * @return void
     */
    public function reset()
    {
        $this->_acl=array();
    }

    /**
     * Load permissions from JSON array
     * 
     * @param string $var JSON permission
     * 
     * @return void
     */
    public function loadAcl($var)
    {
        $this->_acl=json_decode($var, true);
        if ($this->_acl==null) {
            $this->_acl=array();
        }
    }

    /**
     * Determine if exists a permission
     * 
     * @param string $var permission
     * 
     * @return boolean
     */
    public function getAcl($var)
    {
        if (in_array($var, $this->_acl)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set new permission
     * 
     * @param string $var permission
     * 
     * @return void
     */
    public function setAcl($var)
    {
        if (!$this->getAcl($var)) {
            $this->_acl[]=$var;
        }
    }

    /**
     * ACL to Database
     * 
     * @return string
     */
    public function toDB()
    {
        return json_encode($this->_acl);
    }

    /**
     * Get all permissions
     * 
     * @return array
     */
    public static function getAll()
    {
        $acls=array();
        $return=DB::Query('SELECT * FROM aclpermission');
        if ($return->numRows()>0) {
            while ($result=$return->fetchObject()) {
                $acls[]=array($result->id, $result->permission);
            }
        }
        return $acls;
    }
}
