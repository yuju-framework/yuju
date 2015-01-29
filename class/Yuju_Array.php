<?php

/**
 * Yuju_Array Class
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
 * @version  SVN: $Id: Yuju_Array.php 187 2014-09-05 19:17:05Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * Class Yuju_Array
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
class Yuju_Array implements Iterator {

    /**
     * Position
     *
     * @var    integer
     * @access private
     */
    private $_position = 0;

    /**
     * Array
     *
     * @var    array
     * @access private
     */
    private $_array = array();

    /**
     * Full object
     *
     * @var    boolean
     * @access private
     */
    private $_full = false;

    /**
     * Template object
     *
     * @var    IYuju_Array
     * @access private
     */
    private $_object = null;
    
    private $_count = 0;

    /**
     * Constructor
     *
     * @param IYuju_Array $object object
     * @param boolean     $full   full object
     * 
     * @access public
     */
    public function __construct(IYuju_Array $object, $full = false) {
        $this->_full = $full;
        $this->_object = $object;
    }

    /**
     * Rewind
     *
     * @access public
     * @return void
     */
    public function rewind() {
        $this->_position = 0;
    }

    /**
     * Current
     *
     * @access public
     * @return object
     */
    public function current() {
        if (is_null($this->_array[$this->_position][1])) {
            $obj = clone($this->_object);
            if ($this->_full) {
                $obj->load($this->_array[$this->_position][0]);
                $this->_array[$this->_position][1] = $obj;
            } else {
                $obj->load($this->_array[$this->_position][0]);
                $this->_array[$this->_position][1] = $obj;
            }
        }
        return $this->_array[$this->_position][1];
    }

    /**
     * Key
     *
     * @access public
     * @return void
     */
    public function key() {
        return $this->_position;
    }

    /**
     * Next
     *
     * @access public
     * @return void
     */
    public function next() {
        ++$this->_position;
    }

    /**
     * Valid
     *
     * @access public
     * @return boolean
     */
    public function valid() {
        return isset($this->_array[$this->_position]);
    }

    /**
     * Add
     *
     * @param integer $num number or Object
     * 
     * @access public
     * @return void
     */
    public function add($object) {
        if ($object instanceof IYuju_Array) {
            $this->_count++;
            $this->_array[] = array($this->count()+1, $object);
        } elseif (!is_numeric($object)) {
            return false;
        } else {
            $this->_count++;
            $this->_array[] = array($object, null);
        }
    }

    /**
     * Delete
     *
     * @param number $num number
     * 
     * @return void
     */
    public function del($num) {
        //TODO: todo
    }

   /**
     * Count
     *
     * @access public
     * @return integer
     */
    public function count() {
        return $this->_count;
    }

     /**
     * GetNumRows
     *
     * @access public
     * @return integer
     */
    public function getNumRows() {
        return count($this->_array);
    }

    /**
     * Count
     *
     * @access public
     */
    public function setCount($count) {
        $this->_count = $count;
        return true;
    }

    /**
     * Set Key
     *
     * @param integer $num number
     * 
     * @access public
     * @return boolean
     */
    public function setkey($num) {
        if (is_numeric($num)) {
            $current = $this->_position;
            $this->_position = $num;
            if ($this->valid()) {
                return true;
            } else {
                $this->_position = $current;
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Exist a num
     *
     * @param integer $num number
     * 
     * @return boolean
     */
    public function exist($num) {
        foreach ($this->_array as $register) {
            if ($register[0] == $num) {
                return true;
            }
        }
        return false;
    }

    public function loadFromDB(&$return, $database_id, $num, $page) {

        if ($return->numRows() > 0) {
            $pagedResult = (($page - 1) * $num);  
            $return->seek($pagedResult);
            $this->setCount($return->numRows());

            if ($num > $this->count()) {
                $numreg = $this->count();
            } elseif (($this->count() - $pagedResult) < $num) {
                $numreg = ($this->count() - $pagedResult);
            } else {
                $numreg = $num;
            }

            for ($count = 0; $count < $numreg; $count++) {
                $register = $return->fetchObject();
                $this->add($register->$database_id);
            }
            $this->setCount($return->numRows());
        }
    }

}

?>