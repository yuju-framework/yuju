<?php
/**
 * File File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * File Class
 */
class Mailbox_Message
{
    public $message_id;
    private $connection = null;

    public function __construct(&$connection)
    {
        $this->connection = $connection;
    }


    public function fetchHeader()
    {
        return imap_fetchheader($this->connection, $this->message_id);
    }

    public function fetchBody()
    {
        return imap_body($this->connection, $this->message_id);
    }
}
