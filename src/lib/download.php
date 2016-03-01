<?php
/**
 * Yuju download File
 *
 * @category common
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Download file
 *
 * @param string $file file
 *
 * @return string name of temporaly file
 */
function download($file)
{
    $string_file = file_get_contents($file);
    
    $name_file = tempnam('/temp', 'yujuDownload-');
    $file_resource = fopen($name_file, 'w');
    fwrite($file_resource, $string_file);
    return $name_file;
}
