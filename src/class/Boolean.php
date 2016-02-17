<?php
/**
 * File Boolean class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
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
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Boolean
{
    /**
     * Value
     *
     * @var    boolean
     * @access protected
     */
    private $value;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->value= null;
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
        if ($val === 0 || $val === 1 || $val === true || $val === false) {
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
        if ($this->isBoolean($this->value)) {
            return $this->value;
        }
    }

    /**
     * Getter value to datbase
     *
     * @return integer
     */
    public function getValueToDB()
    {
        if ($this->value === null) {
            return 'NULL';
        } elseif ($this->value === true) {
            return 1;
        } else {
            return 0;
        }
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
        if ($val === null || $val === '') {
            $this->value=null;
            return true;
        } elseif ($this->isBoolean($val)) {
            if ($val===1 || $val === true) {
                $this->value = true;
            } else {
                $this->value = false;
            }
            return true;
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
        if ($this->value == 1) {
            return _('Yes');
        } elseif ($this->value == 0) {
            return _('No');
        }
    }
}
