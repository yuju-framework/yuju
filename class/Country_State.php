<?php
/**
 * CountryState File
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
 * CountryState Class
 *
 * @category XXX
 * @package  XXX
 * @author   XXX <xxx@xxx.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: XXX
 * @link     XXX
 * @since    XXX
 */
class Country_State implements IYuju_Array
{

    protected $id;

    protected $name;

    protected $idcountry;

    /**
     * Constructor 
     *
     */
    public function __construct()
    {
        $this->id = new Number();
        $this->idcountry = new Number();
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
     * Getter idcountry
     *
     * @return int
     */
    public function getIdcountry()
    {
        return $this->idcountry;
    }

    /**
     * Load Country_State
     *
     * @param integer $id Id
     *
     * @return boolean
     */
    public function load($id)
    {
        if (is_numeric($id)) {
            $return = DB::query('SELECT * FROM country_state WHERE id='.DB::parse($id));
            if ($return->numRows()>0) {
                $country_state = $return->fetchObject();
                $this->id->setValue($country_state->id);
                $this->name = $country_state->name;
                $this->idcountry->setValue($country_state->idcountry);
                return true;
            }
        }
        return false;
    }

    /**
     * Insert Country_State
     *
     * @return boolean
     */
    public function insert()
    {
        $sql='INSERT INTO country_state (';
        $sql.='name,';
        $sql.='idcountry';
        $sql.=') VALUES(';
        $sql.='\''.$this->name.'\',';
        $sql.=$this->idcountry->getValueToDB().')';
        if (DB::query($sql)) {
            $this->id->setValue(DB::insertId());
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update Country_State
     *
     * @return boolean
     */
    public function update()
    {
        $sql='UPDATE country_state SET ';
        $sql.='name='.'\''.$this->name.'\',';
        $sql.='idcountry='.$this->idcountry->getValueToDB().' ';
        $sql.='WHERE ';
        $sql.='id='.$this->id->getValueToDB().'';
        if (DB::query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete Country_State
     *
     * @return boolean
     */
    public function delete()
    {
        $sql='DELETE FROM country_state WHERE ';
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
        return Country_State::search(array());
    }
    /**
     * Return Array
     *
     * @return Array
     */
     public static function search(array $parametros, $num=null, $page=null, $yuju=true) {
        if ($yuju) {
            $array = new Yuju_Array(new Country_State());
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
                case "eq-idcountry":
                    if (is_numeric($param)) {
                        $where.='`idcountry` =\'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Country_StateSearchError", "You Cant insert $param in eq-idcountry is not a number");
                    }
                    break;
                case "like-idcountry":
                    if (is_numeric($param)) {
                        $where.='`idcountry` LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    } else {
                        Error::setError("Country_StateSearchError", "You Cant insert $param in like-idcountry is not a number");
                    }
                    break;
                case "from-idcountry":
                    if (is_numeric($param)) {
                        $where.='`idcountry` >= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Country_StateSearchError", "You Cant insert $param in from-idcountry is not a number");
                    }
                    break;
                case "to-idcountry":
                    if (is_numeric($param)) {
                        $where.='`idcountry` <= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("Country_StateSearchError", "You Cant insert $param in to-idcountry, is not a number");
                    }
                    break;
          }    
        } 
        if (Error::haveError("Country_StateSearchError")) {
            return false;
        } else {
            if($yuju) {
                $sql = "SELECT id FROM "; 
            } else {
                $sql = "SELECT * FROM ";
            } 
            $sql.="country_state";
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
         $country = new Country_State();
         $country->load($id);
         return $country->getName();
     }
}