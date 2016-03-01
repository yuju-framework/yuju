<?php
/**
 * Yuju ORM command line File
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * ORM page
 *
 * @param string $directory directory
 * @param string $page      page name
 *
 * @return void
 */
function orm($directory, $command, $type, $table, $name = null)
{
    if (substr($directory, strlen($directory) - 1) != '/') {
        $directory=$directory.'/';
    }
    if (strpos($type, '\\')=== false) {
        $type = "YujuFramework\\ORM\\" .$type;
    }
    include $directory.'conf/site.php';
    
    $orm = new $type;
    
    //$orm = new YujuFramework\ORM\ORMMySQL();
    
    switch ($command) {
        case 'object':
            $orm->load($table);
            $file = new YujuFramework\File();
            if ($name == null) {
                $name = $table;
            }
            $file->setContent($orm->generateObject($name));
            $file->create($directory.'class/'.$name.'.php');
            $file->close();
    }
}
