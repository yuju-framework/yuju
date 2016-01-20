<?php
/**
 * Mailbox File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

class Mailbox
{
    private $connection = null;

    public function __construct()
    {
        $this->connection = null;
    }

    public function connection($stringconnection, $user, $pass)
    {
        $this->connection = imap_open($stringconnection, $user, $pass);
        if ($this->connection === false) {
            $this->connection = null;
            return false;
        }
        return true;
    }

    public function getAllMessages()
    {
        $array = array();
        $messages = imap_search($mbox, 'ALL');
        foreach ($messages as $messsage) {
            $msg = new Mailbox_Message($this->connection);
            $msg->message_id = $message;
        }
    }
}
