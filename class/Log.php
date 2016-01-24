<?php
/**
 * Log File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Log Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Log
{
    /**
    * Date
    *
    * @var    Date $date
    * @access private
    */
    private $date;

    /**
     * Message Trace
     *
     * @var    string $message
     * @access private
     */
    private $message;

    /**
     * User Id
     *
     * @var number
     */
    private $iduser;

    /**
     * User
     *
     * @var string
     */
    private $user;

    /**
     * URI
     *
     * @var string
     */
    private $uri;

    /**
     * IP
     *
     * @var string
     */
    private $ip;

    /**
     * Table name
     *
     * @var string
     */
    protected static $dbname='log';

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->date= new Date();
        $this->iduser='NULL';
    }

    /**
     * Add log
     *
     * @param string $message message
     *
     * @return boolean
     */
    public static function addLog($message)
    {
        $iduser='NULL';
        $uri='';
        $ip='';
        if (isset($_SESSION['iduser']) && is_numeric($_SESSION['iduser'])) {
            $iduser=$_SESSION['iduser'];
        }
        if (isset($_SERVER['REQUESTuri'])) {
            $uri=$_SERVER['REQUESTuri'];
        }
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        $sql='INSERT DELAYED '.Log::$dbname;
        $sql.=' VALUES(NOW(),\''.DB::parse($message).'\',';
        $sql.='\''.DB::parse($ip).'\',\''.DB::parse($uri).'\',';
        $sql.=$iduser.')';

        if (DB::query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Getter message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Getter user id
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->iduser;
    }

    /**
     * Getter date
     *
     * @return Date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Getter IP
     *
     * @return string
     */
    public function getIP()
    {
        return $this->ip;
    }

    /**
     * Getter URI
     *
     * @return string
     */
    public function getURI()
    {
        return $this->uri;
    }

    /**
     * Setter message
     *
     * @param string $val message
     *
     * @return void
     */
    public function setMessage($val)
    {
        $this->message=$val;
    }

    /**
     * Setter user id
     *
     * @param integer $val id
     *
     * @return void
     */
    public function setIdUser($val)
    {
        if (is_numeric($val)) {
            $this->iduser=$val;
        }
    }

    /**
     * Getter user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get log records
     *
     * @param integer $initdate init date
     * @param integer $enddate  init date
     * @param integer $num      number records
     * @param integer $page     page number
     *
     * @return array
     */
    public function getLog($initdate = null, $enddate = null, $num = null, $page = null)
    {
        $paged="";
        $where="";
        if (is_numeric($num) && is_numeric($page)) {
            $paged = "LIMIT ".($page*$num).",".$num;
        }
        $traces=array();
        if ($initdate!=null && $enddate!=null) {
            $where=" WHERE date BETWEEN '".$initdate."' AND '".$enddate."'";
        }
        if ($result=DB::Query(
            'SELECT * FROM '.Log::$dbname.' '.$where.' ORDER BY date DESC '.$paged
        )) {
            while ($obj = $result->fetch_object()) {
                $trace= new Log();
                $trace->setMessage($obj->message);
                $trace->setDate($obj->date);
                $trace->setIdUser($obj->iduser);
                $traces[]=$trace;
            }
        }
        return $traces;
    }

    /**
     * Total records
     *
     * @return integer|boolean
     */
    public function count()
    {
        if ($result=DB::Query("SELECT count(*) as total FROM ".Log::$dbname)) {
            $obj=$result->fetch_object();
            return $obj->total;
        } else {
            return false;
        }
    }
}
