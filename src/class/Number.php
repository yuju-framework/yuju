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
     * Number integer
     *
     * @var integer
     */
    private $integer;

    /**
     * Number decimal
     *
     * @var integer
     */
    private $decimal;

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
     * Setter Type
     *
     * @param integer $type number type
     *
     * @return boolean
     * @since version 1.0
     */
    private function setType($type)
    {
        if ($type == Number::INTEGER
            || $type == Number::DECIMAL
            || $type == Number::FLOAT
        ) {
            $this->type = $type;
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
    private function setUnsigned($unsigned)
    {
        if (!is_bool($unsigned)) {
            $this->unsigned = true;
            return false;
        }
        $this->unsigned = $unsigned;
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
    private function setInteger($integer)
    {
        if ($this->type == Number::INTEGER) {
            $this->integer = null;
            return false;
        }
        $this->integer = $integer;
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
    private function setDecimal($decimal)
    {
        if ($this->type == Number::INTEGER) {
            $this->decimal = null;
            return false;
        }
        $this->decimal = $decimal;
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
    private function setMax($max)
    {
        $this->max = PHP_INT_MAX;
        if ($this->type == Number::INTEGER
            || $this->type == Number::DECIMAL
            || $this->type == Number::FLOAT
        ) {
            if (is_int($max)) {
                $this->max = $max;
            } else {
                $this->max = PHP_INT_MAX;
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
    private function setMin($min)
    {
        $this->min = -PHP_INT_MAX;
        if ($this->type == Number::INTEGER
            || $this->type == Number::DECIMAL
            || $this->type == Number::FLOAT
        ) {
            if (is_int($min)) {
                if ($this->unsigned && $min < 0) {
                    $this->min = 0;
                } else {
                    $this->min = $min;
                }
            } elseif ($this->unsigned) {
                $this->min = 0;
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
        $this->setType($type);
        $this->setUnsigned($unsigned);
        $this->setInteger($integer);
        $this->setDecimal($decimal);
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
     * Getter value to database format
     *
     * @return integer|string
     */
    public function getValueToDB()
    {
        if (!is_null($this->value)) {
            return $this->value;
        } else {
            return 'NULL';
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
        } elseif ($this->type == Number::DECIMAL) {
            if (Number::countNumbers($var) > $this->integer
                || Number::countDecimals($var) > $this->decimal
            ) {
                return false;
            }
            $maxDecimals=$this->decimal;
            $var=number_format($var, $maxDecimals, '.', '');
        } elseif ($this->type == Number::FLOAT) {
            $maxDecimals=$this->decimal;
            $var=number_format($var, $maxDecimals, '.', '');
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
            return DB::parse($this->value);
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
