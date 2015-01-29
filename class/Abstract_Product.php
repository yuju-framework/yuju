<?php

/**
 * Abstract_Product File
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
 * Abstract_Product Class
 *
 * @category XXX
 * @package  XXX
 * @author   XXX <xxx@xxx.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: XXX
 * @link     XXX
 * @since    XXX
 */
abstract class Abstract_Product implements IYuju_Array
{

    protected $id;
    protected $code;
    protected $name;
    protected $price;

    /**
     * Constructor 
     *
     */
    public function __construct()
    {
        $this->id=new Number();
        $this->price=new Number(Number::DECIMAL, true, 999999999999999999, 999999999999999999, null, null);
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
     * Getter code
     *
     * @return varchar
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Setter code
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setCode($var)
    {
        $this->code=$var;
        return true;
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
        $this->name=$var;
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
     * Load Product
     *
     * @param integer $id Id
     *
     * @return boolean
     */
    abstract public function load($id);

    /**
     * Insert Product
     *
     * @return boolean
     */
    abstract public function insert();

    /**
     * Update Product
     *
     * @return boolean
     */
    abstract public function update();

    /**
     * Delete Product
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
        return Product::search(array());
    }

    /**
     * Return Array
     *
     * @return Array
     */
    public static function search(array $parametros, $num=null, $page=null, $yuju=true)
    {
        if ($yuju) {
            $array=new Yuju_Array(new Product());
        } else {
            $array=array();
        }
        $where="";
        foreach ($parametros as $key=> $param) {
            switch ($key) {
                case "like-code":
                    $where.='code LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-code":
                    $where.='code =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-name":
                    $where.='name LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-name":
                    $where.='name =\''.DB::Parse($param).'\' AND ';
                    break;
                case "eq-price":
                    if (is_numeric($param)) {
                        $where.='`price` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("ProductSearchError", "You Cant insert $param in eq-price is not a number");
                    }
                    break;
                case "like-price":
                    if (is_numeric($param)) {
                        $where.='`price` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("ProductSearchError", "You Cant insert $param in like-price is not a number");
                    }
                    break;
                case "from-price":
                    if (is_numeric($param)) {
                        $where.='`price` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("ProductSearchError", "You Cant insert $param in from-price is not a number");
                    }
                    break;
                case "to-price":
                    if (is_numeric($param)) {
                        $where.='`price` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("ProductSearchError", "You Cant insert $param in to-price, is not a number");
                    }
                    break;
            }
        }
        if (Error::haveError("ProductSearchError")) {
            return false;
        } else {
            if ($yuju) {
                $sql="SELECT id FROM ";
            } else {
                $sql="SELECT * FROM ";
            }
            $sql.="product";
            if ($where != "") {
                $where=" WHERE ".substr($where, 0, strlen($where) - 4);
            }
            $return=DB::Query($sql.$where);
            if ($num == null || $page == null) {
                if ($yuju) {
                    while ($product=$return->fetchObject()) {
                        $array->add($product->id);
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

}
