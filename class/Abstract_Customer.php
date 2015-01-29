<?php

/**
 * Customer File
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
 * Customer Class
 *
 * @category XXX
 * @package  XXX
 * @author   XXX <xxx@xxx.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: XXX
 * @link     XXX
 * @since    XXX
 */
abstract class Abstract_Customer implements IYuju_Array
{

    protected $id;
    protected $name;
    protected $address;
    protected $vat;
    protected $tradename;
    protected $idcity;
    protected $cp;
    protected $idstate;
    protected $idcountry;

    /**
     * Constructor 
     *
     */
    public function __construct()
    {
        $this->id=new Number();
        $this->idcity=new Number();
        $this->idstate=new Number();
        $this->idcountry=new Number();
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
     * Getter address
     *
     * @return varchar
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Setter address
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setAddress($var)
    {
        $this->address=$var;
        return true;
    }

    /**
     * Getter vat
     *
     * @return varchar
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Setter vat
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setVat($var)
    {
        $this->vat=$var;
        return true;
    }

    /**
     * Getter tradename
     *
     * @return varchar
     */
    public function getTradename()
    {
        return $this->tradename;
    }

    /**
     * Setter tradename
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setTradename($var)
    {
        $this->tradename=$var;
        return true;
    }

    /**
     * Getter city
     *
     * @return varchar
     */
    public function getIdcity()
    {
        return $this->idcity;
    }

    public function getCity()
    {
        return State_City::idToString($this->idcity->getValue());
    }

    /**
     * Getter cp
     *
     * @return varchar
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Setter cp
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setCp($var)
    {
        $this->cp=$var;
        return true;
    }

    /**
     * Getter state
     *
     * @return varchar
     */
    public function getIdstate()
    {
        return $this->idstate;
    }

    public function getState()
    {
        return Country_State::idToString($this->idstate->getValue());
    }

    /**
     * Getter idcountry
     *
     * @return int
     */
    public function getIdcountry()
    {
        return $this->idcountry;
    }

    public function getCountry()
    {
        return Country::idToString($this->idcountry->getValue());
    }

    /**
     * Load Customer
     *
     * @param integer $id Id
     *
     * @return boolean
     */
    abstract public function load($id);

    /**
     * Insert Customer
     *
     * @return boolean
     */
    abstract public function insert();

    /**
     * Update Customer
     *
     * @return boolean
     */
    abstract public function update();

    /**
     * Delete Customer
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
        return Customer::search(array());
    }

    /**
     * Return Array
     *
     * @return Array
     */
    public static function search(array $parametros, $num=null, $page=null, $yuju=true)
    {
        if ($yuju) {
            $array=new

                    Yuju_Array(new Customer());
        } else {
            $array=array();
        }
        $where="";
        foreach ($parametros as $key=> $param) {
            switch ($key) {

                case "like-name":
                    $where.='name LIKE \'%'.DB::Parse($param).'%\' AND ';

                    break;
                case "eq-name":
                    $where.='name =\''.DB::Parse(
                                    $param).'\' AND ';
                    break;
                case "like-address":
                    $where.='address LIKE \'%'.
                            DB::Parse($param).'%\' AND ';
                    break;
                case

                "eq-address":
                    $where.='address =\''.DB::Parse($param).'\' AND ';

                    break;
                case "like-vat":

                    $where.='vat LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-vat":
                    $where.='vat =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-tradename":
                    $where.='tradename LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-tradename":
                    $where.='tradename =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-city":
                    $where.='city LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-city":
                    $where.='city =\''.DB::Parse($param).'\' AND ';
                    break;
                case "like-cp":
                    $where.='cp LIKE \'%'.DB::Parse($param).'%\' AND ';
                    break;
                case "eq-cp":
                    $where.='cp =\''.DB::Parse($param).'\' AND ';
                    break;
                case "eq-idcity":
                    if (is_numeric($param)) {
                        $where.='`idcity` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in eq-idcity is not a number");
                    }
                    break;
                case "like-idcity":
                    if (is_numeric($param)) {
                        $where.='`idcity` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in like-idcity is not a number");
                    }
                    break;
                case "from-idcity":
                    if (is_numeric($param)) {
                        $where.='`idcity` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in from-idcity is not a number");
                    }
                    break;
                case "to-idcity":
                    if (is_numeric($param)) {
                        $where.='`idcity` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in to-idcity, is not a number");
                    }
                    break;
                case "eq-idstate":
                    if (is_numeric($param)) {
                        $where.='`idstate` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in eq-idstate is not a number");
                    }
                    break;
                case "like-idstate":
                    if (is_numeric($param)) {
                        $where.='`idstate` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in like-idstate is not a number");
                    }
                    break;
                case "from-idstate":
                    if (is_numeric($param)) {
                        $where.='`idstate` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in from-idstate is not a number");
                    }
                    break;
                case "to-idstate":
                    if (is_numeric($param)) {
                        $where.='`idstate` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in to-idstate, is not a number");
                    }
                    break;
                case "eq-idcountry":
                    if (is_numeric($param)) {
                        $where.='`idcountry` =\''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in eq-idcountry is not a number");
                    }
                    break;
                case "like-idcountry":
                    if (is_numeric($param)) {
                        $where.='`idcountry` LIKE \'%'.DB::Parse($param).'%\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in like-idcountry is not a number");
                    }
                    break;
                case "from-idcountry":
                    if (is_numeric($param)) {
                        $where.='`idcountry` >= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in from-idcountry is not a number");
                    }
                    break;
                case "to-idcountry":
                    if (is_numeric($param)) {
                        $where.='`idcountry` <= \''.DB::Parse($param).'\' AND ';
                    } else {
                        Error::setError("CustomerSearchError", "You Cant insert $param in to-idcountry, is not a number");
                    }
                    break;
            }
        }
        if (Error::haveError("CustomerSearchError")) {
            return false;
        } else {
            if ($yuju) {
                $sql="SELECT id FROM ";
            } else {
                $sql="SELECT * FROM ";
            }
            $sql.="customer";
            if ($where != "") {
                $where=" WHERE ".substr($where, 0, strlen($where) - 4);
            }
            $return=DB::Query($sql.$where);
            if ($num == null || $page == null) {
                if ($yuju) {
                    while ($customer=$return->fetchObject()) {
                        $array->add($customer->id);
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

    public function getFullAddress()
    {
        return $this->address."<br>".$this->cp." ".$this->getCity().", ".$this->getState()."<br>".$this->getCountry();
    }

}
