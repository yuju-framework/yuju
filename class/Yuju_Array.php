<?php
/**
 * Yujuarray Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Class Yujuarray
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Yujuarray implements Iterator
{

    /**
     * Position
     *
     * @var    integer
     * @access private
     */
    private $position = 0;

    /**
     * Array
     *
     * @var    array
     * @access private
     */
    private $array = array();

    private $count = 0;

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
        $this->position = 0;
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
        return $this->array[$this->position];
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
        return $this->position;
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
        ++$this->position;
    }

    /**
     * Valid
     *
     * @access public
     * @return boolean
     */
    public function valid()
    {
        return isset($this->array[$this->position]);
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
        $this->count++;
        $this->array[] = clone($object);
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
        return $this->count;
    }

     /**
     * GetRows
     *
     * @access public
     * @return integer
     */
    public function getRows()
    {
        return count($this->array);
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
        $this->count = $count;
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
            $current = $this->position;
            $this->position = $num;
            if ($this->valid()) {
                return true;
            } else {
                $this->position = $current;
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
        foreach ($this->array as $register) {
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
     * @param IYujuarray $object  object
     * @param string      $num     num rows
     * @param string      $page    page number
     *
     * @return void
     */
    public function loadFromDB(&$return, IYujuarray $object, $num = null, $page = null)
    {
        if ($return->numRows() > 0) {
            if ($num == null || $page == null) {
                while ($register = $return->fetchObject()) {
                    $obj = clone($object);
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

    public function toJson(&$return, IYujuarray $object, $num = null, $page = null)
    {
        $array = array();
        if ($return->numRows() > 0) {
            if ($num == null || $page == null) {
                while ($register = $return->fetchObject()) {
                    $obj = clone($object);
                    $obj->load($register);
                    $array [] = $obj->jsonSerialize(true);
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
                    $array = $obj->jsonSerialize(true);
                }
            }
        }
        return json_encode($array);
    }
}
