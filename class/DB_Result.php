<?php

/**
 * BD_Resultado File
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
 * @version  SVN: $Id: DB_Result.php 196 2015-03-03 10:43:41Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * DB_Result Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
class DB_Result
{

    private $_dbtype;
    private $_result;

    /**
     * Constructor
     *
     * @param string $_dbtype database type
     * @param string $_result _result
     */
    public function __construct($_dbtype, $_result)
    {
        $this->_dbtype=$_dbtype;
        $this->_result=$_result;
    }

    /**
     * Fetch _result by object
     *
     * @return object
     */
    public function fetchObject()
    {
        $obj=null;
        switch ($this->_dbtype) {
            case 'mysql':
                $obj=$this->_result->fetch_object();
                break;
            case 'sqlserver':
                $obj=mssql_fetch_object($this->_result);
                break;
            case 'oracle':
                $obj=oci_fetch_object($this->_result);
                break;
        }
        return $obj;
    }

    /**
     * Num rows
     *
     * @return integer
     */
    public function numRows()
    {
        switch ($this->_dbtype) {
            case 'mysql':
                return $this->_result->num_rows;
                break;
            case 'sqlserver':
                return mssql_num_rows($this->_result);
                break;
            case 'oracle':
                $rows=oci_fetch_assoc($this->_result);
                return count($rows);
                break;
        }
    }

    /**
     * Get last Insert Id
     * 
     * @return integer
     */
    public function insertId()
    {
        switch ($this->_dbtype) {
            case 'mysql':
                return $this->_result->insert_id;
                break;
            case 'sqlserver':
                $res=mssql_query('SELECT @@IDENTITY as id', $this->_result);
                if ($row=mssql_fetch_object($res)) {
                    return $row->id;
                } else {
                    return false;
                }
                break;
        }
    }
	
    public function freeResult()
    {
        switch ($this->_dbtype) {
            case 'sqlserver':
                return mssql_free_result($this->_result);
                break;
        }
    }
    
    public function seek($num)
    {
        switch ($this->_dbtype) {
            case 'mysql':
                return $this->_result->data_seek($num);
                break;
            case 'sqlserver':
                return mssql_data_seek($this->_result, $num);
                break;
        }
    }
	
	
    public function toArray($num=null, $page=null){
		
		$array = array();
		
		if($num==null || $page==null) {
			$i=0;
			while ($cliente = $this->fetchObject()) {
				
				foreach($cliente as $name => $field){
					$array[$name][$i]=$cliente->$name;
				}
				$i++;
			}
		}else{
			$i=0;
			while ($cliente = $this->fetchObject()) {
				if(($i>=$num*($page-1)) && $i<(($num*($page-1))+$num)){
					foreach($cliente as $name => $field){
						$array[$name][$i]=$cliente->$name;
					}					
				}  
				$i++;
			}			
		}
		
        return($array); 
    }

}