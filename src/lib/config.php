<?php
/**
 * Yuju config command line File
 *
 * @category CLI
 * @package  YujuFramework
 * @author   Daniel Fernández <daniel.fdez.fdez@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @link     https://github.com/yuju-framework/yuju
 * @since    version 1.0
 */

/**
 * Read config file and return array values
 *
 * @param string $file config file
 *
 * @return array
 */
function readconfig($file)
{
    $config=array();
    if (file_exists($file)) {
        $openfile = fopen($file, "r");
        //Output a line of the file until the end is reached
        while (!feof($openfile)) {
            $line=fgets($openfile);
            preg_match('/^define\(\'(.*)\', \'(.*)\'\);/', $line, $result);
            if (count($result)>1) {
                $config[$result[1]]=$result[2];
            }
        }
        fclose($openfile);
    }
    return $config;
}
/**
 * Set config vars
 *
 * @param string $file config file
 * @param array  $vars array vars
 *
 * @return void
 */
function setconfig($file, array $vars)
{
    if (!file_exists($file)) {
        echo _("Config file $file not nound")."\n";
        return false;
    }
    $openfile = fopen($file, "r");
    $newfile='';
    //Output a line of the file until the end is reached
    while (!feof($openfile)) {
        $line=fgets($openfile);
        $new=false;
        foreach ($vars as $key => $value) {
            $newline=preg_replace(
                '/^define\(\''.$key.'\', \'(.*)\'\);/',
                'define(\''.$key.'\', \''.$value.'\');',
                $line
            );
            if ($newline!=$line) {
                $newfile.=$newline;
                $new=true;
            }
        }
        if ($new==false) {
            $newfile.=$line;
        }
    }
    fclose($openfile);
    $openfile = fopen($file, 'w');
    fwrite($openfile, $newfile);
    fclose($openfile);
}
