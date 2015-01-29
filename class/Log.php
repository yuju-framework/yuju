<?php
/**
 * Log File
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
 * @version  SVN: $Id: Log.php 81 2013-05-05 18:48:44Z danifdez $
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */

/**
 * Log Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
class Log
{
    /**
    * Date
    *
    * @var    Date $_date
    * @access private
    */
    private $_date;

    /**
     * Message Trace
     *
     * @var    string $_message
     * @access private
     */
    private $_message;
    
    /**
     * User Id
     * 
     * @var number
     */
    private $_iduser;
    
    /**
     * User
     *
     * @var string
     */
    private $_user;
    
    /**
     * URI
     * 
     * @var string
     */
    private $_uri;
    
    /**
     * IP
     * 
     * @var string
     */
    private $_ip;

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
        $this->_date= new Date();
        $this->_iduser='NULL';
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
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri=$_SERVER['REQUEST_URI'];
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
        return $this->_message;
    }

    /**
     * Getter user id
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->_iduser;
    }

    /**
     * Getter date
     *
     * @return Date
     */
    public function getDate()
    {
        return $this->_date;
    }
    
    /**
     * Getter IP
     *
     * @return string
     */
    public function getIP()
    {
        return $this->_ip;
    }
    
    /**
     * Getter URI
     *
     * @return string
     */
    public function getURI()
    {
        return $this->_uri;
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
        $this->_message=$val;
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
            $this->_iduser=$val;
        }
    }
    
    /**
     * Getter user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->_user;
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
    public function getLog($initdate=null, $enddate=null, $num=null, $page=null)
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
?>
