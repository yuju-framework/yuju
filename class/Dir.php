<?php
/**
 * Directory File
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Class Directory
 *
 * @category Core
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
class Dir
{

    /**
     * Directory path
     *
     * @var string
     */
    private $path;

    /**
     * Getter directory path
     *
     * @return string
     * @since version 1.0
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Setter directory path
     *
     * @param string $path directory path
     *
     * @return boolean
     * @since version 1.0
     */
    public function setPath($path)
    {
        $this->path=$path;
        return true;
    }

    /**
     * Constructor
     *
     * @param string $path path
     *
     * @since version 1.0
     */
    public function __construct($path = null)
    {

    }

    /**
     * Determine if is valid directory
     *
     * @param string $path path
     *
     * @return boolean
     * @since version 1.0
     */
    public static function isValid($path)
    {
        if (strpbrk($path, "?%*:|\"<>") === false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine if exist directory
     *
     * @param string $path directory path
     *
     * @return boolean
     * @since version 1.0
     */
    public static function exist($path)
    {
        return is_dir($path);
    }

    /**
     * Make directory
     *
     * @param string  $directory directory
     * @param boolean $recursive make directory recursively
     * @param integer $mode      mode permission
     *
     * @return boolean
     * @since version 1.0
     */
    public static function mkdir($directory, $recursive = false, $mode = 0777)
    {
        return mkdir($directory, $mode, $recursive);
    }

    /**
     * Copy directory recursive to destination directory
     *
     * @param string $source source directory
     * @param string $dest   destination directory
     *
     * @return boolean
     * @since version 1.0
     */
    public static function copy($source, $dest)
    {
        if (!Dir::exist($source) || !Dir::isValid($dest)) {
            return false;
        }
        $output=shell_exec('cp -r -a '.$source.'/* '.$dest.' 2>&1');
        if (strlen($output) > 0) {
            return false;
        }
        return true;
    }

    /**
     * Change permission directory
     *
     * @param string  $directory directory
     * @param integer $mode      permission mode
     *
     * @return boolean
     * @since version 1.0
     */
    public static function chmod($directory, $mode = 0644)
    {
        if (!Dir::exist($directory)) {
            return false;
        }
        return chmod($directory, $mode);
    }

    /**
     * Delete directory
     *
     * @param string $directory directory
     *
     * @return boolean
     * @since version 1.0
     */
    public static function rmdir($directory)
    {
        return rmdir($directory);
    }

    /**
     * Clean directory
     *
     * @param string $directory directory
     *
     * @return void
     * @since version 1.0
     */
    public static function cleandir($directory)
    {
        $files=scandir($directory); // get all file names
        foreach ($files as $file) { // iterate files
            $f=new File();
            $f->open($directory."/".$file);
            $f->delete();
        }
    }

    /**
     * List files on the directory
     *
     * @param string  $directory directory name
     * @param boolean $deep      deep list
     *
     * @return array
     */
    public static function listFiles($directory, $deep = false)
    {
        $files=scandir($directory); // get all file names
        $arrayFiles=array();
        foreach ($files as $file) { // iterate files
            $f=new File();
            $is=$f->open($directory."/".$file);
            if ($is) {
                $arrayFiles[]=$f;
            } else {
                if ($file != "." && $file != "..") {
                    if ($deep) {
                        $arrayFiles=array_merge(
                            $arrayFiles,
                            Dir::listFiles($directory."/".$file, true)
                        );
                    }
                }
            }
        }
        return $arrayFiles;
    }

    /**
     * List directories
     *
     * @param string  $directory directory
     * @param boolean $deep      deep list
     *
     * @return array
     */
    public function listDirectories($directory, $deep = false)
    {
        $files=scandir($directory);
        $arrayFiles=array();
        foreach ($files as $file) {
            if (is_dir($directory."/".$file) && $file!='.' && $file!='..') {
                $arrayFiles[]=$directory."/".$file;
                if ($deep) {
                    $arrayFiles=array_merge(
                        $arrayFiles,
                        Dir::listDirectories($directory."/".$file, true)
                    );
                }
            }
        }
        return $arrayFiles;
    }
}
