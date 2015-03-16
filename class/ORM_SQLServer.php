<?php
/**
 * ORM_SQLServer File
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
 * ORM_SQLServer Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
 class ORM_SQLServer extends AbstractYuju_ORM
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
         if (DB::Connection('sqlserver', $db_host, $db_user, $db_pass, $db_data)) {
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
         $this->object_name = ucwords($table);
         //TODO: check if table exists
         if ($result = DB::query('sp_columns ' . DB::Parse($this->table))) {
             $first_field = null;
             
            while ($return = $result->fetchObject()) {
                if ($first_field===null) {
                    $first_field = $return->COLUMN_NAME;
                }
                
                $type = '';
                if (substr($return->TYPE_NAME,-8)=='identity') {
                    $autoincremental = true;
                } else {
                    $autoincremental = false;
                }
                // Data type
                if ($return->DATA_TYPE=='4') {
                    $type = 'int';
                } elseif ($return->DATA_TYPE=='5') {
                    $type = 'smallint';
                } elseif ($return->DATA_TYPE=='3') {
                    $type = 'decimal';
                } elseif ($return->DATA_TYPE == '-8' || $return->DATA_TYPE == '-9' || $return->DATA_TYPE == '-10' || $return->DATA_TYPE == '1' || $return->DATA_TYPE == '12') {
                    $type = 'varchar';
                } elseif ($return->DATA_TYPE == '11') {
                    $type = 'datetime';
                }
                $this->_fields[$return->COLUMN_NAME] = array(
                    'type' => $type,
                    'number' => $return->PRECISION,
                    'null' =>($return->NULLABLE == '1') ? true : false,
                    'auto_incremental' => $autoincremental,
                    'primary_key' => false
                );
            }
            // First field as a primary key by default
            $this->_fields[$first_field]['primary_key'] = true;
            
            $sql = 'SELECT COL_NAME(ic.OBJECT_ID,ic.column_id) AS Column_Name ';
            $sql.= 'FROM sys.indexes AS i ';
            $sql.= 'INNER JOIN sys.index_columns AS ic ';
            $sql.= 'INNER JOIN sys.columns AS c ON ic.object_id = c.object_id AND ic.column_id = c.column_id ';
            $sql.= 'ON i.OBJECT_ID = ic.OBJECT_ID ';
            $sql.= 'AND i.index_id = ic.index_id ';
            $sql.= 'WHERE i.is_primary_key = 1 AND ic.OBJECT_ID = OBJECT_ID(\'dbo.'.$this->table.'\')';
            $sql.= 'ORDER BY OBJECT_NAME(ic.OBJECT_ID), ic.key_ordinal';
            
            $result = DB::query($sql);
            while ($return = $result->fetchObject()) {
                $this->_fields[$return->Column_Name]['primary_key'] = true;
            }
        }
     }
      
     /**
      * Generate object
      *
      * @param string $object_name object name
      *
      * @return string
      */
     public function generateObject($object_name='')
     {
         if ($object_name != '') {
             $this->object_name=ucwords($object_name);
         } else {
             $this->object_name=ucwords($this->table);
         }
         $object="<?php\n";
         $object.= $this->generateDocFile();
         $object.="\n";
         $object.= $this->generateDocClass();
         //TODO: check if $_fileds null
         if ($object_name == '') {
             $object .= 'class '.ucwords($this->table)." implements IYuju_Array\n{\n";
         } else {
             $object .= 'class '.ucwords($object_name)." implements IYuju_Array\n{\n\n";
         }
         $object.= $this->generateVars();
         $object.= $this->generateConstructor();
         $object.= $this->generateGetterSetter();
         $object.= $this->generateLoad();
         $object.= $this->generateInsert();
         $object.= $this->generateUpdate();
         $object.= $this->generateDelete();
         $object.= $this->generateGetAll();
         $object.= $this->generateSearch();
          
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
         foreach ($this->_fields as $name=> $field) {
             if ($field['primary_key']) {
                 $id=$name;
             }
         }
         // TODO: make dinamic Primary Key
         $object='    /**'."\n";
         $object.= '     * Load '.$this->object_name."\n";
         $object.= '     *'."\n";
         $object.= '     * @param integer $id Id'."\n";
         $object.= '     *'."\n";
         $object.= '     * @return boolean'."\n";
         $object.= '     */'."\n";
         $object .= '    public function load($id)'."\n";
         $object .= "    {\n";
         $object .= '        if (is_numeric($id)) {'."\n";
         $object .= '            $return = DB::query(\'SELECT * FROM '.
                         $this->table.' WHERE '.$id.'=\'.DB::parse($id));'."\n";
         $object .= '            if ($return->numRows()>0) {'."\n";
         $object .= '                $'.$this->table.
         ' = $return->fetchObject();'."\n";
         foreach ($this->_fields as $name=> $field) {
             switch ($field['type']) {
                 case 'date':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setDateFromDB($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'datetime':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setDateTimeFromDB($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'time':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setTime($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'timestamp':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setDateTimeFromDB($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'year':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'bigint':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'decimal':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'double':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'float':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'int':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'mediumint':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'smallint':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'tinyint':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($'.$this->table.'->'.$name.');'."\n";
                     break;
                 case 'bit':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($'.$this->table.'->'.$name.');'."\n";
                     break;
                 default:
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.' = $'.$this->table.'->'.$name.';'."\n";
                     break;
             }
         }
         $object .= '                return true;'."\n";
         $object .= '            }'."\n";
         $object .= '        }'."\n";
         $object .= '        return false;'."\n";
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
         $object='    /**'."\n";
         $object.= '     * Insert '.$this->object_name."\n";
         $object.= '     *'."\n";
         $object.= '     * @return boolean'."\n";
         $object.= '     */'."\n";
         $object .= '    public function insert()'."\n";
         $object .= "    {\n";
         $object .= '        $sql=\'INSERT INTO '.$this->table.' (\';'."\n";
         $fields='';
         $values='';
         foreach ($this->_fields as $name=> $field) {
             if ($field['auto_incremental']) {
                 continue;
             } else {
                 $fields .= '        $sql.=\''.$name.',\';'."\n";
                 $values .= '        $sql.='.$this->_valueToDB($name, $field).',\';'."\n";
             }
         }
         $fields=substr($fields, 0, strlen($fields) - 4).'\';'."\n";
         $values=substr($values, 0, strlen($values) - 4).')\';'."\n";
         $object .= $fields.'        $sql.=\') VALUES(\';'."\n".$values;
         $object .= '        if (DB::query($sql)) {'."\n";
         foreach ($this->_fields as $name=> $field) {
             if ($field['auto_incremental']) {
                 $object .= '            $this->'.$name.'->setValue(DB::insertId());'."\n";
             }
         }
         $object .= '            return true;'."\n";
         $object .= '        } else {'."\n";
         $object .= '            return false;'."\n";
         $object .= '        }'."\n";
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
         $object='    /**'."\n";
         $object.= '     * Update '.$this->object_name."\n";
         $object.= '     *'."\n";
         $object.= '     * @return boolean'."\n";
         $object.= '     */'."\n";
          
         $where='        $sql.=\'WHERE \';'."\n";
         $object .= '    public function update()'."\n";
         $object .= "    {\n";
         $object .= '        $sql=\'UPDATE '.$this->table.' SET \';'."\n";
         foreach ($this->_fields as $name=> $field) {
             if ($field['auto_incremental']) {
                 $where.='        $sql.=\''.$name.'=\'.'.$this->_valueToDB($name, $field).'\';'."\n";
             } else {
                 $object .= '        $sql.=\''.$name.'=\'.'.$this->_valueToDB($name, $field).',\';'."\n";
             }
         }
         $object=substr($object, 0, strlen($object) - 4).' \';'."\n".$where;
         $object .= '        if (DB::query($sql)) {'."\n";
         $object .= '            return true;'."\n";
         $object .= '        } else {'."\n";
         $object .= '            return false;'."\n";
         $object .= '        }'."\n";
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
         $object='    /**'."\n";
         $object.= '     * Delete '.$this->object_name."\n";
         $object.= '     *'."\n";
         $object.= '     * @return boolean'."\n";
         $object.= '     */'."\n";
         $object .= '    public function delete()'."\n";
         $object .= "    {\n";
         $object .= '        $sql=\'DELETE FROM '.$this->table.' WHERE \';'."\n";
         foreach ($this->_fields as $name=> $field) {
             // TODO: Make to Primary key
             if ($field['auto_incremental']) {
                 $object.='        $sql.=\''.$name.'=\'.'.$this->_valueToDB($name, $field).'\';'."\n";
             }
         }
         $object .= '        if (DB::query($sql)) {'."\n";
         $object .= '            return true;'."\n";
         $object .= '        } else {'."\n";
         $object .= '            return false;'."\n";
         $object .= '        }'."\n";
         $object .= "    }\n\n";
         return $object;
     }
      
     public function generateSearch()
     {
         $object="\n";
         $object='    /**'."\n";
         $object .= '     * Return Array'."\n";
         $object .= '     *'."\n";
         $object .= '     * @return Array'."\n";
         $object .= '     */'."\n";
         $object .= '     public static function search(array $parametros, $num=null, $page=null, $yuju=true) {'."\n";
         $object .= '        if ($yuju) {'."\n";
         //creamos un nuevo array yuju con el nombre de la tabla
         if ($this->object_name == '') {
             $object .= '            $array = new Yuju_Array(new '.ucwords($this->table).'());'."\n";
         } else {
             $object .= '            $array = new Yuju_Array(new '.$this->object_name.'());'."\n";
         }
         $object .= '        } else {'."\n";
         //creamos un array
         $object .= '                $array = array();'."\n";
         $object .= '        } '."\n";
         $object .= '        $where = "";'."\n";
          
         $object .= '        foreach ($parametros as $key => $param) {'."\n";
         //recorrido por los campos
         $object .= '            switch ($key) {'."\n";
         foreach ($this->_fields as $name=> $field) {
             //$object .=                $field['type']."--"; saber el tipo de campo (int, varchar....)
             //$object .=                $field['auto_incremental']."--"; //saber el campo es autoincremental
             if (!$field['auto_incremental']) { //si el campo no es auto incremental..
                 //switch de todos los campos
                 //aqui hacemos la condicion dependiendo del campo
                 switch ($field['type']) {
                     case "char":
                     case "longtext":
                     case "varchar":
                     case "mediumtext":
                     case "text":
                     case "tinytext":
                         $object .= '                case "like-'.$name.'":'."\n";
                         $object .= "                    \$where.='".$name." LIKE \'%' . DB::Parse(\$param) . '%\' AND ';"."\n";
                         $object .= '                    break;'."\n";
                         $object .= '                case "eq-'.$name.'":'."\n";
                         $object .= "                    \$where.='".$name." =\'' . DB::Parse(\$param) . '\' AND ';"."\n";
                         $object .= '                    break;'."\n";
                         break;
                     case "bit":
                         $object .= '                case "eq-'.$name.'":'."\n";
                         $object .= "                    \$where.='".$name." =\'' . DB::Parse(\$param) . '\' AND ';"."\n";
                         $object .= '                    break;'."\n";
                         break;
                     case "double":
                     case "bigint":
                     case "decimal":
                     case "float":
                     case "int":
                     case "tinyint":
                     case "mediumint":
                     case "smallint":
                         $object .= '                case "eq-'.$name.'":'."\n";
                         $object .= '                    if (is_numeric($param)) {'."\n";
                         $object .= "                        \$where.='".$name." =\'' . DB::Parse(\$param) . '\' AND ';"."\n";
                         $object .= '                    } else {'."\n";
                         $object .= '                        Error::setError("'.$this->object_name.'SearchError", "You Cant insert $param in eq-'.$name.' is not a number");'."\n";
                         $object .= '                    }'."\n";
                         $object .= '                    break;'."\n";
                         $object .= '                case "like-'.$name.'":'."\n";
                         $object .= '                    if (is_numeric($param)) {'."\n";
                         $object .= "                        \$where.='".$name." LIKE \'%' . DB::Parse(\$param) . '%\' AND ';"."\n";
                         $object .= '                    } else {'."\n";
                         $object .= '                        Error::setError("'.$this->object_name.'SearchError", "You Cant insert $param in like-'.$name.' is not a number");'."\n";
                         $object .= '                    }'."\n";
                         $object .= '                    break;'."\n";
                         $object .= '                case "from-'.$name.'":'."\n";
                         $object .= '                    if (is_numeric($param)) {'."\n";
                         $object .= "                        \$where.='".$name." >= \'' . DB::Parse(\$param) . '\' AND ';"."\n";
                         $object .= '                    } else {'."\n";
                         $object .= '                        Error::setError("'.$this->object_name.'SearchError", "You Cant insert $param in from-'.$name.' is not a number");'."\n";
                         $object .= '                    }'."\n";
                         $object .= '                    break;'."\n";
                         $object .= '                case "to-'.$name.'":'."\n";
                         $object .= '                    if (is_numeric($param)) {'."\n";
                         $object .= "                        \$where.='".$name." <= \'' . DB::Parse(\$param) . '\' AND ';"."\n";
                         $object .= '                    } else {'."\n";
                         $object .= '                        Error::setError("'.$this->object_name.'SearchError", "You Cant insert $param in to-'.$name.', is not a number");'."\n";
                         $object .= '                    }'."\n";
                         $object .= '                    break;'."\n";
                         break;
                     case "year":
                     case "time":
                     case "datetime":
                     case "date":
                         $object .= '                case "eq-'.$name.'":'."\n";
                         $object .= "                    \$where.='".$name." =\'' . DB::Parse(\$param) . '\' AND ';"."\n";
                         $object .= '                    break;'."\n";
                         $object .= '                case "ini-'.$name.'":'."\n";
                         $object .= "                    \$where.='".$name." >= \'' . DB::Parse(\$param) . '\' AND ';"."\n";
                         $object .= '                    break;'."\n";
                         $object .= '                case "end-'.$name.'":'."\n";
                         $object .= "                    \$where.='".$name." <= \'' . DB::Parse(\$param) . '\' AND ';"."\n";
                         $object .= '                    break;'."\n";
                         break;
                 }
                 if ($field['primary_key']) {
                     $id=$name;
                 }
             } else {
                 if ($field['primary_key']) {
                     $id=$name;
                 }
             }
         }
         $object .= '          }    '."\n";
          
         $object .= '        } '."\n";
         $object .= '        if (Error::haveError("'.$this->object_name.'SearchError")) {'."\n";
         $object .= '            return false;'."\n";
         $object .= '        } else {'."\n";
          
         //hacemos la consulta con la primary key
         $object .= '            if($yuju) {'."\n";
         $object .= '                $sql = "SELECT '.$id.' FROM "; '."\n";
         $object .= '            } else {'."\n";
         $object .= '                $sql = "SELECT * FROM ";'."\n";
         $object .= '            } '."\n";
         //nombre de la tabla
         $object .= '            $sql.="'.$this->table.'";'."\n";
          
         //si hay condicion en el where.. quitamos el ultimo and
         $object .= '            if ($where != "") {'."\n";
         $object .= '                $where = " WHERE " . substr($where, 0, strlen($where) - 4);'."\n";
         $object .= '            }'."\n";
          
         //creamos la consulta
         $object .= "            \$return = DB::Query(\$sql . \$where );"."\n";
          
         //si no hay paginador..
         $object .= '            if($num==null || $page==null) {'."\n";
         $object .= '                if ($yuju) { '."\n";
         $object .= '                    while ($'.$this->table.' = $return->fetchObject()) {'."\n";
         $object .= '                        $array->add($'.$this->table.'->'.$id.'); '."\n"; //id es la primary key
         $object .= '                    } '."\n";
         $object .= '                } else { '."\n";
         $object .= '                    $array = $return->toArray();'."\n";
         $object .= '                } '."\n";
         $object .= '            } else { '."\n"; //si hay paginador..
         $object .= '                if ($yuju) { '."\n";
         $object .= '                    $array->loadFromDB($return,"'.$id.'", $num, $page);'."\n";
         $object .= '                } else { '."\n";
         $object .= '                    $array = $return->toArray($num, $page);'."\n";
         $object .= '                } '."\n";
         $object .= '            } '."\n";
         $object .= '        return $array;'."\n";
         $object .= '        } '."\n";
         $object .= '     }'."\n";
          
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
         $value='';
         switch ($field['type']) {
             case 'date':
                 $value .= '$this->'.$name.'->dateToDB().\'';
                 break;
             case 'datetime':
                 $value .= '$this->'.$name.'->dateTimeToDB().\'';
                 break;
             case 'time':
                 $value .= '$this->'.$name.'->TimeToDB().\'';
                 break;
             case 'timestamp':
                 $value .= '$this->'.$name.'->dateTimeToDB().\'';
                 break;
             case 'year':
                 $value .= '$this->'.$name.'->getValueToDB().\'';
                 break;
             case 'bigint':
                 $value .= '$this->'.$name.'->getValueToDB().\'';
                 break;
             case 'decimal':
                 $value .= '$this->'.$name.'->getValueToDB().\'';
                 break;
             case 'double':
                 $value .= '$this->'.$name.'->getValueToDB().\'';
                 break;
             case 'float':
                 $value .= '$this->'.$name.'->getValueToDB().\'';
                 break;
             case 'int':
                 $value .= '$this->'.$name.'->getValueToDB().\'';
                 break;
             case 'mediumint':
                 $value .= '$this->'.$name.'->getValueToDB().\'';
                 break;
             case 'smallint':
                 $value .= '$this->'.$name.'->getValueToDB().\'';
                 break;
             case 'tinyint':
                 $value .= '$this->'.$name.'->getValueToDB().\'';
                 break;
             case 'bit':
                 $value .= '$this->'.$name.'->getValueDB().\'';
                 break;
             default:
                 $value .= '\'\\\'\'.DB::parse($this->'.$name.').\'\\\'';
                 break;
         }
         return $value;
     }
     
     /**
      * Generate base
      * 
      * @param string $directory directory
      */
     public function generateBase($directory)
     {
         return false;
     }
 }
 