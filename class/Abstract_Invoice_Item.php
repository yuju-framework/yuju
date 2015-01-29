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
 * @category XXX
 * @package  XXX
 * @author   XXX <xxx@xxx.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  SVN: $Id: Yuju_ORM.php 153 2013-12-05 09:56:05Z cristianmv $
 * @link     XXX
 * @since    XXX
 */

/**
 * Abstract_Invoice_Item Class
 *
 * @category XXX
 * @package  XXX
 * @author   XXX <xxx@xxx.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: XXX
 * @link     XXX
 * @since    XXX
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
        $this->price = new Number(Number::DECIMAL, true, 999999999999999999, 999999999999999999, null, null);
        $this->units = new Number(Number::DECIMAL, true, 999999999999999999, 999999999999999999, null, null);
        $this->discount_percent = new Number();
        $this->discount_fixed = new Number(Number::DECIMAL, true, 999999999999999999, 999999999999999999, null, null);
        $this->tax = new Number(Number::DECIMAL, true, 999999999999999999, 999999999999999999, null, null);
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
    public function getDiscount_percent()
    {
        return $this->discount_percent;
    }

    /**
     * Getter discount_fixed
     *
     * @return decimal
     */
    public function getDiscount_fixed()
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
     * @param integer $id Id
     *
     * @return boolean
     */
    abstract public function load($id);
    
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
     * Return Array
     *
     * @return Array
     */
     public static function search(array $parametros, $num=null, $page=null, $yuju=true) {
        if ($yuju) {
            $array = new Yuju_Array(new Invoice_Item());
        } else {
                $array = array();
        } 
        $where = "";
        foreach ($parametros as $key => $param) {
            switch ($key) {
                case "eq-idinvoice":
                    if (is_numeric($param)) {
                        $where.='`idinvoice` =\'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in eq-idinvoice is not a number");
                    }
                    break;
                case "like-idinvoice":
                    if (is_numeric($param)) {
                        $where.='`idinvoice` LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in like-idinvoice is not a number");
                    }
                    break;
                case "from-idinvoice":
                    if (is_numeric($param)) {
                        $where.='`idinvoice` >= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in from-idinvoice is not a number");
                    }
                    break;
                case "to-idinvoice":
                    if (is_numeric($param)) {
                        $where.='`idinvoice` <= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in to-idinvoice, is not a number");
                    }
                    break;
                case "like-name":
                    $where.='name LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    break;
                case "eq-name":
                    $where.='name =\'' . DB::Parse($param) . '\' AND ';
                    break;
                case "eq-price":
                    if (is_numeric($param)) {
                        $where.='`price` =\'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in eq-price is not a number");
                    }
                    break;
                case "like-price":
                    if (is_numeric($param)) {
                        $where.='`price` LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in like-price is not a number");
                    }
                    break;
                case "from-price":
                    if (is_numeric($param)) {
                        $where.='`price` >= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in from-price is not a number");
                    }
                    break;
                case "to-price":
                    if (is_numeric($param)) {
                        $where.='`price` <= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in to-price, is not a number");
                    }
                    break;
                case "eq-units":
                    if (is_numeric($param)) {
                        $where.='`units` =\'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in eq-units is not a number");
                    }
                    break;
                case "like-units":
                    if (is_numeric($param)) {
                        $where.='`units` LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in like-units is not a number");
                    }
                    break;
                case "from-units":
                    if (is_numeric($param)) {
                        $where.='`units` >= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in from-units is not a number");
                    }
                    break;
                case "to-units":
                    if (is_numeric($param)) {
                        $where.='`units` <= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in to-units, is not a number");
                    }
                    break;
                case "eq-discount_percent":
                    if (is_numeric($param)) {
                        $where.='`discount_percent` =\'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in eq-discount_percent is not a number");
                    }
                    break;
                case "like-discount_percent":
                    if (is_numeric($param)) {
                        $where.='`discount_percent` LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in like-discount_percent is not a number");
                    }
                    break;
                case "from-discount_percent":
                    if (is_numeric($param)) {
                        $where.='`discount_percent` >= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in from-discount_percent is not a number");
                    }
                    break;
                case "to-discount_percent":
                    if (is_numeric($param)) {
                        $where.='`discount_percent` <= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in to-discount_percent, is not a number");
                    }
                    break;
                case "eq-discount_fixed":
                    if (is_numeric($param)) {
                        $where.='`discount_fixed` =\'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in eq-discount_fixed is not a number");
                    }
                    break;
                case "like-discount_fixed":
                    if (is_numeric($param)) {
                        $where.='`discount_fixed` LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in like-discount_fixed is not a number");
                    }
                    break;
                case "from-discount_fixed":
                    if (is_numeric($param)) {
                        $where.='`discount_fixed` >= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in from-discount_fixed is not a number");
                    }
                    break;
                case "to-discount_fixed":
                    if (is_numeric($param)) {
                        $where.='`discount_fixed` <= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in to-discount_fixed, is not a number");
                    }
                    break;
                case "eq-tax":
                    if (is_numeric($param)) {
                        $where.='`tax` =\'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in eq-tax is not a number");
                    }
                    break;
                case "like-tax":
                    if (is_numeric($param)) {
                        $where.='`tax` LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in like-tax is not a number");
                    }
                    break;
                case "from-tax":
                    if (is_numeric($param)) {
                        $where.='`tax` >= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in from-tax is not a number");
                    }
                    break;
                case "to-tax":
                    if (is_numeric($param)) {
                        $where.='`tax` <= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Invoice_ItemSearchError", "You Cant insert $param in to-tax, is not a number");
                    }
                    break;
                case "like-obs":
                    $where.='obs LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    break;
                case "eq-obs":
                    $where.='obs =\'' . DB::Parse($param) . '\' AND ';
                    break;
          }    
        } 
        if (Error::haveError("Invoice_ItemSearchError")) {
            return false;
        } else {
            if($yuju) {
                $sql = "SELECT id FROM "; 
            } else {
                $sql = "SELECT * FROM ";
            } 
            $sql.="invoice_item";
            if ($where != "") {
                $where = " WHERE " . substr($where, 0, strlen($where) - 4);
            }
            $return = DB::Query($sql . $where );
            if($num==null || $page==null) {
                if ($yuju) { 
                    while ($invoice_item = $return->fetchObject()) {
                        $array->add($invoice_item->id); 
                    } 
                } else { 
                    $array = $return->toArray();
                } 
            } else { 
                if ($yuju) { 
                    $array->loadFromDB($return,"id", $num, $page);
                } else { 
                    $array = $return->toArray($num, $page);
                } 
            } 
        return $array;
        } 
     }
}