<?php
/**
 * User File
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
 * User Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class User implements IYuju_Array
{

    /**
     * Id
     *
     * @var    number
     * @access protected
     */
    protected $id;

    /**
     * Name
     *
     * @var    string
     * @access protected
     */
    protected $name;

    /**
     * User
     *
     * @var    string
     * @access protected
     */
    protected $user;

    /**
     * Password
     *
     * @var    string
     * @access protected
     */
    protected $pass;

    /**
     * ACL
     *
     * @var    ACL
     * @access protected
     */
    protected $acl;

    /**
     * Preferences
     *
     * @var    string
     * @access protected
     */
    protected $preferences;

    /**
     * Role
     *
     * @var    string
     * @access protected
     */
    protected $role;

    /**
     * Valid
     *
     * @var    Booleano
     * @access protected
     */
    protected $valid;

    /**
     * Getter id
     *
     * @access public
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter name
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter name
     *
     * @param string $name user name
     * 
     * @access public
     * @return string
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Getter user
     *
     * @access public
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Setter user
     *
     * @param string $user user
     * 
     * @access public
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Setter Password
     * 
     * @param string $pass Password
     * 
     * @return void
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * Getter Role
     *     
     * @access public
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
    
    /**
     * Determine if user is a role
     * 
     * @param string $role role
     * 
     * @return boolean
     */
    public function isA($role)
    {
        $explode = explode(',', $this->role);
        if (count($explode)>0) {
            if (array_search($role, $explode) !== false) {
                return true;
            } 
        }
        return false;
    }

    /**
     * Setter role
     *
     * @param string $role user role
     * 
     * @access public
     * @return string
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Setter ACL
     * 
     * @param string $var Permission
     * 
     * @return void
     */
    public function setAcl($var)
    {
        $this->acl->setAcl($var);
    }

    /**
     * Getter ACL
     *
     * @return ACL
     */
    public function getACL()
    {
        return $this->acl;
    }

    /**
     * Getter valid
     *
     * @return Boolean
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Setter valid
     *
     * @param integer $valid valid
     * 
     * @return void
     */
    public function setValid($valid)
    {
        $this->valid->setValue($valid);
    }

    /**
     * Update valid
     *
     * @param integer $valid valid
     * 
     * @return void
     */
    public function updateValid($valid)
    {
        $this->valid->setValue($valid);
        $this->update();
    }

    /**
     * Have Permission
     * 
     * @param string $var Permission
     * 
     * @return boolean
     */
    public function havePermission($var)
    {
        return $this->acl->getAcl($var);
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->acl = new ACL();
        $this->valid = new Boolean();
        $this->id = new Number();
    }

    /**
     * Load user
     *
     * @param mixed $var Id or DB_Result fetch object
     *
     * @access public
     * @return User
     */
    public function load($var)
    {
        if (is_numeric($var)) {
            $return = DB::query('SELECT * FROM user WHERE id='.DB::parse($var));
            if ($return->numRows()>0) {
                $user = $return->fetchObject();
                $return->freeResult();
            } else {
                $user = null;
            }
        } else {
            $user = $var;
        }
        if ($user != null) {
            $this->id->setValue($user->id);
            $this->user = $user->user;
            $this->name = $user->name;
            $this->role = $user->role;
            $this->valid->setValue($user->valid);
            $this->acl->LoadAcl($user->acl);
            return true;
        }
        return false;
    }

    /**
     * Insert user
     * 
     * @return boolean
     */
    public function insert()
    {
        $sql = 'INSERT INTO user ';
        $sql.='(user,pass,name,valid,role,acl) ';
        $sql.='VALUES(\'' . DB::Parse($this->user) . '\',';
        $sql.='\'' . sha1(DB::Parse($this->pass)) . '\',';
        $sql.='\'' . DB::Parse($this->name) . '\',';
        $sql.='\'' . $this->valid->getValueToDB() . '\',';
        $sql.='\'' . DB::Parse($this->role) . '\',';
        $sql.='\'' . $this->acl->toDB() . '\')';
        if (DB::Query($sql)) {
            $this->id->setValue(DB::insertId());
            return true;
        }
        return false;
    }

    /**
     * Update user
     *
     * @return boolean
     */
    public function update()
    {
        $sql = 'UPDATE user SET';
        $sql.=' user=\'' . DB::Parse($this->user) . '\',';
        $sql.='name=\'' . DB::Parse($this->name) . '\',';
        $sql.='valid=\'' . $this->valid->getValueToDB() . '\',';
        $sql.='acl=\'' . $this->acl->toDB() . '\' ';
        $sql.=' WHERE id=' . $this->id->getValueToDB();
        if (DB::Query($sql)) {
            return true;
        }
        return false;
    }

    /**
     * Delete user
     *
     * @return boolean
     */
    public function delete()
    {
        if (DB::Query('DELETE FROM user WHERE id=' . $this->id->getValueToDB())) {
            return true;
        }
        return false;
    }

    /**
     * User login
     * 
     * @param string $user user name
     * @param string $pass user password
     * @param array  $acl  restrictions
     * 
     * @access public
     * @return boolean
     */
    public function login($user, $pass, $acl = array())
    {
        $login = $this->authentication($user, $pass);
        if ($login) {
            $this->load($login);
            // TODO: ACLs
            $this->saveUser();
            return true;
        }
        return false;
    }

    /**
     * Logout user
     * 
     * @access public
     * @return void
     */
    public function logout()
    {
        unset($_SESSION['iduser']);
        unset($_SESSION['user']);
        $_SESSION = array();
        $params = session_get_cookie_params();
        setcookie(
            session_name(), '', time() - 42000, 
            $params["path"], $params["domain"], 
            $params["secure"], $params["httponly"]
        );
        session_destroy();
    }

    /**
     * Determine if is login
     *
     * @access public
     * @return boolean
     */
    public static function isLogin()
    {
        if (isset($_SESSION['iduser']) && is_numeric($_SESSION['iduser'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get logged user
     * 
     * @access public
     * @static
     * @return User      
     */
    public static function getLoggedUser()
    {
        return unserialize($_SESSION['user']);
    }

    /**
     * Authentication user
     * 
     * @param string $user user name
     * @param string $pass user password
     * 
     * @access public
     * @return integer user id or zero for non users
     */
    public function authentication($user, $pass)
    {
        $result = DB::query(
            'SELECT id FROM user WHERE user=\'' . DB::parse($user) .
            '\' AND pass=SHA1(\'' . DB::parse($pass) . '\') AND valid=1'
        );
        if ($result->numRows() == 1) {
            $user = $result->fetchObject();
            return $user->id;
        } else {
            return 0;
        }
    }

    /**
     * Update user password
     * 
     * @param string $pass password
     * 
     * @access public
     * @return boolean
     */
    public function updatePass($pass)
    {
        DB::query(
            'UPDATE user SET pass=SHA1(\'' . DB::parse($pass) . '\') WHERE id=' .
            DB::parse($this->id->getValueToDB())
        );
        return true;
    }

    /**
     * Email remember
     * 
     * @param string $email email
     * 
     * @access public
     * @return boolean
     */
    public function emailRemeber($email)
    {
        $result = DB::query(
            'SELECT id FROM user WHERE user=\'' . DB::Parse($email) . '\''
        );
        if ($result->numRows() == 1) {
            $return = $result->fetchObject();
            $user = new User();
            $user->Load($return->id);
            $pass = Text::getAleatoryText(6);
            $user->UpdatePass($pass);
            include ROOT . 'include/emailremember.php';
            $mail->send();
            return $return->id;
        } else {
            return 0;
        }
    }

    /**
     * Save active user session
     * 
     * @access public
     * @return void
     */
    public function saveUser()
    {
        $_SESSION['iduser'] = $this->id->getValue();
        $_SESSION['user'] = serialize($this);
    }

    /**
     * Check if username exist
     * 
     * @param string  $name user name
     * @param integer $id   id
     * 
     * @return boolean
     */
    public static function checkUsernameAvailability($name, $id = 0)
    {
        $sql = "SELECT count(id) as id FROM user ';
        $sql.= 'WHERE user='".$name."' AND id!=".DB::parse($id);
        $result = DB::query($sql);

        $count = $result->fetchObject();

        if ($count->id == 0) {
            return true;
        }
        return false;
    }
    
    /**
     * Return all objects
     *
     * @return Yuju_Array
     */
    public static function getAll()
    {
        return User::search(array());
    }
    
    /**
     * Search function
     *
     * @param array   $parameters filter array
     * @param integer $num        number of elements
     * @param integer $page       page number
     * @param integer $yuju       return a Yuju_Array or array
     *
     * @return boolean|Yuju_Array
     */
    public static function search(array $parameters, $num=null,
        $page=null, $yuju=true
    ) {
        if ($yuju) {
            $array = new Yuju_Array();
        } else {
            $array = array();
        }
        $where = '';
        foreach ($parameters as $key => $param) {
            switch ($key) {
            case "eq-user":
                $where.='`user` =\''.DB::Parse($param) . '\' AND ';
                break;
            case "like-user":
                $where.='`user` LIKE \'%'.DB::Parse($param) . '%\' AND ';
                break;
            case "eq-name":
                $where.='`name` =\''.DB::Parse($param) . '\' AND ';
                break;
            case "like-name":
                $where.='`name` LIKE \'%'.DB::Parse($param) . '%\' AND ';
                break;
            case "eq-role":
                $where.='`role` =\''.DB::Parse($param) . '\' AND ';
                break;
            case "like-role":
                $where.='`user` LIKE \'%'.DB::Parse($param) . '%\' AND ';
                break;
            case "eq-valid":
                $where.='`valid` =\''.DB::Parse($param) . '\' AND ';
                break;
            }
        }
        $sql = 'SELECT * FROM ';
        $sql.='user';
        if ($where != "") {
            $where = " WHERE " . substr($where, 0, strlen($where) - 4);
        }
        $return = DB::Query($sql . $where);
        if ($yuju) {
            $array->loadFromDB($return, new User(), $num, $page);
        } else {
            $array = $return->toArray($num, $page);
        }
        $return->freeResult();
        return $array;
    }
}

?>
