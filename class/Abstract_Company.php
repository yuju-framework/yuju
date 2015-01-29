<?php
/**
 * Abstract_Company File
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
 * @version  SVN: $Id: Abstract_Company.php 127 2013-08-27 15:13:44Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * Class Abstract_Company
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
abstract class Abstract_Company implements IYuju_Array
{
    /**
     * Id
     * @var number
     */
    protected $id;
    /**
     * Trade name
     * @var string
     */
    protected $tradename;
    /**
     * Business name
     * @var string
     */
    protected $businessname;
    /**
     * Legal Id
     * @var string
     */
    protected $legalid;
    /**
     * Address
     * @var string
     */
    protected $address;
    
    /**
     * Street
     * @var string
     */
    protected $street;
    
    /**
     * Street Number
     * @var string
     */
    protected $streetnumber;
    
    /**
     * City
     * @var string
     */
    protected $city;
    
    /**
     * Telephone
     * @var string
     */
    protected $telephone;
    
    /**
     * Quotations
     * 
     * @var Yuju_Array
     */
    protected $quotations;
    
    /**
     * Getter Id
     * 
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }
    
    
    /**
     * Setter Id
     * 
     * @param number $id Id
     * 
     * @return boolean
     */
    public function setId($id)
    {
        if (is_numeric($id)) {
            $this->id=$id;
            return true;
        }
        return false;
    }
    
    /**
     * Getter Trade name
     * 
     * @return string
     */
    public function getTradeName()
    {
        return $this->tradename;
    }
    
    /**
     * Setter Trade name
     * 
     * @param string $var trade name
     * 
     * @return boolean
     */
    public function setTradeName($var)
    {
        $this->tradename=$var;
        return true;
    }
    
    /**
     * Getter business name
     * 
     * @return string
     */
    public function getBusinessName()
    {
        return $this->businessname;
    }
    
    
    /**
     * Setter business name
     * 
     * @param string $var business name
     * 
     * @return boolean
     */
    public function setBusinessName($var)
    {
        $this->businessname=$var;
        return true;
    }
    
    /**
     * Getter legal Id
     * 
     * @return string
     */
    public function getLegalId()
    {
        return $this->legalid;
    }
    
    /**
     * Setter legal id
     * 
     * @param string $var legal id
     * 
     * @return boolean
     */
    public function setLegalId($var)
    {
        $this->legalid=$var;
        return true;
    }
    
    /**
     * Getter address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Setter address
     *
     * @param string $var street
     * 
     * @return void
     */
    public function setAddress($var)
    {
        $this->address=$var;
    }
    
    /**
     * Getter street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }
    
    /**
     * Setter street
     *
     * @param string $var street
     * 
     * @return void
     */
    public function setStreet($var)
    {
        $this->street=$var;
    }
    
    /**
     * Getter street number
     *
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetnumber;
    }
    
    /**
     * Setter street number
     *
     * @param string $var street number
     * 
     * @return void
     */
    public function setStreetNumber($var)
    {
        $this->streetnumber=$var;
    }
    
    /**
     * Getter city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * Setter city
     *
     * @param string $var city
     * 
     * @return void
     */
    public function setCity($var)
    {
        $this->city=$var;
    }
    
    /**
     * Getter telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
    
    /**
     * Setter telephone
     *
     * @param string $var telephone
     * 
     * @return void
     */
    public function setTelephone($var)
    {
        $this->telephone=$var;
    }
    
    /**
     * Get all quotations
     *
     * @return Yuju_Array
     */
    public function getQuotations()
    {
        $return=DB::query(
            'SELECT * FROM quotations WHERE idcompany='.DB::parse($this->id)
        );
        return $this->quotations;
    }
    
    /**
     * Load company
     * 
     * @param integer $id Id
     * 
     * @return void
     */
    public function load($id)
    {
        if (is_numeric($id)) {
            $return=DB::Query('SELECT * FROM company WHERE id='.DB::parse($id));
            if ($return->numRows()>0) {
                $company=$return->fetchObject();
                $this->id=$company->id;
                $this->tradename=$company->tradename;
                $this->businessname=$company->businessname;
                $this->legalid=$company->legalid;
                $this->address=$company->address;
            }
        }
    }
    
    /**
     * Insert company
     * 
     * @return boolean
     */
    public function insert()
    {
        $sql='INSERT INTO company ';
        $sql.='(tradename,businessname,legalid,';
        $sql.='address) ';
        $sql.='VALUES(\''.DB::parse($this->tradename).'\',';
        $sql.='\''.DB::parse($this->businessname).'\',';
        $sql.='\''.DB::parse($this->legalid).'\',';
        $sql.='\''.DB::parse($this->address).'\')';
        if (DB::query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Update company
     * 
     * @return boolean
     */
    public function update()
    {
        return false;
    }
    
    /**
     * Delete company
     * 
     * @return boolean
     */
    public function delete()
    {
        return false;
    }
    
    
    /**
     * Get all objects
     * 
     * @return Yuju_Array
     */
    public static function getAll()
    {
        $companies= new Yuju_Array(new Company());
        $return=DB::query('SELECT id FROM company');
        if ($return->numRows()>0) {
            while ($result=$return->fetchObject()) {
                $companies->add($result->id);
            }
        }
        return $companies;
    }
}
?>