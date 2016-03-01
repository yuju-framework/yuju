<?php
/**
 * Yuju delete command line File
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Delete project
 *
 * @param string $directory directory
 *
 * @return boolean
 */
function delete($directory)
{
    // TODO: read config, connect to data base and delete database
    include 'lib/config.php';
    $config=readconfig($directory.'conf/site.php');
    $conection=new mysqli($config['DBHOST'], $config['DBUSER'], $config['DBPASS']);
    
    if ($conection->connect_error) {
        echo _("Error connecting to host")."\n";
        return false;
    }
    if (!$conection->query('DROP DATABASE '.$config['DBDATA'].';')) {
        echo _("Error droping database ").$config['DBDATA']." \n";
        return false;
    }
    
    shell_exec('rm -rf '.$directory.' 2>&1');
    return true;
}
