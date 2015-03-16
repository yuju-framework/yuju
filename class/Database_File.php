<?php
/**
 * Database_File File
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
 * Database_File Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Database_File extends File
{
    /**
     * Document Id
     *
     * @var integer
     */
    protected $id;
    
    /**
     * Database table
     *
     * @var string
     */
    protected $dbname;
    
    /**
     * Getter id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Setter id
     *
     * @param integer $value id
     *
     * @return void
     */
    public function setId($value)
    {
        if (is_numeric($value)) {
            $this->id=$value;
        }
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dbname='document';
    }
    
    /**
     * Load document
     *
     * @param integer $id   id
     * @param boolean $full load content document
     *
     * @return boolean
     */
    public function load($id,$full=true)
    {
        if (is_numeric($id)) {
            $this->setId($id);
            $sql='SELECT * FROM '.$this->dbname.' WHERE id=\''.$this->id.'\'';
            if ($result=DB::query($sql)) {
                if ($result->numRows()>0) {
                    $document=$result->fetchObject();
                    $this->setName($document->name);
                    $this->setType($document->type);
                    $this->setSize($document->size);
                    if ($full) {
                        $this->setContent($document->content);
                    }
                }
            } else {
                return false;
            }
        }
    }
    
    /**
     * Determine document exist
     *
     * @param mixed $id document id or path
     *
     * @return boolean
     * @since version 1.0
     */
    public static function exist($id)
    {
        if ($id=='' || !is_numeric($id)) {
            return false;
        }
        // Exist from Data Base
        $result = DB::query(
            'SELECT id FROM '.$this->dbname.' WHERE id='.DB::parse($id)
        );
        if ($result->numRows()>0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Insert document
     *
     * @return boolean
     */
    public function insert()
    {
        $sql='INSERT INTO '.$this->dbname.' (name,type,size,content) VALUES(';
        $sql.='\''.DB::parse($this->name).'\',';
        $sql.='\''.DB::parse($this->type).'\',';
        $sql.='\''.DB::parse($this->size).'\',';
        $sql.='\''.DB::parse($this->getContent()).'\')';
        if (DB::query($sql)===false) {
            return false;
        }
        $this->setId(DB::insertId());
        return true;
    }
    
    /**
     * Update document
     *
     * @return boolean
     */
    public function update()
    {
        if ($this->getName()!="" && $this->getType()!="") {
            $sql='UPDATE '.$this->dbname.' SET ';
            $sql.='name=\''.DB::parse($this->name).'\',';
            $sql.='type=\''.DB::parse($this->type).'\',';
            $sql.='size=\''.DB::parse($this->size).'\',';
            $sql.='content=\''.DB::parse($this->getContent()).'\' ';
            $sql.='WHERE id=\''.$this->id.'\'';
            if (!(DB::query($sql))) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * Delete document
     *
     * @return boolean
     */
    public function delete()
    {
        if (DB::query('DELETE FROM '.$this->dbname.' WHERE id=\''.$this->id.'\'')) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * All Documents
     *
     * @return Yuju_Array
     */
    public static function getAll()
    {
        $array=new Yuju_Array(new Database_File());
        $return=DB::Query('SELECT id FROM document');
        while ($doc=$return->fetchObject()) {
            $array->add($doc->id);
        }
        return $array;
    }
    
    /**
     * Close file
     *
     * @return boolean
     * @since version 1.0
     */
    public function close()
    {
        $this->id = '';
        $this->name='';
        $this->place='';
        $this->type='';
        $this->size='';
        $this->content='';
        $this->_resource=null;
        
        return true;
    }
}
