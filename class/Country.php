<?php
/**
 * Country File
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
 * Country Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Country implements IYuju_Array
{
    protected $id;

    protected $name;

    /**
     * Constructor 
     *
     */
    public function __construct()
    {
        $this->id = new Number();
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
        $this->name = $var;
        return true;
    }

    /**
     * Load Country
     *
     * @param integer $id Id
     *
     * @return boolean
     */
    public function load($id)
    {
        if (is_numeric($id)) {
            $return = DB::query('SELECT * FROM country WHERE id='.DB::parse($id));
            if ($return->numRows()>0) {
                $country = $return->fetchObject();
                $this->id->setValue($country->id);
                $this->name = $country->name;
                return true;
            }
        }
        return false;
    }

    /**
     * Insert Country
     *
     * @return boolean
     */
    public function insert()
    {
        $sql='INSERT INTO country (';
        $sql.='name';
        $sql.=') VALUES(';
        $sql.='\''.$this->name.'\')';
        if (DB::query($sql)) {
            $this->id->setValue(DB::insertId());
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update Country
     *
     * @return boolean
     */
    public function update()
    {
        $sql='UPDATE country SET ';
        $sql.='name='.'\''.$this->name.'\' ';
        $sql.='WHERE ';
        $sql.='id='.$this->id->getValueToDB().'';
        if (DB::query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete Country
     *
     * @return boolean
     */
    public function delete()
    {
        $sql='DELETE FROM country WHERE ';
        $sql.='id='.$this->id->getValueToDB().'';
        if (DB::query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return all objects
     *
     * @return Yuju_Array
     */
    public static function getAll()
    {
        return Country::search(array());
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
    public static function search(array $parameters,
        $num=null, $page=null, $yuju=true
    ) {
        if ($yuju) {
            $array = new Yuju_Array();
        } else {
            $array = array();
        } 
        $where = "";
        foreach ($parametros as $key => $param) {
            switch ($key) {
            case "like-name":
                $where.='name LIKE \'%' . DB::Parse($param) . '%\' AND ';
                break;
            case "eq-name":
                $where.='name =\'' . DB::Parse($param) . '\' AND ';
                break;
            }    
        } 
        if (Error::haveError("CountrySearchError")) {
            return false;
        } else {
            if ($yuju) {
                $sql = "SELECT id FROM "; 
            } else {
                $sql = "SELECT * FROM ";
            } 
            $sql.="country";
            if ($where != "") {
                $where = " WHERE " . substr($where, 0, strlen($where) - 4);
            }
            $return = DB::Query($sql.$where);
            if ($num==null || $page==null) {
                if ($yuju) { 
                    while ($country = $return->fetchObject()) {
                        $array->add($country->id); 
                    } 
                } else { 
                    $array = $return->toArray();
                } 
            } else { 
                if ($yuju) { 
                    $array->loadFromDB($return, "id", $num, $page);
                } else { 
                    $array = $return->toArray($num, $page);
                } 
            } 
            return $array;
        } 
    }
}
