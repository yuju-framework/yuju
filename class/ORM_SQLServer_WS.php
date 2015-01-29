<?php
/**
 * ORM_SQLServer_WS File
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
 * @version  SVN: $Id: Yuju_ORM.php 181 2014-03-20 15:31:04Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * ORM_SQLServer_WS Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
 class ORM_SQLServer_WS extends ORM_SQLServer
 {
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
         
         $object .= '            $ws=new WS(WS_'.strtoupper($this->object_name).');'."\n";
         $object .= '            $w=$ws->getConexion()->WS_'.$this->object_name.'load(array("id"=>$id));'."\n";
         $object .= '            if (count($w->WS_'.$this->object_name.'loadResult) != 0) {'."\n";
         $object .= '                $obj=$w->WS_'.$this->object_name.'loadResult;'."\n";
         foreach ($this->_fields as $name=> $field) {
             switch ($field['type']) {
                 case 'date':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setDateFromDB($obj->'.$name.');'."\n";
                     break;
                 case 'datetime':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setDateTimeFromDB($obj->'.$name.');'."\n";
                     break;
                 case 'time':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setTime($obj->'.$name.');'."\n";
                     break;
                 case 'timestamp':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setDateTimeFromDB($obj->'.$name.');'."\n";
                     break;
                 case 'year':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($obj->'.$name.');'."\n";
                     break;
                 case 'bigint':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($obj->'.$name.');'."\n";
                     break;
                 case 'decimal':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($obj->'.$name.');'."\n";
                     break;
                 case 'double':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($obj->'.$name.');'."\n";
                     break;
                 case 'float':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($obj->'.$name.');'."\n";
                     break;
                 case 'int':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($obj->'.$name.');'."\n";
                     break;
                 case 'mediumint':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($obj->'.$name.');'."\n";
                     break;
                 case 'smallint':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($obj->'.$name.');'."\n";
                     break;
                 case 'tinyint':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($obj->'.$name.');'."\n";
                     break;
                 case 'bit':
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.
                     '->setValue($obj->'.$name.');'."\n";
                     break;
                 default:
                     $object .= str_repeat(' ', 16).
                     '$this->'.$name.' = $obj->'.$name.';'."\n";
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
         $object .= '        $ws=new WS(WS_'.strtoupper($this->object_name).');'."\n";
         $object .= '        $w=$ws->getConexion()->WS_'.$this->object_name.'Insert(array('."\n";
         $fields = '';
         foreach ($this->_fields as $name => $field) {
             if($field['type'] =='double' || $field['type'] =='float' || $field['type'] =='int' || $field['type'] =='decimal') {
                 $fields .= '            "'.$name.'" =>$this->'.$name.'->getValue(),'."\n";
             } else {
                 $fields .= '            "'.$name.'" =>$this->'.$name.','."\n";
             }
         }
         $object.= substr($fields, 0, strlen($fields)-2)."\n";
         $object .= '        ));'."\n";
         $object .= '        return $w->WS_'.ucwords($this->object_name).'InsertResult;'."\n";
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
         $object .= '    public function update()'."\n";
         $object .= "    {\n";
         $object .= '        $ws=new WS(WS_'.strtoupper($this->object_name).');'."\n";
         $object .= '        $w=$ws->getConexion()->WS_'.$this->object_name.'Update(array('."\n";
         $fields = '';
         foreach ($this->_fields as $name => $field) {
             if($field['type'] =='double' || $field['type'] =='float' || $field['type'] =='int' || $field['type'] =='decimal') {
                 $fields .= '            "'.$name.'" =>$this->'.$name.'->getValue(),'."\n";
             } else {
                 $fields .= '            "'.$name.'" =>$this->'.$name.','."\n";
             }
         }
         $object.= substr($fields, 0, strlen($fields)-2)."\n";
         $object .= '        ));'."\n";
         $object .= '        return $w->WS_'.ucwords($this->object_name).'UpdateResult;'."\n";
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
         foreach ($this->_fields as $name=> $field) {
             if ($field['primary_key']) {
                 $id=$name;
             }
         }
         $object='    /**'."\n";
         $object.= '     * Delete '.$this->object_name."\n";
         $object.= '     *'."\n";
         $object.= '     * @return boolean'."\n";
         $object.= '     */'."\n";
         $object .= '    public function delete($id)'."\n";
         $object .= "    {\n";
         $object .= '        $ws=new WS(WS_'.strtoupper($this->object_name).');'."\n";
         $object .= '        $w=$ws->getConexion()->WS_'.$this->object_name.'Delete(array('."\n";
         $object .= '            "id" =>$this->'.$id.'->getValue(),'."\n";
         $object .= '        ));'."\n";
         $object .= '        return $w->WS_'.ucwords($this->object_name).'DeleteResult;'."\n";
         $object .= "    }\n\n";
         return $object;
     }
      
     public function generateSearch()
     {
         $object="\n";
         $object='    /**'."\n";
         $object .= '     * Search '.$this->object_name."\n";
         $object .= '     *'."\n";
         $object .= '     * @param array   $parameters array parameters'."\n";
         $object .= '     * @param integer $num        elements number'."\n";
         $object .= '     * @param integer $page       page number'."\n";
         $object .= '     * @param boolean $yuju       return Yuju array or array'."\n";
         $object .= '     *'."\n";
         $object .= '     * @return Yuju_Array'."\n";
         $object .= '     */'."\n";
         $object .= '     public static function search(array $parameters, $num=null, $page=null, $yuju=true)'."\n";
         $object .= '     {'."\n";
         $object .= '        $array = new Yuju_Array(new '.$this->object_name.'());'."\n";
         $object .= '        $fields = array();'."\n";
         $object .= '        $values = array();'."\n";
         $object .= '        foreach ($parameters as $key=> $param) {'."\n";
         $object .= '            $fields[]=$key;'."\n";
         $object .= '            $values[]=$param;'."\n";
         $object .= '        }'."\n";
         $object .= '        $ws=new WS(WS_'.strtoupper($this->object_name).');'."\n";
         $object .= '        $w=$ws->getConexion()->WS_'.$this->object_name.'Search(array("fields"=>$fields, "values"=>$values, "num"=>$num, "page"=>$page));'."\n";
         $object .= '        if (count($w->WS_'.$this->object_name.'SearchResult) != 0) {'."\n";
         $object .= '            if (isset($w->WS_'.$this->object_name.'SearchResult->result->WSBase)) {'."\n";
         $object .= '                if (count($w->WS_'.$this->object_name.'SearchResult->result->WSBase) == 1) {'."\n";
         $object .= '                    $c[]=$w->WS_'.$this->object_name.'SearchResult->result->WSBase;'."\n";
         $object .= '                } else {'."\n";
         $object .= '                    $c=$w->WS_'.$this->object_name.'SearchResult->result->WSBase;'."\n";
         $object .= '                }'."\n";
         $object .= '            } else {'."\n";
         $object .= '                $c=array();'."\n";
         $object .= '            }'."\n";
         $object .= '            foreach ($c as $val) {'."\n";
         $object .= '                $object = new '.$this->object_name.'();'."\n";
         
         
         
         foreach ($this->_fields as $name=> $field) {
             switch ($field['type']) {
                 case 'date':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setDateFromDB($val->'.$name.');'."\n";
                     break;
                 case 'datetime':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setDateTimeFromDB($val->'.$name.');'."\n";
                     break;
                 case 'time':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setTime($val->'.$name.');'."\n";
                     break;
                 case 'timestamp':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setDateTimeFromDB($val->'.$name.');'."\n";
                     break;
                 case 'year':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setValue($val->'.$name.');'."\n";
                     break;
                 case 'bigint':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setValue($val->'.$name.');'."\n";
                     break;
                 case 'decimal':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setValue($val->'.$name.');'."\n";
                     break;
                 case 'double':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setValue($val->'.$name.');'."\n";
                     break;
                 case 'float':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setValue($val->'.$name.');'."\n";
                     break;
                 case 'int':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setValue($val->'.$name.');'."\n";
                     break;
                 case 'mediumint':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setValue($val->'.$name.');'."\n";
                     break;
                 case 'smallint':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setValue($val->'.$name.');'."\n";
                     break;
                 case 'tinyint':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setValue($val->'.$name.');'."\n";
                     break;
                 case 'bit':
                     $object .= str_repeat(' ', 16).
                     '$object->get'.ucwords($name).
                     '()->setValue($val->'.$name.');'."\n";
                     break;
                 default:
                     $object .= str_repeat(' ', 16).
                     '$object->set'.ucwords($name).'($val->'.$name.');'."\n";
                     break;
             }
         }
         
         
         $object .= '                $array->add($object);'."\n";
         $object .= '            }'."\n";
         $object .= '            $array->setCount($w->WS_'.$this->object_name.'SearchResult->num_rows);'."\n";
         $object .= '        }'."\n";
         $object .= '        return $array;'."\n";
         $object .= '    }'."\n";
         
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
                 $value .= '\'\\\'\'.$this->'.$name.'.\'\\\'';
                 break;
         }
         return $value;
     }
     
     /**
      * @param unknown_type $directory
      */
     public function generateBase($directory)
     {
         // TODO: Auto-generated method stub
     
     }
 }