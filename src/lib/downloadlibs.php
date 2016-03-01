<?php
/**
 * Yuju downloadlibs command line File
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */
$api = substr(__DIR__, 0, strlen(__DIR__)-4).'/';

if (!file_exists($api.'lib/Smarty/Smarty.class.php')) {
    include 'download.php';
    echo _('Downloading template engine...')."\n";
    $smarty_temp = download('https://github.com/smarty-php/smarty/archive/v3.1.29.zip');
    $smarty_file = new ZipArchive();
    if ($smarty_file->open($smarty_temp)) {
        copy('zip://'.$smarty_temp.'#smarty-3.1.29/libs/Smarty.class.php', $api.'lib/Smarty/Smarty.class.php');
        copy('zip://'.$smarty_temp.'#smarty-3.1.29/libs/Autoloader.php', $api.'lib/Smarty/Autoloader.php');
        for ($i = 0; $i < $smarty_file->numFiles; $i++) {
            $entry = $smarty_file->getNameIndex($i);
            if (preg_match('#smarty-3.1.29/libs/sysplugins/(.+)$#i', $entry)) {
                copy(
                    'zip://'.$smarty_temp.'#'.$entry,
                    $api.'lib/Smarty/sysplugins/'.substr($entry, strlen('smarty-3.1.29/libs/sysplugins/'))
                );
            }
            if (preg_match('#smarty-3.1.29/libs/plugins/(.+)$#i', $entry)) {
                copy(
                    'zip://'.$smarty_temp.'#'.$entry,
                    $api.'lib/Smarty/plugins/'.substr($entry, strlen('smarty-3.1.29/libs/plugins/'))
                );
            }
        }
        $smarty_file->close();
        echo _('Download template engine')."\n";
    }
}
