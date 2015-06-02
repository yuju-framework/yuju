<?php
/**
 * File File
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
 * File Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Mailbox_Message
{
    public $message_id;
    private $_connection = null;
    
    public function __construct(&$connection)
    {
        $this->_connection = $connection;
    }
    
    
    public function fetchHeader()
    {
        return imap_fetchheader($this->_connection, $this->message_id);
    }
    
    public function fetchBody()
    {
        return imap_body($this->_connection, $this->message_id);
    }
}
