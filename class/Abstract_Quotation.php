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
 * @version  SVN: $Id: Abstract_Quotation.php 78 2013-05-05 18:44:49Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
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
 * @link     http://sourceforge.net/projects/yuju/
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
     * Load
     *
     * @param integer $id id
     * 
     * @return void
     */
    public function load($id)
    {
        if (is_numeric($id)) {
            $return=DB::Query('SELECT * FROM quotation WHERE id='.DB::Parse($id));
            if ($return->numRows()>0) {
                $quotation=$return->fetchObject();
                $this->id=$quotation->id;
                $this->idcompany=$quotation->idcompany;
                $this->date->setDateFromDB($quotation->date);
                $this->datevalid->setDateFromDB($quotation->datevalid);
                $this->conditions=$quotation->conditions;
                $this->subtotal=$quotation->subtotal;
                $this->total=$quotation->total;
            }
        }
    }
    
    /**
     * Insert
     * 
     * @return boolean
     */
    abstract public function insert();
    
    /**
     * Update
     * 
     * @return boolean
     */
    abstract public function update();
    
    /**
     * Delete
     *
     * @return boolean
     */
    abstract public function delete();
    
    /**
     * Get all
     *
     * @return Yuju_Array
     */
    abstract public static function getAll();
}
?>