<?php
/**
 * YujuORM File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * YujuORM Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class YujuORM
{
    /**
     * ORM
     *
     * @var AbstractYujuORM
     */
    protected $orm;

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
     * Getter ORM
     *
     * @return AbstractYujuORM
     */
    public function getORM()
    {
        return $this->orm;
    }

    /**
     * Setter Object Name
     *
     * @param string $var object name
     *
     * @return boolean
     */
    public function setObjectName($var)
    {
        return $this->orm->setObjectName($var);
    }

    /**
     * Constructor
     *
     * @param AbstractYujuORM $orm orm object
     */
    public function __construct(AbstractYujuORM $orm)
    {
        $this->orm = $orm;
    }

    /**
     * Connect to database
     *
     * @param string $db_host database host
     * @param string $db_user database user
     * @param string $db_pass database password
     * @param string $db_data database name
     *
     * @return boolean
     */
    public function connect($db_host, $db_user, $db_pass, $db_data)
    {
        $this->orm->connect($db_host, $db_user, $db_pass, $db_data);
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
        $this->orm->load($table);
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
        return $this->orm->generateObject($object_name);
    }

    /**
     * Generate file doc
     *
     * @return string
     */
    public function generateDocFile()
    {
        return $this->orm->generateDocFile();
    }

    /**
     * Generate class doc
     *
     * @return string
     */
    public function generateDocClass()
    {
        return $this->orm->generateDocClass();
    }

    /**
     * Generate vars
     *
     * @return string
     */
    public function generateVars()
    {
        return $this->orm->generateVars();
    }

    /**
     * Generate constructor
     *
     * @return string
     */
    public function generateConstructor()
    {
        return $this->orm->generateConstructor();
    }

    /**
     * Generate Getter and Setter
     *
     * @return string
     */
    public function generateGetterSetter()
    {
        return $this->orm->generateGetterSetter();
    }

    /**
     * Generate Load
     *
     * @return string
     */
    public function generateLoad()
    {
        return $this->orm->generateLoad();
    }

    /**
     * Generate inserts
     *
     * @return string
     */
    public function generateInsert()
    {
        return $this->orm->generateInsert();
    }

    /**
     * Generate update function
     *
     * @return string
     */
    public function generateUpdate()
    {
        return $this->orm->generateUpdate();
    }

    /**
     * Generate delete function
     *
     * @return string
     */
    public function generateDelete()
    {
        return $this->orm->generateDelete();
    }

    /**
     * Generate getAll
     *
     * @return string
     */
    public function generateGetAll()
    {
        return $this->orm->generateGetAll();
    }

    /**
     * Get table to json format
     *
     * @param string $toFile write json to file
     *
     * @return string
     */
    public function tableToJSON($toFile = true)
    {
        $arrayJSON=json_encode($this->orm->getFields());

        if ($toFile) {
            $fp=fopen($this->orm->getTable().'.json', 'w');
            fwrite($fp, $arrayJSON);
            fclose($fp);
        } else {
            return $arrayJSON;
        }
    }

    /**
     * Generate search
     *
     * @return string
     */
    public function generateSearch()
    {
        return $this->orm->generateSearch();
    }

    /**
     * Generate base
     *
     * @param string $directory directory
     *
     * @return void
     */
    public function generateBase($directory)
    {
        return $this->orm->generateBase($directory);
    }
}
