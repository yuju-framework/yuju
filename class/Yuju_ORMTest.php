<?php
/**
 * Yuju_ORM File
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
 * Yuju_ORM Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Yuju_ORMTest
{
    protected $table;
    protected $object_name;
    private $_fields;

    /**
     * Getter table
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Connect to database
     *
     * @param string $db_host host
     * @param string $db_user user
     * @param string $db_pass password
     * @param string $db_data database
     * @param string $db_type datbase type
     * 
     * @return boolean
     */
    public function connect($db_host, $db_user, $db_pass,$db_data,$db_type='mysql')
    {
        if (DB::Connection($db_type, $db_host, $db_user, $db_pass, $db_data)) {
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
        //TODO: check if table exists
        //TODO: SQL server tables and Oracle
        if ($result = DB::query('DESCRIBE ' . DB::Parse($table))) {
            $this->table = $table;
            while ($return = $result->fetchObject()) {
                $type = '';
                $number = null;
                $autoincremental = ($return->Extra == 'auto_increment') ? true : false;
                //var_dump($return);exit();
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
                } elseif (
                        preg_match("/varbinary\(([0-9]{1,3})\)/", $return->Type, $regs)
                ) {
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
                } elseif (
                        preg_match("/bigint\(([0-9]{1,3})\)/", $return->Type, $regs)
                ) {
                    $type = 'bigint';
                    $number = $regs[1];
                } elseif (
                        preg_match("/decimal\(([0-9]{1,3},[0-9]{1,3})\)/", $return->Type, $regs)
                ) {
                    $type = 'decimal';
                    $number = $regs[1];
                } elseif (
                    preg_match("/float\(([0-9]{1,3})\)/", $return->Type, $regs)
                ) {
                    $type = 'float';
                    $number = $regs[1];
                } elseif (
                        preg_match("/double\(([0-9]{1,3},[0-9]{1,3})\)/", $return->Type, $regs)
                ) {
                    $type = 'float';
                    $number = $regs[1];
                } elseif (
                        preg_match("/tinyint\(([0-9]{1,3})\)/", $return->Type, $regs)
                ) {
                    $type = 'tinyint';
                    $number = $regs[1];
                } elseif (
                        preg_match("/mediumint\(([0-9]{1,3})\)/", $return->Type, $regs)
                ) {
                    $type = 'mediumint';
                    $number = $regs[1];
                } elseif (
                        preg_match("/smallint\(([0-9]{1,3})\)/", $return->Type, $regs)
                ) {
                    $type = 'smallint';
                    $number = $regs[1];
                } elseif (
                        preg_match("/int\(([0-9]{1,3})\)/", $return->Type, $regs)
                ) {
                    $type = 'int';
                    $number = $regs[1];
                } elseif (
                        preg_match("/varchar\(([0-9]{1,3})\)/", $return->Type, $regs)
                ) {
                    $type = 'varchar';
                    $number = $regs[1];
                } elseif (
                        preg_match("/char\(([0-9]{1,3})\)/", $return->Type, $regs)
                ) {
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
                } elseif (
                        preg_match("/bit\(([0-9]{1,3})\)/", $return->Type, $regs)
                ) {
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
     * @param string $object_name object name
     * 
     * @return string
     */
    public function generateObject($object_name = '')
    {
        $this->object_name = $object_name;
        $object = "<?php\n";
        $object.= $this->generateDocFile();
        $object.="\n";
        $object.= $this->generateDocClass();
        //TODO: check if $_fileds null
        if ($object_name == '') {
            $object .= 'class ' . ucwords($this->table) . "Test extends PHPUnit_Framework_TestCase\n{\n";
        } else {
            $object .= 'class ' . $object_name . "Test extends PHPUnit_Framework_TestCase\n{\n\n";
        }
        
        $object.= $this->generateVars(); 
		$object.= $this->generateCreateClassObject();
		$object.= $this->generateConstructor();
		$object.= $this->generateCleanTable();
		$object.= $this->generateGetterSetter();
		$object.= $this->generateTestInsert(); 
		$object.= $this->generateTestLoad(); 
		$object.= $this->generateTestUpdate(); 
		$object.= $this->generateTestGetAll();  
		$object.= $this->generateTestTableArray();
		$object.= $this->generateTestSearch();
		$object.= $this->generateTestSearchPager();
		$object.= $this->generateTestDelete(); 
		
        $object .= "}";
        return $object;
    }
    
    public function generateTestObjectInRoute($object_name, $table, $route)
    {
        $gestor = fopen($route."/".$object_name."Test.php", "w");
        $this->load($table);
        $obj = $this->generateObject($object_name);   
        fputs($gestor,$obj);
        fclose ($gestor);
    }

    /**
     * Generate file doc
     * 
     * @return string
     */
    public function generateDocFile()
    {
        $return = '/**' . "\n";
        $return .= ' * ' . $this->object_name . ' File' . "\n";
        $return .= ' *' . "\n";
        $return .= ' * PHP version 5' . "\n";
        $return .= ' *' . "\n";
        $return .= ' * Copyright individual contributors as indicated by the @authors tag.' . "\n";
        $return .= ' *' . "\n";
        $return .= ' * This library is free software; you can redistribute it and/or' . "\n";
        $return .= ' * modify it under the terms of the GNU Lesser General Public' . "\n";
        $return .= ' * License as published by the Free Software Foundation; either' . "\n";
        $return .= ' * version 2.1 of the License, or (at your option) any later version.' . "\n";
        $return .= ' *' . "\n";
        $return .= ' * This library is distributed in the hope that it will be useful,' . "\n";
        $return .= ' * but WITHOUT ANY WARRANTY; without even the implied warranty of' . "\n";
        $return .= ' * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU' . "\n";
        $return .= ' * Lesser General Public License for more details.' . "\n";
        $return .= ' *' . "\n";
        $return .= ' * You should have received a copy of the GNU Lesser General Public' . "\n";
        $return .= ' * License along with this library.  If not, see <http://www.gnu.org/licenses/>.' . "\n";
        $return .= ' *' . "\n";
        $return .= ' * @category XXX' . "\n";
        $return .= ' * @package  XXX' . "\n";
        $return .= ' * @author   XXX <xxx@xxx.com>' . "\n";
        $return .= ' * @license  XXX'."\n";
        $return .= ' * @version  XXX'."\n";
        $return .= ' * @link     XXX' . "\n";
        $return .= ' * @since    XXX' . "\n";
        $return .= ' */' . "\n";
        return $return;
    }

    /**
     * Generate class doc
     * 
     * @return string
     */
    public function generateDocClass()
    {
        $return = '/**' . "\n";
        $return .= ' * ' . $this->object_name . ' Class' . "\n";
        $return .= ' *' . "\n";
        $return .= ' * @category XXX' . "\n";
        $return .= ' * @package  XXX' . "\n";
        $return .= ' * @author   XXX <xxx@xxx.com>' . "\n";
        $return .= ' * @license  XXX'."\n";
        $return .= ' * @version  Release: XXX' . "\n";
        $return .= ' * @link     XXX' . "\n";
        $return .= ' * @since    XXX' . "\n";
        $return .= ' */' . "\n";
        return $return;
    }

    /**
     * Generate vars
     *
     * @return string
     */
    public function generateVars()
    {
        $object = '';
        $object .= "    protected \$_" . strtolower($this->object_name) . ";\n\n";
        return $object;
    }	

    /**
     * Generate testCreateObject
     *
     * @return string
     */
    public function generateCreateClassObject()
    {
	$object = '';
        $object.= '    public function create'.$this->object_name.'()' . "\n";
        $object.= '    {' . "\n";		
		$object.= '		require_once __DIR__."/../config.php";' . "\n"; 
		$object.= '		$gestor = fopen(ROOT."'.$this->object_name.'.php", "w");' . "\n";
		$object.= '		$orm = new Yuju_ORM();' . "\n";
		$object.= '		$orm->load("'.$this->table.'");' . "\n";
		$object.= '		$obj = $orm->generateObject("'.$this->object_name.'");   ' . "\n";
		$object.= '		fputs($gestor,$obj);' . "\n";
		$object.= '		fclose ($gestor);' . "\n";
        $object.= '    }' . "\n\n";
        return $object;
    }
	
	/**
     * Generate constructor
     *
     * @return string
     */
    public function generateConstructor()
    {
        $object = '    /**' . "\n";
        $object.= '     * Constructor ' . "\n";
        $object.= '     *' . "\n";
        $object.= '     */' . "\n";
        $object.= '    public function setUp()' . "\n";
        $object.= '    {' . "\n";
        $object.= '		$this->create'.$this->object_name.'();'. "\n";
        $object.= '		$this->_'.strtolower($this->object_name). ' = new '.$this->object_name.'();'. "\n";
        $object.= '    }' . "\n\n";
        return $object;
    }
	
	/**
     * Generate cleanTable
     *
     * @return string
     */
    public function generateCleanTable()
    {
		$object = '    /**' . "\n";
		$object.= '     * CleanTable'. "\n";
		$object.= '     *' . "\n";
		$object.= '     */' . "\n";		
        $object.= '    public function cleanTable()' . "\n";
        $object.= '    {' . "\n";
        $object.= '		DB::query("truncate table '.$this->table.'");' . "\n";
        $object.= '    }' . "\n\n";
        return $object;
    }
	
	/**
     * Generate Getter and Setter
     *
     * @return string
     */
    public function generateGetterSetter()
    {
        $object = '';
        //TODO: if name field contains _ is next upper char
        foreach ($this->_fields as $name => $field) {
            
            // Setter
            if ($field['type'] == 'varchar' || $field['type'] == 'char' || $field['type'] == 'longtext' || $field['type'] == 'mediumtext' || $field['type'] == 'text' || $field['type'] == 'tinytext' || $field['type'] == 'enum' || $field['type'] == 'set' || $field['type'] == 'blob' || $field['type'] == 'longblob' || $field['type'] == 'mediumblob' || $field['type'] == 'tinyblob' || $field['type'] == 'varbinary' || $field['type'] == 'binary'
            ) {
                $object.= '    /**' . "\n";
                $object.= '     * Setter ' . $name . "\n";
                $object.= '     *' . "\n";
                $object.= '     * @param string $var XXX' . "\n";
                $object.= '     *' . "\n";
                $object.= '     * @return boolean' . "\n";
                $object.= '     */' . "\n";
                $object .= "    public function testSet" . ucwords($name) . "()\n";
                $object .= "    {\n";
                $object .= '        $this->setUp();'."\n";
                $object .= '        $this->assertTrue($this->_' . strtolower($this->object_name) . '->setNombre("aaa"));'."\n";
                $object .= '        $this->assertEquals($this->_' . strtolower($this->object_name) . '->getNombre(),"aaa");'."\n";
                $object .= "    }\n\n";
            }
			
			// Getter
            $object.= '    /**' . "\n";
            $object.= '     * Getter ' . $name . "\n";
            $object.= '     *' . "\n";
            $object.= '     * @return boolean' . "\n";
            $object.= '     */' . "\n";
            $object .= "    public function testGet" . ucwords($name) . "()\n";
            $object .= "    {\n";
            $object .= '        $this->setUp();'."\n";
            switch ($field['type']) {
            case 'date':
				$object .= '        $fecha = new Date();'."\n";
				$object .= '        $fecha->setDate(25, 11, 2000);'."\n";
                $object .= '        $this->_' . strtolower($this->object_name) .'->get'.ucfirst($name).'()->setDate(25, 11, 2000);'."\n";  
				$object .= '        $this->assertEquals($fecha->getDay(),$this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->getDay());'."\n";
				$object .= '        $this->assertEquals($fecha->getMonth(),$this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->getMonth());'."\n";
				$object .= '        $this->assertEquals($fecha->getYear(),$this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->getYear());'."\n";
                break;
            case 'datetime':
				$object .= '        $objDateTime = new Date();'."\n";
				$object .= '        $objDateTime->setDateTime(11, 12, 2000, 14, 10, 12);'."\n";
                $object .= '        $this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->setDateTime(11, 12, 2000, 14, 10, 12);'."\n";
				$object .= '        $this->assertEquals($objDateTime->getDay(),$this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->getDay());'."\n";
				$object .= '        $this->assertEquals($objDateTime->getMonth(),$this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->getMonth());'."\n";
				$object .= '        $this->assertEquals($objDateTime->getYear(),$this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->getYear());'."\n";
				$object .= '        $this->assertEquals($objDateTime->getMinutes(),$this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->getMinutes());'."\n";
				$object .= '        $this->assertEquals($objDateTime->getHour(),$this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->getHour());'."\n";
				$object .= '        $this->assertEquals($objDateTime->getSeconds(),$this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->getSeconds());'."\n";					
                break;
            case 'time':
				$time = "00:00:20";
				$object .= '        $dtime = new Date();'."\n";
				$object .= '        $dtime->setTime("'.$time.'");'."\n";
                $object .= '        $this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '()->setTime("'.$time.'");'."\n";
                $object .= '        $this->assertEquals($dtime->getHour(),$this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '()->getHour());'."\n";
				$object .= '        $this->assertEquals($dtime->getMinutes(),$this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '()->getMinutes());'."\n";
				$object .= '        $this->assertEquals($dtime->getSeconds(),$this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '()->getSeconds());'."\n";
                break;
            case 'timestamp':
                $object .= '        $objDateTime = new Date();'."\n";
				$object .= '        $objDateTime->setDateTime(11, 12, 2000, 14, 10, 12);'."\n";
                $object .= '        $this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->setDateTime(11, 12, 2000, 14, 10, 12);'."\n";
                $object .= '        $this->assertEquals($objDateTime->getDate(),$this->_' . strtolower($this->object_name) .'->get'.ucfirst($name). '()->getDate());'."\n";
                break;
            case 'year':
                $object .= '        $this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '()->setValue(1990);'."\n";
                $object .= '        $this->assertEquals(1990,$this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '()->getValue());'."\n";
                break;    
            case 'bigint':
            case 'decimal':
            case 'double':
            case 'float':
            case 'int':
            case 'mediumint':
            case 'smallint':
            case 'tinyint':
                $object .= '        $this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '()->setValue(24);'."\n";
                $object .= '        $this->assertEquals(24,$this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '()->getValue());'."\n";
                break;  
            case 'bit':               
                $object .= '        $this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '()->setValue(1);'."\n";
                $object .= '        $this->assertEquals(1,$this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '()->getValue());'."\n";
                break;
			case 'char':               
                $object .= '        $this->assertTrue($this->_' . strtolower($this->object_name) . '->set'.ucfirst($name).'("a"));'."\n";
                $object .= '        $this->assertEquals("a",$this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '());'."\n";
				break;						
            default :
                $object .= '        $this->assertTrue($this->_' . strtolower($this->object_name) . '->set'.ucfirst($name).'("aaa"));'."\n";
                $object .= '        $this->assertEquals("aaa",$this->_' . strtolower($this->object_name) . '->get' . ucfirst($name) . '());'."\n";
                break;
            }
            $object .= "    }\n\n";
            
        }
        return $object;
    }
	
	/**
     * Generate inserts
     *
     * @return string
     */
    public function generateTestInsert()
    {
        $object = '    /**' . "\n";
        $object.= '     * Insert ' . $this->object_name . "\n";
        $object.= '     *' . "\n";
        $object.= '     * @return boolean' . "\n";
        $object.= '     */' . "\n";
        $object .= '    public function testInsert()' . "\n";
        $object .= "    {\n";
        $object .= '        $this->setUp();'."\n"; 
        $object .= '        $this->cleanTable();'."\n"; 		
        foreach ($this->_fields as $name => $field) {
			if (!$field['primary_key']) {
				switch ($field['type']) {
				case 'date':
					$fecha = date("Y-m-d");
					$object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setDate(6, 6, 2006);'."\n";
					break;
				case 'datetime':									
					$object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setDateTime(11, 12, 2000, 14, 10, 12);'."\n";
					break;
				case 'time':
					$time = "00:00:30";
					$object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setTime("'.$time.'");'."\n";
					break;
				case 'timestamp':
					$object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setDateTime(11, 12, 2000, 14, 10, 12);'."\n";
					break;
				case 'year':
					$object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setValue(1990);'."\n";
					break;    
				case 'bigint':
				case 'decimal':
				case 'double':
				case 'float':
				case 'int':
				case 'mediumint':
				case 'smallint':
				case 'tinyint':
					$object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setValue(24);'."\n";
					break;  
				case 'bit':               
					$object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setValue(1);'."\n";
					break;
				case 'char':               
					$object .= '        $this->_'.strtolower($this->object_name).'->set'.ucfirst($name).'("c");'."\n";
					break;											
				default :
					$object .= '        $this->_'.strtolower($this->object_name).'->set'.ucfirst($name).'("carlos");'."\n";
					break;
				}
			}

            
            
        }  
        $object .= "\n".'      	//Checks'."\n"; 						
        $object .= '        $this->assertTrue($this->_'.strtolower($this->object_name).'->insert());'."\n";     
        $object .= '        $this->assertFalse($this->_'.strtolower($this->object_name).'->load(2));'."\n";		
		$object .= '        $this->assertTrue($this->_'.strtolower($this->object_name).'->load(1));'."\n";		
		foreach ($this->_fields as $name => $field) {
            if (!$field['primary_key']) {
                switch ($field['type']) {
                case 'date':											
                    $object .= '        $this->assertEquals(6,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getDay());'."\n";
					$object .= '        $this->assertEquals(6,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMonth());'."\n";
					$object .= '        $this->assertEquals(2006,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getYear());'."\n";
                    break;
                case 'datetime':
				    $object .= '        $this->assertEquals(11,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getDay());'."\n";
					$object .= '        $this->assertEquals(12,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMonth());'."\n";
					$object .= '        $this->assertEquals(2000,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getYear());'."\n";
					$object .= '        $this->assertEquals(14,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getHour());'."\n";
					$object .= '        $this->assertEquals(10,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMinutes());'."\n";
					$object .= '        $this->assertEquals(12,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getSeconds());'."\n";
                    break;
                case 'time':
                    $time = "00:00:30";
                    $object .= '        $this->assertEquals(00,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getHour());'."\n";
					$object .= '        $this->assertEquals(00,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMinutes());'."\n";
					$object .= '        $this->assertEquals(30,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getSeconds());'."\n";
                    break;
                case 'timestamp':
				    $object .= '        $this->assertEquals(11,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getDay());'."\n";
					$object .= '        $this->assertEquals(12,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMonth());'."\n";
					$object .= '        $this->assertEquals(2000,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getYear());'."\n";
					$object .= '        $this->assertEquals(14,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getHour());'."\n";
					$object .= '        $this->assertEquals(10,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMinutes());'."\n";
					$object .= '        $this->assertEquals(12,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getSeconds());'."\n";
                    break;
                case 'year':
                    $object .= '        $this->assertEquals(1990,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getValue());'."\n";
                    break;   
                case 'bigint':
                case 'decimal':
                case 'double':
                case 'float':
                case 'int':
                case 'mediumint':
                case 'smallint':
                case 'tinyint':
                    $object .= '        $this->assertEquals(24,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getValue());'."\n";
                    break;  
                case 'bit':               
                    $object .= '        $this->assertEquals(1,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getValue());'."\n";
                    break;
				case 'char':               
                    $object .= '        $this->assertEquals("c",$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'());'."\n";
                    break;
                default :
				    $object .= '        $this->assertEquals("carlos",$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()); '."\n";
                    break;
                }
            }
        }
        $object .= "    }\n\n";
        return $object;
    }
	
    /**
     * Generate Load
     *
     * @return string
     */
    public function generateTestLoad()
    {
        // TODO: make dinamic Primary Key
        $object = '    /**' . "\n";
        $object.= '     * Load ' . $this->object_name . "\n";
        $object.= '     *' . "\n";
        $object.= '     * @param integer $id2 Id' . "\n";
        $object.= '     *' . "\n";
        $object.= '     * @return boolean' . "\n";
        $object.= '     */' . "\n";
        $object .= '    public function testLoad()' . "\n";
        $object .= "    {\n";
        $object .= '        $this->setUp();'."\n";
		$object .= '        $this->assertFalse($this->_'.strtolower($this->object_name).'->load(20));'."\n";
        $object .= '        $this->assertTrue($this->_'.strtolower($this->object_name).'->load(1));'."\n";        
		$object .= "\n".'      	//Checks'."\n";
		foreach ($this->_fields as $name => $field) {
            if (!$field['primary_key']) {
                switch ($field['type']) {
                case 'date':											
                    $object .= '        $this->assertEquals(6,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getDay());'."\n";
					$object .= '        $this->assertEquals(6,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMonth());'."\n";
					$object .= '        $this->assertEquals(2006,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getYear());'."\n";
                    break;
                case 'datetime':
				    $object .= '        $this->assertEquals(11,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getDay());'."\n";
					$object .= '        $this->assertEquals(12,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMonth());'."\n";
					$object .= '        $this->assertEquals(2000,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getYear());'."\n";
					$object .= '        $this->assertEquals(14,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getHour());'."\n";
					$object .= '        $this->assertEquals(10,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMinutes());'."\n";
					$object .= '        $this->assertEquals(12,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getSeconds());'."\n";
                    break;
                case 'time':
                    $time = "00:00:30";
                    $object .= '        $this->assertEquals(00,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getHour());'."\n";
					$object .= '        $this->assertEquals(00,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMinutes());'."\n";
					$object .= '        $this->assertEquals(30,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getSeconds());'."\n";
                    break;
                case 'timestamp':
				    $object .= '        $this->assertEquals(11,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getDay());'."\n";
					$object .= '        $this->assertEquals(12,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMonth());'."\n";
					$object .= '        $this->assertEquals(2000,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getYear());'."\n";
					$object .= '        $this->assertEquals(14,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getHour());'."\n";
					$object .= '        $this->assertEquals(10,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMinutes());'."\n";
					$object .= '        $this->assertEquals(12,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getSeconds());'."\n";
                    break;
                case 'year':
                    $object .= '        $this->assertEquals(1990,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getValue());'."\n";
                    break;   
                case 'bigint':
                case 'decimal':
                case 'double':
                case 'float':
                case 'int':
                case 'mediumint':
                case 'smallint':
                case 'tinyint':
                    $object .= '        $this->assertEquals(24,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getValue());'."\n";
                    break;  
                case 'bit':               
                    $object .= '        $this->assertEquals(1,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getValue());'."\n";
                    break;
				case 'char':               
                    $object .= '        $this->assertEquals("c",$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'());'."\n";
                    break;
                default :
				    $object .= '        $this->assertEquals("carlos",$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()); '."\n";
                    break;
                }
            }
        }
        $object .= "    }\n\n";
        return $object;
    }
	
	/**
     * Generate update function
     * 
     * @return string
     */
    public function generateTestUpdate()
    {
        $object = '    /**' . "\n";
        $object.= '     * Update ' . $this->object_name . "\n";
        $object.= '     *' . "\n";
        $object.= '     * @return boolean' . "\n";
        $object.= '     */' . "\n";

        $where = '        $sql.=\'WHERE \';' . "\n";
        $object .= '    public function testUpdate()' . "\n";
        $object .= "    {\n";
        $object .= '        $this->setUp();'."\n";
        $object .= '        $this->_'.strtolower($this->object_name).'->load(1);'."\n";
		$object .= "\n".'        //Insert parameters;'."\n";
        foreach ($this->_fields as $name => $field) {
            if (!$field['primary_key']) {
                switch ($field['type']) {
                case 'date':
                    $object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setDate(2,2,2002);'."\n";
                    break;
                case 'datetime':
					$object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setDateTime(1, 1, 2000, 14, 10, 12);'."\n";
                    break;
                case 'time':
                    $time = "00:00:25";
                    $object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setTime("'.$time.'");'."\n";
                    break;
                case 'timestamp':
                    $object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setDateTime(1, 1, 2000, 14, 10, 12);'."\n";
                    break;
                case 'year':
                    $object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setValue(1991);'."\n";
                    break;   
                case 'bigint':
                case 'decimal':
                case 'double':
                case 'float':
                case 'int':
                case 'mediumint':
                case 'smallint':
                case 'tinyint':
                    $object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setValue(25);'."\n";
                    break;  
                case 'bit':               
                    $object .= '        $this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->setValue(0);'."\n";
                    break;
				case 'char':               
                    $object .= '        $this->_'.strtolower($this->object_name).'->set'.ucfirst($name).'("j");'."\n";
                    break;											
                default :
                    $object .= '        $this->_'.strtolower($this->object_name).'->set'.ucfirst($name).'("jean");'."\n";
                    break;
                }
            }
        }
		$object .= "\n".'   	//Checks;'."\n";							
        $object .= '        $this->assertTrue($this->_'.strtolower($this->object_name).'->update());'."\n"; 
        $object .= '        $this->assertFalse($this->_'.strtolower($this->object_name).'->load(2));'."\n";		
		$object .= '        $this->assertTrue($this->_'.strtolower($this->object_name).'->load(1));'."\n";
		foreach ($this->_fields as $name => $field) {
            if (!$field['primary_key']) {
                switch ($field['type']) {
                case 'date':											
                    $object .= '        $this->assertEquals(2,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getDay());'."\n";
					$object .= '        $this->assertEquals(2,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMonth());'."\n";
					$object .= '        $this->assertEquals(2002,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getYear());'."\n";
                    break;
                case 'datetime':
				    $object .= '        $this->assertEquals(1,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getDay());'."\n";
					$object .= '        $this->assertEquals(1,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMonth());'."\n";
					$object .= '        $this->assertEquals(2000,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getYear());'."\n";
					$object .= '        $this->assertEquals(14,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getHour());'."\n";
					$object .= '        $this->assertEquals(10,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMinutes());'."\n";
					$object .= '        $this->assertEquals(12,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getSeconds());'."\n";
                    break;
                case 'time':
                    $time = "00:00:25";
                    $object .= '        $this->assertEquals(00,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getHour());'."\n";
					$object .= '        $this->assertEquals(00,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMinutes());'."\n";
					$object .= '        $this->assertEquals(25,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getSeconds());'."\n";
                    break;
                case 'timestamp':
				    $object .= '        $this->assertEquals(1,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getDay());'."\n";
					$object .= '        $this->assertEquals(1,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMonth());'."\n";
					$object .= '        $this->assertEquals(2000,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getYear());'."\n";
					$object .= '        $this->assertEquals(14,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getHour());'."\n";
					$object .= '        $this->assertEquals(10,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getMinutes());'."\n";
					$object .= '        $this->assertEquals(12,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getSeconds());'."\n";
                    break;
                case 'year':
                    $object .= '        $this->assertEquals(1991,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getValue());'."\n";
                    break;   
                case 'bigint':
                case 'decimal':
                case 'double':
                case 'float':
                case 'int':
                case 'mediumint':
                case 'smallint':
                case 'tinyint':
                    $object .= '        $this->assertEquals(25,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getValue());'."\n";
                    break;  
                case 'bit':               
                    $object .= '        $this->assertEquals(0,$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()->getValue());'."\n";
                    break;
				case 'char':               
                    $object .= '        $this->assertEquals("j",$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'());'."\n";
                    break;
                default :
				    $object .= '        $this->assertEquals("jean",$this->_'.strtolower($this->object_name).'->get'.ucfirst($name).'()); '."\n";
                    break;
                }
            }
        }
        $object .= "    }\n\n";
        return $object;
    }
	
	public function generateTestGetAll()
    {
        $object  = '    /**' . "\n";
        $object .= '     * Return all objects' . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @return Yuju_Array' . "\n";
        $object .= '     */' . "\n";
        $object .= '    public function testGetAll()' . "\n";
        $object .= '    {' . "\n";
        $object .= '        $this->setUp();'."\n";
        $object .= '        $array=$this->_'.strtolower($this->object_name).'->getAll();'."\n"; 
        $object .= '        $this->assertEquals($array->count(),1);'."\n";          
        $object .= '    }' . "\n\n";        
        return $object;
    }
    
    /**
     * Generate test table array
     * 
     * @return string
     */
    public function generateTestTableArray()
    {
        $object  = '    /**' . "\n";
        $object .= '     * Return a Table' . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @return Array' . "\n";
        $object .= '     */' . "\n";
        $object .= '    public function TestTablaArray()' . "\n";
        $object .= '    {' . "\n";
        $object .= '        $this->setUp();'."\n";
        $object .= '        $array=$this->_'.strtolower($this->object_name).'->tablaArray();'."\n";         
        foreach ($this->_fields as $name => $field) {
            if ($field['primary_key']) {
                $id=$name;
            }
        } 
        $object .= '        $this->assertEquals(count($array["'.$id.'"]),1);'."\n"; 
        $object .= '    }'."\n\n";        
        return $object;
    }
    
    /**
     * Generate test search
     * 
     * @return string
     */
    public function generateTestSearch()
    {
        $object  = "\n";
        $object  = '    /**' . "\n";
        $object .= '     * Return a Array' . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @return Array' . "\n";
        $object .= '     */' . "\n";
        $object .= '     public function testSearch() {' . "\n";
        $object .= '        $this->setUp();'."\n";        
        $object .= '        $param = array();'."\n";     
        foreach ($this->_fields as $name => $field) {
            if ($field['primary_key']) {
                $id=$name;
            } else {
                switch ($field['type']) {
                case 'date': 
                case 'datetime':
                case 'time':
                case 'timestamp':
                case 'year': 
                case 'bigint':
                case 'decimal':
                case 'double':
                case 'float':
                case 'int':
                case 'mediumint':
                case 'smallint':
                case 'tinyint':
                case 'bit':               
                    break;
                default :
                    $campo = $name;
                    break;
                }
            }
        }      
        $object .= '        $param["like-'.$campo.'"]="e";'."\n";  
        $object .= '        $array = $this->_'.strtolower($this->object_name).'->search($param);'."\n";                         
        $object .= '        $this->assertEquals(1,count($array["'.$id.'"]));'."\n";          
        $object .= '        $array = $this->_'.strtolower($this->object_name).'->search($param, null, null, false);'."\n"; 
        $object .= '        $this->assertEquals(1,count($array["'.$id.'"]));'."\n";   
        $object .= '        $arrayYuju = $this->_'.strtolower($this->object_name).'->search($param, null, null, true);'."\n";     
        $object .= '        //$this->assertEquals(1,$arrayYuju->count());'."\n";       
        $object .= '     }'."\n\n";  
        
        return $object;
    }
    
    /**
     * Generate test seach pager
     * 
     * @return string
     */
    public function generateTestSearchPager()
    {
        $object  = "\n";
        $object  = '    /**' . "\n";
        $object .= '     * Return a Array' . "\n";
        $object .= '     *' . "\n";
        $object .= '     * @return Array' . "\n";
        $object .= '     */' . "\n";
        $object .= '     public function testSearchPager() {' . "\n";
        $object .= '        $this->setUp();'."\n";  
        $object .= '        $param = array();'."\n";  
        foreach ($this->_fields as $name => $field) {
            if ($field['primary_key']) {
                $id=$name;
            } else {
                switch ($field['type']) {
                case 'date': 
                case 'datetime':
                case 'time':
                case 'timestamp':
                case 'year': 
                case 'bigint':
                case 'decimal':
                case 'double':
                case 'float':
                case 'int':
                case 'mediumint':
                case 'smallint':
                case 'tinyint':
                case 'bit':               
                    break;
                default :
                    $campo = $name;
                    break;
                }
            }
        }         
        $object .= '        $param["like-'.$campo.'"]="e";'."\n"; 
        $object .= '        $array = $this->_'.strtolower($this->object_name).'->search($param, 3, 1);'."\n";   
        $object .= '        $this->assertEquals(1,count($array["'.$id.'"]));'."\n";  
        $object .= '        $arrayYuju = $this->_'.strtolower($this->object_name).'->search($param, 3, 1, true);'."\n";     
        $object .= '        $this->assertEquals(1,$arrayYuju->getNumRows());'."\n";              
        $object .= '     }'."\n\n";  
        return $object;
    }
    
    /**
     * Generate delete function
     *
     * @return string
     */
    public function generateTestDelete()
    {
        $object = '    /**' . "\n";
        $object.= '     * Delete ' . $this->object_name . "\n";
        $object.= '     *' . "\n";
        $object.= '     * @return boolean' . "\n";
        $object.= '     */' . "\n";
        $object .= '    public function testDelete()' . "\n";
        $object .= "    {\n";
        $object .= '        $this->setUp();'."\n";    
        $object .= '        $this->_'.strtolower($this->object_name).'->load(1);'."\n"; 
        $object .= '        $this->assertEquals(true,$this->_'.strtolower($this->object_name).'->delete());'."\n"; 
        $object .= '        $this->assertFalse($this->_'.strtolower($this->object_name).'->load(1));'."\n"; 		
        $object .= '        unlink(ROOT."'.$this->object_name.'.php");'."\n"; 		
        $object .= "    }\n\n";
        return $object;
    }
}
