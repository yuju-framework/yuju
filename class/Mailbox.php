<?php
/**
 * Mailbox File
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
 * Mailbox Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Mailbox
{
    private $_connection = null;
    
    public function __construct()
    {
        $this->_connection = null;
    }
    
    public function connection($string_connection, $user, $pass)
    {
        $this->_connection = imap_open($string_connection, $user, $pass);
        if ($this->_connection === false) {
            $this->_connection = null;
            return false;
        }
        return true;
    }
    
    public function getAllMessages()
    {
        $array = array();
        $messages = imap_search($mbox, 'ALL');
        foreach ($messages as $messsage) {
            $msg = new Mailbox_Message($this->_connection);
            $msg->message_id = $message;
        }
    }
}