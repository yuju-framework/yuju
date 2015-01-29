<?php

/**
 * Abstract_Invoice File
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
 * Abstract_Invoice Class
 *
 * @category XXX
 * @package  XXX
 * @author   XXX <xxx@xxx.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: XXX
 * @link     XXX
 * @since    XXX
 */
abstract class Abstract_Invoice implements IYuju_Array
{

    protected $id;
    protected $date;
    protected $due_date;
    protected $number;
    protected $pre_number;
    protected $post_number;
    protected $customer_name;
    protected $customer_address;
    protected $customer_vat;
    protected $self_name;
    protected $self_address;
    protected $self_vat;
    protected $subtotal;
    protected $discount_percent;
    protected $discount_fixed;
    protected $taxes;
    protected $total;
    protected $payment_text;
    protected $obs;
    protected $quotation;
    protected $idcustomer;

    /**
     * Constructor 
     *
     */
    public function __construct()
    {
        $this->id=new Number();
        $this->date=new Date();
        $this->due_date=new Date();
        $this->number=new Number();
        $this->subtotal=new Number(Number::DECIMAL, true, 999999999999999999, 999999999999999999, null, null);
        $this->discount_percent=new Number();
        $this->discount_fixed=new Number(Number::DECIMAL, true, 999999999999999999, 999999999999999999, null, null);
        $this->taxes=new Number(Number::DECIMAL, true, 999999999999999999, 999999999999999999, null, null);
        $this->total=new Number(Number::DECIMAL, true, 999999999999999999, 999999999999999999, null, null);
        $this->quotation=new Number();
        $this->idcustomer=new Number();
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
     * Getter date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Getter due_date
     *
     * @return date
     */
    public function getDue_date()
    {
        return $this->due_date;
    }

    /**
     * Getter number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Getter pre_number
     *
     * @return varchar
     */
    public function getPre_number()
    {
        return $this->pre_number;
    }

    /**
     * Setter pre_number
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setPre_number($var)
    {
        $this->pre_number=$var;
        return true;
    }

    /**
     * Getter post_number
     *
     * @return varchar
     */
    public function getPost_number()
    {
        return $this->post_number;
    }

    /**
     * Setter post_number
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setPost_number($var)
    {
        $this->post_number=$var;
        return true;
    }

    /**
     * Getter customer_name
     *
     * @return varchar
     */
    public function getCustomer_name()
    {
        return $this->customer_name;
    }

    /**
     * Setter customer_name
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setCustomer_name($var)
    {
        $this->customer_name=$var;
        return true;
    }

    /**
     * Getter customer_address
     *
     * @return varchar
     */
    public function getCustomer_address()
    {
        return $this->customer_address;
    }

    /**
     * Setter customer_address
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setCustomer_address($var)
    {
        $this->customer_address=$var;
        return true;
    }

    /**
     * Getter customer_vat
     *
     * @return varchar
     */
    public function getCustomer_vat()
    {
        return $this->customer_vat;
    }

    /**
     * Setter customer_vat
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setCustomer_vat($var)
    {
        $this->customer_vat=$var;
        return true;
    }

    /**
     * Getter self_name
     *
     * @return varchar
     */
    public function getSelf_name()
    {
        return $this->self_name;
    }

    /**
     * Setter self_name
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setSelf_name($var)
    {
        $this->self_name=$var;
        return true;
    }

    /**
     * Getter self_address
     *
     * @return varchar
     */
    public function getSelf_address()
    {
        return $this->self_address;
    }

    /**
     * Setter self_address
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setSelf_address($var)
    {
        $this->self_address=$var;
        return true;
    }

    /**
     * Getter self_vat
     *
     * @return varchar
     */
    public function getSelf_vat()
    {
        return $this->self_vat;
    }

    /**
     * Setter self_vat
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setSelf_vat($var)
    {
        $this->self_vat=$var;
        return true;
    }

    /**
     * Getter subtotal
     *
     * @return decimal
     */
    public function getSubtotal()
    {
        return $this->subtotal;
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
     * Getter taxes
     *
     * @return decimal
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * Getter total
     *
     * @return decimal
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Getter payment_text
     *
     * @return text
     */
    public function getPayment_text()
    {
        return $this->payment_text;
    }

    /**
     * Setter payment_text
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setPayment_text($var)
    {
        $this->payment_text=$var;
        return true;
    }

    /**
     * Getter obs
     *
     * @return text
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
        $this->obs=$var;
        return true;
    }

    /**
     * Getter quotation
     *
     * @return int
     */
    public function getQuotation()
    {
        return $this->quotation;
    }

    public function getIdcustomer()
    {
        return $this->idcustomer;
    }

    /**
     * Load Invoice
     *
     * @param integer $id Id
     *
     * @return boolean
     */
    abstract public function load($id);

    /**
     * Insert Invoice
     *
     * @return boolean
     */
    abstract public function insert();

    /**
     * Update Invoice
     *
     * @return boolean
     */
    abstract public function update();

    /**
     * Delete Invoice
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
        return Invoice::search(array());
    }

    /**
     * Return Array
     *
     * @return Array
     */
    public static function search(array $parametros, $num=null, $page=null, $yuju=true)
    {
        if ($yuju) {
            $array=new Yuju_Array(new Invoice());
        } else {
            $array=array();
        }
        $where="";
        foreach ($parametros as $key=> $param) {
            switch ($key) {
                case "eq-date":
                    $where.='`date` =\''.DB::Parse($param).'\' AND ';
                    break;
                case "ini-date":
                    $where.='`date` >= \''.DB::Parse($param).'\' AND ';
                    break;
                case "end-date":
                    $where.='`date` <= \''.DB::Parse($param).'\' AND ';
                    break;
                case "eq-due_date":
                    $where.='`due_date` =\''.DB::Parse($param).'\' AND ';
                    break;
                case "ini-due_date":
                    $where.='`due_date` >= \''.DB::Parse($param).'\' AND ';
                    break;
                case "end-due_date":
                    $where.='`due_date` <= \''.DB::Parse($param).'\' AND ';
                    break;
                case "eq-number":
                    if (is_numeric($param)) {
                        $where.='`number` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in eq-number is not a number");
                    }
                    break;
                case "like-number":
                    if (is_numeric($param)) {
                        $where.='`number` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in like-number is not a number");
                    }
                    break;
                case "from-number":
                    if (is_numeric($param)) {
                        $where.='`number` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in from-number is not a number");
                    }
                    break;
                case "to-number":
                    if (is_numeric($param)) {
                        $where.='`number` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in to-number, is not a number");
                    }
                    break;
                case "like-pre_number":
                    $where.='pre_number LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-pre_number":
                    $where.='pre_number =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-post_number":
                    $where.='post_number LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-post_number":
                    $where.='post_number =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-customer_name":
                    $where.='customer_name LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-customer_name":
                    $where.='customer_name =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-customer_address":
                    $where.='customer_address LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-customer_address":
                    $where.='customer_address =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-customer_vat":
                    $where.='customer_vat LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-customer_vat":
                    $where.='customer_vat =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-self_name":
                    $where.='self_name LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-self_name":
                    $where.='self_name =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-self_address":
                    $where.='self_address LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-self_address":
                    $where.='self_address =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-self_vat":
                    $where.='self_vat LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-self_vat":
                    $where.='self_vat =\''.DB::Parse($param).'\' AND ';
                    break;
                case "eq-subtotal":
                    if (is_numeric($param)) {
                        $where.='`subtotal` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in eq-subtotal is not a number");
                    }
                    break;
                case "like-subtotal":
                    if (is_numeric($param)) {
                        $where.='`subtotal` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in like-subtotal is not a number");
                    }
                    break;
                case "from-subtotal":
                    if (is_numeric($param)) {
                        $where.='`subtotal` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in from-subtotal is not a number");
                    }
                    break;
                case "to-subtotal":
                    if (is_numeric($param)) {
                        $where.='`subtotal` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in to-subtotal, is not a number");
                    }
                    break;
                case "eq-discount_percent":
                    if (is_numeric($param)) {
                        $where.='`discount_percent` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in eq-discount_percent is not a number");
                    }
                    break;
                case "like-discount_percent":
                    if (is_numeric($param)) {
                        $where.='`discount_percent` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in like-discount_percent is not a number");
                    }
                    break;
                case "from-discount_percent":
                    if (is_numeric($param)) {
                        $where.='`discount_percent` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in from-discount_percent is not a number");
                    }
                    break;
                case "to-discount_percent":
                    if (is_numeric($param)) {
                        $where.='`discount_percent` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in to-discount_percent, is not a number");
                    }
                    break;
                case "eq-discount_fixed":
                    if (is_numeric($param)) {
                        $where.='`discount_fixed` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in eq-discount_fixed is not a number");
                    }
                    break;
                case "like-discount_fixed":
                    if (is_numeric($param)) {
                        $where.='`discount_fixed` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in like-discount_fixed is not a number");
                    }
                    break;
                case "from-discount_fixed":
                    if (is_numeric($param)) {
                        $where.='`discount_fixed` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in from-discount_fixed is not a number");
                    }
                    break;
                case "to-discount_fixed":
                    if (is_numeric($param)) {
                        $where.='`discount_fixed` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in to-discount_fixed, is not a number");
                    }
                    break;
                case "eq-taxes":
                    if (is_numeric($param)) {
                        $where.='`taxes` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in eq-taxes is not a number");
                    }
                    break;
                case "like-taxes":
                    if (is_numeric($param)) {
                        $where.='`taxes` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in like-taxes is not a number");
                    }
                    break;
                case "from-taxes":
                    if (is_numeric($param)) {
                        $where.='`taxes` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in from-taxes is not a number");
                    }
                    break;
                case "to-taxes":
                    if (is_numeric($param)) {
                        $where.='`taxes` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in to-taxes, is not a number");
                    }
                    break;
                case "eq-total":
                    if (is_numeric($param)) {
                        $where.='`total` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in eq-total is not a number");
                    }
                    break;
                case "like-total":
                    if (is_numeric($param)) {
                        $where.='`total` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in like-total is not a number");
                    }
                    break;
                case "from-total":
                    if (is_numeric($param)) {
                        $where.='`total` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in from-total is not a number");
                    }
                    break;
                case "to-total":
                    if (is_numeric($param)) {
                        $where.='`total` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in to-total, is not a number");
                    }
                    break;
                case "like-payment_text":
                    $where.='payment_text LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-payment_text":
                    $where.='payment_text =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-obs":
                    $where.='obs LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-obs":
                    $where.='obs =\''.DB::Parse($param).'\' AND ';
                    break;
                case "eq-quotation":
                    if (is_numeric($param)) {
                        $where.='`quotation` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in eq-quotation is not a number");
                    }
                    break;
                case "like-quotation":
                    if (is_numeric($param)) {
                        $where.='`quotation` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in like-quotation is not a number");
                    }
                    break;
                case "from-quotation":
                    if (is_numeric($param)) {
                        $where.='`quotation` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in from-quotation is not a number");
                    }
                    break;
                case "to-quotation":
                    if (is_numeric($param)) {
                        $where.='`quotation` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in to-quotation, is not a number");
                    }
                    break;
                case "eq-idcustomer":
                    if (is_numeric($param)) {
                        $where.='`idcustomer` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in eq-idcustomer is not a number");
                    }
                    break;
                case "like-idcustomer":
                    if (is_numeric($param)) {
                        $where.='`idcustomer` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in like-idcustomer is not a number");
                    }
                    break;
                case "from-idcustomer":
                    if (is_numeric($param)) {
                        $where.='`idcustomer` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in from-idcustomer is not a number");
                    }
                    break;
                case "to-idcustomer":
                    if (is_numeric($param)) {
                        $where.='`idcustomer` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("InvoiceSearchError", "You Cant insert $param in to-idcustomer, is not a number");
                    }
                    break;
            }
        }
        if (Error::haveError("InvoiceSearchError")) {
            return false;
        } else {
            if ($yuju) {
                $sql="SELECT id FROM ";
            } else {
                $sql="SELECT * FROM ";
            }
            $sql.="invoice";
            if ($where != "") {
                $where=" WHERE ".substr($where, 0, strlen($where) - 4);
            }
            $return=DB::Query($sql.$where);
            if ($num == null || $page == null) {
                if ($yuju) {
                    while ($invoice=$return->fetchObject()) {
                        $array->add($invoice->id);
                    }
                } else {
                    $array=$return->toArray();
                }
            } else {
                if ($yuju) {
                    $array->loadFromDB($return, "id", $num, $page);
                } else {
                    $array=$return->toArray($num, $page);
                }
            }
            return $array;
        }
    }

    public function getAllInvoiceItems()
    {
        $arr=new Yuju_Array(new Invoice_Item);

        $query=DB::Query("SELECT id FROM invoice_item WHERE idinvoice = ".$this->id->getValue());

        while ($result=$query->fetchObject()) {
            $arr->add($result->id);
        }
        return $arr;
    }

}
