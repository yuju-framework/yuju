<?php
/**
 * File Boolean class
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
 * @version  SVN: $Id: Boolean.php 120 2013-07-29 08:48:14Z carlosmelga $
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Boolean class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Boolean
{
    /**
     * Value
     *
     * @var    int
     * @access protected
     */
    private $_value;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->_value= 0;
    }

    /**
     * Determine if is boolean
     *
     * @param integer $val value
     * 
     * @return boolean
     */
    protected function isBoolean($val)
    {
        if ($val== 0 || $val== 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Getter Value
     *
     * @access public
     * @return integer
     */
    public function getValue()
    {
        if ($this->isBoolean($this->_value)) {
            return $this->_value;
        }
    }

    /**
     * Getter value to datbase
     *
     * @return integer
     */
    public function getValueToDB()
    {
        return $this->_value;
    }

    /**
     * Setter value
     *
     * @param integer $val value
     * 
     * @return boolean
     */
    public function setValue($val)
    {
        if ($this->isBoolean($val)) {
            $this->_value=intval($val);
            return true;
        } else {
            if ($val==null || $val=='') {
                $this->_value='NULL';
                return true;
            }
        }
        return false;
    }

    /**
     * Get value name
     *
     * @return string
     */
    public function getNameValue()
    {
        if ($this->_value == 1) {
            return _('Yes');
        } elseif ($this->_value == 0) {
            return _('No');
        }
    }
}
?>
