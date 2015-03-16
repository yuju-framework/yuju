<?php
/**
 * Tax File
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
 * @version  GIT: 
 * @link     XXX
 * @since    version 1.0
 */

/**
 * Tax Class
 *
 * @category XXX
 * @package  XXX
 * @author   XXX <xxx@xxx.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: XXX
 * @link     XXX
 * @since    version 1.0
 */
class Tax implements IYuju_Array
{
    protected $id;

    protected $name;

    protected $percentage;

    /**
     * Constructor 
     *
     */
    public function __construct()
    {
        $this->id = new Number();
        $this->percentage = new Number();
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
     * Getter percentage
     *
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Load Tax
     *
     * @param integer $id Id
     *
     * @return boolean
     */
    public function load($id)
    {
        if (is_numeric($id)) {
            $return = DB::query('SELECT * FROM tax WHERE id='.DB::parse($id));
            if ($return->numRows()>0) {
                $tax = $return->fetchObject();
                $this->id->setValue($tax->id);
                $this->name = $tax->name;
                $this->percentage->setValue($tax->percentage);
                return true;
            }
        }
        return false;
    }

    /**
     * Insert Tax
     *
     * @return boolean
     */
    public function insert()
    {
        $sql='INSERT INTO tax (';
        $sql.='name,';
        $sql.='percentage';
        $sql.=') VALUES(';
        $sql.='\''.$this->name.'\',';
        $sql.=$this->percentage->getValueToDB().')';
        if (DB::query($sql)) {
            $this->id->setValue(DB::insertId());
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update Tax
     *
     * @return boolean
     */
    public function update()
    {
        $sql='UPDATE tax SET ';
        $sql.='name='.'\''.$this->name.'\',';
        $sql.='percentage='.$this->percentage->getValueToDB().' ';
        $sql.='WHERE ';
        $sql.='id='.$this->id->getValueToDB().'';
        if (DB::query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete Tax
     *
     * @return boolean
     */
    public function delete()
    {
        $sql='DELETE FROM tax WHERE ';
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
        return Tax::search(array());
    }
    /**
     * Return Array
     *
     * @return Array
     */
     public static function search(array $parametros, $num=null, $page=null, $yuju=true) {
        if ($yuju) {
            $array = new Yuju_Array(new Tax());
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
                case "eq-percentage":
                    if (is_numeric($param)) {
                        $where.='`percentage` =\'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("TaxSearchError", "You Cant insert $param in eq-percentage is not a number");
                    }
                    break;
                case "like-percentage":
                    if (is_numeric($param)) {
                        $where.='`percentage` LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    } else {
                        Error::setError("TaxSearchError", "You Cant insert $param in like-percentage is not a number");
                    }
                    break;
                case "from-percentage":
                    if (is_numeric($param)) {
                        $where.='`percentage` >= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("TaxSearchError", "You Cant insert $param in from-percentage is not a number");
                    }
                    break;
                case "to-percentage":
                    if (is_numeric($param)) {
                        $where.='`percentage` <= \'' . DB::Parse($param) . '\' AND ';
                    } else {
                        Error::setError("TaxSearchError", "You Cant insert $param in to-percentage, is not a number");
                    }
                    break;
          }    
        } 
        if (Error::haveError("TaxSearchError")) {
            return false;
        } else {
            if($yuju) {
                $sql = "SELECT id FROM "; 
            } else {
                $sql = "SELECT * FROM ";
            } 
            $sql.="tax";
            if ($where != "") {
                $where = " WHERE " . substr($where, 0, strlen($where) - 4);
            }
            $return = DB::Query($sql . $where );
            if($num==null || $page==null) {
                if ($yuju) { 
                    while ($tax = $return->fetchObject()) {
                        $array->add($tax->id); 
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