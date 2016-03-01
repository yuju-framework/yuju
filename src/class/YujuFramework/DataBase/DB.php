<?php
/**
 * DB File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

namespace YujuFramework\DataBase;

/**
 * Class DB
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class DB
{

    /**
     * Active connection
     *
     * @var object
     */
    private static $connection = array();

    /**
     * Parse data
     *
     * @param string  $var        string
     * @param integer $connection connection id
     *
     * @return string
     * @since version 1.0
     */
    public static function parse($var, $connection = 1)
    {
        if (!DB::isConnected($connection - 1)) {
            if (!DB::Connection()) {
                return false;
            }
        }
        switch (self::$connection[$connection - 1][0]) {
            case 'mysql':
                if (DB::$connection[$connection - 1] == null) {
                    DB::query("SELECT 1");
                }
                return DB::$connection[$connection - 1][1]->real_escape_string($var);
                break;
            case 'sqlserver':
                $var = addslashes($var);
                return str_replace("'", "''", $var);
                break;
            case 'oracle':
                $var = addslashes($var);
                return str_replace("'", "''", $var);
                break;
        }
    }

    /**
     * Make string paged
     *
     * @param number $num Register number
     * @param numbre $pag Number of page. Starting from the 1
     *
     * @return string
     * @since version 1.0
     */
    public static function paged($num, $pag)
    {
        $limit = "";
        if ($num !== null && $pag !== null && is_numeric($num) && is_numeric($pag)) {
            $limit = "LIMIT " . ($pag * $num) . "," . $num;
        }
        return $limit;
    }

    /**
     * Begin Transaction
     *
     * @param integer $connection connection id
     *
     * @return boolean
     * @since version 1.0
     */
    public static function beginTransaction($connection = 1)
    {
        if (!DB::isConnected($connection - 1) && !DB::connection()) {
            return false;
        }
        switch (self::$connection[$connection - 1][0]) {
            case 'mysql':
                self::$connection[$connection - 1][1]->autocommit(false);
                if (self::$connection[$connection - 1][1]->error != "") {
                    if (isset($_SESSION["iduser"])) {
                        $user = $_SESSION["iduser"];
                    } else {
                        $user = '';
                    }
                    mail(
                        MAILADM,
                        _('SQL Error begin transaction'),
                        ' -> '.self::$connection[$connection - 1][1]->error .
                        _(' user: ') . $user . ' page: ' . $_SERVER['REQUEST_URI']
                    );
                    return false;
                }
                return true;
                break;
        }
    }

    /**
     * Rollback Transaction
     *
     * @param number $connection connection id
     *
     * @return boolean
     * @since version 1.0
     */
    public static function rollback($connection = 1)
    {
        switch (self::$connection[$connection - 1][0]) {
            case 'mysql':
                self::$connection[$connection - 1][1]->rollback();
                self::$connection[$connection - 1][1]->autocommit(true);
                if (self::$connection[$connection - 1][1]->error != '') {
                    if (isset($_SESSION["iduser"])) {
                        $user = $_SESSION["iduser"];
                    } else {
                        $user = '';
                    }
                    mail(
                        MAILADM,
                        _('SQL Error rollback transaction'),
                        ' -> '.self::$connection[$connection - 1][1]->error .
                        _(' user: ') . $user . ' page: ' . $_SERVER['REQUEST_URI']
                    );
                    return false;
                }
                return true;
                break;
        }
    }

    /**
     * Commit Transaction
     *
     * @param number $connection connection id
     *
     * @return boolean
     * @since version 1.0
     */
    public static function commit($connection = 1)
    {
        switch (self::$connection[$connection - 1][0]) {
            case 'mysql':
                self::$connection[$connection - 1][1]->commit();
                self::$connection[$connection - 1][1]->autocommit(true);
                if (self::$connection[$connection - 1][1]->error != "") {
                    if (isset($_SESSION["iduser"])) {
                        $user = $_SESSION["iduser"];
                    } else {
                        $user = '';
                    }
                    mail(
                        MAILADM,
                        _('SQL Error commit transaction'),
                        ' -> '.self::$connection[$connection - 1][1]->error .
                        _(' user: ') . $user . ' page: ' . $_SERVER['REQUEST_URI']
                    );
                    return false;
                }
                return true;
                break;
        }
    }

    /**
     * Connection to Data Base
     *
     * @param string $dbtype database type
     * @param string $dbhost host
     * @param string $dbuser user
     * @param string $dbpass password
     * @param string $dbdata table
     *
     * @return boolean|integer
     * @since version 1.0
     */
    public static function connection($dbtype = null, $dbhost = null, $dbuser = null, $dbpass = null, $dbdata = null)
    {
        if ($dbtype == null || $dbhost == null || $dbuser == null) {
            $dbtype = DBTYPE;
            $dbhost = DBHOST;
            $dbuser = DBUSER;
            $dbpass = DBPASS;
            $dbdata = DBDATA;
        }
        $con = null;
        switch ($dbtype) {
            case 'mysql':
                $con = @new \mysqli($dbhost, $dbuser, $dbpass, $dbdata);
                if ($con->connect_error) {
                    return false;
                }
                $con->query('SET NAMES \'utf8\'');
                self::$connection[] = array('mysql', $con);

                break;
            case 'sqlserver':
                $con = mssql_connect($dbhost, $dbuser, $dbpass, true);
                if ($con == null) {
                    return false;
                }
                mssql_select_db($dbdata, $con);
                self::$connection[] = array('sqlserver', $con);
                break;
            case 'oracle':
                $tns = "
    		  (DESCRIPTION =
    		  	(ADDRESS_LIST =
    		    	(ADDRESS = (PROTOCOL = TCP)(HOST = " . $dbhost . ")(PORT = 1521))
    		   	)
    		    (CONNECT_DATA =
    		      (SERVER = DEDICATED)
    		      (SERVICE_NAME = " . $dbdata . ")
    		    )
    		  )";
                $con = oci_connect($dbuser, $dbpass, $tns);
                //mssql_select_db($dbdata, $con);
                self::$connection[] = array('oracle', $con);
                break;
        }
        return count(self::$connection);
    }

    /**
     * Select database
     *
     * @param string  $dbname     database name
     * @param integer $connection connection id
     *
     * @return boolean
     * @since version 1.0
     */
    public static function selectDB($dbname, $connection = 1)
    {
        if (!DB::isConnected($connection - 1)) {
            if (!DB::Connection()) {
                return false;
            }
        }
        switch (self::$connection[$connection - 1][0]) {
            case 'mysql':
                self::$connection[$connection - 1][1]->select_db($dbname);
                if (self::$connection[$connection - 1][1]->error != "") {
                    if (isset($_SESSION["iduser"])) {
                        $user = $_SESSION["iduser"];
                    } else {
                        $user = '';
                    }
                    mail(
                        MAILADM,
                        _('SQL Error selecting database'),
                        $dbname.' -> '.self::$connection[$connection - 1][1]->error .
                        _(' user: ') . $user . ' page: ' . $_SERVER['REQUEST_URI']
                    );
                    return false;
                }
                return true;
                break;
        }
    }

    /**
     * Determine if connected
     *
     * @param integer $connection connection id
     *
     * @return boolean
     * @since version 1.0
     */
    public static function isConnected($connection = 1)
    {
        if (isset(self::$connection[$connection])) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Affected rows by last SQL
     *
     * @param int $connection connection id
     *
     * @return int
     */
    public static function affectedRows($connection = 1)
    {
        switch (self::$connection[$connection - 1][0]) {
            case 'sqlserver':
                return mssql_rows_affected(self::$connection[$connection - 1][1]);
                break;
        }
    }

    /**
     * Run SQL Query
     *
     * @param string  $sql        SQL
     * @param integer $connection connection id
     *
     * @return boolean|BD_Resultado
     * @since version 1.0
     */
    public static function query($sql, $connection = 1)
    {
        if (!DB::isConnected($connection - 1)) {
            if (!DB::Connection()) {
                return false;
            }
        }
        switch (self::$connection[$connection - 1][0]) {
            case 'mysql':
                $result = self::$connection[$connection - 1][1]->query($sql);
                if (self::$connection[$connection - 1][1]->error != "") {
                    if (isset($_SESSION["iduser"])) {
                        $user = $_SESSION["iduser"];
                    } else {
                        $user = '';
                    }
                    echo self::$connection[$connection - 1][1]->error;
                    return false;
                }
                return new DBResult('mysql', $result);
                break;
            case 'sqlserver':
                $result = mssql_query($sql, self::$connection[$connection - 1][1]);
                if (!$result) {
                    echo mssql_get_last_message();
                    return false;
                }
                return new DBResult('sqlserver', $result);
                break;
            case 'oracle':
                $result = oci_parse(self::$connection[$connection - 1][1], $sql);
                oci_execute($result);
                return new DBResult('oracle', $result);
                break;
        }
    }

    /**
     * Get last Insert Id
     *
     * @param integer $connection connection id
     *
     * @return boolean
     * @since version 1.0
     */
    public static function insertId($connection = 1)
    {
        switch (self::$connection[$connection - 1][0]) {
            case 'mysql':
                return self::$connection[$connection - 1][1]->insert_id;
                break;
            case 'sqlserver':
                $res = mssql_query('SELECT @@IDENTITY as id', self::$connection[$connection - 1][1]);
                if ($row = mssql_fetch_object($res)) {
                    return $row->id;
                } else {
                    return false;
                }
                break;
        }
    }

    /**
     * Create database
     *
     * @param string  $name       database name
     * @param integer $connection connection id
     *
     * @return boolean|DBResult
     * @since version 1.0
     */
    public static function createSchema($name, $connection = 1)
    {
        if (!DB::isConnected($connection - 1)) {
            if (!DB::connection()) {
                return false;
            }
        }

        switch (self::$connection[$connection - 1][0]) {
            case 'mysql':
                $sql = 'CREATE DATABASE ' . DB::parse($name) . ';';
                $result = self::$connection[$connection - 1][1]->query($sql);
                if (self::$connection[$connection - 1][1]->error != "") {
                    if (isset($_SESSION["iduser"])) {
                        $user = $_SESSION["iduser"];
                    } else {
                        $user = '';
                    }
                    mail(
                        MAILADM,
                        _('SQL Error creating schema'),
                        $sql . ' -> '.self::$connection[$connection - 1][1]->error .
                        _(' user: ') . $user . ' page: ' . $_SERVER['REQUEST_URI']
                    );
                    return false;
                }
                return new DBResult('mysql', $result);
                break;
        }
    }

    /**
     * Drop database
     *
     * @param string  $name       database name
     * @param integer $connection connection id
     *
     * @return boolean|DBResult
     * @since version 1.0
     */
    public static function dropSchema($name, $connection = 1)
    {
        if (!DB::isConnected($connection - 1)) {
            if (!DB::Connection()) {
                return false;
            }
        }
        switch (self::$connection[$connection - 1][0]) {
            case 'mysql':
                $sql = 'DROP DATABASE ' . DB::parse($name) . ';';
                $result = self::$connection[$connection - 1][1]->query($sql);
                if (self::$connection[$connection - 1][1]->error != "") {
                    if (isset($_SESSION["iduser"])) {
                        $user = $_SESSION["iduser"];
                    } else {
                        $user = '';
                    }
                    mail(
                        MAILADM,
                        _('SQL Error creating schema '),
                        $sql . ' -> '.self::$connection[$connection - 1][1]->error .
                        _(' user: ') . $user . ' page: ' . $_SERVER['REQUEST_URI']
                    );
                    return false;
                }
                return new DBResult('mysql', $result);
                break;
        }
    }
}
