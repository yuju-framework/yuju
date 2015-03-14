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
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  GIT: 
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Abstract_Payment Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
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
     * @param mixed $var Id or DB_Result fetch object
     *
     * @return boolean
     */
    abstract public function load($var);
    

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
}
