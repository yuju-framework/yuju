<?php
/**
 * DB_Result File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * DB_Result Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class DB_Result
{

    private $dbtype;
    private $result;

    /**
     * Constructor
     *
     * @param string $dbtype database type
     * @param string $result result
     */
    public function __construct($dbtype, $result)
    {
        $this->dbtype=$dbtype;
        $this->result=$result;
    }

    /**
     * Fetch result by object
     *
     * @return object
     */
    public function fetchObject()
    {
        $obj=null;
        switch ($this->dbtype) {
            case 'mysql':
                $obj=$this->result->fetch_object();
                break;
            case 'sqlserver':
                $obj=mssql_fetch_object($this->result);
                break;
            case 'oracle':
                $obj=oci_fetch_object($this->result);
                break;
        }
        return $obj;
    }

    /**
     * Fetch result by array
     *
     * @return object
     */
    public function fetchArray()
    {
        $obj=null;
        switch ($this->dbtype) {
            case 'mysql':
                $obj=$this->result->fetch_array();
                break;
            case 'sqlserver':
                $obj=mssql_fetch_array($this->result);
                break;
            case 'oracle':
                $obj=oci_fetch_array($this->result);
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
        switch ($this->dbtype) {
            case 'mysql':
                return $this->result->num_rows;
                break;
            case 'sqlserver':
                return mssql_num_rows($this->result);
                break;
            case 'oracle':
                $rows=oci_fetch_assoc($this->result);
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
        switch ($this->dbtype) {
            case 'mysql':
                return $this->result->insert_id;
                break;
            case 'sqlserver':
                $res=mssql_query('SELECT @@IDENTITY as id', $this->result);
                if ($row=mssql_fetch_object($res)) {
                    return $row->id;
                } else {
                    return false;
                }
                break;
        }
    }

    /**
     * Free result
     *
     * @return boolean
     */
    public function freeResult()
    {
        switch ($this->dbtype) {
            case 'sqlserver':
                return mssql_freeresult($this->result);
                break;
        }
    }

    /**
     * Move internal result pointer
     *
     * @param integer $num num row
     *
     * @return boolean
     */
    public function seek($num)
    {
        switch ($this->dbtype) {
            case 'mysql':
                return $this->result->data_seek($num);
                break;
            case 'sqlserver':
                return mssql_data_seek($this->result, $num);
                break;
        }
    }

    /**
     * Database result to array
     *
     * @param string $num  num rows
     * @param string $page num page
     *
     * @return array
     */
    public function toArray($num = null, $page = null)
    {
        $array = array();
        if ($num==null || $page==null) {
            $i=0;
            while ($cliente = $this->fetchObject()) {
                foreach ($cliente as $name => $field) {
                    $array[$i][$name]=$cliente->$name;
                }
                $i++;
            }
        } else {
            $i=0;
            while ($cliente = $this->fetchObject()) {
                if (($i>=$num*($page-1)) && $i<(($num*($page-1))+$num)) {
                    foreach ($cliente as $name => $field) {
                        $array[$i][$name]=$cliente->$name;
                    }
                }
                $i++;
            }
        }
        return $array;
    }
}
