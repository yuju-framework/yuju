<?php

/**
 * Number File
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
 * @version  SVN: $Id: Number.php 199 2015-03-03 10:45:53Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * Number Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
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
        if ($type == Number::INTEGER || $type == Number::DECIMAL || $type == Number::FLOAT) {
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
            $this->_decimal = NULL;
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
        $this->_max = 9999999999999999999999999999999999999999999999999999999;
        if ($this->_type == Number::INTEGER || $this->_type == Number::DECIMAL || $this->_type == Number::FLOAT) {
            if (is_int($max)) {
                $this->_max = $max;
            } else {
                $this->_max = 9999999999999999999999999999999999999999999999999999999;
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
        $this->_min = -9999999999999999999999999999999999999999999999999999999999999;
        if ($this->_type == Number::INTEGER || $this->_type == Number::DECIMAL || $this->_type == Number::FLOAT) {
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
    $type = Number::INTEGER, $unsigned = false, $integer = null, $decimal = null, $max = null, $min = null
    )
    {
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
        if (!is_numeric($var) || $this->_max < $var || $this->_min > $var) {
            return false;
        }
        $var = 0 + $var;
        if ($this->_type == Number::INTEGER) {
            if (!is_int($var)) {
                return false;
            }
        } elseif ($this->_type == Number::DECIMAL) {
            if (Number::countNumbers($var) > $this->_integer || Number::countDecimals($var) > $this->_decimal) {
                return false;
            }
            $maxDecimals=Number::countDecimals($this->_decimal);
            $var=number_format($var,$maxDecimals,'.','');                 
        } elseif ($this->_type == Number::FLOAT) {
            $maxDecimals=Number::countDecimals($this->_decimal);
            $var=number_format($var,$maxDecimals,'.','');                 
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
