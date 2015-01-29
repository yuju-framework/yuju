<?php
/**
 * Person File
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
 * @version  SVN: $Id: Person.php 186 2014-09-05 19:15:51Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * Person Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
abstract class Person implements IYuju_Array, IYuju_getAll
{

    /**
     * Id
     *
     * @var    integer
     * @access protected
     */
    protected $id;
    /**
     * Name
     *
     * @var    string
     * @access protected
     */
    protected $name;
    
    /**
     * Surname
     *
     * @var    string
     * @access protected
     */
    protected $surname;

    /**
     * Surname 2
     *
     * @var    string
     * @access protected
     */
    protected $surname2;

    /**
     * Address
     *
     * @var    string
     * @access protected
     */
    protected $address;

    /**
     * Getter Id
     *
     * @return number
     * @access public
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter Name
     *
     * @return string
     * @access public
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter Name
     *
     * @param string $name Name
     * 
     * @return boolean
     * @access public
     */
    public function setName($name)
    {
        $this->name = $name;
        return true;
    }

    /**
     * Getter Surname
     *
     * @return string
     * @access public
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Setter Surname
     *
     * @param string $surname Surname
     * 
     * @access public
     * @return boolean
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return true;
    }

    /**
     * Getter Surname 2
     *
     * @return string
     * @access public
     */
    public function getSurname2()
    {
        return $this->surname2;
    }

    /**
     * Setter Surname 2
     *
     * @param string $surname Surname
     * 
     * @access public
     * @return boolean
     */
    public function setSurname2($surname)
    {
        $this->surname2 = $surname;
        return true;
    }

    
    public function __construct() {
        $this->id = new Number();
    }
    
    /**
     * Insert Person
     * 
     * @return boolean
     */
    abstract public function insert();
    
    /**
     * Update person
     *
     * @return boolean
     */
    abstract public function update();
    
    /**
     * Delete person
     *
     * @return boolean
     */
    abstract public function delete();

}