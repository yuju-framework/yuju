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
 * @version  GIT: 
 * @link     https://github.com/yuju-framework/yuju
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
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Yuju_Array implements Iterator
{

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
    
    private $_count = 0;

    /**
     * Constructor
     * 
     * @access public
     */
    public function __construct()
    {
        
    }

    /**
     * Rewind
     *
     * @access public
     * 
     * @return void
     */
    public function rewind()
    {
        $this->_position = 0;
    }

    /**
     * Current
     *
     * @access public
     * 
     * @return object
     */
    public function current()
    {
        return $this->_array[$this->_position];
    }

    /**
     * Key
     *
     * @access public
     * 
     * @return void
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * Next
     *
     * @access public
     * 
     * @return void
     */
    public function next()
    {
        ++$this->_position;
    }

    /**
     * Valid
     *
     * @access public
     * @return boolean
     */
    public function valid()
    {
        return isset($this->_array[$this->_position]);
    }

    /**
     * Add object 
     * 
     * @param mixed $object number or Object
     * 
     * @access public
     * @return void
     */
    public function add($object)
    {
        $this->_count++;
        $this->_array[] = clone($object);
    }

    /**
     * Delete
     *
     * @param number $num number
     * 
     * @return void
     */
    public function del($num)
    {
        //TODO: todo
    }

    /**
     * Count
     *
     * @access public
     * @return integer
     */
    public function count()
    {
        return $this->_count;
    }

     /**
     * GetRows
     *
     * @access public
     * @return integer
     */
    public function getRows()
    {
        return count($this->_array);
    }

    /**
     * Count
     * 
     * @param integer $count count
     *
     * @access public
     * @return boolean
     */
    public function setCount($count)
    {
        $this->_count = $count;
        return true;
    }

    /**
     * Set Key
     *
     * @param integer $num number
     * 
     * @access public
     * 
     * @return boolean
     */
    public function setkey($num)
    {
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
    public function exist($num)
    {
        foreach ($this->_array as $register) {
            if ($register[0] == $num) {
                return true;
            }
        }
        return false;
    }

    /**
     * Load object from database
     * 
     * @param mixed       &$return return database object
     * @param IYuju_Array $object  object
     * @param string      $num     num rows
     * @param string      $page    page number
     * 
     * @return void
     */
    public function loadFromDB(&$return, IYuju_Array $object,
        $num = null, $page = null
    ) {
        if ($return->numRows() > 0) {
            if ($num == null || $page == null) {
                while ($register = $return->fetchObject()) {
                    $obj = $object;
                    $obj->load($register);
                    $this->add($obj);
                }
            } else {
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
                    $obj = $object;
                    $obj->load($register);
                    $this->add($obj);
                }
                $this->setCount($return->numRows());
            }
        }
    }
}
