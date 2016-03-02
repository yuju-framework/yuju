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

namespace YujuFramework;

use \Exception;

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
    const FLOAT = 2;

    /**
     * Value
     *
     * @var mixed
     */
    private $value;

    /**
     * Number type
     *
     * @var integer
     */
    private $type;

    /**
     * Unsigned
     *
     * @var boolean
     */
    private $unsigned;

    /**
     * Precision on FLOAT type
     *
     * @var integer
     */
    private $precision;

    /**
     * Maximum
     *
     * @var mixed
     */
    private $max;

    /**
     * Minimum value
     *
     * @var mixed
     */
    private $min;

    /**
     * Constructor
     *
     * @param integer $type      type
     * @param boolean $unsigned  unsigned
     * @param integer $precision number precision for FLOAT type
     * @param mixed   $max       max number
     * @param mixed   $min       min number
     */
    public function __construct(
        $type = Number::INTEGER,
        $unsigned = false,
        $precision = null,
        $max = null,
        $min = null
    ) {
        $this->setType($type);
        $this->setUnsigned($unsigned);
        $this->setPrecision($precision);
        $this->setMax($max);
        $this->setMin($min);

        $this->value = null;
    }

    /**
     * Getter value
     *
     * @return integer|NULL
     */
    public function getValue()
    {
        if (!is_null($this->value)) {
            return $this->value;
        } else {
            return null;
        }
    }

    /**
     * Setter Type
     *
     * @param integer $type number type
     *
     * @return void
     * @since version 1.0
     */
    private function setType($type)
    {
        if ($type == Number::INTEGER || $type == Number::FLOAT) {
            $this->type = $type;
        } else {
            throw new Exception('Number type undefined');
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
    private function setUnsigned($unsigned)
    {
        if (!is_bool($unsigned)) {
            throw new Exception('Unsigned type is not boolean');
        }
        $this->unsigned = $unsigned;
        return true;
    }

    /**
     * Setter precision
     *
     * @param integer $precision precision for FLOAT type
     *
     * @return void
     * @since version 1.0
     */
    private function setPrecision($precision)
    {
        if ($this->type == Number::INTEGER) {
            if ($precision !== null) {
                throw new Exception('Integer can not set precision');
            } else {
                $this->precision = null;
            }
        } else {
            if (is_int($precision) || $precision == null) {
                $this->precision = $precision;
            } else {
                throw new Exception('Precision not number');
            }
        }
    }

    /**
     * Setter Max value
     *
     * @param number $max max value
     *
     * @return boolean
     * @since version 1.0
     */
    private function setMax($max)
    {
        $this->max = PHP_INT_MAX;
        if (is_int($max)) {
            $this->max = $max;
        } elseif ($max !== null) {
            throw new Exception('Max value not number');
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
    private function setMin($min)
    {
        if ($this->unsigned) {
            $this->min = 0;
        } else {
            $this->min = -PHP_INT_MAX;
        }
        if (is_int($min)) {
            if ($this->unsigned && $min < 0) {
                throw new Exception('Set min value for unsigned not valid');
            } else {
                $this->min = $min;
            }
        } elseif ($min !== null) {
            throw new Exception('Min value not number');
        }
    }

    /**
     * Setter value
     *
     * @param unknowntype $var value
     *
     * @return boolean
     */
    public function setValue($var)
    {
        if ($var == '' || $var === null) {
            $this->value = null;
            return true;
        }
        if (!is_numeric($var) || $this->max < $var || $this->min > $var) {
            return false;
        }
        $var = 0 + $var;
        if ($this->type == Number::INTEGER) {
            if (!is_int($var)) {
                return false;
            }
        } else {
            if ($this->countPrecision($var) > $this->precision) {
                return false;
            }
            $var = number_format($var, $this->precision, '.', '');
        }
        
        $this->value = $var;
        return true;
    }

    /**
     * To database
     *
     * @return string
     */
    public function toDB()
    {
        if ($this->value == null) {
            return 'NULL';
        } else {
            return $this->value;
        }
    }

    /**
     * Get number of precision
     *
     * @param number $var number
     *
     * @return number|boolean
     */
    private function countPrecision($var)
    {
        if ((int) $var == $var) {
            return 0;
        }
        
        $ex = explode(".", $var);
        return strlen($ex[1]);
    }
}
