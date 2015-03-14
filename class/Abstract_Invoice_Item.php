<?php
/**
 * Abstract_Invoice_Item File
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
 * Abstract_Invoice_Item Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
abstract class Abstract_Invoice_Item implements IYuju_Array
{

    protected $id;

    protected $idinvoice;

    protected $name;

    protected $price;

    protected $units;

    protected $discount_percent;

    protected $discount_fixed;

    protected $tax;

    protected $obs;

    /**
     * Constructor 
     *
     */
    public function __construct()
    {
        $this->id = new Number();
        $this->idinvoice = new Number();
        $this->price = new Number(Number::DECIMAL, true, 99, 2, null, null);
        $this->units = new Number();
        $this->discount_percent = new Number();
        $this->discount_fixed = new Number(Number::DECIMAL, true, 99, 2, null, null);
        $this->tax = new Number(Number::DECIMAL, true, 99, 2, null, null);
    }

    /**
     * Getter id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter idinvoice
     *
     * @return int
     */
    public function getIdinvoice()
    {
        return $this->idinvoice;
    }

    /**
     * Getter name
     *
     * @return varchar
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter name
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setName($var)
    {
        $this->name = $var;
        return true;
    }

    /**
     * Getter price
     *
     * @return decimal
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Getter units
     *
     * @return decimal
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * Getter discount_percent
     *
     * @return int
     */
    public function getDiscountPercent()
    {
        return $this->discount_percent;
    }

    /**
     * Getter discount_fixed
     *
     * @return decimal
     */
    public function getDiscountFixed()
    {
        return $this->discount_fixed;
    }

    /**
     * Getter tax
     *
     * @return decimal
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Getter obs
     *
     * @return varchar
     */
    public function getObs()
    {
        return $this->obs;
    }

    /**
     * Setter obs
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setObs($var)
    {
        $this->obs = $var;
        return true;
    }

    /**
     * Load Invoice_Item
     *
     * @param mixed $var Id or DB_Result fetch object
     *
     * @return boolean
     */
    abstract public function load($var);
    
    /**
     * Insert Invoice_Item
     *
     * @return boolean
     */
    abstract public function insert();

    /**
     * Update Invoice_Item
     *
     * @return boolean
     */
    abstract public function update();

    /**
     * Delete Invoice_Item
     *
     * @return boolean
     */
    abstract public function delete();

    /**
     * Return all objects
     *
     * @return Yuju_Array
     */
    public static function getAll()
    {
        return Invoice_Item::search(array());
    }
    
    /**
     * Search function
     *
     * @param array   $parameters filter array
     * @param integer $num        number of elements
     * @param integer $page       page number
     * @param integer $yuju       return a Yuju_Array or array
     *
     * @return boolean|Yuju_Array
     */
     abstract public static function search(array $parameters, $num=null, 
         $page=null, $yuju=true
     );
}
