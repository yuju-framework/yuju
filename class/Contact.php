<?php
/**
 * Contact File
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
 * @version  SVN: $Id: Contact.php 78 2013-05-05 18:44:49Z danifdez $
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Contact Class
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version  Release: 1.0
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Contact
{
    protected $subject;
    protected $email;
    protected $name;
    protected $message;
    protected $telephone;
    protected $emailcontact;
    protected $emailfromcontact;
    protected $template;
    // TODO: contact type
    protected $type;
    
    private $_state;

    /**
     * Constructot
     *
     * @param string $emailcontact     email contact
     * @param string $emailfromcontact email from contact
     * @param string $template         template
     */
    public function __construct(
        $emailcontact, $emailfromcontact, $template='contact.tpl'
    ) {
        $this->setEmailContact($emailcontact);
        $this->setEmailFromContact($emailfromcontact);
        $this->template=$template;
        $this->_state=0;
    }

    /**
     * Getter subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Getter telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Setter subject
     *
     * @param string $val subject
     * 
     * @return boolean
     */
    public function setSubject($val)
    {
        $this->subject=$val;
        return true;
    }

    /**
     * Setter telephone
     *
     * @param string $val telephone
     * 
     * @return boolean
     */
    public function setTelephone($val)
    {
        $this->telephone=$val;
        return true;
    }

    /**
     * Getter messahe
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Setter message
     *
     * @param string $val message
     * 
     * @return boolean
     */
    public function setMessage($val)
    {
        $this->message=$val;
        return true;
    }

    /**
     * Getter email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Getter email contact
     *
     * @return string
     */
    public function getEmailContact()
    {
        return $this->emailcontact;
    }
    
    /**
     * Setter email contact
     *
     * @param string $val email
     * 
     * @return boolean
     */
    public function setEmailContact($val)
    {
        $this->emailcontact=$val;
        return true;
    }
    
    /**
     * Getter email from
     *
     * @return string
     */
    public function getEmailFromContact()
    {
        return $this->emailfromcontact;
    }
    
    /**
     * Setter email from
     *
     * @param string $val email
     * 
     * @return boolean
     */
    public function setEmailFromContact($val)
    {
        $this->emailfromcontact=$val;
        return true;
    }
    
    /**
     * Set email
     *
     * @param string $val email
     * 
     * @return boolean
     */
    public function setEmail($val)
    {
        if (!Email::validEmail($val)) {
            Error::setError("contact-email", _("You must enter a valid e-mail"));
            return false;
        } else {
            $this->email=$val;
            return true;
        }
    }

    /**
     * Getter name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter name
     *
     * @param string $val name
     * 
     * @return boolean
     */
    public function setName($val)
    {
        $this->name=$val;
        return true;
    }

    /**
     * Get state
     * 
     * States:
     * 0  : pending send
     * 1  : send
     * -1 : error    
     *
     * @return number
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * Send contact
     *
     * @return boolean
     */
    public function send()
    {
        if (!Error::exist()) {
            // Email view template
            $email=new Yuju_View();
            $email->caching=false;
            $email->assignByRef('name', $this->name);
            $email->assignByRef('email', $this->email);
            $email->assignByRef('telephone', $this->telephone);
            $email->assignByRef('message', $this->message);
            $message=$email->fetch(ROOT.'modules/contact/view/'.$this->template);
            if (mail(
                $this->emailcontact, _('Contact ').$this->subject,
                $message, "From: ".$this->emailfromcontact."\n"
            )
            ) {
                $this->_state=1;
                return true;
            } else {
                $this->_state=-1;
                Error::setError(
                    "contact-send", _("Failed to send the contact form")
                );
                return false;
            }
        }
        return false;
    }
}
?>
