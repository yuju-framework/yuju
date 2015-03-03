<?php
/**
 * ORM_SQLServer_WS_CSharp File
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
 * @version  SVN: $Id: ORM_SQLServer_WS_CSharp.php 200 2015-03-03 10:46:08Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * ORM_SQLServer_WS_CSharp Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
class ORM_SQLServer_WS_CSharp extends ORM_SQLServer
{
    protected $namespace = 'WebService';
    
    protected $urlnamespace = 'http://www.temp-uri.com';
    
    /**
     * Setter NameSpace
     * 
     * @param string $var namespace
     * 
     * @return boolean
     */
    public function setNameSpace($var)
    {
        $this->namespace = $var;
        return true;
    }
    
    /**
     * Setter URL NameSpace
     * 
     * @param string $var URL namespace
     * 
     * @return boolean
     */
    public function setURLNameSpace($var)
    {
        $this->urlnamespace = $var;
        return true;
    }

    /**
     * Generate object
     *
     * @param string $object_name object name
     * 
     * @return string
     */
    public function generateObject($object_name = '')
    {
        if ($object_name != '') {
            $this->object_name=ucwords($object_name);
        } elseif ($this->object_name=='') {
            $this->object_name=ucwords($this->table);
        }
        $object = $this->generateDocFile();
        $object .= "using System;
using System.Collections;
using System.Data;
using System.Data.SqlClient;
using System.Web;
using System.Web.Services;
using System.Web.Services.Protocols;
using System.IO;
using System.Net.Mail;
using System.Net;
using System.Configuration;

namespace ".$this->namespace."
{
".$this->generateDocClass()."
    [WebService(Description=\"WebService\",Namespace=\"".$this->urlnamespace."\")]
    public class WS_".$this->object_name.":WSBase
    {
        public WSAuthenticationHeader auth;
        
";
        $object.= $this->generateLoad();
        $object.= $this->generateInsert();
        $object.= $this->generateUpdate();
        $object.= $this->generateDelete();
        $object.= $this->generateSearch();
        $object .= "    }\n"
                ."}";
        return $object;
    }
    
    /**
     * Generate file doc
     *
     * @return string
     */
    public function generateDocFile()
    {
        $return  = '/// <summary>'."\n";
        $return .= '/// Copyright by the authors.'."\n";
        $return .= '/// </summary>'."\n";
        return $return;
    }
    
    /**
     * Generate class doc
     *
     * @return string
     */
    public function generateDocClass()
    {
        $return  = '    /// <summary>'."\n";
        $return .= '    /// Web Service '.$this->object_name."\n";
        $return .= '    /// </summary>';
        return $return;
    }

    /**
     * Generate vars
     *
     * @return string
     */
    public function generateVars()
    {
        $object  = $this->generateDocFile();
        $object .='using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Xml.Serialization;
namespace '.$this->namespace.'
{'."\n";
        $object.= $this->generateDocClass()."\n";
        $object.= '    public class '.$this->object_name.':WSBase'."\n";
        $object.= '    {'."\n";
        foreach ($this->_fields as $name=> $field) {
            $object .= "        [XmlElement(IsNullable = true)]\n";
            $object .= "        public string ".$name.";\n\n";
        }
        $object.='    }'."\n";
        $object.='}';
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
        
        $object='        [WebMethod(Description = "Loader '.$this->object_name.'")]'."\n";
        $object .= '        [SoapHeader("auth")]'."\n";
        $object .= '        public '.$this->object_name.' WS_'.$this->object_name.'load(string id)'."\n";
        $object .= "        {\n";
        $object .= "            if (auth.User != WSConfig.WSUser || auth.Password != WSConfig.WSPassword) {\n";
        $object .= "                ".$this->object_name." error = new ".$this->object_name." ();\n";
        $object .= "                error.error_code = \"0\";\n";
        $object .= "                error.error_msj = \"Failed to authenticate user\";\n";
        $object .= "                return error;\n";
        $object .= "            }\n";
        $object .= "            ".$this->object_name." retorno = new ".$this->object_name."();\n";
        $object .= "            \n";
        $object .= "            using (SqlConnection conexion = new SqlConnection(WSConfig.connectionString))\n";
        $object .= "            {\n";
        $object .= "                conexion.Open();\n";
        $object .= "                SqlCommand command = new SqlCommand(null, conexion);\n";
        $select = "";
        $campos = '';
        foreach ($this->_fields as $name=> $field) {
                $campos.=$name.',';
        }
        $campos = substr($campos,0, -1);
        $object .= '                command.CommandText = "SELECT '.$campos.' FROM '.$this->table.' WHERE '.$id.'=@id;";'."\n";
        $object .= '                command.Parameters.Add("@id", SqlDbType.Int).Value = Convert.ToInt32(id);'."\n";
        $object .= "                command.Prepare();\n";
        $object .= "                using (SqlDataReader myReader = command.ExecuteReader(CommandBehavior.CloseConnection))\n";
        $object .= "                {\n";
        $object .= "                    while (myReader.Read())\n";
        $object .= "                    {\n";
        $i=0;
        
        foreach ($this->_fields as $name=> $field) {
            $object .= "                        retorno.".$name." = ";
            if ($field['type'] == 'int') {
                $object .= '(myReader.IsDBNull('.$i.') == true) ? "" : myReader.GetInt32('.$i.').ToString();'."\n";
            } elseif ($field['type'] == 'varchar' || $field['type'] == 'nchar') {
                $object .= '(myReader.IsDBNull('.$i.') == true) ? "" : myReader.GetString('.$i.');'."\n";
            } elseif ($field['type'] == 'datetime') {
                $object .= '(myReader.IsDBNull('.$i.') == true) ? "" : myReader.GetDateTime('.$i.').ToString();'."\n";
            } elseif ($field['type'] == 'smallint') {
                $object .= '(myReader.IsDBNull('.$i.') == true) ? "" : myReader.GetInt16('.$i.').ToString();'."\n";
            } elseif ($field['type'] == 'decimal') {
                $object .= '(myReader.IsDBNull('.$i.') == true) ? "" : myReader.GetDecimal('.$i.').ToString();'."\n";
            }
            $i++;
        }
        $object .= "                    }\n";
        $object .= "                    myReader.Close();\n";
        $object .= "                }\n";
        $object .= "            }\n";
        $object .= "            return retorno;\n";
        $object .= "        }\n\n";
        return $object;
    }

    public function generateSearch()
    {

        foreach ($this->_fields as $name=> $field) {
            if ($field['primary_key']) {
                $id=$name;
            }
        }
        
        $object  = "        [WebMethod(Description = \"Buscador tabla ".$this->object_name."\")]\n";
        $object .= "        [SoapHeader(\"auth\")]\n";
        $object .= "        public WSSearch WS_".$this->object_name."Search(string[] fields, string[] values, string num = null, string page = null)\n";
        $object .= "        {\n";
        $object .= "            if (auth.User != WSConfig.WSUser || auth.Password != WSConfig.WSPassword) {\n";
		$object .= "                WSSearch error = new WSSearch ();\n";
		$object .= "                error.error_code = \"0\";\n";
		$object .= "                error.error_msj = \"Failed to authenticate user\";\n";
		$object .= "                return error;\n";
		$object .= "            }\n";
        $object .= "            string where = \"\";\n";
        $object .= "            string order = \"\";\n";
        $object .= "            string orderdir = \"\";\n";
        $object .= "            ArrayList AL = new ArrayList();\n";
        $object .= "            WSSearch retorno = new WSSearch ();\n";
        $object .= "            \n";
        $object .= "            using(SqlConnection conexion = new SqlConnection(WSConfig.connectionString))\n";
        $object .= "            {\n";
        $object .= "                conexion.Open();\n";
        $object .= "                SqlCommand command = new SqlCommand (null, conexion);\n";
        $object .= "                for (int iter = 0; iter < fields.Length; iter++) {\n";
        $object .= "                    switch (fields [iter]) {\n";


        foreach ($this->_fields as $name=> $field) {
            $object .= $this->getSearchVar($name, $field);
        }

        $object .= "                        case \"orderby\":\n";
        $object .= "                            order = values [iter];\n";
        $object .= "                            break;\n";
        $object .= "                        case \"orderdir\":\n";
        $object .= "                            orderdir = values [iter];\n";
        $object .= "                            break;\n";
        $object .= "                    }\n";
        $object .= "                }\n";
        $object .= "                \n";
        $object .= "                if (where != \"\") {\n";
        $object .= "                    where = \" WHERE \" + where.Remove (where.Length - 4);\n";
        $object .= "                }\n\n";
        $object .= "                string whereNums = \"\";\n";
        $object .= "                if (num != null && page != null) {\n";
        $object .= "                    int numero = Convert.ToInt32 (num);\n";
        $object .= "                    int pagina = Convert.ToInt32 (page);\n";
        $object .= "                    whereNums=\") AS a WHERE rows >= \" + (((pagina - 1) * numero) + 1) + \" AND rows <= \" + (pagina * numero);\n";
        $object .= "                } else {\n";
        $object .= "                    whereNums = \") AS a\";\n";
        $object .= "                }\n";
        $object .= "                \n";
        $campos ='';
        foreach ($this->_fields as $name=> $field) {
            $campos.=$name.',';
        }
        $campos = substr($campos,0, -1);
        $object .= "                command.CommandText=\"SELECT ".$campos." FROM (SELECT ".$campos.", ROW_NUMBER() OVER (ORDER BY \"+order+\" \"+orderdir+\") AS rows FROM ".$this->table." \" + where + whereNums + \" ORDER BY \"+order+\" \"+orderdir;\n";
        $object .= "                command.Prepare ();\n";
        $object .= "                using (SqlDataReader myReader = command.ExecuteReader (CommandBehavior.Default))\n";
        $object .= "                {\n";
        $object .= "                    while (myReader.Read()) {\n";
        $object .= "                        ".$this->object_name." ".strtolower($this->object_name)." = new ".$this->object_name."();\n";
        $c = 0;
        foreach ($this->_fields as $name=> $field) {
            switch ($field['type']) {
                case "int":
                    $object .= "                        ".strtolower($this->object_name).".".$name." = (myReader.IsDBNull (".$c.") == true) ? \"\" : myReader.GetInt32 (".$c.").ToString ();\n";
                    break;
                case "varchar":
                case "nvarchar":
                    $object .= "                        ".strtolower($this->object_name).".".$name." = (myReader.IsDBNull (".$c.") == true) ? \"\" : myReader.GetString (".$c.");\n";
                    break;
                case "datetime":
                    $object .= "                        ".strtolower($this->object_name).".".$name." = (myReader.IsDBNull (".$c.") == true) ? \"\" : myReader.GetDateTime (".$c.").ToString();\n";
                    break;
                case "decimal":
                    $object .= "                        ".strtolower($this->object_name).".".$name." = (myReader.IsDBNull (".$c.") == true) ? \"\" : myReader.GetDecimal (".$c.").ToString();\n";
                    break;
            }
            $c++;
        }
        
        $object .= "                        AL.Add (".strtolower($this->object_name).");\n";
        $object .= "                    }\n";
        $object .= "                    myReader.Close();\n";
        $object .= "                }\n";
        $object .= "                \n";
        $object .= "                command.CommandText = \"SELECT count(*) AS total FROM ".$this->table." \" + where;\n";
        $object .= "                command.Prepare ();\n";
        $object .= "                using (SqlDataReader myReader = command.ExecuteReader (CommandBehavior.CloseConnection))\n";
        $object .= "                {\n";
        $object .= "                    myReader.Read ();\n";
        $object .= "                    retorno.num_rows = myReader.GetInt32 (0).ToString ();\n";
        $object .= "                    myReader.Close();\n";
        $object .= "                }\n";
        $object .= "                conexion.Close();\n";
        $object .= "            }\n";
        $object .= "            retorno.result = AL.ToArray (typeof(".$this->object_name.")) as ".$this->object_name."[];\n";
        $object .= "            return retorno;\n";
        $object .= "        }\n\n";
        return $object;
    }
    
    protected function getSearchVar($name, $field)
    {
        $object ='';
        switch ($field['type']) {
            case "char":
                $object .= '                    case "like-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." LIKE @like_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@like_".$name."\", SqlDbType.Char, ".$field['number'].").Value = \"%\" + values [iter] + \"%\";\n";
                $object .= '                        break;'."\n";
                $object .= '                    case "eq-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." = @eq_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@eq_".$name."\", SqlDbType.Char, ".$field['number'].").Value = values [iter];\n";
                $object .= '                        break;'."\n";
                break;
            case "varchar":
                $object .= '                    case "like-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." LIKE @like_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@like_".$name."\", SqlDbType.VarChar, ".$field['number'].").Value = \"%\" + values [iter] + \"%\";\n";
                $object .= '                        break;'."\n";
                $object .= '                    case "eq-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." = @eq_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@eq_".$name."\", SqlDbType.VarChar, ".$field['number'].").Value = values [iter];\n";
                $object .= '                        break;'."\n";
                break;
            case "nchar":
                $object .= '                    case "like-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." LIKE @like_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@like_".$name."\", SqlDbType.NChar, ".$field['number'].").Value = \"%\" + values [iter] + \"%\";\n";
                $object .= '                        break;'."\n";
                $object .= '                    case "eq-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." = @eq_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@eq_".$name."\", SqlDbType.NChar, ".$field['number'].").Value = values [iter];\n";
                $object .= '                        break;'."\n";
                break;
            case "bit":
                $object .= '                    case "eq-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." = @eq_".$name." AND \";\n";
                $object .= '                        break;'."\n";
                break;
            case "double":
            case "bigint":
            case "decimal":
            case "float":
            case "int":
            case "tinyint":
            case "mediumint":
            case "smallint":
                $object .= '                    case "eq-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." = @eq_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@eq_".$name."\", SqlDbType.Int).Value = Convert.ToInt32(values [iter]);\n";
                $object .= '                        break;'."\n";
                $object .= '                    case "like-'.$name.'":'."\n";
                $object .= "                        where+=\"Cast(".$name." As nvarchar(20)) LIKE @like_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@like_".$name."\", SqlDbType.NVarChar, 20).Value = \"%\" + values [iter] + \"%\";\n";
                $object .= '                        break;'."\n";
                $object .= '                    case "from-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." >= @from_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@from_".$name."\", SqlDbType.Int).Value = Convert.ToInt32(values [iter]);\n";
                $object .= '                        break;'."\n";
                $object .= '                    case "to-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." <= @to_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@to_".$name."\", SqlDbType.Int).Value = Convert.ToInt32(values [iter]);\n";
                $object .= '                        break;'."\n";
                break;
            case "datetime":
                $object .= '                    case "eq-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." = @eq_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@eq_".$name."\", SqlDbType.DateTime).Value = values [iter];\n";
                $object .= '                        break;'."\n";
                $object .= '                    case "ini-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." >= @ini_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@ini_".$name."\", SqlDbType.DateTime).Value = values [iter] + \" 00:00:00\";\n";
                $object .= '                        break;'."\n";
                $object .= '                    case "end-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." <= @end_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@end_".$name."\", SqlDbType.DateTime).Value = values [iter] + \" 23:59:59\";\n";
                $object .= '                        break;'."\n";
                break;
            case "date":
                $object .= '                    case "eq-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." = @eq_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@eq_".$name."\", SqlDbType.Date).Value = values [iter];\n";
                $object .= '                        break;'."\n";
                $object .= '                    case "ini-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." >= @ini_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@ini_".$name."\", SqlDbType.Date).Value = values [iter];\n";
                $object .= '                        break;'."\n";
                $object .= '                    case "end-'.$name.'":'."\n";
                $object .= "                        where+=\"".$name." >= @end_".$name." AND \";\n";
                $object .= "                        command.Parameters.Add (\"@end_".$name."\", SqlDbType.Date).Value = values [iter];\n";
                $object .= '                        break;'."\n";
                break;
        }
        return $object;
    }

    
    /**
     * Generate inserts
     *
     * @return string
     */
    public function generateInsert()
    {
        $object  = "        [WebMethod(Description = \"Insert ".$this->object_name."\")]\n";
        $object .= "        [SoapHeader(\"auth\")]\n";
        $object .= '        public int WS_'.$this->object_name.'Insert(';
        foreach ($this->_fields as $name => $field) {
            $object .= 'string '.$name.', ';
        }
        
        $object = substr($object, 0,-2).')' . "\n";
        $object .= "        {\n";
        $object .= '            if (auth.User != WSConfig.WSUser || auth.Password != WSConfig.WSPassword) {' . "\n";
        $object .= '                return 0;' . "\n";
        $object .= '            }' . "\n";
        $object .= '            int r;' . "\n";
        $object .= '            using (SqlConnection conexion = new SqlConnection(WSConfig.connectionString))' . "\n";
        $object .= '            {' . "\n";
        $object .= '                conexion.Open();' . "\n";
        $object .= '                SqlCommand command = new SqlCommand(null, conexion);' . "\n";
        $object .= '                command.CommandText = "INSERT INTO '.$this->table.' (';
        $values = '';
        foreach ($this->_fields as $name => $field) {
            if (!$field['primary_key']) {
                $values .='@'.$name.',';
                $object .=$name.',';
            }
        }
        $values = substr($values, 0, -1);
        $object=substr($object, 0,-1).') VALUES('.$values.")\";\n";
        foreach($this->_fields as $name => $field) {
            if (!$field['primary_key']) {
                $object.='                '.$this->getParameterVar($name, $field)."\n";
            }
        }
        $object .= '                command.Prepare();' . "\n";
        $object .= '                command.ExecuteNonQuery();' . "\n";
        $object .= '                command.Parameters.Clear();' . "\n";
        $object .= '                command.CommandText ="SELECT @@IDENTITY";'."\n";
        $object .= '                r = Convert.ToInt32( command.ExecuteScalar() );'."\n";
        $object .= '                conexion.Close();'."\n";
        $object .= '            }'."\n";
        $object .= '            return r;' . "\n";
        $object .= "        }\n\n";
        return $object;
    }

    /**
     * Generate update function
     * 
     * @return string
     */
    public function generateUpdate()
    {
        
        $object  = "        [WebMethod(Description = \"Update ".$this->object_name."\")]\n";
        $object .= "        [SoapHeader(\"auth\")]\n";
        $object .= '        public int WS_'.$this->object_name.'Update(';
        foreach ($this->_fields as $name => $field) {
            $object .= 'string '.$name.', ';
        }
        
        $object = substr($object, 0,-2).')' . "\n";
        $object .= "        {\n";
        $object .= '            if (auth.User != WSConfig.WSUser || auth.Password != WSConfig.WSPassword) {' . "\n";
        $object .= '                return 0;' . "\n";
        $object .= '            }' . "\n";
        $object .= '            int r;' . "\n";
        $object .= '            using (SqlConnection conexion = new SqlConnection(WSConfig.connectionString))' . "\n";
        $object .= '            {' . "\n";
        $object .= '                conexion.Open();' . "\n";
        $object .= '                SqlCommand command = new SqlCommand(null, conexion);' . "\n";
        $object .= '                command.CommandText = "UPDATE '.$this->table.' SET ';
        foreach ($this->_fields as $name => $field) {
            if ($field['primary_key']) {
                $primary = 'WHERE '.$name.'=@'.$name;
            } else {
                $object .=$name.'=@'.$name.',';
            }
        }
        $object=substr($object, 0,-1).' '.$primary."\";\n";
        foreach($this->_fields as $name => $field) {
            $object.='                '.$this->getParameterVar($name, $field)."\n";
        }
        $object .= '                command.Prepare();' . "\n";
        $object .= '                r = command.ExecuteNonQuery();' . "\n";
        $object .= '                conexion.Close();' . "\n";
        $object .= '            }' . "\n";
        $object .= '            return r;' . "\n";
        $object .= "        }\n\n";
        return $object;
    }
      
    public function getParameterVar($name, $field)
    {
        $object ='';
        switch ($field['type']) {
            case 'varchar':
                $object .='command.Parameters.Add("@'.$name.'", SqlDbType.NVarChar, '.$field['number'].').Value = '.$name.';';
                break;
            case 'int':
                $object .='command.Parameters.Add("@'.$name.'", SqlDbType.Int).Value = '.$name.';';
                break;
        }
        return $object;
    }

    /**
     * Generate delete function
     *
     * @return string
     */
    public function generateDelete()
    {
        $object  = "        [WebMethod(Description = \"Delete ".$this->object_name."\")]\n";
        $object .= "        [SoapHeader(\"auth\")]\n";
        $object .= '        public int WS_'.$this->object_name.'Delete(string id)'."\n";
        $object .= "        {\n";
        $object .= '            if (auth.User != WSConfig.WSUser || auth.Password != WSConfig.WSPassword) {' . "\n";
        $object .= '                return 0;' . "\n";
        $object .= '            }' . "\n";
        $object .= '            int r;' . "\n";
        $object .= '            using (SqlConnection conexion = new SqlConnection(WSConfig.connectionString))' . "\n";
        $object .= '            {' . "\n";
        $object .= '                conexion.Open();' . "\n";
        $object .= '                SqlCommand command = new SqlCommand(null, conexion);' . "\n";
        foreach ($this->_fields as $name => $field) {
            if ($field['primary_key']) {
                $primary = $name;
            }
        }
        $object .= '                command.CommandText = "DELETE FROM '.$this->table.' WHERE '.$primary.'=@id";' . "\n";
        $object .= '                command.Parameters.Add("@id", SqlDbType.Int).Value = id;' . "\n";
        $object .= '                command.Prepare();' . "\n";
        $object .= '                r = command.ExecuteNonQuery();' . "\n";
        $object .= '                conexion.Close();' . "\n";
        $object .= '            }' . "\n";
        $object .= '            return r;' . "\n";
        $object .= "        }\n\n";
        return $object;
    }
    
    /**
     * Generate base files
     * 
     * @param string $directory project directory
     */
    public function generateBase($directory)
    {
        $file = new File(); 
        $file->setContent('using System;
using System.Collections;
using System.Web;
using System.Web.Services.Protocols;

namespace '.$this->namespace.'
{
	public class WSAuthenticationHeader : SoapHeader
	{
			public string User;
			public string Password;
	}
}');
        $file->create($directory.'WSAuthenticationHeader.cs');
        $file->close();
        $file->setContent('using System;

namespace '.$this->namespace.'
{
	public class WSSearch : WSBase
	{
		public string num_rows;
		public WSBase[] result;
	}
}');
        $file->create($directory.'WSSearch.cs');
        $file->close();
        $file->setContent('using System;
using System.Collections.Generic;
using System.Web;
using System.Xml.Serialization;

namespace '.$this->namespace.'
{
    public class WSBase
    {
        [XmlElement(IsNullable = true)]
		public string error_code;
		[XmlElement(IsNullable = true)]
        public string error_msj;
    }
}');
        $file->create($directory.'WSBase.cs');
        $file->close();
        $file->setContent('using System;

namespace '.$this->namespace.'
{
	public class WSConfig
	{
		protected static string DBHOST = "'.$this->db_host.'";
		protected static string DBUSER = "'.$this->db_user.'";
		protected static string DBPASS = "'.$this->db_pass.'";

		protected static string DBNAME = "'.$this->db_data.'";
		public static string connectionString = "Data Source="+DBHOST+";Initial Catalog="+DBNAME+";User ID="+DBUSER+";Password="+DBPASS;
        
        public static string WSUser = "user";
		public static string WSPassword = "pass";
                        
		public static string SMTPHOST = "";
		public static string SMTPUSER = "";
		public static string SMTPPASS = "";
	}
}');
        $file->create($directory.'WSConfig.cs');
        
    }
}
