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
     * @var    int
     * @access protected
     */
    private $value;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->value= 0;
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
        return $this->value;
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
            $this->value=intval($val);
            return true;
        } else {
            if ($val==null || $val=='') {
                $this->value='NULL';
                return true;
            }
        }
        return false;
    }

    public function getBoolean()
    {
        if ($this->value == 1) {
            return true;
        } else {
            return false;
        }
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
