<?php
/**
 * ORM_MySQL File
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
 * ORM_MySQL Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class ORM_MySQL extends AbstractYuju_ORM
{

    /**
     * Connect to database
     *
     * @param string $db_host host
     * @param string $db_user user 
     * @param string $db_pass password
     * @param string $db_data database
     *            
     * @return boolean
     */
    public function connect($db_host, $db_user, $db_pass, $db_data)
    {
        if (DB::connection('mysql', $db_host, $db_user, $db_pass, $db_data)) {
            $this->db_host = $db_host;
            $this->db_user = $db_user;
            $this->db_pass = $db_pass;
            $this->db_data = $db_data;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Load table
     *
     * @param string $table table
     *            
     * @return void
     */
    public function load($table)
    {
        $this->table = $table;
        // TODO: check if table exists
        if ($result = DB::query('DESCRIBE ' . DB::Parse($table))) {
            while ($return = $result->fetchObject()) {
                $type = '';
                $number = null;
                $autoincremental = ($return->Extra == 'auto_increment') ? true : false;
                $primary = ($return->Key == 'PRI') ? true : false;
                // Data type
                if ($return->Type == 'blob') {
                    $type = 'blob';
                } elseif ($return->Type == 'longblob') {
                    $type = 'longblob';
                } elseif ($return->Type == 'mediumblob') {
                    $type = 'mediumblob';
                } elseif ($return->Type == 'tinyblob') {
                    $type = 'tinyblob';
                } elseif (preg_match("/varbinary\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'varbinary';
                    $number = $regs[1];
                } elseif (preg_match("/binary\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'binary';
                    $number = $regs[1];
                } elseif ($return->Type == 'date') {
                    $type = 'date';
                } elseif ($return->Type == 'double') {
                    $type = 'double';
                } elseif ($return->Type == 'float') {
                    $type = 'float';
                } elseif ($return->Type == 'datetime') {
                    $type = 'datetime';
                } elseif ($return->Type == 'time') {
                    $type = 'time';
                } elseif ($return->Type == 'timestamp') {
                    $type = 'timestamp';
                } elseif ($return->Type == 'year(4)') {
                    $type = 'year';
                } elseif (preg_match("/bigint\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'bigint';
                    $number = $regs[1];
                } elseif (preg_match("/decimal\(([0-9]{1,3},[0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'decimal';
                    $number = $regs[1];
                } elseif (preg_match("/float\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'float';
                    $number = $regs[1];
                } elseif (preg_match("/double\(([0-9]{1,3},[0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'float';
                    $number = $regs[1];
                } elseif (preg_match("/tinyint\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'tinyint';
                    $number = $regs[1];
                } elseif (preg_match("/int\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'int';
                    $number = $regs[1];
                } elseif (preg_match("/mediumint\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'mediumint';
                    $number = $regs[1];
                } elseif (preg_match("/smallint\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'smallint';
                    $number = $regs[1];
                } elseif (preg_match("/varchar\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'varchar';
                    $number = $regs[1];
                } elseif (preg_match("/char\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'char';
                    $number = $regs[1];
                } elseif ($return->Type == 'longtext') {
                    $type = 'longtext';
                } elseif ($return->Type == 'mediumtext') {
                    $type = 'mediumtext';
                } elseif ($return->Type == 'text') {
                    $type = 'text';
                } elseif ($return->Type == 'tinytext') {
                    $type = 'tinytext';
                } elseif (preg_match("/bit\(([0-9]{1,3})\)/", $return->Type, $regs)) {
                    $type = 'bit';
                    $number = $regs[1];
                } elseif (preg_match("/enum\(\'(.+)\'\)/", $return->Type, $regs)) {
                    // TODO: make better
                    $type = 'enum';
                    $number = $regs[1];
                } elseif (preg_match("/set\(\'(.+)\'\)/", $return->Type, $regs)) {
                    // TODO: make better
                    $type = 'set';
                    $number = $regs[1];
                }
                $this->_fields[$return->Field] = array(
                    'type' => $type,
                    'number' => $number,
                    'null' => ($return->Null == 'YES') ? true : false,
                    'auto_incremental' => $autoincremental,
                    'primary_key' => $primary
                );
            }
        }
    }

    /**
     * Generate object
     *
     * @param string $object_name
     *            object name
     *            
     * @return string
     */
    public function generateObject($object_name = '')
    {
        if ($object_name != '') {
            $this->object_name = ucwords($object_name);
        } else {
            $this->object_name = ucwords($this->table);
        }
        $object = "<?php\n";
        $object .= $this->generateDocFile();
        $object .= "\n";
        $object .= $this->generateDocClass();
        // TODO: check if $_fileds null
        if ($object_name == '') {
            $object .= 'class ' . ucwords($this->table) . " implements IYuju_Array\n{\n";
        } else {
            $object .= 'class ' . ucwords($object_name) . " implements IYuju_Array\n{\n\n";
        }
        $object .= $this->generateVars();
        $object .= $this->generateConstructor();
        $object .= $this->generateGetterSetter();
        $object .= $this->generateLoad();
        $object .= $this->generateInsert();
        $object .= $this->generateUpdate();
        $object .= $this->generateDelete();
        $object .= $this->generateGetAll();
        $object .= $this->generateSearch();
        
        $object .= "}";
        return $object;
    }

    /**
     * Generate Load
     *
     * @return string
     */
    public function generateLoad()
    {
        foreach ($this->_fields as $name => $field) {
            if ($field['primary_key']) {
                $id = $name;
            }
        }
        // TODO: make dinamic Primary Key
        $object = '    /**' . "\n";
        $object .= '     * Load ' . $this->object_name . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @param mixed $var Id or DB_Result fetch object' . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @return boolean' . "\n";
        $object .= '     */' . "\n";
        $object .= '    public function load($var)' . "\n";
        $object .= "    {\n";
        $object .= '        if (is_numeric($var)) {' . "\n";
        $object .= '            $return = DB::query(\'SELECT * FROM ' . $this->table . ' WHERE ' . $id . '=\'.DB::parse($var));' . "\n";
        $object .= '            if ($return->numRows()>0) {' . "\n";
        $object .= '                $' . $this->table . ' = $return->fetchObject();' . "\n";
        $object .= '                $return->freeResult();' . "\n";
        $object .= '            } else {' . "\n";
        $object .= '               $' . $this->table . ' = null;' . "\n";
        $object .= '            }' . "\n";
        $object .= '        } else {' . "\n";
        $object .= '           $' . $this->table . ' = $var;' . "\n";
        $object .= '        }' . "\n";
        $object .= '        if ($' . $this->table . ' != null) {' . "\n";
        
        foreach ($this->_fields as $name => $field) {
            $object .= str_repeat(' ', 12);
            switch ($field['type']) {
                case 'date':
                    $object .= '$this->' . $name . '->setDateFromDB($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'datetime':
                    $object .= '$this->' . $name . '->setDateTimeFromDB($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'time':
                    $object .= '$this->' . $name . '->setTime($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'timestamp':
                    $object .= '$this->' . $name . '->setDateTimeFromDB($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'year':
                    $object .= '$this->' . $name . '->setValue($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'bigint':
                    $object .= '$this->' . $name . '->setValue($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'decimal':
                    $object .= '$this->' . $name . '->setValue($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'double':
                    $object .= '$this->' . $name . '->setValue($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'float':
                    $object .= '$this->' . $name . '->setValue($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'int':
                    $object .= '$this->' . $name . '->setValue($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'mediumint':
                    $object .= '$this->' . $name . '->setValue($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'smallint':
                    $object .= '$this->' . $name . '->setValue($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'tinyint':
                    $object .= '$this->' . $name . '->setValue($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                case 'bit':
                    $object .= '$this->' . $name . '->setValue($' . $this->table . '->' . $name . ');' . "\n";
                    break;
                default:
                    $object .= '$this->' . $name . ' = $' . $this->table . '->' . $name . ';' . "\n";
                    break;
            }
        }
        $object .= '            return true;' . "\n";
        $object .= '        }' . "\n";
        $object .= '        return false;' . "\n";
        $object .= "    }\n\n";
        return $object;
    }

    /**
     * Generate inserts
     *
     * @return string
     */
    public function generateInsert()
    {
        $object = '    /**' . "\n";
        $object .= '     * Insert ' . $this->object_name . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @return boolean' . "\n";
        $object .= '     */' . "\n";
        $object .= '    public function insert()' . "\n";
        $object .= "    {\n";
        $object .= '        $sql=\'INSERT INTO ' . $this->table . ' (\';' . "\n";
        $fields = '';
        $values = '';
        foreach ($this->_fields as $name => $field) {
            if ($field['auto_incremental']) {
                continue;
            } else {
                $fields .= '        $sql.=\'' . $name . ',\';' . "\n";
                $values .= '        $sql.=' . $this->_valueToDB($name, $field) . ',\';' . "\n";
            }
        }
        $fields = substr($fields, 0, strlen($fields) - 4) . '\';' . "\n";
        $values = substr($values, 0, strlen($values) - 4) . ')\';' . "\n";
        $object .= $fields . '        $sql.=\') VALUES(\';' . "\n" . $values;
        $object .= '        if (DB::query($sql)) {' . "\n";
        foreach ($this->_fields as $name => $field) {
            if ($field['auto_incremental']) {
                $object .= '            $this->' . $name . '->setValue(DB::insertId());' . "\n";
            }
        }
        $object .= '            return true;' . "\n";
        $object .= '        } else {' . "\n";
        $object .= '            return false;' . "\n";
        $object .= '        }' . "\n";
        $object .= "    }\n\n";
        return $object;
    }

    /**
     * Generate update function
     *
     * @return string
     */
    public function generateUpdate()
    {
        $object = '    /**' . "\n";
        $object .= '     * Update ' . $this->object_name . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @return boolean' . "\n";
        $object .= '     */' . "\n";
        
        $where = '        $sql.=\'WHERE \';' . "\n";
        $object .= '    public function update()' . "\n";
        $object .= "    {\n";
        $object .= '        $sql=\'UPDATE ' . $this->table . ' SET \';' . "\n";
        foreach ($this->_fields as $name => $field) {
            if ($field['auto_incremental']) {
                $where .= '        $sql.=\'' . $name . '=\'.' . $this->_valueToDB($name, $field) . '\';' . "\n";
            } else {
                $object .= '        $sql.=\'' . $name . '=\'.' . $this->_valueToDB($name, $field) . ',\';' . "\n";
            }
        }
        $object = substr($object, 0, strlen($object) - 4) . ' \';' . "\n" . $where;
        $object .= '        if (DB::query($sql)) {' . "\n";
        $object .= '            return true;' . "\n";
        $object .= '        } else {' . "\n";
        $object .= '            return false;' . "\n";
        $object .= '        }' . "\n";
        $object .= "    }\n\n";
        return $object;
    }

    /**
     * Generate delete function
     *
     * @return string
     */
    public function generateDelete()
    {
        $object = '    /**' . "\n";
        $object .= '     * Delete ' . $this->object_name . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @return boolean' . "\n";
        $object .= '     */' . "\n";
        $object .= '    public function delete()' . "\n";
        $object .= "    {\n";
        $object .= '        $sql=\'DELETE FROM ' . $this->table . ' WHERE \';' . "\n";
        foreach ($this->_fields as $name => $field) {
            // TODO: Make to Primary key
            if ($field['auto_incremental']) {
                $object .= '        $sql.=\'' . $name . '=\'.' . $this->_valueToDB($name, $field) . '\';' . "\n";
            }
        }
        $object .= '        if (DB::query($sql)) {' . "\n";
        $object .= '            return true;' . "\n";
        $object .= '        } else {' . "\n";
        $object .= '            return false;' . "\n";
        $object .= '        }' . "\n";
        $object .= "    }\n\n";
        return $object;
    }

    public function generateSearch()
    {
        $object = "\n";
        $object = '    /**' . "\n";
        $object .= '     * Search function' . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @param array   $parametros filter array' . "\n";
        $object .= '     * @param integer $num        number of elements' . "\n";
        $object .= '     * @param integer $page       page number' . "\n";
        $object .= '     * @param integer $yuju       return a Yuju_Array or array' . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @return boolean|Yuju_Array' . "\n";
        $object .= '     */' . "\n";
        $object .= '     public static function search(array $parametros, $num=null, $page=null, $yuju=true) {' . "\n";
        $object .= '        if ($yuju) {' . "\n";
        $object .= '            $array = new Yuju_Array();' . "\n";
        $object .= '        } else {' . "\n";
        $object .= '                $array = array();' . "\n";
        $object .= '        } ' . "\n";
        $object .= '        $where = "";' . "\n";
        
        $object .= '        foreach ($parametros as $key => $param) {' . "\n";
        $object .= '            switch ($key) {' . "\n";
        foreach ($this->_fields as $name => $field) {
            if (! $field['auto_incremental']) {
                switch ($field['type']) {
                    case "char":
                    case "longtext":
                    case "varchar":
                    case "mediumtext":
                    case "text":
                    case "tinytext":
                        $object .= '            case "like-' . $name . '":' . "\n";
                        $object .= "                \$where.='" . $name . " LIKE \'%'.DB::Parse(\$param) . '%\' AND ';" . "\n";
                        $object .= '                break;' . "\n";
                        $object .= '            case "eq-' . $name . '":' . "\n";
                        $object .= "                \$where.='" . $name . " =\''.DB::Parse(\$param) . '\' AND ';" . "\n";
                        $object .= '                break;' . "\n";
                        break;
                    case "bit":
                        $object .= '            case "eq-' . $name . '":' . "\n";
                        $object .= "                \$where.='" . $name . " =\''.DB::Parse(\$param) . '\' AND ';" . "\n";
                        $object .= '                break;' . "\n";
                        break;
                    case "double":
                    case "bigint":
                    case "decimal":
                    case "float":
                    case "int":
                    case "tinyint":
                    case "mediumint":
                    case "smallint":
                        $object .= '            case "eq-' . $name . '":' . "\n";
                        $object .= '                if (is_numeric($param)) {' . "\n";
                        $object .= "                    \$where.='`" . $name . "` =\''.DB::Parse(\$param) . '\' AND ';" . "\n";
                        $object .= '                } else {' . "\n";
                        $object .= '                    Error::setError("' . $this->object_name . 'SearchError", "Value $param in eq-' . $name . ' is not a number");' . "\n";
                        $object .= '                }' . "\n";
                        $object .= '                break;' . "\n";
                        $object .= '            case "like-' . $name . '":' . "\n";
                        $object .= '                if (is_numeric($param)) {' . "\n";
                        $object .= "                    \$where.='`" . $name . "` LIKE \'%'.DB::Parse(\$param) . '%\' AND ';" . "\n";
                        $object .= '                } else {' . "\n";
                        $object .= '                    Error::setError("' . $this->object_name . 'SearchError", "Value $param in like-' . $name . ' is not a number");' . "\n";
                        $object .= '                }' . "\n";
                        $object .= '                break;' . "\n";
                        $object .= '            case "from-' . $name . '":' . "\n";
                        $object .= '                if (is_numeric($param)) {' . "\n";
                        $object .= "                    \$where.='`" . $name . "` >= \''.DB::Parse(\$param) . '\' AND ';" . "\n";
                        $object .= '                } else {' . "\n";
                        $object .= '                    Error::setError("' . $this->object_name . 'SearchError", "Value $param in from-' . $name . ' is not a number");' . "\n";
                        $object .= '                }' . "\n";
                        $object .= '                break;' . "\n";
                        $object .= '            case "to-' . $name . '":' . "\n";
                        $object .= '                if (is_numeric($param)) {' . "\n";
                        $object .= "                    \$where.='`" . $name . "` <= \''.DB::Parse(\$param) . '\' AND ';" . "\n";
                        $object .= '                } else {' . "\n";
                        $object .= '                    Error::setError("' . $this->object_name . 'SearchError", "Value $param in to-' . $name . ', is not a number");' . "\n";
                        $object .= '                }' . "\n";
                        $object .= '                break;' . "\n";
                        break;
                    case "year":
                    case "time":
                    case "datetime":
                    case "date":
                        $object .= '            case "eq-' . $name . '":' . "\n";
                        $object .= "                \$where.='`" . $name . "` =\''.DB::Parse(\$param) . '\' AND ';" . "\n";
                        $object .= '                break;' . "\n";
                        $object .= '            case "ini-' . $name . '":' . "\n";
                        $object .= "                \$where.='`" . $name . "` >= \''.DB::Parse(\$param) . '\' AND ';" . "\n";
                        $object .= '                break;' . "\n";
                        $object .= '            case "end-' . $name . '":' . "\n";
                        $object .= "                \$where.='`" . $name . "` <= \''.DB::Parse(\$param) . '\' AND ';" . "\n";
                        $object .= '                break;' . "\n";
                        break;
                }
                if ($field['primary_key']) {
                    $id = $name;
                }
            } else {
                if ($field['primary_key']) {
                    $id = $name;
                }
            }
        }
        $object .= '          }    ' . "\n";
        
        $object .= '        } ' . "\n";
        $object .= '        if (Error::haveError("' . $this->object_name . 'SearchError")) {' . "\n";
        $object .= '            return false;' . "\n";
        $object .= '        } else {' . "\n";
        $object .= '            $sql = "SELECT * FROM ";' . "\n";
        $object .= '            $sql.="' . $this->table . '";' . "\n";
        $object .= '            if ($where != "") {' . "\n";
        $object .= '                $where = " WHERE " . substr($where, 0, strlen($where) - 4);' . "\n";
        $object .= '            }' . "\n";
        $object .= "            \$return = DB::Query(\$sql . \$where);" . "\n";
        $object .= '            if ($yuju) { ' . "\n";
        $object .= '                $array->loadFromDB($return, new ' . $this->object_name . '(), $num, $page);' . "\n";
        $object .= '            } else { ' . "\n";
        $object .= '                $array = $return->toArray($num, $page);' . "\n";
        $object .= '            } ' . "\n";
        $object .= '            $return->freeResult();' . "\n";
        $object .= '            return $array;' . "\n";
        $object .= '        } ' . "\n";
        $object .= '     }' . "\n";
        
        return $object;
    }

    /**
     * Get string value to database
     *
     * @param string $name   field name
     * @param array  &$field field
     *            
     * @return string
     */
    private function _valueToDB($name, &$field)
    {
        $value = '';
        switch ($field['type']) {
        case 'date':
            $value .= '$this->' . $name . '->dateToDB().\'';
            break;
        case 'datetime':
            $value .= '$this->' . $name . '->dateTimeToDB().\'';
            break;
        case 'time':
            $value .= '$this->' . $name . '->TimeToDB().\'';
            break;
        case 'timestamp':
            $value .= '$this->' . $name . '->dateTimeToDB().\'';
            break;
        case 'year':
            $value .= '$this->' . $name . '->getValueToDB().\'';
            break;
        case 'bigint':
            $value .= '$this->' . $name . '->getValueToDB().\'';
            break;
        case 'decimal':
            $value .= '$this->' . $name . '->getValueToDB().\'';
            break;
        case 'double':
            $value .= '$this->' . $name . '->getValueToDB().\'';
            break;
        case 'float':
            $value .= '$this->' . $name . '->getValueToDB().\'';
            break;
        case 'int':
            $value .= '$this->' . $name . '->getValueToDB().\'';
            break;
        case 'mediumint':
            $value .= '$this->' . $name . '->getValueToDB().\'';
            break;
        case 'smallint':
            $value .= '$this->' . $name . '->getValueToDB().\'';
            break;
        case 'tinyint':
            $value .= '$this->' . $name . '->getValueToDB().\'';
            break;
        case 'bit':
            $value .= '$this->' . $name . '->getValueDB().\'';
            break;
        default:
            $value .= '\'\\\'\'.$this->' . $name . '.\'\\\'';
            break;
        }
        return $value;
    }

    /**
     * Generate base
     * 
     * @param string $directory directory
     * 
     * @return boolean
     */
    public function generateBase($directory)
    {
        return false;
    }
}
 