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
class File implements IYuju_Array
{

    /**
     * Document name
     * 
     * @var string
     */
    protected $name;

    /**
     * Place
     * 
     * @var unknown_type
     */
    protected $place;

    /**
     * Document type
     * 
     * @var string
     */
    protected $type;

    /**
     * Document size
     * 
     * @var integer
     */
    protected $size;

    /**
     * Document content
     * 
     * @var string
     */
    protected $content;

    /**
     * Resource file
     *
     * @var resource
     */
    private $_resource;

    /**
     * Setter name
     * 
     * @param string $value name
     * 
     * @return void
     */
    public function setName($value)
    {
        $this->name=$value;
    }

    /**
     * Setter place
     * 
     * @param string $value place
     * 
     * @return boolean
     */
    public function setPlace($value)
    {
        $this->place=$value;
        return true;
    }

    /**
     * Setter type
     * 
     * @param string $value type
     * 
     * @return void
     */
    public function setType($value)
    {
        $this->type=$value;
    }

    /**
     * Setter size
     * 
     * @param integer $value size
     * 
     * @return void
     */
    public function setSize($value)
    {
        $this->size=$value;
    }

    /**
     * Setter content
     * 
     * @param string $value content
     * 
     * @return void
     */
    public function setContent($value)
    {
        $this->content=$value;
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
     * Getter document place
     * 
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Getter type
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Getter extension
     *
     * @return string
     */
    public function getExtension()
    {
        return end(explode(".", $this->name));
    }

    /**
     * Get name file without extension
     *  
     * @return string
     */
    public function getNameNoExtension()
    {
        $name = explode(".", $this->name);
        return reset($name);
    }

    /**
     * Getter size
     * 
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Get content
     * 
     * @return string
     */
    public function getContent()
    {
        if ($this->content != '') {
            return $this->content;
        } else {
            return fread($this->_resource, $this->size);
        }
    }

    /**
     * Load document
     *
     * @param integer $file id
     * @param boolean $full load content document
     * 
     * @return boolean
     * @see File::open()
     * @since version 1.0
     */
    public function load($file, $full=false)
    {
        return $this->open($file, $full);
    }

    /**
     * Open file
     * 
     * @param string  $file file path
     * @param boolean $full full content on object
     * @param string  $mode open mode
     * 
     * @return boolean
     * @since version 1.0
     */
    public function open($file, $full=false, $mode='r')
    {
        if (!File::exist($file)) {
            return false;
        }
        $this->_resource=@fopen($file, $mode);
        if ($this->_resource === false) {
            return false;
        }
        $this->place=$file;
        $this->type=mime_content_type($this->place);
        $this->size = filesize($file);
        $name=explode("/", $this->place);
        $this->name=$name[count($name) - 1];
        if ($full) {
            $this->setContent(fread($fp, filesize($file)));
        }
        return true;
    }
    
    /**
     * Create file
     * 
     * @param string $file file name
     * 
     * @return boolean
     */
    public function create($file)
    {
        if (File::exist($file)) {
            return false;
        }
        $this->_resource=@fopen($file, 'w');
        if ($this->_resource === false) {
            return false;
        }
        fwrite($this->_resource, $this->getContent());
        $this->place=$file;
        $this->type=mime_content_type($this->place);
        $name=explode("/", $this->place);
        $this->name=$name[count($name) - 1];
        return true;
    }

    /**
     * Upload document
     * 
     * @param mixed $file document
     * 
     * @return boolean
     */
    public function upload($file)
    {
        if (isset($file['tmp_name']) && is_uploaded_file($file['tmp_name'])) {
            // Load file from form
            $this->setName($file['name']);
            $this->setType($file['type']);
            $tmp=tempnam(BASETMP, $this->dbname);
            copy($file['tmp_name'], $tmp);
            $this->setPlace($tmp);
            $this->setSize($file['size']);
            return true;
        }
        return false;
    }

    /**
     * Determine document exist
     * 
     * @param mixed $id document id or path
     * 
     * @return boolean
     */
    public static function exist($id)
    {
        if ($id == '' || is_dir($id)) {
            return false;
        }
        return file_exists($id);
    }

    /**
     * Save document
     * 
     * @return boolean
     */
    public function save()
    {
        if (File::exist($this->place)) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    /**
     * Insert file
     * 
     * @return boolean
     */
    public function insert()
    {
        $this->close();
        $this->open($this->place, false, 'w');
        return fwrite($this->_resource, $this->getContent());
    }

    /**
     * Update document
     * 
     * @return boolean|integer
     */
    public function update()
    {
        //$this->close();
        $this->open($this->place, false, 'w');
        return fwrite($this->_resource, $this->getContent());
    }

    /**
     * Delete document
     * 
     * @return boolean
     */
    public function delete()
    {
        if ($this->place == '') {
            return false;
        }
        return unlink($this->place);
    }

    /**
     * Return if document is empty
     *
     * @access public
     * @return boolean
     */
    public function isEmpty()
    {
        if ($this->getContent() == "" && $this->getPlace() == "") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Move document
     *
     * @param string $newlocation new location
     * 
     * @return boolean
     */
    public function move($newlocation)
    {
        if ($this->exist()) {
            if (copy($this->place, $newlocation) && unlink($this->place)) {
                $this->place=$newlocation;
                $this->name=end(split('/', $this->place));
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * Determine if is image
     * 
     * @return boolean
     */
    public function isImage()
    {
        $image[]="image/jpeg";
        $image[]="image/gif";
        $image[]="image/png";
        $image[]="image/bmp";
        if (in_array($this->type, $image)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine if is document
     * 
     * @return boolean
     */
    public function isDocument()
    {
        $document[]="application/msword";
        $document[]="application/pdf";
        if (in_array($this->type, $document)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Show document
     * 
     * @return void
     */
    public function show()
    {
        header("Content-type: ".$this->type);
        header('Content-Disposition: attachment; filename="'.$this->name.'"');
        echo $this->getContent();
    }

    /**
     * Close file
     * 
     * @return boolean
     * @since version 1.0
     */
    public function close()
    {
        if (fclose($this->_resource)) {
            $this->name='';
            $this->place='';
            $this->type='';
            $this->size='';
            $this->content='';
            $this->_resource=null;
            return true;
        }
        return false;
    }

    /**
     * End-of-file
     * 
     * @return boolean
     */
    public function eof()
    {
        return feof($this->_resource);
    }

    /**
     * Gets line from current pointer
     * 
     * @return string
     * @since version 1.0
     */
    public function getLine()
    {
        return fgets($this->_resource);
    }

}
