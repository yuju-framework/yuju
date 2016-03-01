<?php
/**
 * ACL File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

namespace YujuFramework;

/**
 * Class ACL
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class ACL
{
    /**
     * Permision
     *
     * @var array
     * @access private
     */
    private $acl;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->acl=array();
    }

    /**
     * Reset permisssions
     *
     * @return void
     */
    public function reset()
    {
        $this->acl=array();
    }

    /**
     * Load permissions from JSON array
     *
     * @param string $var JSON permission
     *
     * @return void
     */
    public function loadAcl($var)
    {
        $this->acl=json_decode($var, true);
        if ($this->acl==null) {
            $this->acl=array();
        }
    }

    /**
     * Determine if exists a permission
     *
     * @param string $var permission
     *
     * @return boolean
     */
    public function getAcl($var)
    {
        if (in_array($var, $this->acl)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set new permission
     *
     * @param string $var permission
     *
     * @return void
     */
    public function setAcl($var)
    {
        if (!$this->getAcl($var)) {
            $this->acl[]=$var;
        }
    }

    /**
     * ACL to Database
     *
     * @return string
     */
    public function toDB()
    {
        return json_encode($this->acl);
    }

    /**
     * Get all permissions
     *
     * @return array
     */
    public static function getAll()
    {
        $acls=array();
        $return=DB::Query('SELECT * FROM aclpermission');
        if ($return->numRows()>0) {
            while ($result=$return->fetchObject()) {
                $acls[]=array($result->id, $result->permission);
            }
        }
        return $acls;
    }
}
