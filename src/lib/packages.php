<?php
/**
 * Yuju packages command line File
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
$api = substr(__DIR__, 0, strlen(__DIR__)-4).'/';

/**
 * Install package file
 *
 * @param string $file package to install
 *
 * @return boolean
 */
function install($file)
{
    include 'download.php';
    echo _('Downloading package...')."\n";
    $temporal_zip = download($file);
    $fp = fopen('zip://'.$temporal_zip.'#yuju-imap/yuju.json', 'r');
    if ($fp) {
        $config_file = json_decode(fread($fp, filesize($temporal_zip)), true);
        fclose($fp);
    }
    var_dump($config_file);
    try {
        $php_version_package = getPHPVersion($config_file['php']);
    } catch (Exception $e) {
        echo $e->getMessage()."\n";
        exit;
    }
    
    if (PHP_VERSION_ID < getPHPVersion($config_file['php'])) {
        echo _('Package ').$config_file['name']._(' require PHP version ').$config_file['php']."\n";
        exit;
    }
    $all_extensions = get_loaded_extensions();
    if (isset($config_file['php-extensions'])) {
        foreach ($config_file['php-extensions'] as $extension => $required) {
            if (!in_array($extension, $all_extensions)) {
                if ($required) {
                    echo _('Package ').$config_file['name']._(' require PHP extension ').$extension."\n";
                    exit;
                } else {
                    echo _('Package ').$config_file['name']._(' recomends PHP extension ').$extension."\n";
                }
            }
        }
    }
    
    echo _('Installing package ').$config_file['name'].'...'."\n";
    
    /*
    copy(
        'zip://'.$smarty_temp.'#'.$entry,
        $api.'lib/Smarty/sysplugins/'.substr($entry, strlen('smarty-3.1.29/libs/sysplugins/'))
    );
    */
}

function getPHPVersion($version)
{
    $array_version = explode('.', $version);
    if (count($array_version)<2) {
        throw new Exception(_('Package version not correct format'), 1);
    }
    
    return ($array_version[0]*10000 + $array_version[1]*100);
}
