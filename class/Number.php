<?php
/**
 * Number File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Number Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Number
{

    const INTEGER = 1;
    const DECIMAL = 2;
    const FLOAT = 3;

    /**
     * Value
     *
     * @var mixed
     */
    private $_value;

    /**
     * Number type
     *
     * @var integer
     */
    private $_type;

    /**
     * Unsigned
     *
     * @var boolean
     */
    private $_unsigned;

    /**
     * Number integer
     *
     * @var integer
     */
    private $_integer;

    /**
     * Number decimal
     *
     * @var integer
     */
    private $_decimal;

    /**
     * Maximum
     *
     * @var mixed
     */
    private $_max;

    /**
     * Minimum value
     *
     * @var mixed
     */
    private $_min;

    /**
     * Setter Type
     *
     * @param integer $type number type
     *
     * @return boolean
     * @since version 1.0
     */
    private function _setType($type)
    {
        if ($type == Number::INTEGER
            || $type == Number::DECIMAL
            || $type == Number::FLOAT
        ) {
            $this->_type = $type;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Setter Unsigned
     *
     * @param boolean $unsigned unsigned
     *
     * @return boolean
     * @since version 1.0
     */
    private function _setUnsigned($unsigned)
    {
        if (!is_bool($unsigned)) {
            $this->_unsigned = true;
            return false;
        }
        $this->_unsigned = $unsigned;
        return true;
    }

    /**
     * Setter Integer
     *
     * @param integer $integer integer
     *
     * @return boolean
     * @since version 1.0
     */
    private function _setInteger($integer)
    {
        if ($this->_type == Number::INTEGER) {
            $this->_integer = null;
            return false;
        }
        $this->_integer = $integer;
        return true;
    }

    /**
     * Setter decimal
     *
     * @param integer $decimal decimal
     *
     * @return boolean
     * @since version 1.0
     */
    private function _setDecimal($decimal)
    {
        if ($this->_type == Number::INTEGER) {
            $this->_decimal = null;
            return false;
        }
        $this->_decimal = $decimal;
        return true;
    }

    /**
     * Setter Max value
     *
     * @param number $max max value
     *
     * @return boolean
     * @since version 1.0
     */
    private function _setMax($max)
    {
        $this->_max = PHP_INT_MAX;
        if ($this->_type == Number::INTEGER
            || $this->_type == Number::DECIMAL
            || $this->_type == Number::FLOAT
        ) {
            if (is_int($max)) {
                $this->_max = $max;
            } else {
                $this->_max = PHP_INT_MAX;
            }
        }
    }

    /**
     * Setter Min value
     *
     * @param number $min min value
     *
     * @return boolean
     * @since version 1.0
     */
    private function _setMin($min)
    {
        $this->_min = -PHP_INT_MAX;
        if ($this->_type == Number::INTEGER
            || $this->_type == Number::DECIMAL
            || $this->_type == Number::FLOAT
        ) {
            if (is_int($min)) {
                if ($this->_unsigned && $min < 0) {
                    $this->_min = 0;
                } else {
                    $this->_min = $min;
                }
            } elseif ($this->_unsigned) {
                $this->_min = 0;
            }
        }
    }

    /**
     * Constructor
     *
     * @param integer $type     type
     * @param boolean $unsigned unsigned
     * @param integer $integer  number integer part
     * @param integer $decimal  number decimal part
     * @param mixed   $max      max number
     * @param mixed   $min      min number
     */
    public function __construct(
        $type = Number::INTEGER,
        $unsigned = false,
        $integer = null,
        $decimal = null,
        $max = null,
        $min = null
    ) {
        $this->_setType($type);
        $this->_setUnsigned($unsigned);
        $this->_setInteger($integer);
        $this->_setDecimal($decimal);
        $this->_setMax($max);
        $this->_setMin($min);

        $this->_value = null;
    }

    /**
     * Getter value
     *
     * @return integer|NULL
     */
    public function getValue()
    {
        if (!is_null($this->_value)) {
            return $this->_value;
        } else {
            return null;
        }
    }

    /**
     * Getter value to database format
     *
     * @return integer|string
     */
    public function getValueToDB()
    {
        if (!is_null($this->_value)) {
            return $this->_value;
        } else {
            return 'NULL';
        }
    }

    /**
     * Setter value
     *
     * @param unknown_type $var value
     *
     * @return boolean
     */
    public function setValue($var)
    {
        if ($var == '' || $var === null) {
            $this->_value = null;
            return true;
        }
        if (!is_numeric($var) || $this->_max < $var || $this->_min > $var) {
            return false;
        }
        $var = 0 + $var;
        if ($this->_type == Number::INTEGER) {
            if (!is_int($var)) {
                return false;
            }
        } elseif ($this->_type == Number::DECIMAL) {
            if (Number::countNumbers($var) > $this->_integer
                || Number::countDecimals($var) > $this->_decimal
            ) {
                return false;
            }
            $maxDecimals=$this->_decimal;
            $var=number_format($var, $maxDecimals, '.', '');
        } elseif ($this->_type == Number::FLOAT) {
            $maxDecimals=$this->_decimal;
            $var=number_format($var, $maxDecimals, '.', '');
        }
        $this->_value = $var;
        return true;
    }

    /**
     * To database
     *
     * @return string
     */
    public function toDB()
    {
        if ($this->_value == null) {
            return 'NULL';
        } else {
            return DB::parse($this->_value);
        }
    }

    /**
     * Get number of decimals
     *
     * @param number $var number
     *
     * @return number|boolean
     */
    public static function countDecimals($var)
    {
        if ((int) $var == $var) {
            return 0;
        } elseif (!is_numeric($var)) {
            return false;
        }

        $ex = explode(".", $var);
        if (count($ex)==1) {
            return 0;
        } else {
            return strlen($ex[1]);
        }
    }

    /**
     * Get integer of number
     *
     * @param number $var number
     *
     * @return boolean|number
     */
    public static function countNumbers($var)
    {
        if (!is_numeric($var)) {
            return false;
        }
        $ex = explode(".", $var);
        $ex[0] = str_replace('-', '', $ex[0]);
        return strlen($ex[0]);
    }
}
