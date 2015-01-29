<?php
/**
 * State_City File
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
 * State_City Class
 *
 * @category XXX
 * @package  XXX
 * @author   XXX <xxx@xxx.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: XXX
 * @link     XXX
 * @since    XXX
 */
class State_City implements IYuju_Array
{

    protected $id;

    protected $name;

    protected $idstate;

    /**
     * Constructor 
     *
     */
    public function __construct()
    {
        $this->id = new Number();
        $this->idstate = new Number();
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
     * Getter idstate
     *
     * @return int
     */
    public function getIdcountry()
    {
        return $this->idstate;
    }

    /**
     * Load State_City
     *
     * @param integer $id Id
     *
     * @return boolean
     */
    public function load($id)
    {
        if (is_numeric($id)) {
            $return = DB::query('SELECT * FROM state_city WHERE id='.DB::parse($id));
            if ($return->numRows()>0) {
                $country_state = $return->fetchObject();
                $this->id->setValue($country_state->id);
                $this->name = $country_state->name;
                $this->idstate->setValue($country_state->idstate);
                return true;
            }
        }
        return false;
    }

    /**
     * Insert State_City
     *
     * @return boolean
     */
    public function insert()
    {
        $sql='INSERT INTO state_city (';
        $sql.='name,';
        $sql.='idstate';
        $sql.=') VALUES(';
        $sql.='\''.$this->name.'\',';
        $sql.=$this->idstate->getValueToDB().')';
        if (DB::query($sql)) {
            $this->id->setValue(DB::insertId());
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update State_City
     *
     * @return boolean
     */
    public function update()
    {
        $sql='UPDATE state_city SET ';
        $sql.='name='.'\''.$this->name.'\',';
        $sql.='idstate='.$this->idstate->getValueToDB().' ';
        $sql.='WHERE ';
        $sql.='id='.$this->id->getValueToDB().'';
        if (DB::query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete State_City
     *
     * @return boolean
     */
    public function delete()
    {
        $sql='DELETE FROM state_city WHERE ';
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
        return State_City::search(array());
    }
    /**
     * Return Array
     *
     * @return Array
     */
     public static function search(array $parametros, $num=null, $page=null, $yuju=true) {
        if ($yuju) {
            $array = new Yuju_Array(new State_City());
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
                case "eq-idstate":
                    if (is_numeric($param)) {
                        $where.='`idstate` =\'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("State_CitySearchError", "You Cant insert $param in eq-idstate is not a number");
                    }
                    break;
                case "like-idstate":
                    if (is_numeric($param)) {
                        $where.='`idstate` LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    } else {
                        Error::setError("State_CitySearchError", "You Cant insert $param in like-idstate is not a number");
                    }
                    break;
                case "from-idstate":
                    if (is_numeric($param)) {
                        $where.='`idstate` >= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("State_CitySearchError", "You Cant insert $param in from-idstate is not a number");
                    }
                    break;
                case "to-idstate":
                    if (is_numeric($param)) {
                        $where.='`idstate` <= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("State_CitySearchError", "You Cant insert $param in to-idstate, is not a number");
                    }
                    break;
          }    
        } 
        if (Error::haveError("State_CitySearchError")) {
            return false;
        } else {
            if($yuju) {
                $sql = "SELECT id FROM "; 
            } else {
                $sql = "SELECT * FROM ";
            } 
            $sql.="state_city";
            if ($where != "") {
                $where = " WHERE " . substr($where, 0, strlen($where) - 4);
            }
            $return = DB::Query($sql . $where );
            if($num==null || $page==null) {
                if ($yuju) { 
                    while ($country_state = $return->fetchObject()) {
                        $array->add($country_state->id); 
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
     
     public static function idToString($id) {
         $country = new State_City();
         $country->load($id);
         return $country->getName();
     }
}