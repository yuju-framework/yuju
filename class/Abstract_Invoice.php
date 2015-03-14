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
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  GIT: 
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Abstract_Invoice Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
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
        $this->subtotal=new Number(Number::DECIMAL, true, 99, 2, null, null);
        $this->discount_percent=new Number();
        $this->discount_fixed=new Number(Number::DECIMAL, true, 99, 2, null, null);
        $this->taxes=new Number(Number::DECIMAL, true, 99, 2, null, null);
        $this->total=new Number(Number::DECIMAL, true, 99, 2, null, null);
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
    public function getDueDate()
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
    public function getPreNumber()
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
    public function setPreNumber($var)
    {
        $this->pre_number=$var;
        return true;
    }

    /**
     * Getter post_number
     *
     * @return varchar
     */
    public function getPostNumber()
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
    public function setPostNumber($var)
    {
        $this->post_number=$var;
        return true;
    }

    /**
     * Getter customer_name
     *
     * @return varchar
     */
    public function getCustomerName()
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
    public function setCustomerName($var)
    {
        $this->customer_name=$var;
        return true;
    }

    /**
     * Getter customer_address
     *
     * @return varchar
     */
    public function getCustomerAddress()
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
    public function setCustomerAddress($var)
    {
        $this->customer_address=$var;
        return true;
    }

    /**
     * Getter customer_vat
     *
     * @return varchar
     */
    public function getCustomerVAT()
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
    public function setCustomerVAT($var)
    {
        $this->customer_vat=$var;
        return true;
    }

    /**
     * Getter self_name
     *
     * @return varchar
     */
    public function getSelfName()
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
    public function setSelfName($var)
    {
        $this->self_name=$var;
        return true;
    }

    /**
     * Getter self_address
     *
     * @return varchar
     */
    public function getSelfAddress()
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
    public function setSelfAddress($var)
    {
        $this->self_address=$var;
        return true;
    }

    /**
     * Getter self_vat
     *
     * @return varchar
     */
    public function getSelfVAT()
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
    public function setSelfVAT($var)
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
    public function getPaymentText()
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
    public function setPaymentText($var)
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

    /**
     * Getter idcustomer
     * 
     * @return Number
     */
    public function getIdcustomer()
    {
        return $this->idcustomer;
    }

    /**
     * Load Invoice
     *
     * @param mixed $var Id or DB_Result fetch object
     *
     * @return boolean
     */
    abstract public function load($var);

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

    /**
     * Get invoice items
     * 
     * @return Yuju_Array
     */
    public function getAllInvoiceItems()
    {
        $arr=new Yuju_Array();

        $query=DB::Query(
            "SELECT * FROM invoice_item WHERE idinvoice = ".
            $this->id->getValue()
        );

        while ($result=$query->fetchObject()) {
            $invoice_item = new Invoice_Item();
            $invoice_item->load($result);
            $arr->add($invoice_item);
        }
        return $arr;
    }

}
