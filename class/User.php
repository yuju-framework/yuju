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
 * @version  SVN: $Id: User.php 183 2014-07-21 17:56:17Z carlosmelga $
 * @link     http://sourceforge.net/projects/yuju/
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
 * @link     http://sourceforge.net/projects/yuju/
 * @since    version 1.0
 */
class User
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
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * Setter Password
     * 
     * @param string $pass Password
     * 
     * @return void
     */
    public function setPass($pass) {
        $this->pass = $pass;
    }

    /**
     * Getter Role
     *     
     * @access public
     * @return string
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * Setter role
     *
     * @param string $role user role
     * 
     * @access public
     * @return string
     */
    public function setRole($role) {
        $this->role = $role;
    }

    /**
     * Setter ACL
     * 
     * @param string $var Permission
     * 
     * @return void
     */
    public function setAcl($var) {
        $this->acl->setAcl($var);
    }

    /**
     * Getter ACL
     *
     * @return ACL
     */
    public function getACL() {
        return $this->acl;
    }

    /**
     * Getter valid
     *
     * @return Boolean
     */
    public function getValid() {
        return $this->valid;
    }

    /**
     * Setter valid
     *
     * @param integer $valid valid
     * 
     * @return void
     */
    public function setValid($valid) {
        $this->valid->setValue($valid);
    }

    /**
     * Update valid
     *
     * @param integer $valid valid
     * 
     * @return void
     */
    public function updateValid($valid) {
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
    public function havePermission($var) {
        return $this->acl->getAcl($var);
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->acl = new ACL();
        $this->valid = new Boolean();
        $this->id = new Number();
    }

    /**
     * Load user
     *
     * @param integer $id  id
     * @param string  $rol role
     *
     * @access public
     * @return User
     */
    public function load($id, $rol = null) {
        if (is_numeric($id)) {
            $return = DB::Query('SELECT * FROM user WHERE id=' . DB::Parse($id));
            if ($return->numRows() > 0) {
                $user = $return->fetchObject();
                $this->id->setValue($user->id);
                $this->user = $user->user;
                $this->name = $user->name;
                $this->role = $user->role;
                $this->valid->setValue($user->valid);
                $this->acl->LoadAcl($user->acl);
            }
        }
    }

    /**
     * Insert user
     * 
     * @return boolean
     */
    public function insert() {
        $sql = 'INSERT INTO user ';
        $sql.='(user,pass,name,valid,role,acl) ';
        $sql.='VALUES(\'' . DB::Parse($this->user) . '\',';
        $sql.='\'' . sha1(DB::Parse($this->pass)) . '\',';
        $sql.='\'' . DB::Parse($this->name) . '\',';
        $sql.='\'' . $this->valid->getValueDB() . '\',';
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
    public function update() {
        $sql = 'UPDATE user SET';
        $sql.=' user=\'' . DB::Parse($this->user) . '\',';
        $sql.='name=\'' . DB::Parse($this->name) . '\',';
        $sql.='valid=\'' . $this->valid->getValueDB() . '\',';
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
    public function delete() {
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
    public function login($user, $pass, $acl = array()) {

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
    public function logout() {
        unset($_SESSION['iduser']);
        unset($_SESSION['user']);
        $_SESSION = array();
        $params = session_get_cookie_params();
        setcookie(
                session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
        );
        session_destroy();
    }

    /**
     * Determine if is login
     *
     * @access public
     * @return boolean
     */
    public static function isLogin() {
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
    public static function getLoggedUser() {
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
    public function authentication($user, $pass) {
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
    public function updatePass($pass) {
        DB::query(
                'UPDATE user SET pass=SHA1(\'' . DB::parse($pass) . '\') WHERE id=' .
                DB::parse($this->id->getValueToDB())
        );
        return true;
    }

    /**
     * Email remember
     * 
     * @param string $user user
     * 
     * @access public
     * @return boolean
     */
    public function emailRemeber($email) {
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
    public function saveUser() {
        $_SESSION['iduser'] = $this->id->getValue();
        $_SESSION['user'] = serialize($this);
    }

    public static function checkUsernameAvailability($name, $id = 0) {

        $sql = "SELECT count(id) as id FROM user WHERE user='" . $name . "' AND id != " . $id;
        $result = DB::query($sql);

        $count = $result->fetchObject();

        if ($count->id == 0) {
            return true;
        }
        return false;
    }

}

?>
