<?php
/**
 * Abstract_Payment File
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
 * Abstract_Payment Class
 *
 * @category XXX
 * @package  XXX
 * @author   XXX <xxx@xxx.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: XXX
 * @link     XXX
 * @since    XXX
 */
abstract class Abstract_Payment implements IYuju_Array
{
    protected $id;

    protected $name;

    protected $text;

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
     * Getter text
     *
     * @return text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Setter text
     *
     * @param string $var XXX
     *
     * @return boolean
     */
    public function setText($var)
    {
        $this->text = $var;
        return true;
    }

    /**
     * Load Payment
     *
     * @param integer $id Id
     *
     * @return boolean
     */
    abstract public function load($id);
    

    /**
     * Insert Payment
     *
     * @return boolean
     */
    abstract public function insert();

    /**
     * Update Payment
     *
     * @return boolean
     */
    abstract public function update();

    /**
     * Delete Payment
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
        return Payment::search(array());
    }
    /**
     * Return Array
     *
     * @return Array
     */
     public static function search(array $parametros, $num=null, $page=null, $yuju=true) {
        if ($yuju) {
            $array = new Yuju_Array(new Payment());
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
                case "like-text":
                    $where.='text LIKE \'%' . DB::Parse($param) . '%\' AND ';
                    break;
                case "eq-text":
                    $where.='text =\'' . DB::Parse($param) . '\' AND ';
                    break;
          }    
        } 
        if (Error::haveError("PaymentSearchError")) {
            return false;
        } else {
            if($yuju) {
                $sql = "SELECT id FROM "; 
            } else {
                $sql = "SELECT * FROM ";
            } 
            $sql.="payment";
            if ($where != "") {
                $where = " WHERE " . substr($where, 0, strlen($where) - 4);
            }
            $return = DB::Query($sql . $where );
            if($num==null || $page==null) {
                if ($yuju) { 
                    while ($payment = $return->fetchObject()) {
                        $array->add($payment->id); 
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