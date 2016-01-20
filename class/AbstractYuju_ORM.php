<?php
/**
 * AbstractYuju_ORM File
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
 * AbstractYuju_ORM Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
abstract class AbstractYuju_ORM
{
    protected $db_host;
    protected $db_user;
    protected $db_pass;
    protected $db_data;
    protected $table;
    protected $object_name;
    protected $fields;

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
     *
     * @return boolean
     */
    abstract public function connect($db_host, $db_user, $db_pass, $db_data);

    /**
     * Setter Object Name
     *
     * @param string $var object name
     *
     * @return boolean
     */
    public function setObjectName($var)
    {
        $this->object_name = $var;
        return true;
    }

    /**
     * Getter Object Name
     *
     * @param string $var object name
     *
     * @return boolean
     */
    public function getObjectName($var)
    {
        return $this->object_name;
    }

    /**
     * Getter Fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Load table
     *
     * @param string $table table
     *
     * @return void
     */
    abstract public function load($table);

    /**
     * Generate object
     *
     * @param string $object_name object name
     *
     * @return string
     */
    abstract public function generateObject($object_name = '');

    /**
     * Generate file doc
     *
     * @return string
     */
    public function generateDocFile()
    {
        $return='/**'."\n";
        $return .= ' * '.$this->object_name.' File'."\n";
        $return .= ' *'."\n";
        $return .= ' * @category XXX'."\n";
        $return .= ' * @package  XXX'."\n";
        $return .= ' * @author   XXX <xxx@xxx.com>'."\n";
        $return .= ' * @license  '."\n";
        $return .= ' * @link     XXX'."\n";
        $return .= ' * @since    XXX'."\n";
        $return .= ' */'."\n";
        return $return;
    }

    /**
     * Generate class doc
     *
     * @return string
     */
    public function generateDocClass()
    {
        $return='/**'."\n";
        $return .= ' * '.$this->object_name.' Class'."\n";
        $return .= ' *'."\n";
        $return .= ' * @category XXX'."\n";
        $return .= ' * @package  XXX'."\n";
        $return .= ' * @author   XXX <xxx@xxx.com>'."\n";
        $return .= ' * @license  '."\n";
        $return .= ' * @link     XXX'."\n";
        $return .= ' * @since    XXX'."\n";
        $return .= ' */'."\n";
        return $return;
    }

    /**
     * Generate vars
     *
     * @return string
     */
    public function generateVars()
    {
        $object='';
        foreach ($this->fields as $name => $field) {
            $object .= "    protected $".$name.";\n\n";
        }
        return $object;
    }

    /**
     * Generate constructor
     *
     * @return string
     */
    public function generateConstructor()
    {
        $object='    /**'."\n";
        $object.= '     * Constructor'."\n";
        $object.= '     *'."\n";
        $object.= '     */'."\n";
        $object.= '    public function __construct()'."\n";
        $object.= '    {'."\n";
        foreach ($this->fields as $name => $field) {
            switch ($field['type']) {
                case 'date':
                    $object .= '        $this->'.$name." = new Date();\n";
                    break;
                case 'datetime':
                    $object .= '        $this->'.$name." = new Date();\n";
                    break;
                case 'time':
                    $object .= '        $this->'.$name." = new Date();\n";
                    break;
                case 'timestamp':
                    $object .= '        $this->'.$name." = new Date();\n";
                    break;
                case 'year':
                    $object .= '        $this->'.$name.
                        " = new Number(Number::INTEGER, true, null, null, 2155, 1901);\n";
                    break;
                case 'bigint':
                    $object .= '        $this->'.$name." = new Number();\n";
                    break;
                case 'decimal':
                    $object .= '        $this->'.$name." = new Number(Number::DECIMAL, true);\n";
                    break;
                case 'double':
                    $object .= '        $this->'.$name." = new Number(Number::FLOAT, true);\n";
                    break;
                case 'float':
                    $object .= '        $this->'.$name." = new Number(Number::FLOAT, true);\n";
                    break;
                case 'int':
                    $object .= '        $this->'.$name." = new Number();\n";
                    break;
                case 'mediumint':
                    $object .= '        $this->'.$name." = new Number();\n";
                    break;
                case 'smallint':
                    $object .= '        $this->'.$name." = new Number();\n";
                    break;
                case 'tinyint':
                    if ($field['number'] == 1) {
                        $object .= '        $this->'.$name." = new Boolean();\n";
                    } else {
                        $object .= '        $this->'.$name." = new Number();\n";
                    }
                    break;
                case 'bit':
                    $object .= '        $this->'.$name." = new Boolean();\n";
                    break;
            }
        }
        $object .= '    }'."\n\n";

        $object.='    /**'."\n";
        $object.= '     * Clone'."\n";
        $object.= '     *'."\n";
        $object.= '     */'."\n";
        $object.= '    public function __clone()'."\n";
        $object.= '    {'."\n";
        foreach ($this->fields as $name => $field) {
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
                    $object .= '        $this->'.$name.' = clone($this->'.$name.');'."\n";
                    break;
            }
        }
        $object .= '    }'."\n\n";

        return $object;
    }
    
    protected function getCamelCase($name)
    {
        $name_camel = ucwords($name, '_');
        $name_camel = str_replace('_', '', $name_camel);
        return $name_camel;
    }
    

    /**
     * Generate Getter and Setter
     *
     * @return string
     */
    public function generateGetterSetter()
    {
        $object='';
        //TODO: if name field contains _ is next upper char
        foreach ($this->fields as $name => $field) {
            // Getter
            $object.= '    /**'."\n";
            $object.= '     * Getter '.$name."\n";
            $object.= '     *'."\n";
            $object.= '     * @return '.$field['type']."\n";
            $object.= '     */'."\n";
            $object .= "    public function get".$this->getCamelCase($name)."()\n";
            $object .= "    {\n";
            $object .= '        return $this->'.$name.";\n";
            $object .= "    }\n\n";
            // Setter
            if ($field['type'] == 'varchar' || $field['type'] == 'char' || $field['type'] == 'longtext'
                || $field['type'] == 'mediumtext' || $field['type'] == 'text' || $field['type'] == 'tinytext'
                || $field['type'] == 'enum' || $field['type'] == 'set' || $field['type'] == 'blob'
                || $field['type'] == 'longblob' || $field['type'] == 'mediumblob' || $field['type'] == 'tinyblob'
                || $field['type'] == 'varbinary' || $field['type'] == 'binary'
            ) {
                $object.= '    /**'."\n";
                $object.= '     * Setter '.$name."\n";
                $object.= '     *'."\n";
                $object.= '     * @param string $var XXX'."\n";
                $object.= '     *'."\n";
                $object.= '     * @return boolean'."\n";
                $object.= '     */'."\n";
                $object .= "    public function set".$this->getCamelCase($name)."(\$var)\n";
                $object .= "    {\n";
                $object .= '        $this->'.$name." = \$var;\n";
                $object .= '        return true;'."\n";
                $object .= "    }\n\n";
            }
        }
        return $object;
    }

    /**
     * Determine if has setter function
     *
     * @param string $type filed type
     *
     * @return boolean
     */
    protected function hasSetterFunction($type)
    {
        $setter_types = array(
            'varchar','char','longtext','mediumtext','text','tinytext','enum',
            'set','blob','longblob','mediumblob','tinyblob','varbinary',
            'binary'
        );
        if (in_array($type, $setter_types)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate Load
     *
     * @return string
     */
    abstract public function generateLoad();

    /**
     * Generate inserts
     *
     * @return string
     */
    abstract public function generateInsert();

    /**
     * Generate update function
     *
     * @return string
     */
    abstract public function generateUpdate();

    /**
     * Generate delete function
     *
     * @return string
     */
    abstract public function generateDelete();

    /**
     * Generate getAll
     *
     * @return string
     */
    public function generateGetAll()
    {
        $object='    /**'."\n";
        $object .= '     * Return all objects'."\n";
        $object .= '     *'."\n";
        $object .= '     * @return Yuju_Array'."\n";
        $object .= '     */'."\n";
        $object .= '    public static function getAll()'."\n";
        $object .= '    {'."\n";
        $object .= '        return '.$this->object_name.'::search(array());'."\n";
        $object .= '    }'."\n\n";
        return $object;
    }

    /**
     * Generate search
     *
     * @return string
     */
    abstract public function generateSearch();

    /**
     * Generate base
     *
     * @param string $directory directory to generate
     *
     * @return void
     */
    abstract public function generateBase($directory);
}
