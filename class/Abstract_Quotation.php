<?php
/**
 * Abstract_Quotation File
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
 * Class Abstract_Quotation
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
abstract class Abstract_Quotation implements IYuju_Array
{
    /**
     * Id
     * 
     * @var string
     */
    protected $id;
    
    /**
     * Date
     * @var Date
     */
    protected $date;
    
    /**
     * Date valid
     * @var Date
     */
    protected $datevalid;
    
    /**
     * Customer Id
     * 
     * @var number
     */
    protected $idcustomer;
    
    /**
     * Customer Id
     * 
     * @var number
     */
    protected $idcompany;
    
    /**
     * Array Detail
     * 
     * @var array
     */
    protected $details;
    
    /**
     * Conditions
     * 
     * @var string
     */
    protected $conditions;
    
    /**
     * Subtotal
     * 
     * @var decimal
     */
    protected $subtotal;
    
    /**
     * Total
     * 
     * @var decimal
     */
    protected $total;
    
    /**
     * Getter Id
     * 
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Setter Id
     * 
     * @param string $val id
     * 
     * @return boolean
     */
    public function setId($val)
    {
        $this->id=$val;
        return true;
    }
    
    /**
     * Geter date
     *
     * @return Date
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * Getter id customer
     *
     * @return integer
     */
    public function getIdCustomer()
    {
        return $this->idcustomer;
    }
    
    /**
     * Setter id customer
     *
     * @param integer $var id
     * 
     * @return boolean
     */
    public function setIdCustomer($var)
    {
        if (is_numeric($var)) {
            $this->idcustomer=$var;
            return true;
        }
        return false;
    }
    
    /**
     * Getter id company
     *
     * @return integer
     */
    public function getIdCompany()
    {
        return $this->idcompany;
    }
    
    /**
     * Setter id company
     *
     * @param integer $var id
     * 
     * @return boolean
     */
    public function setIdCompany($var)
    {
        if (is_numeric($var)) {
            $this->idcompany=$var;
            return true;
        }
        return false;
    }
    
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->date      = new Date();
        $this->datevalid = new Date();
        $this->details   = array();
    }
    
    /**
     * Load Contacto
     *
     * @param mixed $var Id or DB_Result fetch object
     *
     * @return boolean
     */
    abstract public function load($var);
    
    /**
     * Insert Quotation
     * 
     * @return boolean
     */
    abstract public function insert();
    
    /**
     * Update Quotation
     * 
     * @return boolean
     */
    abstract public function update();
    
    /**
     * Delete Quotation
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
        return Quotation::search(array());
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
